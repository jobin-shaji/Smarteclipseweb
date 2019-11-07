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
        @foreach($kmReportExport as $kmReport)   
        <?php
        $gps_km=$kmReport->km;
        $km=round($gps_km/1000);
            
       ?>     
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $kmReport->gps->vehicle->name }}</td>           
            <td>{{ $kmReport->gps->vehicle->register_number }}</td>            
            <td>{{ $km }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>