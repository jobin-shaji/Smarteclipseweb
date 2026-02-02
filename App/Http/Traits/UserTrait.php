<?php

namespace App\Http\Traits;
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
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait UserTrait{

    public function getOriginalNameFromUserId($user_id)
    {
        $user_details = DB::SELECT("select
        case when isnull(cl.id)=0 then  cl.name
        when isnull(dl.id)=0 then dl.name
        when isnull(sb.id)=0 then sb.name
        when isnull(td.id)=0 then td.name
        when isnull(rs.id)=0 then rs.name
        end as `name`
        from users AS us
        LEFT JOIN clients AS cl ON us.id =cl.user_id 
        LEFT JOIN dealers AS dl ON us.id =dl.user_id
        LEFT JOIN sub_dealers AS sb ON us.id=sb.user_id
        LEFT JOIN traders AS td ON us.id=td.user_id
        LEFT JOIN roots AS rs ON us.id=rs.user_id
        where us.id =".$user_id);
        return ucfirst(strtolower($user_details ? $user_details[0]->name : ""));
    }

}