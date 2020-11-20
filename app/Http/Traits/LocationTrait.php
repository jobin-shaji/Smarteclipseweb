<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait LocationTrait{

    /**
     * 
      *from here map  or google map get address
     * 
    */
    public function getPlacenameFromGeoCords($latitude,$longitude,$map)
    {
       if($map =="heremap")
       {
          
        $app_id               = "RN9UIyGura2lyToc9aPg";
        $app_code             = "4YMdYfSTVVe1MOD_bDp_ZA";    
        $ch                   = curl_init();  
        curl_setopt($ch,CURLOPT_URL,'https://reverse.geocoder.api.here.com/6.2/reversegeocode.json?prox='.$latitude.'%2C'.$longitude.'%2C118&mode=retrieveAddresses&maxresults=1&gen=9&app_id='.$app_id.'&app_code='.$app_code);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $output=curl_exec($ch);
        curl_close($ch);
        $data=json_decode($output,true);
        return $data['Response']['View'][0]['Result'][0]['Location']['Address']['Label'];  
        }else{
        if(!empty($latitude) && !empty($longitude)){
            //Send request and receive json data by address
            try
            {
                    $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key='.config('eclipse.keys.googleMap'));
                    $output = json_decode($geocodeFromLatLong);
                    $status = $output->status;
                    $address = ($status=="OK")?$output->results[0]->formatted_address:'';
                    if(!empty($address)){
                        $address = removeUrlFromString($address);
                        return $address;
                    }else{
                        return false;
                    }
            }
            catch(Exception $e)
            {
                report($e);
            }
       
        }else{
            return false;
        }
       }
    }  
}