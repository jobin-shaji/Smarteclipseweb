<table>
    <thead>
    <tr>
        <th>Si.No</th>
        <th>Waybill</th>
        <th>Date</th>
        <th>Inspector</th>
        <th>Penalty Type</th>
        <th>Employee</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($penalties as $penalty)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $penalty->waybill->code }}</td>
             <td>{{ $penalty->created_at}}</td>
            <td>{{ $penalty->inspector->name }}</td>
            <td>{{ $penalty->concession->name }}</td>
            <?php
                if($penalty->employee_id == null){
                    $employee = '--';
                }else{
                    $employee = $penalty->employee->name;
                }
            ?>
            <td>{{ $employee }}</td>
            <td>{{ $penalty->amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>