

<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>WayBill Number</th>
        <th>Conductor</th>
        <th>Conductor Name</th>
        <th>Trip ID</th>
        <th>ETM</th>
        <th>ETM Name</th>
        <th>Vehicle</th>
        <th>Cash</th>
        <th>Advance</th>
        <th>KM</th>

        <th>Missed KM</th>
        <th> Total Amount</th>
        <th>EPKM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($FormanyDriverReportExport as $FormanyDriverReportExport)
   
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td></td> 
            <td></td>                      
            <td></td>
            <td></td>
             <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
             <td></td>
            <td></td>



            <td></td>
            <td>
           </td>
        </tr>
    @endforeach
    </tbody>
</table>