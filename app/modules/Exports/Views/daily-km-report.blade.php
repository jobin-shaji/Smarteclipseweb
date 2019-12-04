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
        @foreach($dailykmReportExport as $dailykmReport)
       <?php
       $gps_km=$dailykmReport->km;
          $km=round($gps_km/1000);
            
       ?>
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $dailykmReport->gps->vehicle->name }}</td>           
            <td>{{ $dailykmReport->gps->vehicle->register_number }}</td>            
            <td>{{ $km }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>