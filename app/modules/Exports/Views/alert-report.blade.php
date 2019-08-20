<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Vehicle</th>
        <th>Alert Type</th>
        <th>Location</th>
        <th>DateTime</th>
    </tr>
    </thead>
     <tbody>
        @foreach($alertReportExport as $alertReportExport)
        <?php 
            $latitude= $alertReportExport->latitude;
            $longitude=$alertReportExport->longitude;          
            if(!empty($latitude) && !empty($longitude)){
                //Send request and receive json data by address
                $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap'); 
                $output = json_decode($geocodeFromLatLong);         
                $status = $output->status;
                //Get address from json data
                $address = ($status=="OK")?$output->results[1]->formatted_address:'';
            }
        ?>
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $alertReportExport->vehicle->register_number }}</td>           
            <td>{{ $alertReportExport->alertType->description }}</td>
            <td>{{ $address}}</td>
            <td>{{ $alertReportExport->device_time }}</td>            
        </tr>
        @endforeach
    </tbody>
</table>