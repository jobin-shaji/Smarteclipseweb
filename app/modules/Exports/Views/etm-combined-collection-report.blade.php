
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
    @foreach($EtmCombinedCollectionExport as $EtmCombinedCollectionExport)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $EtmCombinedCollectionExport->date }}</td>
            <td>{{ $EtmCombinedCollectionExport->etm->imei }}</td>
            <td>{{ $EtmCombinedCollectionExport->waybill->code }}</td>                     
            <td>{{ $EtmCombinedCollectionExport->total_amount}}</td>

            <td>{{ $EtmCombinedCollectionExport->sumOfAdvanceBookingAmount->sum('advanceBookingAmount')}}</td>
            <td>{{ $EtmCombinedCollectionExport->total_amount}}</td>
            <td>{{ $EtmCombinedCollectionExport->km->sum('km')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>