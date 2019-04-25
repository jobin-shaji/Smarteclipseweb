<table>
    <thead>
    <tr>
        <th>Si.No</th>
        <th>Date</th>
        <th>Waybill No</th>
        <th>Conductor No</th>
        <th>Expense Type</th>
        <th>Expense Amount Paid </th>
    </tr>
    </thead>
    <tbody>
    @foreach($ExpenseExport as $Expense)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ date('Y-m-d', strtotime($Expense->date_time))}}</td>
            <td>{{ $Expense->waybill->code }}</td>
            <td>{{ $Expense->conductorname->name}}</td>
            <td>{{ $Expense->expenditureType->name }}</td>
            <td>{{ $Expense->amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>