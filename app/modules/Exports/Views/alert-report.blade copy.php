<table>
    <thead>
    <tr>
        <th>SL.No</th>
        <th>Vehicle Name</th>
        <th>Vehicle Registration</th>
        <th>Address</th>
        <th>Alert Type</th>
        <th>DateTime</th>
    </tr>
    </thead>
     <tbody>
        @foreach($alertReportExport as $alertReportExport)
        
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $alertReportExport['gps']['connected_vehicle_name'] }}</td> 
            <td>{{ $alertReportExport['gps']['connected_vehicle_registration_number'] }}</td> 
            <td>{{ $alertReportExport['address']}}</td>           
            <td>{{ $alertReportExport['alert_type']['description'] }}</td>           
            <td>{{ $alertReportExport['device_time'] }}</td>           
        </tr>
        @endforeach
    </tbody>
</table>