<?php

namespace App\Modules\VltData\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VltData extends Model
{
    protected $table = 'vlt_data';

    protected $fillable=[];

    /**
     *
     *
     */
    public function getUnprocessedVltData($imei, $header, $search_key)
    {
        $query  =   DB::table('vlt_data')
            ->where('is_processed', '0')
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

    public function getUnprocessedData($imei,$date=null)
    {
        $query  =   DB::table('vlt_data')
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
        $query  =   DB::table('vlt_data')
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
        $query  =   DB::table('vlt_data')
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
        $query  =   DB::table('vlt_data')
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
}
