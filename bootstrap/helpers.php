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

function removeUrlFromString($string)
{
    $string = cleaner($string);
    $string = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $string);
    $string = str_replace("?","",$string);
    return $string;
}   

function cleaner($url) {
  $U = explode(' ',$url);

  $W =array();
  foreach ($U as $k => $u) {
    if (stristr($u,'http') || (count(explode('.',$u)) > 1)) {
      unset($U[$k]);
      return cleaner( implode(' ',$U));
    }
  }
  return implode(' ',$U);
}

function m2Km($meter)
{
    $km = $meter/1000;

    return $km;
}


/**
 * 
 *
 * 
 */
function dateTimediff($d1, $d2)
{
    if($d1 == $d2)
    {
        return "0 seconds";
    }
    // Declare and define two dates 
    $date1 = strtotime($d1);  
    $date2 = strtotime($d2);   
    // Formulate the Difference between two dates 
    $diff = abs($date2 - $date1);  
    // To get the year divide the resultant date into 
    // total seconds in a year (365*60*60*24) 
    $years = floor($diff / (365*60*60*24));  
    // To get the month, subtract it with years and 
    // divide the resultant date into 
    // total seconds in a month (30*60*60*24) 
    $months = floor(($diff - $years * 365*60*60*24) 
                                   / (30*60*60*24));  
    // To get the day, subtract it with years and  
    // months and divide the resultant date into 
    // total seconds in a days (60*60*24) 
    $days = floor(($diff - $years * 365*60*60*24 -  
                 $months*30*60*60*24)/ (60*60*24)); 
    // To get the hour, subtract it with years,  
    // months & seconds and divide the resultant 
    // date into total seconds in a hours (60*60) 
    $hours = floor(($diff - $years * 365*60*60*24  
           - $months*30*60*60*24 - $days*60*60*24) 
                                       / (60*60));        
    // To get the minutes, subtract it with years, 
    // months, seconds and hours and divide the  
    // resultant date into total seconds i.e. 60 
    $minutes = floor(($diff - $years * 365*60*60*24  
             - $months*30*60*60*24 - $days*60*60*24  
                              - $hours*60*60)/ 60); 
    // To get the minutes, subtract it with years, 
    // months, seconds, hours and minutes  
    $seconds = floor(($diff - $years * 365*60*60*24  
             - $months*30*60*60*24 - $days*60*60*24 
            - $hours*60*60 - $minutes*60));

    $string = "";
    if($years > 0)
    {
        $string = $string.$years." years ";
    }
    if($months > 0)
    {
        $string = $string.$months." months ";
    }
    if($days > 0)
    {
        $string = $string.$days." days ";
    }
    if($hours > 0)
    {
        $string = $string.$hours." hours ";
    }
    if($minutes > 0)
    {
        $string = $string.$minutes." minutes ";
    }
    if($seconds > 0)
    {
        $string = $string.$seconds." seconds";
    }

    return $string;

}

/**
 * 
 * @var array
 * 
 */
 function tripDistanceFromHereMap($geo_locations)
 {
    $xml = '<?xml version="1.0"?>
                <gpx version="1.0"
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xmlns="http://www.topografix.com/GPX/1/0"
                xsi:schemaLocation="http://www.topografix.com/GPX/1/0 http://www.topografix.com/GPX/1/0/gpx.xsd">
                <trk>
                <trkseg>';

    foreach($geo_locations as $each_geo_location)
    {
        $xml .= '<trkpt lat="'.$each_geo_location['lattitude'].'" lon="'.$each_geo_location['longitude'].'"/>';
        $xml .= "<time>".$each_geo_location['device_time']."</time>"; 
    }
     
    $xml .= '</trkseg>
     </trk>
    </gpx>';

    $client     = new \GuzzleHttp\Client(['base_uri' => 'https://m.fleet.ls.hereapi.com/']);
    $distance   = 0;

    try
    {
        $resp       = $client->request('POST', "2/calculateroute.json?apiKey=yHvLiXMvNW-Mvmp8whDmDfQCP0gS9KdQBZojr5u6igo&routeMatch=1&mode=fastest;car;traffic:disabled", ['body' => $xml]);
    
        $points     = (string) $resp->getBody();
        $points     = json_decode($points, true);
        $distance   = $points['response']['route'][0]['summary']['distance'];
    }
    catch(Exception $e)
    {
        $e->getMessage();
    }

    return ["distance" => $distance, "gpx" => $xml];
 }

?>