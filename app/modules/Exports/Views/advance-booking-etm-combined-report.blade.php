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
    @foreach($AdvanceBookingEtmCombinedReportExport as $AdvanceBookingEtmCombinedReportExport)
    <?php
        $total_km=$AdvanceBookingEtmCombinedReportExport->route->sum('total_km');
        $covered_km=$AdvanceBookingEtmCombinedReportExport->sum('km');
        $missed_km=$total_km-$covered_km;
    ?>
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $AdvanceBookingEtmCombinedReportExport->date }}</td>
            <td>{{ $AdvanceBookingEtmCombinedReportExport->etm->imei }}</td>
            <td>{{ $AdvanceBookingEtmCombinedReportExport->etm->name}}</td>
            <td>{{ $AdvanceBookingEtmCombinedReportExport->waybill->code }}</td>                     
            <td>{{ $AdvanceBookingEtmCombinedReportExport->total_amount}}</td>           
            <td>{{ $covered_km}}</td>
            <td>{{ $missed_km}}</td>
        </tr>
    @endforeach
    </tbody>
</table>