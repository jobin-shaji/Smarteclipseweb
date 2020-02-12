<?php
namespace App\Modules\VltData\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Gps\Models\Gps;
use App\Modules\VltData\Models\VltData;

class VltDataController extends Controller 
{
    CONST VLT_DTA_HEADER_NORMAL                 =   'NRM';
    CONST VLT_DTA_HEADER_FULL                   =   'FUL';
    CONST VLT_DTA_HEADER_EMERGENCY              =   'EPB';
    CONST VLT_DTA_HEADER_CRITICAL               =   'CRT';
    CONST VLT_DTA_HEADER_BATCH                  =   'BTH';
    CONST VLT_DTA_HEADER__OTA_ACKNOWLEDGMENT    =   'ACK';
    CONST VLT_DTA_HEADER_ACKNOWLEDGMENT         =   'AVK';
    CONST VLT_DTA_HEADER_HEALTH                 =   'HLM';
    CONST VLT_DTA_HEADER_LOGIN                  =   'LGN';
    CONST VLT_DTA_HEADER_ALERT                  =   'ALT';

    /**
     * 
     */
    public $imei;

    /**
     * 
     * 
     */
    public $header;

    /**
     * 
     * 
     */
    public $search_key;

    /**
     * 
     * 
     */
    public function unprocessedDataView(Request $request)
    {
        $imei_list          = (new Gps())->getImeiList();
        $gps_header_list    = self::getVltDataHeaders();
        $data               = [];
        // params
        $this->imei         = ( isset($request->imei) ) ? $request->imei : '';
        $this->header       = ( isset($request->header) ) ? $request->header : '';
        $this->search_key   = ( isset($request->search_key) ) ? $request->search_key : '';

        // filters
        $filters            = [
            'imei'          => $this->imei,
            'header'        => $this->header,
            'search_key'    => $this->search_key
        ];

        if( ($this->imei != '') || ($this->header != '') )
        {
            $data           = (new VltData())->getUnprocessedVltData($this->imei, $this->header, $this->search_key);
        }
        
        return view('VltData::unprocessed-list', [ 'imei_list' => $imei_list, 'headers' => $gps_header_list, 'data' => $data, 'filters' => $filters ]);
    }

    /**
     * 
     * 
     */
    public static function getVltDataHeaders()
    {
        return [
            self::VLT_DTA_HEADER_NORMAL,
            self::VLT_DTA_HEADER_FULL,  
            self::VLT_DTA_HEADER_EMERGENCY,    
            self::VLT_DTA_HEADER_CRITICAL,  
            self::VLT_DTA_HEADER_BATCH,        
            self::VLT_DTA_HEADER__OTA_ACKNOWLEDGMENT,   
            self::VLT_DTA_HEADER_ACKNOWLEDGMENT,   
            self::VLT_DTA_HEADER_HEALTH,
            self::VLT_DTA_HEADER_LOGIN,     
            self::VLT_DTA_HEADER_ALERT  
        ];
    }

    /**
     * 
     * 
     * 
     */
    public function getConsoleData(Request $request)
    {
        $data = (new VltData())->getVltData($this->imei, $this->header, $this->search_key);
    }

    /**
     * 
     * 
     */
    public function getPublicVltData(Request $request)
    {
        $data = (new VltData())->getVltData($this->imei, $this->header, $this->search_key);
    }
}