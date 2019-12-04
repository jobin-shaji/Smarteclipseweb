<table>
    <thead>
    <tr>
        <th>SL.No</th>
        <th>Vehicle</th>
        <th>Alert Type</th>
        <th>Location</th>
        <th>DateTime</th>  
    </tr>
    </thead>
     <tbody>
        @foreach($overspeedReportExport as $overspeedReportExport)
         <?php 
            $latitude= $overspeedReportExport->latitude;
            $longitude=$overspeedReportExport->longitude;          
            if(!empty($latitude) && !empty($longitude)){
                //Send request and receive json data by address
                $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=drawing&callback=initMap'); 
                $output = json_decode($geocodeFromLatLong);         
                $status = $output->status;
                //Get address from json data
                $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            }
        ?> 
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $overspeedReportExport->gps->vehicle->register_number }}</td>           
            <td>{{ $overspeedReportExport->alertType->description }}</td>
            <td>{{ $address }}</td>
            <td>{{ $overspeedReportExport->device_time }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>