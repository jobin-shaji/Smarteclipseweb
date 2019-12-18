<table>
    <thead>
    <tr>
        <th>SL NO.</th>
        <th>IMEI</th>
        <th>VLT DATA</th>
        <th>CREATED AT</th> 
    </tr>
    </thead>
    <tbody>
        @foreach($gpsUnprocessedDataReportExport as $gpsUnprocessedDataReportExport)
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $gpsUnprocessedDataReportExport->imei }}</td>           
            <td>{{ $gpsUnprocessedDataReportExport->vltdata }}</td>
            <td>{{ $gpsUnprocessedDataReportExport->created_at }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>