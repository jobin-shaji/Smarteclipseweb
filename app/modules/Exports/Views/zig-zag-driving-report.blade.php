<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Vehicle</th>
        <th>Alert Type</th>
        <th>DateTime</th>  
    </tr>
    </thead>
     <tbody>
        @foreach($zigzagdrivingReportExport as $zigzagdrivingReportExport)
        
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $zigzagdrivingReportExport->gps->vehicle->register_number }}</td>           
            <td>{{ $zigzagdrivingReportExport->alertType->description }}</td>
            <td>{{ $zigzagdrivingReportExport->device_time }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>