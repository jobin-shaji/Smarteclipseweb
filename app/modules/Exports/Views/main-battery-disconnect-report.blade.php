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
        @foreach($mainBatteryDisconnectReportExport as $mainBatteryDisconnectReportExport)
            <tr>           
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mainBatteryDisconnectReportExport->vehicleGps->vehicle->name }}</td>  
                <td>{{ $mainBatteryDisconnectReportExport->vehicleGps->vehicle->register_number }}</td>           
                <td>{{ $mainBatteryDisconnectReportExport->alertType->description }}</td>
                <td>{{ $mainBatteryDisconnectReportExport->device_time }}</td>         
            </tr>
        @endforeach
    </tbody>
</table>