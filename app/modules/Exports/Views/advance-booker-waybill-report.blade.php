<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>WayBill Number</th>        
        <th>Agent</th>
        <th>Agent Code</th>       
        <th>Etm</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($waybills as $waybill)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $waybill->code }}</td>          
            <td>{{ $waybill->agent->name }}</td>
            <td>{{ $waybill->agent->employee_code }}</td>          
            <td>{{ $waybill->etm->imei }}</td>
            <td>{{ $waybill->date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>