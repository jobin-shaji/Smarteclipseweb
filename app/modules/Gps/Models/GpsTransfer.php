<?php

namespace App\Modules\Gps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\DeleteScope;
use DB;

class GpsTransfer extends Model
{
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DeleteScope);
    }

	// fillable fields
    protected $fillable=['from_user_id','to_user_id','order_number','scanned_employee_code','invoice_number','dispatched_on','accepted_on'];

	//join user table with gps table
    public function gps()
    {
    	return $this->hasOne('App\Modules\Gps\Models\Gps','id','gps_id');
    }

	//join user table with gps table
    public function fromUser()
    {
    	return $this->hasOne('App\Modules\User\Models\User','id','from_user_id')->withTrashed();
    }

    //join user table with gps table
    public function toUser()
    {
    	return $this->hasOne('App\Modules\User\Models\User','id','to_user_id')->withTrashed();
    }

    public function gpsTransferItems()
    {
        return $this->hasMany('App\Modules\Gps\Models\GpsTransferItems','gps_transfer_id','id');
    }

    public function fromUserTrackView()
    {
        return $this->hasOne('App\Modules\User\Models\User','id','from_user_id')->withTrashed();
    }

    public function toUserTrackView()
    {
        return $this->hasOne('App\Modules\User\Models\User','id','to_user_id')->withTrashed();
    }

    public function getTransferredCountBetweenTwoUsers($from_user_ids,$to_user_ids,$from_date,$to_date)
    {
        return DB::select("SELECT COUNT(gps_transfer_items.id) as count FROM `gps_transfers` LEFT join gps_transfer_items ON gps_transfers.id = gps_transfer_items.gps_transfer_id WHERE gps_transfers.deleted_at IS NULL AND date(gps_transfers.dispatched_on) >= '$from_date' AND date(gps_transfers.dispatched_on) <= '$to_date' AND gps_transfers.from_user_id IN  ('" . implode("', '", $from_user_ids) . "') AND gps_transfers.to_user_id IN ('" . implode("', '", $to_user_ids) . "')");
    }

    public function getDetailedReportOfGpsTransfers($from_user_ids,$to_user_ids,$from_date,$to_date)
    {
        return DB::select("SELECT gps_transfers.from_user_id,gps_transfers.to_user_id,count(gps_transfer_items.id) as count FROM `gps_transfers` LEFT join gps_transfer_items ON gps_transfers.id = gps_transfer_items.gps_transfer_id WHERE gps_transfers.deleted_at IS NULL AND date(gps_transfers.dispatched_on) >= '$from_date' AND date(gps_transfers.dispatched_on) <= '$to_date' AND gps_transfers.from_user_id IN  ('" . implode("', '", $from_user_ids) . "') AND gps_transfers.to_user_id IN ('" . implode("', '", $to_user_ids) . "') GROUP BY gps_transfers.to_user_id");
    }

    public function getTransferredGpsDetailsWhichIncludesTransferAcceptedGps($from_user_ids,$to_user_ids,$from_date,$to_date)
    {
        return DB::select("SELECT COUNT(gps_transfer_items.id) as count FROM `gps_transfers` LEFT join gps_transfer_items ON gps_transfers.id = gps_transfer_items.gps_transfer_id WHERE gps_transfers.deleted_at IS NULL AND gps_transfers.accepted_on IS NOT NULL AND date(gps_transfers.dispatched_on) >= '$from_date' AND date(gps_transfers.dispatched_on) <= '$to_date' AND gps_transfers.from_user_id IN  ('" . implode("', '", $from_user_ids) . "') AND gps_transfers.to_user_id IN ('" . implode("', '", $to_user_ids) . "')");
    }

    public function getTransferredGpsDetailsWhichIncludesAwaitingConfirmationGps($from_user_ids,$to_user_ids,$from_date,$to_date)
    {
        return DB::select("SELECT COUNT(gps_transfer_items.id) as count FROM `gps_transfers` LEFT join gps_transfer_items ON gps_transfers.id = gps_transfer_items.gps_transfer_id WHERE gps_transfers.deleted_at IS NULL AND gps_transfers.accepted_on IS  NULL AND date(gps_transfers.dispatched_on) >= '$from_date' AND date(gps_transfers.dispatched_on) <= '$to_date' AND gps_transfers.from_user_id IN  ('" . implode("', '", $from_user_ids) . "') AND gps_transfers.to_user_id IN ('" . implode("', '", $to_user_ids) . "')");
    }

    public function getTransferredGpsDetailsWhichIncludesBothAcceptedAndAwaitingConfirmationGps($from_date,$to_date)
    {
        return self::select(
            'id',
            'from_user_id',
            'to_user_id',
            'dispatched_on',
            'accepted_on',
            'deleted_at'
        )
        ->with('fromUser:id,username')
        ->with('toUser:id,username')
        ->with('gpsTransferItems')
        ->orderBy('created_at','DESC')
        ->whereDate('dispatched_on', '>=', $from_date)
        ->whereDate('dispatched_on', '<=', $to_date)
        ->withTrashed();
    }

    public function getStockToAcceptCount($to_user_ids)
    {
        return DB::select("SELECT COUNT(gps_transfer_items.id) as count FROM `gps_transfers` LEFT join gps_transfer_items ON gps_transfers.id = gps_transfer_items.gps_transfer_id WHERE gps_transfers.deleted_at IS NULL AND gps_transfers.accepted_on IS  NULL  AND gps_transfers.to_user_id IN ('" . implode("', '", $to_user_ids) . "')");
    }

    public function checkGpsTransferLogExistAndNotAccepted($gps_transfer_id)
    {
        return self::where('id',$gps_transfer_id)->whereNull('accepted_on')->first();
    }
    
}
