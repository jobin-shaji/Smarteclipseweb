<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th> 
        <th>ETM</th>
        <th>ETM Name</th>
        <th>Waybill No</th>   
        <th>Cash</th>                            
        <th>Covered KM</th> 
        <th>Missed KM</th>        
    </tr>
    </thead>
    <tbody>
    @foreach($AdvanceBookingEtmformanyReportExport as $AdvanceBookingEtmformanyReportExport)
    <?php
        $total_km=$AdvanceBookingEtmformanyReportExport->route->sum('total_km');
        $covered_km=$AdvanceBookingEtmformanyReportExport->sum('km');
        $missed_km=$total_km-$covered_km;
    ?>
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $AdvanceBookingEtmformanyReportExport->date }}</td>
            <td>{{ $AdvanceBookingEtmformanyReportExport->etm->imei }}</td>
            <td>{{ $AdvanceBookingEtmformanyReportExport->etm->name}}</td>
            <td>{{ $AdvanceBookingEtmformanyReportExport->waybill->code }}</td>                     
            <td>{{ $AdvanceBookingEtmformanyReportExport->total_amount}}</td>           
            <td>{{ $covered_km}}</td>
            <td>{{ $missed_km}}</td>
        </tr>
    @endforeach
    </tbody>
</table>