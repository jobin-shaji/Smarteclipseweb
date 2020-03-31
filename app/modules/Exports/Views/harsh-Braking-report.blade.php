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
        @foreach($harshBrakingReportExport as $harshBrakingReportExport)
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $harshBrakingReportExport->vehicleGps->vehicle->name }}</td>
            <td>{{ $harshBrakingReportExport->vehicleGps->vehicle->register_number }}</td>           
            <td>{{ $harshBrakingReportExport->alertType->description }}</td>
            <td>{{ $harshBrakingReportExport->device_time }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>