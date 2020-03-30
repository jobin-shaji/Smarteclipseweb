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
        @foreach($accidentImpactAlertReportExport as $accidentImpactAlertReportExport)
            <tr>           
                <td>{{ $loop->iteration }}</td>
                <td>{{ $accidentImpactAlertReportExport->gps->vehicle->register_number }}</td>           
                <td>{{ $accidentImpactAlertReportExport->alertType->description }}</td>
                <td>{{ $accidentImpactAlertReportExport->device_time }}</td>         
            </tr>
        @endforeach
    </tbody>
</table>