
<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>ETM</th>
        <th>WayBill Number</th>      
        <th>cash</th>
        <th>Advance</th>
        <th>Total</th>
        <th>KM</th>
        
    </tr>
    </thead>
    <tbody>
    @foreach($EtmformanyCollectionReportExport as $EtmformanyCollectionReportExport)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $EtmformanyCollectionReportExport->date }}</td>
            <td>{{ $EtmformanyCollectionReportExport->etm->imei }}</td>
            <td>{{ $EtmformanyCollectionReportExport->waybill->code }}</td>                     
            <td>{{ $EtmformanyCollectionReportExport->total_amount}}</td>

            <td>{{ $EtmformanyCollectionReportExport->sumOfAdvanceBookingAmount->sum('advanceBookingAmount')}}</td>
            <td>{{ $EtmformanyCollectionReportExport->total_amount}}</td>
            <td>{{ $EtmformanyCollectionReportExport->km->sum('km')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>