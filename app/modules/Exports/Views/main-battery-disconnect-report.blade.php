<table>
    <thead>
        <tr>
            <th>SL.No</th>
            <th>Vehicle</th>
            <th>Alert Type</th>
            <th>Date & Time</th>  
        </tr>
    </thead>
    <tbody>
        @foreach($mainBatteryDisconnectReportExport as $mainBatteryDisconnectReportExport)
            <tr>           
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mainBatteryDisconnectReportExport->gps->vehicle->register_number }}</td>           
                <td>{{ $mainBatteryDisconnectReportExport->alertType->description }}</td>
                <td>{{ $mainBatteryDisconnectReportExport->device_time }}</td>         
            </tr>
        @endforeach
    </tbody>
</table>