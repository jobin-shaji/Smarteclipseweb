<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>Cond Name</th>
        <th>Waybill No</th>
        <th>Amount Paid</th>
    </tr>
    </thead>
    <tbody>
    @foreach($expenses as $expense)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $expense->date_time }}</td>
            <td>{{ $expense->employee->name }}</td>
            <td>{{ $expense->waybill->code }}</td>
            <td>{{ $expense->amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>