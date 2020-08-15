<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GpsTransferItems extends Model
{
    // fillable fields
    protected $fillable=['gps_transfer_id','gps_id'];

    //join user table with gps table
    public function gps()
    {
        return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }
    public function gpstransfer()
    {
        return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }
    public function gpsTransferDetail()
    {       
        return $this->hasMany('App\Modules\Gps\Models\GpsTransfer','id','gps_transfer_id');
    }


    
    /**
     * 
     * 
     */
    public function getTransferredGpsDevices($gps_transfer_id)
    {
        return self::select('gps_id')
            ->where('gps_transfer_id', $gps_transfer_id)
            ->get();
    }

    public function updateReturnStatusInTrasferItem($gps_id)
    {
        return self::select('id','gps_id','is_returned')->where('gps_id',$gps_id)
                ->update([
                    'is_returned' =>  1,
                ]);
    }
    public function getTransferDetailsBasedOnGps($gps_id)
    {
        // return DB::table('gps_transfer_items')
        //         ->select('gps_transfers.from_user_id as from_user_id', 'gps_transfers.to_user_id as to_user_id', 'gps_transfers.dispatched_on as dispatched_on', 'gps_transfers.accepted_on as accepted_on', 'gps_transfers.deleted_at as deleted_at')
        //         ->join('gps_transfers', 'gps_transfers.id', '=', 'gps_transfer_items.gps_transfer_id')
        //         ->where('gps_transfer_items.gps_id', $gps_id)
        //         ->get();

        return self::with('gpsTransferDetail.fromUser')
        ->with('gpsTransferDetail.toUser')
        ->where('gps_transfer_items.gps_id', $gps_id)
        ->get();
    }
}
