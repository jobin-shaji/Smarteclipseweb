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
        @foreach($alertReportExport as $alertReportExport)
        
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $alertReportExport->gps->vehicle->register_number }}</td>           
            <td>{{ $alertReportExport->alertType->description }}</td>
            
            <td>{{ $alertReportExport->device_time }}</td>            
        </tr>
        @endforeach
    </tbody>
</table>