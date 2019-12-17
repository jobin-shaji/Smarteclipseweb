<table>
    <thead>
    <tr>
        <th>SL NO.</th>
        <th>IMEI</th>
        <th>VLT DATA</th>
        <th>DEVICE TIME</th>
        <th>CREATED AT</th> 
    </tr>
    </thead>
    <tbody>
        @foreach($gpsProcessedDataReportExport as $gpsProcessedDataReportExport)
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $gpsProcessedDataReportExport->imei }}</td>           
            <td>{{ $gpsProcessedDataReportExport->vlt_data }}</td>
            <td>{{ $gpsProcessedDataReportExport->device_time }}</td>
            <td>{{ $gpsProcessedDataReportExport->created_at }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>