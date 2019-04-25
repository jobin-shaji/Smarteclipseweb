<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>WayBill Number</th>
        <th>Bus</th>
        <th>Driver</th>
        <th>Driver Code</th>
        <th>Conductor</th>
        <th>Conductor Code</th>
        <th>Etm</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($waybills as $waybill)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $waybill->code }}</td>
            <td>{{ $waybill->vehicle->register_number }}</td>
            <td>{{ $waybill->driver->name }}</td>
            <td>{{ $waybill->driver->employee_code }}</td>
            <td>{{ $waybill->conductor->name }}</td>
            <td>{{ $waybill->conductor->employee_code }}</td>
            <td>{{ $waybill->etm->imei }}</td>
            <td>{{ $waybill->date }}</td>
        </tr>
    @endforeach
    </tbody>
</table>