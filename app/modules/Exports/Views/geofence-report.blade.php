<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Vehicle Name</th>
        <th>Register Number</th>
        <th>Geofence Type</th>
        <th>Time</th>
    </tr>
    </thead>
     <tbody>
        @foreach($geofenceReportExport as $geofenceReportExport)        
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $geofenceReportExport->gps->vehicle->name }}</td>           
            <td>{{ $geofenceReportExport->gps->vehicle->register_number }}</td>
            <td>{{ $geofenceReportExport->alert->description }}</td>
            <td>{{ $geofenceReportExport->device_time }}</td>            
        </tr>
        @endforeach
    </tbody>
</table>