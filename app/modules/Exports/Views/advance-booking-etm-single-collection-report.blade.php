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
    @foreach($AdvanceBookingEtmSingleReportExport as $AdvanceBookingEtmSingleReportExport)
    <?php
        $total_km=$AdvanceBookingEtmSingleReportExport->route->sum('total_km');
        $covered_km=$AdvanceBookingEtmSingleReportExport->sum('km');
        $missed_km=$total_km-$covered_km;
    ?>
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $AdvanceBookingEtmSingleReportExport->date }}</td>
            <td>{{ $AdvanceBookingEtmSingleReportExport->etm->imei }}</td>
            <td>{{ $AdvanceBookingEtmSingleReportExport->etm->name}}</td>
            <td>{{ $AdvanceBookingEtmSingleReportExport->waybill->code }}</td>                     
            <td>{{ $AdvanceBookingEtmSingleReportExport->total_amount}}</td>           
            <td>{{ $covered_km}}</td>
            <td>{{ $missed_km}}</td>
        </tr>
    @endforeach
    </tbody>
</table>