<table>
    <thead>
    <tr>
        <th>SL.No</th>
        <th>Vehicle Name</th>
        <th>Registration Number</th>                          
        <th>Total KM</th>  
        <th>Date</th>  
    </tr>
    </thead>
     <tbody>
        @foreach($dailykmReportExport as $dailykmReport)
        <?php
            $gps_km     =   $dailykmReport->km;
            $km         =   round($gps_km/1000); 
        ?>
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $dailykmReport->vehicleGps->vehicle->name }}</td>           
            <td>{{ $dailykmReport->vehicleGps->vehicle->register_number }}</td>            
            <td>{{ $km }}</td>     
            <td>{{ $dailykmReport->date }}</td>     
        </tr>
        @endforeach
    </tbody>
</table>