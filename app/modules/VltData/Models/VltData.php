<?php

namespace App\Modules\VltData\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VltData extends Model
{
    protected $table = 'vlt_data';

    protected $fillable=[];

    /**
     *
     *
     */
    public function getUnprocessedVltData($imei, $header, $search_key,$date)
    {
        $table = "vlt_data_".$date;
        if(Schema::hasTable($table) == true)
        {
            $query  =   DB::table($table)
                            // ->where('is_processed', '0')
                            ->select('vltdata','created_at')
                            ->orderBy('created_at','DESC');
            if( $imei != '0' )
            {
                $query = $query->where('imei', $imei);
            }
            if( $header != '0' )
            {
                $query = $query->where('header',$header);
            }
            if( $search_key != null )
            {
                $query = $query->where('vltdata','LIKE','%'.$search_key."%");
            }
        
            return $query->paginate(10);
        }
    }

    public function getUnprocessedData($imei,$date=null)
    {
        $table = "vlt_data_".date('Ymd');

        $query  =   DB::table($table)
                        ->select('id','imei','vltdata','created_at')
                        ->where('is_processed', '0')
                        ->orderBy('created_at','DESC');
        if( $imei != '0' )
        {
            $query = $query->where('imei', $imei);
        }
        if( $date != null )
        {
            $query = $query->whereDate('created_at', $date);
        }
        return $query->paginate(10);
    }

    /**
     *
     *
     *
     */
    public function getProcessedVltData($imei,$date=null)
    {
        $table = "vlt_data_".date('Ymd');
        
        $query  =   DB::table($table)
                        ->select('id','imei','vltdata','created_at')
                        ->where('is_processed', '1')
                        ->orderBy('created_at','DESC');
        if( $imei != '0' )
        {
            $query = $query->where('imei', $imei);
        }
        if( $date != null )
        {
            $query = $query->whereDate('created_at', $date);
        }
        return $query->paginate(10);
    }
    /**
     *
     *
     *
     */
    public function getProcessedVltDataDownload($imei,$date=null)
    {
        $table = "vlt_data_".date('Ymd');

        $query  =   DB::table($table)
                        ->select('id','imei','vltdata','created_at')
                        ->where('is_processed', '1')
                        ->orderBy('created_at','DESC');
        if( $imei != '0' )
        {
            $query = $query->where('imei', $imei);
        }
        if( $date != null )
        {
            $query = $query->whereDate('created_at', $date);
        }
        return $query->get();
    }

    public function getUnprocessedVltDataDownload($imei,$date=null)
    {
        $table = "vlt_data_".date('Ymd');

        $query  =   DB::table($table)
                        ->select('id','imei','vltdata','created_at')
                        ->where('is_processed', '0')
                        ->orderBy('created_at','DESC');
        if( $imei != '0' )
        {
            $query = $query->where('imei', $imei);
        }
        if( $date != null )
        {
            $query = $query->whereDate('created_at', $date);
        }
        return $query->get();
    }

    public function vltDataImeiUpdation($imei,$imei_incremented)
    {
        return self::select('id','imei')->where('imei',$imei)->update([
                        'imei' =>  $imei_incremented,
                    ]);
    }

    /**
     * 
     * 
     */
    public function getProcessedAndUnprocessedDataFromDynamicTableVltData($imei)
    {
        $packets    = [];
        $table_name = 'vlt_data_'.date('Ymd');
        $this->setTable($table_name);
        if(Schema::hasTable($table_name) == true)
        {
            $packets =  self::select('id','vltdata','created_at')
                            ->where('imei',$imei)
                            ->orderBy('created_at','DESC')
                            ->take(10)->get();
        }
        return $packets;
    }
}
