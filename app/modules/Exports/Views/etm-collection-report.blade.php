<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>ETM</th>
        <th>WayBill Number</th>      
        <th>Income</th>
        
    </tr>
    </thead>
    <tbody>
    @foreach($EtmCollectionExport as $etmcollection)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $etmcollection->date }}</td>
            <td>{{ $etmcollection->etm->imei }}</td>
            <td>{{ $etmcollection->code }}</td>                      
           
            <td>{{ $etmcollection->trips->sum('total_collection_amount')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>