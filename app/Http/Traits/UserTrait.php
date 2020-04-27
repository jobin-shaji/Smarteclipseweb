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
        $manufacturer   =   (new Root())->checkUserIdIsInManufacturerTable($user_id);
        if($manufacturer == null)
        {
            $distributor   =   (new Dealer())->checkUserIdIsInDistributorTable($user_id);
            if($distributor == null)
            {
                $dealer   =   (new SubDealer())->checkUserIdIsInDealerTable($user_id);
                if($dealer == null)
                {
                    $sub_dealer   =   (new Trader())->checkUserIdIsInSubDealerTable($user_id);
                    if($sub_dealer == null)
                    {
                        $client   =   (new Client())->checkUserIdIsInClientTable($user_id);
                        if($client == null)
                        {
                            return null;
                        }
                        else
                        {
                            return $client->name;
                        }
                    }
                    else
                    {
                        return $sub_dealer->name;
                    }
                }
                else
                {
                    return $dealer->name;
                }
            }
            else
            {
                return $distributor->name;
            }
        }
        else
        {
            return $manufacturer->name;
        }
    }

}