<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Vehicle</th>
        <th>Register Number</th>
        <th>Halt</th>
        <th>DateTime</th> 
    </tr>
    </thead>
     <tbody>
        @foreach($idleReportExport as $idleReportExport) 
        <?php            
            $v_mode=$idleReportExport->sleep->where('vehicle_mode','H')->count(); 
            $sleep= gmdate("H:i:s",$v_mode);                  
        ?>
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $idleReportExport->vehicle->name }}</td>           
            <td>{{ $idleReportExport->vehicle->register_number }}</td>
            <td>{{ $sleep }}</td>            
            <td>{{ $idleReportExport->device_time }}</td>              
        </tr>
        @endforeach
    </tbody>
</table>