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
        @foreach($accidentImpactAlertReportExport as $accidentImpactAlertReportExport)
         <?php 
            $latitude= $accidentImpactAlertReportExport->latitude;
            $longitude=$accidentImpactAlertReportExport->longitude;          
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
            <td>{{ $accidentImpactAlertReportExport->gps->vehicle->register_number }}</td>           
            <td>{{ $accidentImpactAlertReportExport->alertType->description }}</td>
            <td>{{ $address }}</td>
            <td>{{ $accidentImpactAlertReportExport->device_time }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>