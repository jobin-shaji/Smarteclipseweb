<?php

function maskPartsOfString($string = '', $start, $end, $maskEelement = '*')
{
    $string_length = strlen($string);
    return substr($string, 0, $start).str_repeat($maskEelement, ($string_length - (($string_length - $end) + $start))).substr($string, $end, $string_length);
}


function getDateTime($date,$time)
{
    $d = substr($date,0,2);
    $m = substr($date,2,2);
    $y = substr($date,4,4);
    $h = substr($time,0,2);
    $mi = substr($time,2,2);
    $s = substr($time,4,2);
    $device_time = '20'.$y.'-'.$m.'-'.$d.' '.$h.':'.$mi.':'.$s;
    return $device_time;
}


function getPlacenameFromLatLng($latitude,$longitude)
{  
    // $app_id              = "RN9UIyGura2lyToc9aPg";
    // $app_code            = "4YMdYfSTVVe1MOD_bDp_ZA";    
    // $ch = curl_init();  
    // curl_setopt($ch,CURLOPT_URL,'https://reverse.geocoder.api.here.com/6.2/reversegeocode.json?prox='.$latitude.'%2C'.$longitude.'%2C118&mode=retrieveAddresses&maxresults=1&gen=9&app_id='.$app_id.'&app_code='.$app_code);
    // curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    // //  curl_setopt($ch,CURLOPT_HEADER, false);
    // $output=curl_exec($ch);
    // curl_close($ch);
    // $data=json_decode($output,true);
    // return $data['Response']['View'][0]['Result'][0]['Location']['Address']['Label'];
    if(!empty($latitude) && !empty($longitude)){
        //Send request and receive json data by address
        
        $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key='.config('eclipse.keys.googleMap'));
        $output = json_decode($geocodeFromLatLong);
        $status = $output->status;
        $address = ($status=="OK")?$output->results[0]->formatted_address:'';
        if(!empty($address)){
            return $address;
        }else{
            return false;
        }
    }else{
        return false;
    }
}  

function m2Km($meter)
{
    $km = $meter/1000;

    return $km;
}

?>