<table>
    <thead>
    <tr>
        <th>SL.No</th>
        <th>Vehicle</th>
        <th>Registration Number</th>                          
        <th>Total KM</th>  
    </tr>
    </thead>
     <tbody>
        @foreach($totalkmReportExport as $totalkmReport)
        <?php
            $gps_km     =   $totalkmReport['total_km'];
            $km         =   round($gps_km/1000); 
        ?>
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $totalkmReport['vehicle_name'] }}</td>           
            <td>{{ $totalkmReport['vehicle_register_number'] }}</td>            
            <td>{{ $km }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>