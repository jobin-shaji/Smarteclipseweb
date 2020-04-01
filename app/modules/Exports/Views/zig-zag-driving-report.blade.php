<table>
    <thead>
    <tr>
        <th>SL.No</th>
        <th>Vehicle Name</th>
        <th>Registration Number</th>
        <th>Alert Type</th>
        <th>DateTime</th>  
    </tr>
    </thead>
     <tbody>
        @foreach($zigzagdrivingReportExport as $zigzagdrivingReportExport)
        
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $zigzagdrivingReportExport->vehicleGps->vehicle->name }}</td>
            <td>{{ $zigzagdrivingReportExport->vehicleGps->vehicle->register_number }}</td>           
            <td>{{ $zigzagdrivingReportExport->alertType->description }}</td>
            <td>{{ $zigzagdrivingReportExport->device_time }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>