<?php
namespace App\Modules\GpsReport\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Client\Models\Client;
use App\Modules\Gps\Models\Gps;
use App\Modules\Gps\Models\GpsTransfer;
use App\Modules\Gps\Models\GpsTransferItems;
use App\Modules\Warehouse\Models\GpsStock;
use App\Modules\User\Models\User;
use App\Modules\Root\Models\Root;
use App\Modules\Dealer\Models\Dealer;
use App\Modules\SubDealer\Models\SubDealer;
use App\Modules\Trader\Models\Trader;
use Illuminate\Support\Facades\Crypt;
use App\Http\Traits\UserTrait;
use DataTables;
use DB;
use PDF;

class GpsReportController extends Controller 
{
    /**
     * 
     * 
     */
    use UserTrait;
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
                $pdf                    =   PDF::loadView('GpsReport::gps-transfer-report-download',['transfer_summary' => $transfer_details['transfer_summary'], 'manufacturer_to_distributor_details'=> $transfer_details['manufacturer_to_distributor_details'], 'distributor_to_dealer_details' => $transfer_details['distributor_to_dealer_details'], 'dealer_to_sub_dealer_details'=> $transfer_details['dealer_to_sub_dealer_details'],'dealer_to_client_details' => $transfer_details['dealer_to_client_details'], 'sub_dealer_to_client_details' => $transfer_details['sub_dealer_to_client_details'], 'generated_by' => $transfer_details['generated_by'].' '.'( Manufacturer )', 'generated_on' => date("d/m/Y h:m:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
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
                $pdf                    =   PDF::loadView('GpsReport::gps-transfer-report-download',['transfer_summary' => $transfer_details['transfer_summary'], 'manufacturer_to_distributor_details'=> $transfer_details['manufacturer_to_distributor_details'], 'distributor_to_dealer_details' => $transfer_details['distributor_to_dealer_details'], 'dealer_to_sub_dealer_details'=> $transfer_details['dealer_to_sub_dealer_details'],'dealer_to_client_details' => $transfer_details['dealer_to_client_details'], 'sub_dealer_to_client_details' => $transfer_details['sub_dealer_to_client_details'], 'generated_by' => $transfer_details['generated_by'].' '.'( Distributor )', 'generated_on' => date("d/m/Y h:m:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
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
                $pdf                    =   PDF::loadView('GpsReport::gps-transfer-report-download',['transfer_summary' => $transfer_details['transfer_summary'], 'manufacturer_to_distributor_details'=> $transfer_details['manufacturer_to_distributor_details'], 'distributor_to_dealer_details' => $transfer_details['distributor_to_dealer_details'], 'dealer_to_sub_dealer_details'=> $transfer_details['dealer_to_sub_dealer_details'],'dealer_to_client_details' => $transfer_details['dealer_to_client_details'], 'sub_dealer_to_client_details' => $transfer_details['sub_dealer_to_client_details'], 'generated_by' => $transfer_details['generated_by'].' '.'( Dealer )', 'generated_on' => date("d/m/Y h:m:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
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
                $pdf                    =   PDF::loadView('GpsReport::gps-transfer-report-download',['transfer_summary' => $transfer_details['transfer_summary'], 'manufacturer_to_distributor_details'=> $transfer_details['manufacturer_to_distributor_details'], 'distributor_to_dealer_details' => $transfer_details['distributor_to_dealer_details'], 'dealer_to_sub_dealer_details'=> $transfer_details['dealer_to_sub_dealer_details'],'dealer_to_client_details' => $transfer_details['dealer_to_client_details'], 'sub_dealer_to_client_details' => $transfer_details['sub_dealer_to_client_details'], 'generated_by' => $transfer_details['generated_by'].' '.'( Sub Dealer )', 'generated_on' => date("d/m/Y h:m:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
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
                $pdf                            =   PDF::loadView('GpsReport::gps-return-report-download',['return_details' => $return_details, 'return_device_details' => $return_device_details, 'return_device_manufactured' => $return_device_manufactured,'generated_by' => ucfirst(strtolower($manufacturer_details->name)).' '.'( Manufacturer )', 'generated_on' => date("d/m/Y h:m:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
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
                $pdf                            =   PDF::loadView('GpsReport::gps-return-report-download',['return_details' => $return_details, 'return_device_details' => $return_device_details, 'return_device_manufactured' => $return_device_manufactured,'generated_by' => ucfirst(strtolower($distributor_details->name)).' '.'( Distributor )', 'generated_on' => date("d/m/Y h:m:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
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
                $pdf                            =   PDF::loadView('GpsReport::gps-return-report-download',['return_details' => $return_details, 'return_device_details' => $return_device_details, 'return_device_manufactured' => $return_device_manufactured,'generated_by' => ucfirst(strtolower($dealer_details->name)).' '.'( Dealer )', 'generated_on' => date("d/m/Y h:m:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
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
                $pdf                            =   PDF::loadView('GpsReport::gps-return-report-download',['return_details' => $return_details, 'return_device_details' => $return_device_details, 'return_device_manufactured' => $return_device_manufactured,'generated_by' => ucfirst(strtolower($sub_dealer_details->name)).' '.'( Sub Dealer )', 'generated_on' => date("d/m/Y h:m:s A"), 'from_date' => date('d/m/Y',strtotime($from_date)), 'to_date' => date('d/m/Y',strtotime($to_date))]);
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

}
