<?php
namespace App\Vst\Fare;

use App\Modules\Route\Models\Route;
use App\Modules\StateFareSlab\Models\StateFareSlab;
use App\Modules\TollFeeSlab\Models\TollFeeSlab;
use App\Modules\Stage\Models\Stage;
use App\Modules\Vehicle\Models\VehicleType;
use App\Modules\Route\Models\RouteStage;

class FareSlab
{
    
    public static function slabify($stage_id,$route,$vehicle_type){
        $slab = "";
        $route_ = Route::find($route);
        // $all_toll = ($route_->stages->where('toll',0)->count() == 0 ? TRUE : FALSE );
        $st = RouteStage::where('route_id',$route_->id)->where('stage_id',$stage_id)->first();

        if($stage_id == $route_->from_stage_id){
            return 00;
        }

        foreach ($route_->stages as $stage) {

            if($stage->id == $stage_id){
                return $slab;
            }

            $slab = $slab.','.FareSlab::lessToll($route_,$stage->pivot->id,$st->id,$vehicle_type);
         
        }

    }



    public static function lessToll($route,$from,$to,$vehicle_type_id){

         // $route = Route::find($route);

        $stages = $route->stages()->wherePivot('id','>=',$from)->wherePivot('id','<=',$to)->get();
        $total = $stages->count();
        $first = $stages->first();
        $prev;
        $km = 0;
        $flag =0;
        $states= [];
        $state_km = 0;
        $state_id = 0;
        $in = 0;

        foreach ($stages as $stage) {

            if($stage->toll == 1 && $flag == 0){
                $prev = $stage;
                $flag = 1;
            }elseif($stage->toll == 0){
                $flag =0;
            }

            $state_km = $stage->pivot->km - $first->pivot->km;
            $state_id = $stage->depot->state->id;

            if($flag == 1 && $stage->toll == 1){
                $distance = $stage->pivot->km - $prev->pivot->km;
                $km = $km + $distance;
                $prev  = $stage;
                $in = 1;
            }

            if($stage->border_status == 1){
                $state["toll_km"] = $km;
                $state["km"] = $stage->pivot->km - $first->pivot->km;
                $state["state_id"] = $prev->depot->state->id;
                $states[] = $state;
                $prev = $stage;
                $km = 0;
                $flag = $stage->toll;
                $first = $stage;
                $in = 0;
            }

        }
            if($in == 1){
                $state["toll_km"] = $km;
                $state["km"] = $state_km;
                $state["state_id"] = $state_id;
                $states[] = $state;
            }

        $items = $states;
        $states = [];
        foreach ($items as $item) {
            if($item["km"] > 0){
                $states[] = $item;
            }
        }

        return FareSlab::fare($states,$vehicle_type_id);

    }

    public static function fare($items,$vehicle_type_id){
        $fare = 0;
        $multy_state = FALSE;
        if(count($items) > 1){
            $multy_state = TRUE;
        }
        foreach ($items as $item) 
        {
            $state = $item["state_id"];
            $km = $item["km"];
            $toll_km = $item["toll_km"];

            $slab = StateFareSlab::where('vehicle_type_id',$vehicle_type_id)->where('state_id',$state)->first();
            if(!$slab){
                dd("fare slab not found");
            }

            if(!$slab->plain_fpkm == 0){
                $sum = $km * $slab->plain_fpkm;
            }else{
                $sum = $slab->min_fare;
            }

            if($sum < $slab->min_fare){
                $sum =  $slab->min_fare;
            }

            $toll = 0;
            if($toll_km > 0){
                $toll_slab = TollFeeSlab::where('state_id',$state)->where('max_km','>=',$toll_km)->where('min_km','<=',$km)->first();
                if(!$toll_slab){
                    dd("toll slab not found");
                }

                $toll = $toll_slab->amount;
            }

            $total = $sum + $toll;
            $tot = FareSlab::roundOff($total,$multy_state);
            $fare = $fare + $tot;

        }


        return $fare;

    }

    public static function roundOff($fare,$multy_state){
        $rem = fmod($fare,5);

           // if($rem == 0){
           //      return (int)$fare;
           //  }
           //  else if($rem >= 2.5){
           //      $fare = $fare-$rem;
           //      $amount = $fare+5;
           //      return (int)$amount;
           //  }
           //  else{
           //      $fare = $fare-$rem;
           //      return (int)$fare;
           //  }


        if($multy_state == FALSE){
            if($rem == 0){
                return (int)$fare;
            }
            else if($rem >= 2.5){
                $fare = $fare-$rem;
                $amount = $fare+5;
                return (int)$amount;
            }
            else{
                $fare = $fare-$rem;
                return (int)$fare;
            }
        }else{
            $fare = $fare-$rem;
            return $fare;
        }
  
    }


}