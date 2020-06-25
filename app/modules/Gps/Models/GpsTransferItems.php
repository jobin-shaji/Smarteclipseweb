<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;

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
        return self::select(
            'id',
            'gps_transfer_id',
            'gps_id'
            )
            ->where('gps_id', $gps_id)
            ->with('gpsTransferDetail.fromUser')
            ->with('gpsTransferDetail.toUser')

            ->get();
    }
    
}
