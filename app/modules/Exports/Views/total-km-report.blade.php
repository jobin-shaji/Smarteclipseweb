<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Vehicle</th>
        <th>Register Number</th>                          
        <th>Total KM</th>  
    </tr>
    </thead>
     <tbody>
        @foreach($totalkmReportExport as $totalkmReportExport)
        <?php

               $earthRadius = 6371000;
        $lat_from=floatval($totalkmReportExport->first()->latitude);
        $lng_from=floatval($totalkmReportExport->first()->longitude);
        $lat_to=floatval($totalkmReportExport->latitude);
        $lng_to=floatval($totalkmReportExport->longitude);
        // dd($lat_from.",".$lng_from.",".$lat_to.",".$lng_to);
        $latFrom = deg2rad($lat_from);
        $lonFrom = deg2rad($lng_from);
        $latTo = deg2rad($lat_to);
        $lonTo = deg2rad($lng_to);
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        $km = $angle * $earthRadius; 
        ?>
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $totalkmReportExport->vehicle->name }}</td>           
            <td>{{ $totalkmReportExport->vehicle->register_number }}</td>            
            <td>{{ $km }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>