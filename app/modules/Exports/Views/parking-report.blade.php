<table>
    <thead>
    <tr>
        <th>SL.No</th>
        <th>Vehicle</th>
        <th>Register Number</th>
        <th>Parking</th>
        <th>DateTime</th> 
    </tr>
    </thead>
     <tbody>
        @foreach($parkingReportExport as $parkingReportExport) 
        <?php            
            $v_mode=$parkingReportExport->sleep->where('vehicle_mode','S')->count(); 
            $sleep= gmdate("H:i:s",$v_mode);                  
        ?>
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $parkingReportExport->vehicle->name }}</td>           
            <td>{{ $parkingReportExport->vehicle->register_number }}</td>
            <td>{{ $sleep }}</td>            
            <td>{{ $parkingReportExport->device_time }}</td>              
        </tr>
        @endforeach
    </tbody>
</table>