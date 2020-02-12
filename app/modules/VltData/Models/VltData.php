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
            ->select('vltdata','created_at');
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
