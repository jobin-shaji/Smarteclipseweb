<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Vehicle</th>
        <th>Alert Type</th>
        <th>Location</th>
        <th>DateTime</th>
    </tr>
    </thead>
     <tbody>
    @foreach($alertReportExport as $alertReportExport)
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>            
        </tr>
    @endforeach
    </tbody>
</table>