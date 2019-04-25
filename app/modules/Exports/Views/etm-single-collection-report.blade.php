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
    @foreach($EtmSingleCollectionExport as $EtmSingleCollectionExport)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $EtmSingleCollectionExport->date }}</td>
            <td>{{ $EtmSingleCollectionExport->etm->imei }}</td>
            <td>{{ $EtmSingleCollectionExport->waybill->code }}</td>                     
            <td>{{ $EtmSingleCollectionExport->total_amount}}</td>

            <td>{{ $EtmSingleCollectionExport->sumOfAdvanceBookingAmount->sum('advanceBookingAmount')}}</td>
            <td>{{ $EtmSingleCollectionExport->total_amount}}</td>
            <td>{{ $EtmSingleCollectionExport->km->sum('km')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>