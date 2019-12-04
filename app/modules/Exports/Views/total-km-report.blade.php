<table>
    <thead>
    <tr>
        <th>SL.No</th>
        <th>Vehicle</th>
        <th>Register Number</th>                          
        <th>Total KM</th>  
    </tr>
    </thead>
     <tbody>
        @foreach($totalkmReportExport as $totalkmReport)
        <?php
       $gps_km=$totalkmReport->km;
          $km=round($gps_km/1000);
            
       ?>
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $totalkmReport->vehicle->name }}</td>           
            <td>{{ $totalkmReport->vehicle->register_number }}</td>            
            <td>{{ $km }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>