<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Vehicle</th>
        <th>Register Number</th>
        <th>Scheduling Route</th>
        <th>Deviating Place</th>
        <th>DateTime</th>  
    </tr>
    </thead>
     <tbody>
        @foreach($routeDeviationReportExport as $routeDeviationReportExport)
         <?php 
            $latitude= $routeDeviationReportExport->latitude;
            $longitude=$routeDeviationReportExport->longitude;          
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
            <td>{{ $routeDeviationReportExport->vehicle->name }}</td>           
            <td>{{ $routeDeviationReportExport->vehicle->register_number }}</td>
            <td>{{ $routeDeviationReportExport->route->name }}</td>
            <td>{{ $address }}</td>
            <td>{{ $routeDeviationReportExport->deviating_time }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>