<table>
    <thead>
    <tr>
        <th>SL.No</th>
        <th>Vehicle</th>
        <th>Alert Type</th>
        <th>DateTime</th>  
    </tr>
    </thead>
     <tbody>
        @foreach($harshBrakingReportExport as $harshBrakingReportExport)
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $harshBrakingReportExport->gps->vehicle->register_number }}</td>           
            <td>{{ $harshBrakingReportExport->alertType->description }}</td>
            <td>{{ $harshBrakingReportExport->device_time }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>