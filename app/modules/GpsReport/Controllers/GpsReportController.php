<?php
namespace App\Modules\GpsReport\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\Vehicle\Models\Vehicle;
use App\Modules\User\Models\User;
use App\Modules\Root\Models\Root;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Trader\Models\Trader;
use App\Modules\Driver\Models\Driver;
use App\Modules\Servicer\Models\ServicerJob;
use App\Modules\Operations\Models\Operations;
use App\Modules\Vehicle\Models\VehicleGps;
use App\Modules\VltData\Models\VltData;
use App\Modules\Ota\Models\OtaResponse;
use Illuminate\Support\Facades\Crypt;
use App\Http\Traits\UserTrait;
use App\Http\Traits\MqttTrait;
use DataTables;
use DB;
use PDF;

class GpsReportController extends Controller 
{
    /**
     * 
     * 
     *
     */
    use MqttTrait;
    /**
     * 
     * 
     */
    use UserTrait;

    /**
     * 
     * 
     */
    public function __construct()
    {
        //ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
    }

    /**
     * 
     * 
     */
    public function detailedDeviceReport()
    {
        return view('GpsReport::detailed-device-report');
    }
    /**
     * 
     * 
     */
    public function gpsTransferReport(Request $request)
    {
        $from_date          =   ( isset($request->from_date) ) ? date ('Y-m-d',strtotime($request->from_date)) : null;
        $to_date            =   ( isset($request->to_date) ) ? date ('Y-m-d',strtotime($request->to_date)) : null;
        $download_type      =   ( isset($request->type) ) ? $request->type : null;
        if(\Auth::user()->hasRole('root'))
        {
            if($from_date == null && $to_date == null)
            {
                $transfer_details       =   [];
            }
            else
            {
                $transfer_details       =   $this->TransferSummaryOfManufacturer($from_date,$to_date,$download_type);
            }
            if($download_type == 'pdf')
            {
                $pdf                    =   PDF::loadView('GpsReport::gps-transfer-report-download',['transfer_summary' => $transfer_details['transfer_summary'], 'manufacturer_to_distributor_details'=> $transfer_details['manufacturer_to_distributor_details'], 'distributor_to_dealer_details' => $transfer_details['distributor_to_dealer_details'], 'dealer_to_sub_dealer_details'=> $transfer_details['dealer_to_sub_dealer_details'],'dealer_to_client_details' => $transfer_details['dealer_to_client_details'], 'sub_dealer_to_client_details' => $transfer_details['sub_dealer_to_client_details'], 'generated_by' => $transfer_details['generated_by'].' '.'( Manufacturer )', 'generated_on' => date("d/m/Y h:i:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
                return $pdf->download('gps-transfer-report.pdf');
            }
            else
            {
                return view('GpsReport::gps-transfer-report-in-manufacturer',['transfer_details' => $transfer_details, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
        }
        else if(\Auth::user()->hasRole('dealer'))
        {
            if($from_date == null && $to_date == null)
            {
                $transfer_details       =   [];
            }
            else
            {
                $transfer_details       =   $this->TransferSummaryOfDistributor($from_date,$to_date,$download_type);
            }
            if($download_type == 'pdf')
            {
                $pdf                    =   PDF::loadView('GpsReport::gps-transfer-report-download',['transfer_summary' => $transfer_details['transfer_summary'], 'manufacturer_to_distributor_details'=> $transfer_details['manufacturer_to_distributor_details'], 'distributor_to_dealer_details' => $transfer_details['distributor_to_dealer_details'], 'dealer_to_sub_dealer_details'=> $transfer_details['dealer_to_sub_dealer_details'],'dealer_to_client_details' => $transfer_details['dealer_to_client_details'], 'sub_dealer_to_client_details' => $transfer_details['sub_dealer_to_client_details'], 'generated_by' => $transfer_details['generated_by'].' '.'( Distributor )', 'generated_on' => date("d/m/Y h:i:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
                return $pdf->download('gps-transfer-report.pdf');
            }
            else
            {
                return view('GpsReport::gps-transfer-report-in-distributor',['transfer_details' => $transfer_details, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
        }
        else if(\Auth::user()->hasRole('sub_dealer'))
        {
            if($from_date == null && $to_date == null)
            {
                $transfer_details       =   [];
            }
            else
            {
                $transfer_details       =   $this->TransferSummaryOfDealer($from_date,$to_date,$download_type);
            }
            if($download_type == 'pdf')
            {
                $pdf                    =   PDF::loadView('GpsReport::gps-transfer-report-download',['transfer_summary' => $transfer_details['transfer_summary'], 'manufacturer_to_distributor_details'=> $transfer_details['manufacturer_to_distributor_details'], 'distributor_to_dealer_details' => $transfer_details['distributor_to_dealer_details'], 'dealer_to_sub_dealer_details'=> $transfer_details['dealer_to_sub_dealer_details'],'dealer_to_client_details' => $transfer_details['dealer_to_client_details'], 'sub_dealer_to_client_details' => $transfer_details['sub_dealer_to_client_details'], 'generated_by' => $transfer_details['generated_by'].' '.'( Dealer )', 'generated_on' => date("d/m/Y h:i:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
                return $pdf->download('gps-transfer-report.pdf');
            }
            else
            {
                return view('GpsReport::gps-transfer-report-in-dealer',['transfer_details' => $transfer_details, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
        }
        else if(\Auth::user()->hasRole('trader'))
        {
            if($from_date == null && $to_date == null)
            {
                $transfer_details       =   [];
            }
            else
            {
                $transfer_details       =   $this->TransferSummaryOfSubDealer($from_date,$to_date,$download_type);
            }
            if($download_type == 'pdf')
            {
                $pdf                    =   PDF::loadView('GpsReport::gps-transfer-report-download',['transfer_summary' => $transfer_details['transfer_summary'], 'manufacturer_to_distributor_details'=> $transfer_details['manufacturer_to_distributor_details'], 'distributor_to_dealer_details' => $transfer_details['distributor_to_dealer_details'], 'dealer_to_sub_dealer_details'=> $transfer_details['dealer_to_sub_dealer_details'],'dealer_to_client_details' => $transfer_details['dealer_to_client_details'], 'sub_dealer_to_client_details' => $transfer_details['sub_dealer_to_client_details'], 'generated_by' => $transfer_details['generated_by'].' '.'( Sub Dealer )', 'generated_on' => date("d/m/Y h:i:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
                return $pdf->download('gps-transfer-report.pdf');
            }
            else
            {
                return view('GpsReport::gps-transfer-report-in-sub-dealer',['transfer_details' => $transfer_details, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
        }
    }
    /**
     * 
     * 
     */
    public function TransferSummaryOfManufacturer($from_date,$to_date,$download_type)
    {
        $transfer_details           =   [];
        //from manufactures
        $manufacturer_user_id[]     =   \Auth::user()->id;
        $manufacturer_id[]          =   \Auth::user()->root->id;
        $distributor_details        =   (new Dealer())->getDistributorsOfManufacturer($manufacturer_id); 
        $distributor_user_ids       =   [];
        $distributor_ids            =   [];
        foreach($distributor_details as $each_data)
        {
            $distributor_user_ids[] =   $each_data->user_id;
            $distributor_ids[]      =   $each_data->id;
        }
        $transferred_count_from_manufacturier   =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($manufacturer_user_id,$distributor_user_ids,$from_date,$to_date);
        $transfer_details[]         =   [
                                            'from'              =>  'From Manufacturers',
                                            'type'              =>  '1',
                                            'to_distributers'   =>  $transferred_count_from_manufacturier[0]->count,
                                            'to_dealers'        =>  0,
                                            'to_sub_dealers'    =>  0,
                                            'to_clients'        =>  0,
                                            'total'             =>  $transferred_count_from_manufacturier[0]->count,
                                        ];
        if($download_type   ==  'pdf')
        {
            $manufacturer_to_distributor_details    =   $this->detailedTransferReportBetweenTwoUsers($manufacturer_user_id,$distributor_user_ids,$from_date,$to_date);
        }
        //from distributers
        $dealer_details             =   (new SubDealer())->getDealersOfDistributers($distributor_ids); 
        $dealer_user_ids            =   [];
        $dealer_ids                 =   [];
        foreach($dealer_details as $each_data)
        {
            $dealer_user_ids[]      =   $each_data->user_id;
            $dealer_ids[]           =   $each_data->id;
        }
        $transferred_count_from_distributor   =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($distributor_user_ids,$dealer_user_ids,$from_date,$to_date);
        $transfer_details[]         =   [
                                            'from'              =>  'From Distributors',
                                            'type'              =>  '2',
                                            'to_distributers'   =>  '-',
                                            'to_dealers'        =>  $transferred_count_from_distributor[0]->count,
                                            'to_sub_dealers'    =>  0,
                                            'to_clients'        =>  0,
                                            'total'             =>  $transferred_count_from_distributor[0]->count,
                                        ];
        if($download_type   ==  'pdf')
        {
            $distributor_to_dealer_details    =   $this->detailedTransferReportBetweenTwoUsers($distributor_user_ids,$dealer_user_ids,$from_date,$to_date);
        }
        //from dealers to sub dealers
        $sub_dealer_details             =   (new Trader())->getSubDealersOfDealers($dealer_ids); 
        $sub_dealer_user_ids            =   [];
        $sub_dealer_ids                 =   [];
        foreach($sub_dealer_details as $each_data)
        {
            $sub_dealer_user_ids[]      =   $each_data->user_id;
            $sub_dealer_ids[]           =   $each_data->id;
        }
        $transferred_count_from_dealer_to_sub_dealer    =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($dealer_user_ids,$sub_dealer_user_ids,$from_date,$to_date);
        //from dealers to clients
        $client_details_of_dealer       =   (new Client())->getClientsOfDealers($dealer_ids); 
        $client_of_dealer_user_ids      =   [];
        $client_of_dealer_ids           =   [];
        foreach($client_details_of_dealer as $each_data)
        {
            $client_of_dealer_user_ids[]            =   $each_data->user_id;
            $client_of_dealer_ids[]                 =   $each_data->id;
        }
        $transferred_count_from_dealer_to_client    =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($dealer_user_ids,$client_of_dealer_user_ids,$from_date,$to_date);
        $transfer_details[]         =   [
                                            'from'              =>  'From Dealers',
                                            'type'              =>  '3',
                                            'to_distributers'   =>  '-',
                                            'to_dealers'        =>  '-',
                                            'to_sub_dealers'    =>  $transferred_count_from_dealer_to_sub_dealer[0]->count,
                                            'to_clients'        =>  $transferred_count_from_dealer_to_client[0]->count,
                                            'total'             =>  ($transferred_count_from_dealer_to_sub_dealer[0]->count)+($transferred_count_from_dealer_to_client[0]->count),
                                        ];
        if($download_type   ==  'pdf')
        {
            $dealer_to_sub_dealer_details           =   $this->detailedTransferReportBetweenTwoUsers($dealer_user_ids,$sub_dealer_user_ids,$from_date,$to_date);
            $dealer_to_client_details               =   $this->detailedTransferReportBetweenTwoUsers($dealer_user_ids,$client_of_dealer_user_ids,$from_date,$to_date);
        }
        //from sub dealers to clients
        $client_details_of_sub_dealer       =   (new Client())->getClientsOfSubDealers($sub_dealer_ids); 
        $client_of_sub_dealer_user_ids      =   [];
        $client_of_sub_dealer_ids           =   [];
        foreach($client_details_of_sub_dealer as $each_data)
        {
            $client_of_sub_dealer_user_ids[]            =   $each_data->user_id;
            $client_of_sub_dealer_ids[]                 =   $each_data->id;
        }
        $transferred_count_from_sub_dealer_to_client    =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($sub_dealer_user_ids,$client_of_sub_dealer_user_ids,$from_date,$to_date);
        $transfer_details[]         =   [
                                            'from'              =>  'From Sub Dealers',
                                            'type'              =>  '4',
                                            'to_distributers'   =>  '-',
                                            'to_dealers'        =>  '-',
                                            'to_sub_dealers'    =>  '-',
                                            'to_clients'        =>  $transferred_count_from_sub_dealer_to_client[0]->count,
                                            'total'             =>  $transferred_count_from_sub_dealer_to_client[0]->count,
                                        ];
        if($download_type   ==  'pdf')
        {
            $sub_dealer_to_client_details           =   $this->detailedTransferReportBetweenTwoUsers($sub_dealer_user_ids,$client_of_sub_dealer_user_ids,$from_date,$to_date);
            $manufacturer_details                   =   (new Root())->getManufacturerDetails(\Auth::user()->root->id);
            return [
                'transfer_summary'                      =>  $transfer_details,
                'manufacturer_to_distributor_details'   =>  $manufacturer_to_distributor_details,
                'distributor_to_dealer_details'         =>  $distributor_to_dealer_details,
                'dealer_to_sub_dealer_details'          =>  $dealer_to_sub_dealer_details,
                'dealer_to_client_details'              =>  $dealer_to_client_details,
                'sub_dealer_to_client_details'          =>  $sub_dealer_to_client_details,
                'generated_by'                          =>  ucfirst(strtolower($manufacturer_details->name)) 
            ];
        }
        else
        {
            return $transfer_details;
        }
    }
    /**
     * 
     * 
     */
    public function TransferSummaryOfDistributor($from_date,$to_date,$download_type)
    {
        $transfer_details           =   [];
        //from distributers
        $distributor_user_ids[]     =   \Auth::user()->id;
        $distributor_ids[]          =   \Auth::user()->dealer->id;
        $dealer_details             =   (new SubDealer())->getDealersOfDistributers($distributor_ids); 
        $dealer_user_ids            =   [];
        $dealer_ids                 =   [];
        foreach($dealer_details as $each_data)
        {
            $dealer_user_ids[]      =   $each_data->user_id;
            $dealer_ids[]           =   $each_data->id;
        }
        $transferred_count_from_distributor   =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($distributor_user_ids,$dealer_user_ids,$from_date,$to_date);
        $transfer_details[]         =   [
                                            'from'              =>  'From Distributors',
                                            'type'              =>  '2',
                                            'to_distributers'   =>  '-',
                                            'to_dealers'        =>  $transferred_count_from_distributor[0]->count,
                                            'to_sub_dealers'    =>  0,
                                            'to_clients'        =>  0,
                                            'total'             =>  $transferred_count_from_distributor[0]->count,
                                        ];
        if($download_type   ==  'pdf')
        {
            $distributor_to_dealer_details    =   $this->detailedTransferReportBetweenTwoUsers($distributor_user_ids,$dealer_user_ids,$from_date,$to_date);
        }
        //from dealers to sub dealers
        $sub_dealer_details             =   (new Trader())->getSubDealersOfDealers($dealer_ids); 
        $sub_dealer_user_ids            =   [];
        $sub_dealer_ids                 =   [];
        foreach($sub_dealer_details as $each_data)
        {
            $sub_dealer_user_ids[]      =   $each_data->user_id;
            $sub_dealer_ids[]           =   $each_data->id;
        }
        $transferred_count_from_dealer_to_sub_dealer    =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($dealer_user_ids,$sub_dealer_user_ids,$from_date,$to_date);
        //from dealers to clients
        $client_details_of_dealer       =   (new Client())->getClientsOfDealers($dealer_ids); 
        $client_of_dealer_user_ids      =   [];
        $client_of_dealer_ids           =   [];
        foreach($client_details_of_dealer as $each_data)
        {
            $client_of_dealer_user_ids[]            =   $each_data->user_id;
            $client_of_dealer_ids[]                 =   $each_data->id;
        }
        $transferred_count_from_dealer_to_client    =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($dealer_user_ids,$client_of_dealer_user_ids,$from_date,$to_date);
        $transfer_details[]         =   [
                                            'from'              =>  'From Dealers',
                                            'type'              =>  '3',
                                            'to_distributers'   =>  '-',
                                            'to_dealers'        =>  '-',
                                            'to_sub_dealers'    =>  $transferred_count_from_dealer_to_sub_dealer[0]->count,
                                            'to_clients'        =>  $transferred_count_from_dealer_to_client[0]->count,
                                            'total'             =>  ($transferred_count_from_dealer_to_sub_dealer[0]->count)+($transferred_count_from_dealer_to_client[0]->count),
                                        ];
        if($download_type   ==  'pdf')
        {
            $dealer_to_sub_dealer_details           =   $this->detailedTransferReportBetweenTwoUsers($dealer_user_ids,$sub_dealer_user_ids,$from_date,$to_date);
            $dealer_to_client_details               =   $this->detailedTransferReportBetweenTwoUsers($dealer_user_ids,$client_of_dealer_user_ids,$from_date,$to_date);
        }
        //from sub dealers to clients
        $client_details_of_sub_dealer       =   (new Client())->getClientsOfSubDealers($sub_dealer_ids); 
        $client_of_sub_dealer_user_ids      =   [];
        $client_of_sub_dealer_ids           =   [];
        foreach($client_details_of_sub_dealer as $each_data)
        {
            $client_of_sub_dealer_user_ids[]            =   $each_data->user_id;
            $client_of_sub_dealer_ids[]                 =   $each_data->id;
        }
        $transferred_count_from_sub_dealer_to_client    =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($sub_dealer_user_ids,$client_of_sub_dealer_user_ids,$from_date,$to_date);
        $transfer_details[]         =   [
                                            'from'              =>  'From Sub Dealers',
                                            'type'              =>  '4',
                                            'to_distributers'   =>  '-',
                                            'to_dealers'        =>  '-',
                                            'to_sub_dealers'    =>  '-',
                                            'to_clients'        =>  $transferred_count_from_sub_dealer_to_client[0]->count,
                                            'total'             =>  $transferred_count_from_sub_dealer_to_client[0]->count,
                                        ];
        if($download_type   ==  'pdf')
        {
            $sub_dealer_to_client_details           =   $this->detailedTransferReportBetweenTwoUsers($sub_dealer_user_ids,$client_of_sub_dealer_user_ids,$from_date,$to_date);
            $distributor_details                    =   (new Dealer())->getDistributorDetails(\Auth::user()->dealer->id);
            return [
                'transfer_summary'                      =>  $transfer_details,
                'manufacturer_to_distributor_details'   =>  [],
                'distributor_to_dealer_details'         =>  $distributor_to_dealer_details,
                'dealer_to_sub_dealer_details'          =>  $dealer_to_sub_dealer_details,
                'dealer_to_client_details'              =>  $dealer_to_client_details,
                'sub_dealer_to_client_details'          =>  $sub_dealer_to_client_details,
                'generated_by'                          =>  ucfirst(strtolower($distributor_details->name)) 
            ];
        }
        else
        {
            return $transfer_details;
        }
    }
    /**
     * 
     * 
     */
    public function TransferSummaryOfDealer($from_date,$to_date,$download_type)
    {
        $transfer_details               =   [];
        $dealer_user_ids[]              =   \Auth::user()->id;
        $dealer_ids[]                   =   \Auth::user()->subdealer->id;

        //from dealers to sub dealers
        $sub_dealer_details             =   (new Trader())->getSubDealersOfDealers($dealer_ids); 
        $sub_dealer_user_ids            =   [];
        $sub_dealer_ids                 =   [];
        foreach($sub_dealer_details as $each_data)
        {
            $sub_dealer_user_ids[]      =   $each_data->user_id;
            $sub_dealer_ids[]           =   $each_data->id;
        }
        $transferred_count_from_dealer_to_sub_dealer    =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($dealer_user_ids,$sub_dealer_user_ids,$from_date,$to_date);
        
        //from dealers to clients
        $client_details_of_dealer       =   (new Client())->getClientsOfDealers($dealer_ids); 
        $client_of_dealer_user_ids      =   [];
        $client_of_dealer_ids           =   [];
        foreach($client_details_of_dealer as $each_data)
        {
            $client_of_dealer_user_ids[]            =   $each_data->user_id;
            $client_of_dealer_ids[]                 =   $each_data->id;
        }
        $transferred_count_from_dealer_to_client    =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($dealer_user_ids,$client_of_dealer_user_ids,$from_date,$to_date);
        $transfer_details[]         =   [
                                            'from'              =>  'From Dealers',
                                            'type'              =>  '3',
                                            'to_distributers'   =>  '-',
                                            'to_dealers'        =>  '-',
                                            'to_sub_dealers'    =>  $transferred_count_from_dealer_to_sub_dealer[0]->count,
                                            'to_clients'        =>  $transferred_count_from_dealer_to_client[0]->count,
                                            'total'             =>  ($transferred_count_from_dealer_to_sub_dealer[0]->count)+($transferred_count_from_dealer_to_client[0]->count),
                                        ];
        if($download_type   ==  'pdf')
        {
            $dealer_to_sub_dealer_details           =   $this->detailedTransferReportBetweenTwoUsers($dealer_user_ids,$sub_dealer_user_ids,$from_date,$to_date);
            $dealer_to_client_details               =   $this->detailedTransferReportBetweenTwoUsers($dealer_user_ids,$client_of_dealer_user_ids,$from_date,$to_date);
        }
        //from sub dealers to clients
        $client_details_of_sub_dealer       =   (new Client())->getClientsOfSubDealers($sub_dealer_ids); 
        $client_of_sub_dealer_user_ids      =   [];
        $client_of_sub_dealer_ids           =   [];
        foreach($client_details_of_sub_dealer as $each_data)
        {
            $client_of_sub_dealer_user_ids[]            =   $each_data->user_id;
            $client_of_sub_dealer_ids[]                 =   $each_data->id;
        }
        $transferred_count_from_sub_dealer_to_client    =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($sub_dealer_user_ids,$client_of_sub_dealer_user_ids,$from_date,$to_date);
        $transfer_details[]         =   [
                                            'from'              =>  'From Sub Dealers',
                                            'type'              =>  '4',
                                            'to_distributers'   =>  '-',
                                            'to_dealers'        =>  '-',
                                            'to_sub_dealers'    =>  '-',
                                            'to_clients'        =>  $transferred_count_from_sub_dealer_to_client[0]->count,
                                            'total'             =>  $transferred_count_from_sub_dealer_to_client[0]->count,
                                        ];
        if($download_type   ==  'pdf')
        {
            $sub_dealer_to_client_details           =   $this->detailedTransferReportBetweenTwoUsers($sub_dealer_user_ids,$client_of_sub_dealer_user_ids,$from_date,$to_date);
            $dealer_details                         =   (new SubDealer())->getDealerDetails(\Auth::user()->subdealer->id);
            return [
                'transfer_summary'                      =>  $transfer_details,
                'manufacturer_to_distributor_details'   =>  [],
                'distributor_to_dealer_details'         =>  [],
                'dealer_to_sub_dealer_details'          =>  $dealer_to_sub_dealer_details,
                'dealer_to_client_details'              =>  $dealer_to_client_details,
                'sub_dealer_to_client_details'          =>  $sub_dealer_to_client_details,
                'generated_by'                          =>  ucfirst(strtolower($dealer_details->name))
            ];
        }
        else
        {
            return $transfer_details;
        }
    }
    /**
     * 
     * 
     */
    public function TransferSummaryOfSubDealer($from_date,$to_date,$download_type)
    {
        $transfer_details                   =   [];
        $sub_dealer_user_ids[]              =   \Auth::user()->id;
        $sub_dealer_ids[]                   =   \Auth::user()->trader->id;

        //from sub dealers to clients
        $client_details_of_sub_dealer       =   (new Client())->getClientsOfSubDealers($sub_dealer_ids); 
        $client_of_sub_dealer_user_ids      =   [];
        $client_of_sub_dealer_ids           =   [];
        foreach($client_details_of_sub_dealer as $each_data)
        {
            $client_of_sub_dealer_user_ids[]            =   $each_data->user_id;
            $client_of_sub_dealer_ids[]                 =   $each_data->id;
        }
        $transferred_count_from_sub_dealer_to_client    =   (new GpsTransfer())->getTransferredCountBetweenTwoUsers($sub_dealer_user_ids,$client_of_sub_dealer_user_ids,$from_date,$to_date);
        $transfer_details[]         =   [
                                            'from'              =>  'From Sub Dealers',
                                            'type'              =>  '4',
                                            'to_distributers'   =>  '-',
                                            'to_dealers'        =>  '-',
                                            'to_sub_dealers'    =>  '-',
                                            'to_clients'        =>  $transferred_count_from_sub_dealer_to_client[0]->count,
                                            'total'             =>  $transferred_count_from_sub_dealer_to_client[0]->count,
                                        ];
        if($download_type   ==  'pdf')
        {
            $sub_dealer_to_client_details           =   $this->detailedTransferReportBetweenTwoUsers($sub_dealer_user_ids,$client_of_sub_dealer_user_ids,$from_date,$to_date);
            $sub_dealer_details                     =   (new Trader())->getSubDealerDetails(\Auth::user()->trader->id);
            return [
                'transfer_summary'                      =>  $transfer_details,
                'manufacturer_to_distributor_details'   =>  [],
                'distributor_to_dealer_details'         =>  [],
                'dealer_to_sub_dealer_details'          =>  [],
                'dealer_to_client_details'              =>  [],
                'sub_dealer_to_client_details'          =>  $sub_dealer_to_client_details,
                'generated_by'                          =>  ucfirst(strtolower($sub_dealer_details->name)) 
            ];
        }
        else
        {
            return $transfer_details;
        }
    }
    /**
     * 
     * 
     */
    public function gpsTransferReportDetails(Request $request)
    {
        $report_type    =   $request->type;
        $from_date      =   $request->from;
        $to_date        =   $request->to;
        if(\Auth::user()->hasRole('root'))
        {
            //from manufactueres
            $manufacturer_user_id[]     =   \Auth::user()->id;
            $manufacturer_id[]          =   \Auth::user()->root->id;
            $distributor_details        =   (new Dealer())->getDistributorsOfManufacturer($manufacturer_id); 
            $distributor_user_ids       =   [];
            $distributor_ids            =   [];
            foreach($distributor_details as $each_data)
            {
                $distributor_user_ids[] =   $each_data->user_id;
                $distributor_ids[]      =   $each_data->id;
            }
            if($report_type ==  1) //From manufacturers to distributors
            {
                $transfer_details       =   $this->detailedTransferReportBetweenTwoUsers($manufacturer_user_id,$distributor_user_ids,$from_date,$to_date);
                return view('GpsReport::manufacturer-to-distributor-view',['transfer_details' => $transfer_details, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
            
            //from distributers
            $dealer_details             =   (new SubDealer())->getDealersOfDistributers($distributor_ids); 
            $dealer_user_ids            =   [];
            $dealer_ids                 =   [];
            foreach($dealer_details as $each_data)
            {
                $dealer_user_ids[]      =   $each_data->user_id;
                $dealer_ids[]           =   $each_data->id;
            }
            if($report_type ==  2) //From distributors to dealers
            {
                $transfer_details       =   $this->detailedTransferReportBetweenTwoUsers($distributor_user_ids,$dealer_user_ids,$from_date,$to_date);
                return view('GpsReport::distributor-to-dealer-view',['transfer_details' => $transfer_details, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
           
            //from dealers to sub dealers
            $sub_dealer_details             =   (new Trader())->getSubDealersOfDealers($dealer_ids); 
            $sub_dealer_user_ids            =   [];
            $sub_dealer_ids                 =   [];
            foreach($sub_dealer_details as $each_data)
            {
                $sub_dealer_user_ids[]      =   $each_data->user_id;
                $sub_dealer_ids[]           =   $each_data->id;
            }

            //from dealers to clients
            $client_details_of_dealer       =   (new Client())->getClientsOfDealers($dealer_ids); 
            $client_of_dealer_user_ids      =   [];
            $client_of_dealer_ids           =   [];
            foreach($client_details_of_dealer as $each_data)
            {
                $client_of_dealer_user_ids[]            =   $each_data->user_id;
                $client_of_dealer_ids[]                 =   $each_data->id;
            }

            if($report_type ==  3) //From dealers to sub dealers and dealers to clients
            {
                $transfer_details_to_sub_dealer       =   $this->detailedTransferReportBetweenTwoUsers($dealer_user_ids,$sub_dealer_user_ids,$from_date,$to_date);
                $transfer_details_to_client           =   $this->detailedTransferReportBetweenTwoUsers($dealer_user_ids,$client_of_dealer_user_ids,$from_date,$to_date);
                return view('GpsReport::dealer-to-sub-dealer-client-view',['transfer_details_to_sub_dealer' => $transfer_details_to_sub_dealer,'transfer_details_to_client' => $transfer_details_to_client, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
            
            //from sub dealers to clients
            $client_details_of_sub_dealer       =   (new Client())->getClientsOfSubDealers($sub_dealer_ids); 
            $client_of_sub_dealer_user_ids      =   [];
            $client_of_sub_dealer_ids           =   [];
            foreach($client_details_of_sub_dealer as $each_data)
            {
                $client_of_sub_dealer_user_ids[]            =   $each_data->user_id;
                $client_of_sub_dealer_ids[]                 =   $each_data->id;
            }
            if($report_type ==  4) //From sub dealers to client
            {
                $transfer_details       =   $this->detailedTransferReportBetweenTwoUsers($sub_dealer_user_ids,$client_of_sub_dealer_user_ids,$from_date,$to_date);
                return view('GpsReport::sub-dealer-to-client-view',['transfer_details' => $transfer_details, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
           
        }
        else if(\Auth::user()->hasRole('dealer'))
        {
            //from distributers
            $distributor_user_ids[]     =   \Auth::user()->id;
            $distributor_ids[]          =   \Auth::user()->dealer->id;
            $dealer_details             =   (new SubDealer())->getDealersOfDistributers($distributor_ids); 
            $dealer_user_ids            =   [];
            $dealer_ids                 =   [];
            foreach($dealer_details as $each_data)
            {
                $dealer_user_ids[]      =   $each_data->user_id;
                $dealer_ids[]           =   $each_data->id;
            }
            if($report_type ==  2) //From distributors to dealers
            {
                $transfer_details       =   $this->detailedTransferReportBetweenTwoUsers($distributor_user_ids,$dealer_user_ids,$from_date,$to_date);
                return view('GpsReport::distributor-to-dealer-view',['transfer_details' => $transfer_details, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
           
            //from dealers to sub dealers
            $sub_dealer_details             =   (new Trader())->getSubDealersOfDealers($dealer_ids); 
            $sub_dealer_user_ids            =   [];
            $sub_dealer_ids                 =   [];
            foreach($sub_dealer_details as $each_data)
            {
                $sub_dealer_user_ids[]      =   $each_data->user_id;
                $sub_dealer_ids[]           =   $each_data->id;
            }

            //from dealers to clients
            $client_details_of_dealer       =   (new Client())->getClientsOfDealers($dealer_ids); 
            $client_of_dealer_user_ids      =   [];
            $client_of_dealer_ids           =   [];
            foreach($client_details_of_dealer as $each_data)
            {
                $client_of_dealer_user_ids[]            =   $each_data->user_id;
                $client_of_dealer_ids[]                 =   $each_data->id;
            }

            if($report_type ==  3) //From dealers to sub dealers and dealers to clients
            {
                $transfer_details_to_sub_dealer       =   $this->detailedTransferReportBetweenTwoUsers($dealer_user_ids,$sub_dealer_user_ids,$from_date,$to_date);
                $transfer_details_to_client           =   $this->detailedTransferReportBetweenTwoUsers($dealer_user_ids,$client_of_dealer_user_ids,$from_date,$to_date);
                return view('GpsReport::dealer-to-sub-dealer-client-view',['transfer_details_to_sub_dealer' => $transfer_details_to_sub_dealer,'transfer_details_to_client' => $transfer_details_to_client, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
            
            //from sub dealers to clients
            $client_details_of_sub_dealer       =   (new Client())->getClientsOfSubDealers($sub_dealer_ids); 
            $client_of_sub_dealer_user_ids      =   [];
            $client_of_sub_dealer_ids           =   [];
            foreach($client_details_of_sub_dealer as $each_data)
            {
                $client_of_sub_dealer_user_ids[]            =   $each_data->user_id;
                $client_of_sub_dealer_ids[]                 =   $each_data->id;
            }
            if($report_type ==  4) //From sub dealers to client
            {
                $transfer_details       =   $this->detailedTransferReportBetweenTwoUsers($sub_dealer_user_ids,$client_of_sub_dealer_user_ids,$from_date,$to_date);
                return view('GpsReport::sub-dealer-to-client-view',['transfer_details' => $transfer_details, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
            
        }
        else if(\Auth::user()->hasRole('sub_dealer'))
        {
            $dealer_user_ids[]              =   \Auth::user()->id;
            $dealer_ids[]                   =   \Auth::user()->subdealer->id;
            //from dealers to sub dealers
            $sub_dealer_details             =   (new Trader())->getSubDealersOfDealers($dealer_ids); 
            $sub_dealer_user_ids            =   [];
            $sub_dealer_ids                 =   [];
            foreach($sub_dealer_details as $each_data)
            {
                $sub_dealer_user_ids[]      =   $each_data->user_id;
                $sub_dealer_ids[]           =   $each_data->id;
            }

            //from dealers to clients
            $client_details_of_dealer       =   (new Client())->getClientsOfDealers($dealer_ids); 
            $client_of_dealer_user_ids      =   [];
            $client_of_dealer_ids           =   [];
            foreach($client_details_of_dealer as $each_data)
            {
                $client_of_dealer_user_ids[]            =   $each_data->user_id;
                $client_of_dealer_ids[]                 =   $each_data->id;
            }

            if($report_type ==  3) //From dealers to sub dealers and dealers to clients
            {
                $transfer_details_to_sub_dealer       =   $this->detailedTransferReportBetweenTwoUsers($dealer_user_ids,$sub_dealer_user_ids,$from_date,$to_date);
                $transfer_details_to_client           =   $this->detailedTransferReportBetweenTwoUsers($dealer_user_ids,$client_of_dealer_user_ids,$from_date,$to_date);
                return view('GpsReport::dealer-to-sub-dealer-client-view',['transfer_details_to_sub_dealer' => $transfer_details_to_sub_dealer,'transfer_details_to_client' => $transfer_details_to_client, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
            
            //from sub dealers to clients
            $client_details_of_sub_dealer       =   (new Client())->getClientsOfSubDealers($sub_dealer_ids); 
            $client_of_sub_dealer_user_ids      =   [];
            $client_of_sub_dealer_ids           =   [];
            foreach($client_details_of_sub_dealer as $each_data)
            {
                $client_of_sub_dealer_user_ids[]            =   $each_data->user_id;
                $client_of_sub_dealer_ids[]                 =   $each_data->id;
            }
            if($report_type ==  4) //From sub dealers to client
            {
                $transfer_details       =   $this->detailedTransferReportBetweenTwoUsers($sub_dealer_user_ids,$client_of_sub_dealer_user_ids,$from_date,$to_date);
                return view('GpsReport::sub-dealer-to-client-view',['transfer_details' => $transfer_details, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
        }
        else if(\Auth::user()->hasRole('trader'))
        {
            $sub_dealer_user_ids[]              =   \Auth::user()->id;
            $sub_dealer_ids[]                   =   \Auth::user()->trader->id;
            //from sub dealers to clients
            $client_details_of_sub_dealer       =   (new Client())->getClientsOfSubDealers($sub_dealer_ids); 
            $client_of_sub_dealer_user_ids      =   [];
            $client_of_sub_dealer_ids           =   [];
            foreach($client_details_of_sub_dealer as $each_data)
            {
                $client_of_sub_dealer_user_ids[]            =   $each_data->user_id;
                $client_of_sub_dealer_ids[]                 =   $each_data->id;
            }
            if($report_type ==  4) //From sub dealers to client
            {
                $transfer_details       =   $this->detailedTransferReportBetweenTwoUsers($sub_dealer_user_ids,$client_of_sub_dealer_user_ids,$from_date,$to_date);
                return view('GpsReport::sub-dealer-to-client-view',['transfer_details' => $transfer_details, 'from_date' => $from_date, 'to_date' => $to_date ]);
            }
        }
    }
    /**
     * 
     * 
     */
    public function detailedTransferReportBetweenTwoUsers($from_user_ids,$to_user_ids,$from_date,$to_date)
    {
        $transfer_details       =   (new GpsTransfer())->getDetailedReportOfGpsTransfers($from_user_ids,$to_user_ids,$from_date,$to_date);
        $transfer_details       =   $this->gpsTransferDetailedView($transfer_details);
        return $transfer_details;
    }
    /**
     * 
     * 
     */
    public function gpsTransferDetailedView($transfer_details)
    {
        $transfer_log       =   [];
        if(count($transfer_details) > 0)
        {
            foreach($transfer_details as $each_data)
            {
                $transfer_log[] =   [
                    'transfer_from'     =>  $this->getOriginalNameFromUserId($each_data->from_user_id),
                    'transfer_to'       =>  $this->getOriginalNameFromUserId($each_data->to_user_id),
                    'transferred_count' =>  $each_data->count
                ];
            }
        }
        return $transfer_log;
    }
    /*
     *
     * RETURNED DEVICE REPORT
     * 
     */
    public function gpsReturnedReport(Request $request)
    {
        $from_date          =   ( isset($request->from_date) ) ? date ('Y-m-d',strtotime($request->from_date)) : null;
        $to_date            =   ( isset($request->to_date) ) ? date ('Y-m-d',strtotime($request->to_date)) : null;
        $download_type      =   ( isset($request->type) ) ? $request->type : null;
        $search_key         =   ( isset($request->search_key) ) ? $request->search_key : null;
        if(\Auth::user()->hasRole('root'))
        {
            $manufacturer_id            =   \Auth::user()->root->id;
            if($from_date == null && $to_date == null)
            {
                $return_details                 =   [];
                $return_device_details          =   [];
            }
            else
            {
                $return_details                 =   (new GpsStock())->getReturnedDeviceCountOfManufacturer($manufacturer_id,$from_date,$to_date);
                $return_device_details          =   (new GpsStock())->getReturnedDeviceDetailsOfManufacturer($manufacturer_id,$from_date,$to_date,$search_key,$download_type);
            }
            if($download_type == 'pdf')
            {
                $return_device_manufactured     =   (new GpsStock())->getReturnedDeviceManufactureDate($manufacturer_id,$from_date,$to_date);
                $manufacturer_details           =   (new Root())->getManufacturerDetails($manufacturer_id);
                $pdf                            =   PDF::loadView('GpsReport::gps-return-report-download',['return_details' => $return_details, 'return_device_details' => $return_device_details, 'return_device_manufactured' => $return_device_manufactured,'generated_by' => ucfirst(strtolower($manufacturer_details->name)).' '.'( Manufacturer )', 'generated_on' => date("d/m/Y h:i:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
                return $pdf->download('gps-return-report.pdf');
            }
            else
            {
                return view('GpsReport::gps-returned-report-in-manufacturer',['return_details' => $return_details,'return_device_details' => $return_device_details, 'from_date' => $from_date, 'to_date' => $to_date, 'search_key' => $search_key]);
            }
        }
        else if(\Auth::user()->hasRole('dealer'))
        {
            $distributor_id             =   \Auth::user()->dealer->id;
            if($from_date == null && $to_date == null)
            {
                $return_details         =   [];
                $return_device_details  =   [];
            }
            else
            {
                $return_details         =   (new GpsStock())->getReturnedDeviceCountOfDistributor($distributor_id,$from_date,$to_date);
                $return_device_details  =   (new GpsStock())->getReturnedDeviceDetailsOfDistributor($distributor_id,$from_date,$to_date,$search_key,$download_type);
            }
            if($download_type == 'pdf')
            {
                $return_device_manufactured     =   [];
                $distributor_details            =   (new Dealer())->getDistributorDetails($distributor_id);
                $pdf                            =   PDF::loadView('GpsReport::gps-return-report-download',['return_details' => $return_details, 'return_device_details' => $return_device_details, 'return_device_manufactured' => $return_device_manufactured,'generated_by' => ucfirst(strtolower($distributor_details->name)).' '.'( Distributor )', 'generated_on' => date("d/m/Y h:i:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
                return $pdf->download('gps-return-report.pdf');
            }
            else
            {
                return view('GpsReport::gps-returned-report-in-distributor',['return_details' => $return_details,'return_device_details' => $return_device_details, 'from_date' => $from_date, 'to_date' => $to_date, 'search_key' => $search_key ]);
            }
        }
        else if(\Auth::user()->hasRole('sub_dealer'))
        {
            $dealer_id                  =   \Auth::user()->subdealer->id;
            if($from_date == null && $to_date == null)
            {
                $return_details         =   [];
                $return_device_details  =   [];
            }
            else
            {
                $return_details         =   (new GpsStock())->getReturnedDeviceCountOfDealer($dealer_id,$from_date,$to_date);
                $return_device_details  =   (new GpsStock())->getReturnedDeviceDetailsOfDealer($dealer_id,$from_date,$to_date,$search_key,$download_type);
            }
            if($download_type == 'pdf')
            {
                $return_device_manufactured     =   [];
                $dealer_details                 =   (new SubDealer())->getDealerDetails($dealer_id);
                $pdf                            =   PDF::loadView('GpsReport::gps-return-report-download',['return_details' => $return_details, 'return_device_details' => $return_device_details, 'return_device_manufactured' => $return_device_manufactured,'generated_by' => ucfirst(strtolower($dealer_details->name)).' '.'( Dealer )', 'generated_on' => date("d/m/Y h:i:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
                return $pdf->download('gps-return-report.pdf');
            }
            else
            {
                return view('GpsReport::gps-returned-report-in-dealer',['return_details' => $return_details,'return_device_details' => $return_device_details, 'from_date' => $from_date, 'to_date' => $to_date, 'search_key' => $search_key ]);
            }
        }
        else if(\Auth::user()->hasRole('trader'))
        {
            $trader_id                  =   \Auth::user()->trader->id;
            if($from_date == null && $to_date == null)
            {
                $return_details         =   [];
                $return_device_details  =   [];
            }
            else
            {
                $return_details         =   (new GpsStock())->getReturnedDeviceCountOfSubDealer($trader_id,$from_date,$to_date);
                $return_device_details  =   (new GpsStock())->getReturnedDeviceDetailsOfSubDealer($trader_id,$from_date,$to_date,$search_key,$download_type);
            }
            if($download_type == 'pdf')
            {
                $return_device_manufactured     =   [];
                $sub_dealer_details             =   (new Trader())->getSubDealerDetails($trader_id);
                $pdf                            =   PDF::loadView('GpsReport::gps-return-report-download',['return_details' => $return_details, 'return_device_details' => $return_device_details, 'return_device_manufactured' => $return_device_manufactured,'generated_by' => ucfirst(strtolower($sub_dealer_details->name)).' '.'( Sub Dealer )', 'generated_on' => date("d/m/Y h:i:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
                return $pdf->download('gps-return-report.pdf');
            }
            else
            {
                return view('GpsReport::gps-returned-report-in-sub-dealer',['return_details' => $return_details,'return_device_details' => $return_device_details, 'from_date' => $from_date, 'to_date' => $to_date, 'search_key' => $search_key ]);
            }
        }
    }

    public function returnedGpsManufacturedDateGraph(Request $request)
    {
        $manufacturer_id                    =   \Auth::user()->root->id;
        $from_date                          =   date ('Y-m-d',strtotime($request->from_date));
        $to_date                            =   date ('Y-m-d',strtotime($request->to_date));
        $return_device_manufactured         =   (new GpsStock())->getReturnedDeviceManufactureDate($manufacturer_id,$from_date,$to_date);
        $manufacturing_date                 =   [];
        $device_count                       =   [];
        foreach($return_device_manufactured as $each_data)
        {
            $manufacturing_date[]           =   $each_data->manufacturing_date;
            $device_count[]                 =   $each_data->count;
        }
        $returned_gps_manufactured_dates    =   array(
                                                    "manufacturing_date"=>$manufacturing_date,
                                                    "device_count"=>$device_count
                                                );
        return response()->json($returned_gps_manufactured_dates);
    }
    /*
     *
     * DEVICE STOCK REPORT
     * 
     */
    public function gpsStockReport(Request $request)
    {
        $download_type                  =   ( isset($request->type) ) ? $request->type : null;
        $stock_summary_details          =   $this->stockSummaryDetails();
        if($download_type == 'pdf')
        {
            $pdf                        =   PDF::loadView('GpsReport::gps-stock-report-download',['stock_summary_details' => $stock_summary_details['stock_summary_details'], 'stock_details_of_manufacturer'=> $stock_summary_details['stock_details_of_manufacturer'], 'stock_details_of_distributors' => $stock_summary_details['stock_details_of_distributors'],'stock_details_of_dealers' => $stock_summary_details['stock_details_of_dealers'],'stock_details_of_sub_dealers' => $stock_summary_details['stock_details_of_sub_dealers'],'generated_by' => $stock_summary_details['login_user'], 'generated_on' => date("d/m/Y h:i:s A")]);
            return $pdf->download('gps-stock-report.pdf');
        }
        else
        {
            return view('GpsReport::gps-stock-report',['stock_summary_details' => $stock_summary_details['stock_summary_details'], 'stock_details_of_manufacturer'=> $stock_summary_details['stock_details_of_manufacturer'], 'stock_details_of_distributors' => $stock_summary_details['stock_details_of_distributors'],'stock_details_of_dealers' => $stock_summary_details['stock_details_of_dealers'],'stock_details_of_sub_dealers' => $stock_summary_details['stock_details_of_sub_dealers']]);
        }
    }

    public function stockSummaryDetails()
    {
        $stock_summary_details          =   [];
        $stock_details_of_manufacturer  =   [];
        $stock_details_of_distributors  =   [];
        $stock_details_of_dealers       =   [];
        $stock_details_of_sub_dealers   =   [];
        if(\Auth::user()->hasRole('root'))
        {
            //manufacture section
            $manufacturer_user_id[]                     =   \Auth::user()->id;
            $manufacturer_id[]                          =   \Auth::user()->root->id;
            $login_user_details                         =   (new Root())->getManufacturerDetails(\Auth::user()->root->id);
            $stock_count_of_manufacturier               =   (new GpsStock())->getInStockCountOfManufacturer($manufacturer_id);
            $stock_summary_details[]                    =       [
                                                                'user'              =>  'Manufacturer'.' ( '.$login_user_details->name.' )',
                                                                'in_stock'          =>  $stock_count_of_manufacturier,
                                                                'stock_to_accept'   =>  'NA',
                                                                'modal_section'     =>  '#setManufacturerModal'
                                                            ];
            $stock_details_of_manufacturer[]            =   [
                                                                'user'              =>  ucfirst(strtolower($login_user_details->name)),
                                                                'in_stock'          =>  $stock_count_of_manufacturier
                                                            ];
            //distributor section
            $distributor_details                        =   (new Dealer())->getDistributorsOfManufacturer($manufacturer_id); 
            $distributor_user_ids                       =   [];
            $distributor_ids                            =   [];
            foreach($distributor_details as $each_data)
            {
                $distributor_user_ids[]                 =   $each_data->user_id;
                $distributor_ids[]                      =   $each_data->id;
                $stock_details_of_distributors[]        =   $this->getStockDetailsOfDistributor($each_data->name,$each_data->id,$each_data->user_id,$login_user_details->name); 
            }
            $stock_count_of_distributor                 =   (new GpsStock())->getInStockCountOfDistributor($distributor_ids);
            $stock_to_accept_count_of_distributor       =   (new GpsTransfer())->getStockToAcceptCount($distributor_user_ids);
            $stock_summary_details[]                    =   [
                                                                'user'              =>  'Distributors',
                                                                'in_stock'          =>  $stock_count_of_distributor,
                                                                'stock_to_accept'   =>  $stock_to_accept_count_of_distributor[0]->count,
                                                                'modal_section'     =>  '#setDistributorModal'
                                                            ];
            //dealer section
            $dealer_details                             =   (new SubDealer())->getDealersOfDistributers($distributor_ids); 
            $dealer_user_ids                            =   [];
            $dealer_ids                                 =   [];
            foreach($dealer_details as $each_data)
            {
                $dealer_user_ids[]                      =   $each_data->user_id;
                $dealer_ids[]                           =   $each_data->id;
                $stock_details_of_dealers[]             =   $this->getStockDetailsOfDealer($each_data->name,$each_data->id,$each_data->user_id,$each_data->dealer->name); 
            }
            $stock_count_of_dealer                      =   (new GpsStock())->getInStockCountOfDealer($dealer_ids);
            $stock_to_accept_count_of_dealer            =   (new GpsTransfer())->getStockToAcceptCount($dealer_user_ids);
            $stock_summary_details[]                    =   [
                                                                'user'              =>  'Dealers',
                                                                'in_stock'          =>  $stock_count_of_dealer,
                                                                'stock_to_accept'   =>  $stock_to_accept_count_of_dealer[0]->count,
                                                                'modal_section'     =>  '#setDealerModal'
                                                            ];
            //sub dealer details
            $sub_dealer_details                         =   (new Trader())->getSubDealersOfDealers($dealer_ids); 
            $sub_dealer_user_ids                        =   [];
            $sub_dealer_ids                             =   [];
            foreach($sub_dealer_details as $each_data)
            {
                $sub_dealer_user_ids[]                  =   $each_data->user_id;
                $sub_dealer_ids[]                       =   $each_data->id;
                $stock_details_of_sub_dealers[]         =   $this->getStockDetailsOfSubDealer($each_data->name,$each_data->id,$each_data->user_id,$each_data->subDealer->name); 
            }
            $stock_count_of_sub_dealer                  =   (new GpsStock())->getInStockCountOfSubDealer($sub_dealer_ids);
            $stock_to_accept_count_of_sub_dealer        =   (new GpsTransfer())->getStockToAcceptCount($sub_dealer_user_ids);
            $stock_summary_details[]                    =   [
                                                                'user'              =>  'Sub Dealers',
                                                                'in_stock'          =>  $stock_count_of_sub_dealer,
                                                                'stock_to_accept'   =>  $stock_to_accept_count_of_sub_dealer[0]->count,
                                                                'modal_section'     =>  '#setSubDealerModal'
                                                            ];
            return  [
                        'stock_summary_details'         =>  $stock_summary_details,
                        'stock_details_of_manufacturer' =>  $stock_details_of_manufacturer,
                        'stock_details_of_distributors' =>  $stock_details_of_distributors,
                        'stock_details_of_dealers'      =>  $stock_details_of_dealers,
                        'stock_details_of_sub_dealers'  =>  $stock_details_of_sub_dealers,
                        'login_user'                    =>  ucfirst(strtolower($login_user_details->name)).' '.'( Manufacturer )'
                    ];
        }
        else if(\Auth::user()->hasRole('dealer'))
        {
            $distributor_user_ids[]                     =   \Auth::user()->id;
            $distributor_ids[]                          =   \Auth::user()->dealer->id;
            $login_user_details                         =   (new Dealer())->getDistributorDetails(\Auth::user()->dealer->id);
            $stock_count_of_distributor                 =   (new GpsStock())->getInStockCountOfDistributor($distributor_ids);
            $stock_to_accept_count_of_distributor       =   (new GpsTransfer())->getStockToAcceptCount($distributor_user_ids);
            $stock_summary_details[]                    =   [
                                                                'user'              =>  'Distributor'.' ( '.$login_user_details->name.' )',
                                                                'in_stock'          =>  $stock_count_of_distributor,
                                                                'stock_to_accept'   =>  $stock_to_accept_count_of_distributor[0]->count,
                                                                'modal_section'     =>  '#setDistributorModal'
                                                            ];
            $stock_details_of_distributors[]            =   [
                                                                'manufacturer_name' =>  ucfirst(strtolower($login_user_details->root->name)), 
                                                                'in_stock'          =>  $stock_count_of_distributor,
                                                                'stock_to_accept'   =>  $stock_to_accept_count_of_distributor[0]->count,
                                                                'distributor_name'  =>  ucfirst(strtolower($login_user_details->name))
                                                            ];   
            
            //dealer section
            $dealer_details                             =   (new SubDealer())->getDealersOfDistributers($distributor_ids); 
            $dealer_user_ids                            =   [];
            $dealer_ids                                 =   [];
            foreach($dealer_details as $each_data)
            {
                $dealer_user_ids[]                      =   $each_data->user_id;
                $dealer_ids[]                           =   $each_data->id;
                $stock_details_of_dealers[]             =   $this->getStockDetailsOfDealer($each_data->name,$each_data->id,$each_data->user_id,$each_data->dealer->name); 
            }
            $stock_count_of_dealer                      =   (new GpsStock())->getInStockCountOfDealer($dealer_ids);
            $stock_to_accept_count_of_dealer            =   (new GpsTransfer())->getStockToAcceptCount($dealer_user_ids);
            $stock_summary_details[]                    =   [
                                                                'user'              =>  'Dealers',
                                                                'in_stock'          =>  $stock_count_of_dealer,
                                                                'stock_to_accept'   =>  $stock_to_accept_count_of_dealer[0]->count,
                                                                'modal_section'     =>  '#setDealerModal'
                                                            ];
            //sub dealer details
            $sub_dealer_details                         =   (new Trader())->getSubDealersOfDealers($dealer_ids); 
            $sub_dealer_user_ids                        =   [];
            $sub_dealer_ids                             =   [];
            foreach($sub_dealer_details as $each_data)
            {
                $sub_dealer_user_ids[]                  =   $each_data->user_id;
                $sub_dealer_ids[]                       =   $each_data->id;
                $stock_details_of_sub_dealers[]         =   $this->getStockDetailsOfSubDealer($each_data->name,$each_data->id,$each_data->user_id,$each_data->subDealer->name); 
            }
            $stock_count_of_sub_dealer                  =   (new GpsStock())->getInStockCountOfSubDealer($sub_dealer_ids);
            $stock_to_accept_count_of_sub_dealer        =   (new GpsTransfer())->getStockToAcceptCount($sub_dealer_user_ids);
            $stock_summary_details[]                    =   [
                                                            'user'              =>  'Sub Dealers',
                                                            'in_stock'          =>  $stock_count_of_sub_dealer,
                                                            'stock_to_accept'   =>  $stock_to_accept_count_of_sub_dealer[0]->count,
                                                            'modal_section'     =>  '#setSubDealerModal'
                                                        ];
        return  [
                    'stock_summary_details'             =>  $stock_summary_details,
                    'stock_details_of_manufacturer'     =>  $stock_details_of_manufacturer,
                    'stock_details_of_distributors'     =>  $stock_details_of_distributors,
                    'stock_details_of_dealers'          =>  $stock_details_of_dealers,
                    'stock_details_of_sub_dealers'      =>  $stock_details_of_sub_dealers,
                    'login_user'                        =>  ucfirst(strtolower($login_user_details->name)).' '.'( Distributor )'
                ];
            
        }
        else if(\Auth::user()->hasRole('sub_dealer'))
        {
            //dealer section
            $dealer_user_ids[]                          =   \Auth::user()->id;
            $dealer_ids[]                               =   \Auth::user()->subdealer->id;
            $login_user_details                         =   (new SubDealer())->getDealerDetails(\Auth::user()->subdealer->id);
            $stock_count_of_dealer                      =   (new GpsStock())->getInStockCountOfDealer($dealer_ids);
            $stock_to_accept_count_of_dealer            =   (new GpsTransfer())->getStockToAcceptCount($dealer_user_ids);
            $stock_summary_details[]                    =   [
                                                                'user'              =>  'Dealer'.' ( '.$login_user_details->name.' )',
                                                                'in_stock'          =>  $stock_count_of_dealer,
                                                                'stock_to_accept'   =>  $stock_to_accept_count_of_dealer[0]->count,
                                                                'modal_section'     =>  '#setDealerModal'
                                                            ];
            $stock_details_of_dealers[]                 =   [
                                                                'distributor_name'  =>  ucfirst(strtolower($login_user_details->dealer->name)), 
                                                                'in_stock'          =>  $stock_count_of_dealer,
                                                                'stock_to_accept'   =>  $stock_to_accept_count_of_dealer[0]->count,
                                                                'dealer_name'       =>  ucfirst(strtolower($login_user_details->name))
                                                            ]; 
            //sub dealer details
            $sub_dealer_details                         =   (new Trader())->getSubDealersOfDealers($dealer_ids); 
            $sub_dealer_user_ids                        =   [];
            $sub_dealer_ids                             =   [];
            foreach($sub_dealer_details as $each_data)
            {
                $sub_dealer_user_ids[]                  =   $each_data->user_id;
                $sub_dealer_ids[]                       =   $each_data->id;
                $stock_details_of_sub_dealers[]         =   $this->getStockDetailsOfSubDealer($each_data->name,$each_data->id,$each_data->user_id,$each_data->subDealer->name); 
            }
            $stock_count_of_sub_dealer                  =   (new GpsStock())->getInStockCountOfSubDealer($sub_dealer_ids);
            $stock_to_accept_count_of_sub_dealer        =   (new GpsTransfer())->getStockToAcceptCount($sub_dealer_user_ids);
            $stock_summary_details[]                    =   [
                                                                'user'              =>  'Sub Dealers',
                                                                'in_stock'          =>  $stock_count_of_sub_dealer,
                                                                'stock_to_accept'   =>  $stock_to_accept_count_of_sub_dealer[0]->count,
                                                                'modal_section'     =>  '#setSubDealerModal'
                                                            ];
            return  [
                        'stock_summary_details'         =>  $stock_summary_details,
                        'stock_details_of_manufacturer' =>  $stock_details_of_manufacturer,
                        'stock_details_of_distributors' =>  $stock_details_of_distributors,
                        'stock_details_of_dealers'      =>  $stock_details_of_dealers,
                        'stock_details_of_sub_dealers'  =>  $stock_details_of_sub_dealers,
                        'login_user'                    =>  ucfirst(strtolower($login_user_details->name)).' '.'( Dealer )'
                    ];
            
        }
        else if(\Auth::user()->hasRole('trader'))
        {
            //dealer section
            $sub_dealer_user_ids[]                      =   \Auth::user()->id;
            $sub_dealer_ids[]                           =   \Auth::user()->trader->id;
            $login_user_details                         =   (new Trader())->getSubDealerDetails(\Auth::user()->trader->id);
            $stock_count_of_sub_dealer                  =   (new GpsStock())->getInStockCountOfSubDealer($sub_dealer_ids);
            $stock_to_accept_count_of_sub_dealer        =   (new GpsTransfer())->getStockToAcceptCount($sub_dealer_user_ids);
            $stock_summary_details[]                    =   [
                                                                'user'              =>  'Sub Dealer'.' ( '.$login_user_details->name.' )',
                                                                'in_stock'          =>  $stock_count_of_sub_dealer,
                                                                'stock_to_accept'   =>  $stock_to_accept_count_of_sub_dealer[0]->count,
                                                                'modal_section'     =>  '#setSubDealerModal'
                                                            ];
            $stock_details_of_sub_dealers[]             =   [
                                                                'dealer_name'       =>  ucfirst(strtolower($login_user_details->subDealer->name)), 
                                                                'in_stock'          =>  $stock_count_of_sub_dealer,
                                                                'stock_to_accept'   =>  $stock_to_accept_count_of_sub_dealer[0]->count,
                                                                'sub_dealer_name'   =>  ucfirst(strtolower($login_user_details->name))
                                                            ]; 
            return  [
                        'stock_summary_details'         =>  $stock_summary_details,
                        'stock_details_of_manufacturer' =>  $stock_details_of_manufacturer,
                        'stock_details_of_distributors' =>  $stock_details_of_distributors,
                        'stock_details_of_dealers'      =>  $stock_details_of_dealers,
                        'stock_details_of_sub_dealers'  =>  $stock_details_of_sub_dealers,
                        'login_user'                    =>  ucfirst(strtolower($login_user_details->name)).' '.'( Sub Dealer )'
                    ];
            
        }
    }

    public function getStockDetailsOfDistributor($distributor_name,$distributor_id,$distributor_user_id,$manufacturer_name)
    {
        $in_stock_count                 =   (new GpsStock())->getInStockCountOfDistributor([$distributor_id]);
        $stock_to_accept_count          =   (new GpsTransfer())->getStockToAcceptCount([$distributor_user_id]);
        $stock_details_of_distributor   =   [
                                                'manufacturer_name' =>  ucfirst(strtolower($manufacturer_name)), 
                                                'in_stock'          =>  $in_stock_count,
                                                'stock_to_accept'   =>  $stock_to_accept_count[0]->count,
                                                'distributor_name'  =>  ucfirst(strtolower($distributor_name))
                                            ];     
        return $stock_details_of_distributor;
        
    }

    public function getStockDetailsOfDealer($dealer_name,$dealer_id,$dealer_user_id,$distributor_name)
    {
        $in_stock_count                 =   (new GpsStock())->getInStockCountOfDealer([$dealer_id]);
        $stock_to_accept_count          =   (new GpsTransfer())->getStockToAcceptCount([$dealer_user_id]);
        $stock_details_of_dealer        =   [
                                                'distributor_name'  =>  ucfirst(strtolower($distributor_name)), 
                                                'in_stock'          =>  $in_stock_count,
                                                'stock_to_accept'   =>  $stock_to_accept_count[0]->count,
                                                'dealer_name'       =>  ucfirst(strtolower($dealer_name))
                                            ];     
        return $stock_details_of_dealer;
        
    }

    public function getStockDetailsOfSubDealer($sub_dealer_name,$sub_dealer_id,$sub_dealer_user_id,$dealer_name)
    {
        $in_stock_count                 =   (new GpsStock())->getInStockCountOfSubDealer([$sub_dealer_id]);
        $stock_to_accept_count          =   (new GpsTransfer())->getStockToAcceptCount([$sub_dealer_user_id]);
        $stock_details_of_sub_dealer    =   [
                                                'dealer_name'       =>  ucfirst(strtolower($dealer_name)), 
                                                'in_stock'          =>  $in_stock_count,
                                                'stock_to_accept'   =>  $stock_to_accept_count[0]->count,
                                                'sub_dealer_name'   =>  ucfirst(strtolower($sub_dealer_name))
                                            ];     
        return $stock_details_of_sub_dealer;
        
    }
    /**
     * 
     * PLAN BASED REPORT
     */
    public function planBasedReport(Request $request)
    {
        $plan_type                      = ( isset($request->plan) ) ? $request->plan : null;
        $download_type                  = ( isset($request->type) ) ? $request->type : null;
        $count_of_clients_under_plan    = [];
        $client_user_ids                = (new Client())->getUserIdOfAllClientsWithTrashedItems();
        $manufacturer_details           = (new Root())->getManufacturerDetails(\Auth::user()->root->id);
        if($plan_type == '')
        { 
            $plan_based_details         = (new User())->getUserRoleDetailsOfAllClients($client_user_ids, $download_type);
            if($download_type == 'pdf')
            {
                $all_plans                  = config('eclipse.PLANS');
                foreach($all_plans as $each_plan)
                {
                    $get_count_of_clients_under_plan    = (new User())->getCountOfClientsUnderPlan($client_user_ids, $each_plan['ID']);
                    $count_of_clients_under_plan[]      = [
                        'name'  => $each_plan['NAME'],
                        'count' => $get_count_of_clients_under_plan
                    ];
                }
            }
        }
        else
        {
            $plan_based_details = (new User())->getUserRoleDetailsOfAllClients($client_user_ids, $download_type, $plan_type);
            if($download_type == 'pdf')
            {
                $plan_names                         = array_column(config('eclipse.PLANS'), 'NAME', 'ID');
                $get_count_of_clients_under_plan    = (new User())->getCountOfClientsUnderPlan($client_user_ids, $plan_type);
                $count_of_clients_under_plan[]      = [
                    'name'  => $plan_names[$plan_type],
                    'count' => $get_count_of_clients_under_plan
                ];
            }
        }
        if($download_type == 'pdf')
        {
            $pdf                    =   PDF::loadView('GpsReport::plan-based-report-download',[ 'plan_based_details' => $plan_based_details, 'plan_type' => $plan_type, 'count_of_clients_under_plan' => $count_of_clients_under_plan, 'generated_by' => ucfirst(strtolower($manufacturer_details->name)).' '.'( Manufacturer )', 'generated_on' => date("d/m/Y h:i:s A") ]);
            return $pdf->download('plan-based-report.pdf');
        }
        else
        {
            return view('GpsReport::plan-based-report-in-manufacturer',[ 'plan_based_details' => $plan_based_details, 'plan_type' => $plan_type] );
        }
    }

    /**
     * 
     * 
     */
    public function planBasedReportGraph(Request $request)
    {
        $plan_type                      = ( isset($request->plan_type) ) ? $request->plan_type : null;
        $download_type                  = ( isset($request->type) ) ? $request->type : null;
        $plan_name                      = [];
        $client_count                   = [];
        $client_user_ids                = (new Client())->getUserIdOfAllClientsWithTrashedItems();
        if($plan_type == '')
        { 
            $all_plans  = config('eclipse.PLANS');
            foreach($all_plans as $each_plan)
            {
                $count_of_clients_under_plan    = (new User())->getCountOfClientsUnderPlan($client_user_ids, $each_plan['ID']);
                $plan_name[]                    = $each_plan['NAME'];
                $client_count[]                 = $count_of_clients_under_plan;
            }
        }
        else
        {
            $plan_names                         = array_column(config('eclipse.PLANS'), 'NAME', 'ID');
            $count_of_clients_under_plan        = (new User())->getCountOfClientsUnderPlan($client_user_ids,$plan_type);
            $plan_name                          = [$plan_names[$plan_type]];
            $client_count                       = [$count_of_clients_under_plan];
        }
        return response()->json(array('plan_name' =>$plan_name, 'client_count' =>$client_count ));
    }

    /**
     * 
     * DEVICE STATUS REPORT
     */
    public function deviceStatusReport()
    {
        $online_limit_date              =   date('Y-m-d H:i:s',strtotime("-".config('eclipse.OFFLINE_DURATION').""));
        $current_time                   =   date('Y-m-d H:i:s');
        $device_online_count           =   (new GPS())->getDeviceOnlineCount($online_limit_date,$current_time);
        $device_onfline_count          =   (new GPS())->getDeviceOfflineCount($online_limit_date,$current_time);
        // dd($device_onfline_report);
        return view('GpsReport::device-status-report',['device_online_count'=>$device_online_count,'device_onfline_count'=>$device_onfline_count]);
    }
    /**
     * DEVICE ONLINE REPORT
     */
    public function deviceOnlineReport(Request $request)
    {
        $generated_by                   =   \Auth::user()->operations->name;
        $logged_user_details            =   (new Operations())->getOperatorDetails(\Auth::user()->operations->id);
        $online_limit_date              =   date('Y-m-d H:i:s',strtotime("-".config('eclipse.OFFLINE_DURATION').""));
        $current_time                   =   date('Y-m-d H:i:s');
        $device_status                  =   (isset($request->device_status) ) ? $request->device_status : 1;     
        $download_type                  =   ( isset($request->type) ) ? $request->type : null;
        // $search_key                     =   ( isset($request->search_key) ) ? $request->search_key : null;
        $search                         =   ( isset($request->search) ) ? $request->search : null;     
        
        $gps_ids                        =   (new Vehicle())->getAllVehiclesWithUnreturnedGps();
        $vehicle_status                 =   (isset($request->vehicle_status) ) ? $request->vehicle_status : null;      
        $device_online_report           =   (new GPS())->getDeviceOnlineReport($online_limit_date,$current_time,$vehicle_status,$device_status,$gps_ids,$search,$download_type);
     
       
        if($download_type == 'pdf')
        {
            if($device_online_report->count()>0)
            {
                $pdf                        =   PDF::loadView('GpsReport::device-online-report-download',[ 'device_online_report' => $device_online_report, 'generated_by' => $generated_by, 'manufactured_by' => ucfirst(strtolower($logged_user_details->root->name)).' '.'( Manufacturer )','generated_on' => date("d/m/Y h:m:s A") ]);
                return $pdf->download('device-online-report.pdf');
            }
            else{
               return view('GpsReport::device-online-report',['device_online_report'=>$device_online_report,'device_status'=>$device_status,'vehicle_status'=>$vehicle_status,'search'=>$search]);    
            }
            
        }  
        else if($request->ajax())
        {
            // dd($device_online_report);
            return ($device_online_report != null) ? Response([ 'links' => $device_online_report->appends(['sort' => 'votes'])]) : Response([ 'links' => null]);
        }
        else
        {
            // dd($search);
            return view('GpsReport::device-online-report',['device_online_report'=>$device_online_report,'device_status'=>$device_status,'vehicle_status'=>$vehicle_status,'search'=>$search]);    
        }
    }

    /**
     * 
     * GPS Offline Report
     */
    public function deviceOfflineReport(Request $request)
    {
        $device_type            = ( isset($request->device_type) ) ? $request->device_type : config("eclipse.DEVICE_STATUS.TAGGED");
        $offline_duration       = ( isset($request->offline_duration) ) ? $request->offline_duration : null;
        $download_type          = ( isset($request->type) ) ? $request->type : null;
        // $search_key          = ( isset($request->search_key) ) ? $request->search_key : null;
        $search_key             =   ( isset($request->search) ) ? $request->search : null;     
       
        $logged_user_details    = (new Operations())->getOperatorDetails(\Auth::user()->operations->id);

        if($offline_duration == null )
        {
            $offline_duration_in_minutes    = '-'. config('eclipse.OFFLINE_DURATION');
        }
        else
        {
            $offline_duration_in_minutes    = '-'. $offline_duration * 60 .' minutes';
        }
        $offline_date_time                  = date('Y-m-d H:i:s',strtotime("".$offline_duration_in_minutes.""));
        $gps_id_of_active_vehicles          = null;
        if( $device_type == config("eclipse.DEVICE_STATUS.TAGGED") || $device_type == config("eclipse.DEVICE_STATUS.UNTAGGED"))
        {
            $gps_id_of_active_vehicles      = (new Vehicle())->getAllVehiclesWithUnreturnedGps();
        }
        $offline_devices                    = (new Gps())->getAllOfflineDevices($offline_date_time, $device_type, $download_type , $gps_id_of_active_vehicles,$search_key);
        if( $download_type == 'pdf')
        {
            if($offline_devices->count()>0)
            {
                $pdf    =   PDF::loadView('GpsReport::device-offline-status-report-download',[ 'offline_devices' => $offline_devices, 'offline_duration' => $offline_duration, 'device_type' => $device_type, 'generated_by' => ucfirst(strtolower($logged_user_details->root->name)).' '.'( Manufacturer )', 'user_generated_by' => $logged_user_details->name, 'generated_on' => date("d/m/Y h:i:s A") ]);
                return $pdf->download('device-offline-status-report.pdf');
            }
            else{
                return view('GpsReport::device-offline-status-report', [ 'offline_devices' => $offline_devices, 'offline_duration' => $offline_duration, 'device_type' => $device_type]);
            }
        }
        else if($request->ajax())
        {            
            return ($offline_devices != null) ? Response([ 'links' => $offline_devices->appends(['sort' => 'votes'])]) : Response([ 'links' => null]);
        }
        else
        {
            
            return view('GpsReport::device-offline-status-report', [ 'offline_devices' => $offline_devices, 'offline_duration' => $offline_duration, 'device_type' => $device_type, 'search_key' => $search_key ]);
        }
    }
    /**
     * 
     * 
     */
    public function deviceReportDetailedView(Request $request)
    {
        $imei               = Crypt::decrypt($request->imei);
        //get offline time limit
        $offline_date_time  = date('Y-m-d H:i:s',strtotime("".'-'. config('eclipse.OFFLINE_DURATION').""));

        //get gps details based on imei
        $gps_details        = (new Gps())->getDeviceDetailsBasedOnImei($imei);
        
        if( $gps_details->device_time <= $offline_date_time ) 
        {
            $gps_details->device_status = '#c41900';
            $gps_details->mode          = 'Offline ('.$gps_details->mode.')';
        }
        else
        { 
            switch( $gps_details->mode )
            {
                case 'M':
                    $gps_details->device_status = '#84b752';
                    $gps_details->mode          = 'Motion';
                    break;
                case 'H':
                    $gps_details->device_status = '#69b4b9';
                    $gps_details->mode          = 'Halt';
                    break;
                case 'S':
                    $gps_details->device_status = '#858585';
                    $gps_details->mode          = 'Sleep';
                    break;
                default:
                    $gps_details->device_status = '#c41900';
                    $gps_details->mode          = 'Offline';
                    break;
            }
        }
        //SIGNAL STRENGTH
        if ($gps_details->gsm_signal_strength >= 19 ) 
        {
            $gps_details->gsm_signal_strength = "GOOD";
        }
        else if ($gps_details->gsm_signal_strength < 19 && $gps_details->gsm_signal_strength >= 13 ) 
        {
            $gps_details->gsm_signal_strength = "AVERAGE";
        }
        else if ($gps_details->gsm_signal_strength <= 12 )
        {
            $gps_details->gsm_signal_strength = "POOR";
        }
        else
        {
            $gps_details->gsm_signal_strength = "LOST";
        }
        // AC STATUS
        if( $gps_details->ac_status == 1 )
        {
            $gps_details->ac_status = "ON";
        }
        else if( $gps_details->ac_status == 0 )
        {
            $gps_details->ac_status = "OFF";
        }
        //IGNITION
        if( $gps_details->ignition == 1 )
        {
            $gps_details->ignition = "ON";
        }
        else if( $gps_details->ignition == 0 )
        {
            $gps_details->ignition = "OFF";
        }
        //MAIN POWER STATUS
        if( $gps_details->main_power_status == 1) 
        {
            $gps_details->main_power_status  = "CONNECTED";
        }
        else if( $gps_details->main_power_status == 0) 
        {
            $gps_details->main_power_status  = "DISCONNECTED";
        }
        //TILT
        if( $gps_details->tilt_status == 1) 
        {
            $gps_details->tilt_status  = "YES";
        }
        else
        {
            $gps_details->tilt_status  = "NO";
        }
        //OVER SPEED
        if( $gps_details->overspeed_status == 1) 
        {
            $gps_details->overspeed_status  = "YES";
        }
        else
        {
            $gps_details->overspeed_status  = "NO";
        }
        //EMERGENCY
        if( $gps_details->emergency_status == 1) 
        {
            $gps_details->emergency_status  = "YES";
        }
        else
        {
            $gps_details->emergency_status  = "NO";
        }
        //RETURN STATUS
        if( $gps_details->is_returned == 1) 
        {
            $gps_details->is_returned  = "YES";
        }
        else
        {
            $gps_details->is_returned  = "NO";
        }
        //REFURBISHED STATUS
        if( $gps_details->refurbished_status == 1) 
        {
            $gps_details->refurbished_status  = "YES";
        }
        else
        {
            $gps_details->refurbished_status  = "NO";
        }
        //get location based on latlng
        $last_location      = $this->getPlacenameFromLatLng($gps_details->lat,$gps_details->lon);
        return view('GpsReport::device-detailed-report-view', [ 'gps_details' => $gps_details, 'last_location' => $last_location ]);
    }

    /**
     * 
     * 
     */
    public function deviceReportDetailedViewOfVehicle(Request $request)
    {
        $gps_id                 = $request->gps_id;
        $driver_details         = [];
        $vehicle_details        = (new VehicleGps())->getSingleVehicleDetailsBasedOnGps($gps_id);
        if($vehicle_details)
        {
            //THEFT MODE
            if( $vehicle_details->vehicle->theft_mode == 1) 
            {
                $vehicle_details->vehicle->theft_mode  = "Enabled";
            }
            else
            {
                $vehicle_details->vehicle->theft_mode  = "Disabled";
            }
            //TOWING STATUS
            if( $vehicle_details->vehicle->towing == 1) 
            {
                $vehicle_details->vehicle->towing  = "Enabled";
            }
            else
            {
                $vehicle_details->vehicle->towing  = "Disabled";
            }
            if($vehicle_details->vehicle->driver_id)
            {
                $driver_details     = (new Driver())->getDriverDetails($vehicle_details->vehicle->driver_id);
                ( $driver_details->points > 100 ) ? $driver_details->points = 100 : $driver_details->points;
                ( $driver_details->points < 0 )   ? $driver_details->points = 0 : $driver_details->points;
            }
        }
        
        $vehicle_driver_details = array( 'vehicle_details' => $vehicle_details, 'driver_details' => $driver_details);
        return response()->json($vehicle_driver_details);
    }

    /**
     * 
     * 
     */
    public function deviceReportDetailedViewOfTransfer(Request $request)
    {
        $gps_id             = $request->gps_id;
        $transfer_details   = (new GpsStock())->getTransactionDetailsBasedOnGps($gps_id);
        return response()->json($transfer_details);
    }

    /**
     * 
     * 
     */
    public function deviceReportDetailedViewOfEndUser(Request $request)
    {
        $gps_id             = $request->gps_id;
        $owner_details      = [];
        $transfer_details    = (new GpsStock())->getTransactionDetailsBasedOnGps($gps_id);
        if($transfer_details)
        {
            ($transfer_details->client_id) ? $owner_details = (new Client())->getClientDetailsOfVehicle($transfer_details->client_id) : $owner_details = null;
            $plan_names = array_column(config('eclipse.PLANS'), 'NAME', 'ID');
            ($owner_details) ? $owner_details->user->role = ucfirst(strtolower($plan_names[$owner_details->user->role]))  : $owner_details->user->role = '-NA-'  ;
        }
        return response()->json($owner_details);
    }

    /**
     * 
     * 
     */
    public function deviceReportDetailedViewOfInstallation(Request $request)
    {
        $gps_id                 = $request->gps_id;
        $installation_details   = (new ServicerJob())->getInstallationBasedOnGps($gps_id);
        if( $installation_details )
        {
            if( $installation_details->status == 1 )
            {
                $installation_details->status = 'Pending';
            }
            else if( $installation_details->status == 2 )
            {
                $installation_details->status = 'In Progress';
            }
            else if( $installation_details->status == 3 )
            {
                $installation_details->status = 'Completed';
            }
        }
        return response()->json($installation_details);
    }

    /**
     * 
     * 
     */
    public function deviceReportDetailedViewOfServices(Request $request)
    {
        $gps_id             = $request->gps_id;
        $service_details    = (new ServicerJob())->getServiceDetailsBasedOnGps($gps_id);
        return response()->json($service_details);
    }
    
    /**
     * 
     * 
     */
    public function deviceReportDetailedViewSetOta(Request $request)
    {
        $gps_id     = $request->gps_id;
        $command    = $request->command;
        $imei       = $request->imei;
        $response   = (new OtaResponse())->saveCommandsToDevice($gps_id,$command);
        if($response)
        {
            $is_command_write_to_device =   (new OtaResponse())->writeCommandToDevice($imei,$command);
            if($is_command_write_to_device)
            {
                $this->topic            =   $this->topic.'/'.$imei;
                $is_mqtt_publish        =   $this->mqttPublish($this->topic, $command);
                if ($is_mqtt_publish === true) 
                {
                    $request->session()->flash('message','Command send successfully..');
                    $request->session()->flash('alert-class','alert-success');
                }
            }
            
        }
        $request->session()->flash('message','Send command to device is failed!! Please try again..');
        $request->session()->flash('alert-class','alert-success');
        return  redirect(route('device-detailed-report-view',encrypt($imei)));
    }

    /**
     * 
     * 
     */
    public function deviceReportDetailedViewConsole(Request $request)
    {
        $imei       = $request->imei;
        $packets    = (new VltData())->getProcessedAndUnprocessedDataFromDynamicTableVltData($imei);
        return response()->json($packets);
    }

    /**
     * 
     * 
     */
    public function getVehicleAndUserIdBasedOnGps(Request $request)
    {
        $gps_id             = $request->gps_id;
        $vehicle_details    = (new VehicleGps())->getVehicleAndUserIdBasedOnGps($gps_id);
        return response()->json($vehicle_details);
    }

    /**
     * 
     * Find location based on latitude and longitude
     */
    private function getPlacenameFromLatLng($latitude,$longitude)
    {
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key='.config('eclipse.keys.googleMap'));
            $output = json_decode($geocodeFromLatLong);
            $status = $output->status;
            //Get address from json data
            $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            //Return address of the given latitude and longitude
            if(!empty($address)){
                return $address;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    /**
     * 
     */
    public function deviceReportDetailedViewOfTransferHistory(Request $request)
    {
        $gps_id             =  $request->gps_id;
        $transfer_details   = (new GpsTransferItems())->getTransferDetailsBasedOnGps($gps_id);
        $transfer_log       = [];
        foreach($transfer_details as $each_data)
        {
            $transfer_log[] =   [
                'transfer_from'     =>  $this->getOriginalNameFromUserId($each_data->from_user_id),
                'transfer_to'       =>  $this->getOriginalNameFromUserId($each_data->to_user_id),
                'dispatched_on'     =>  $each_data->dispatched_on,
                'accepted_on'       =>  $each_data->accepted_on,
                'deleted_at'        =>  $each_data->deleted_at
            ];
        }
        return response()->json($transfer_log);
    }
    public function deviceDetailImeiEncription(Request $request)
    {
       return $encrypt_imei=Crypt::encrypt($request['imei']);
    }
}
