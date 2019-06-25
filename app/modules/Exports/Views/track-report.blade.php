<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Vehicle</th>
        <th>Register Number</th>
        <th>Run</th>
        <th>Idle</th>
        <th>Sleep</th>
        <th>AC ON</th>
        <th>AC OFF</th>
        <th>Total KM</th>
        <th>DateTime</th> 
    </tr>
    </thead>
     <tbody>
        @foreach($trackReportExport as $trackReportExport) 
        <?php 
            $M_mode=$trackReportExport->sleep->where('vehicle_mode','M')->count();
            $motion= gmdate("H:i:s",$M_mode); 
            $v_mode=$trackReportExport->sleep->where('vehicle_mode','S')->count(); 
            $sleep= gmdate("H:i:s",$v_mode);
            $H_mode=$trackReportExport->sleep->where('vehicle_mode','H')->count();
            $halt= gmdate("H:i:s",$H_mode);
            $ac_on=0;
            $ac_off=0;
            $km='-';            
        ?>




        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $trackReportExport->vehicle->name }}</td>           
            <td>{{ $trackReportExport->vehicle->register_number }}</td>
            <td>{{ $motion }}</td>            
            <td>{{ $halt }}</td>
             <td>{{ $sleep }}</td> 
            <td>{{ $ac_on }}</td>  
            <td>{{ $ac_off }}</td>  
            <td>{{ $km }}</td>  
            <td>{{ $trackReportExport->device_time }}</td>              
        </tr>
        @endforeach
    </tbody>
</table>