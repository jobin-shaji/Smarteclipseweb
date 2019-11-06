<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Vehicle</th>
        <th>Register Number</th>                          
        <th>Total KM</th>  
    </tr>
    </thead>
     <tbody>
        @foreach($kmReportExport as $kmReport)        
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $kmReport->gps->vehicle->name }}</td>           
            <td>{{ $kmReport->gps->vehicle->register_number }}</td>            
            <td>{{ $kmReport->km }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>