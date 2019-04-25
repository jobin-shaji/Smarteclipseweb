<table>
    <thead>
    <tr>
        <th>Si No.</th>
        <th>Ticket No</th>
        <th>Date</th>
        <th>Time</th>
        <th>From Stage</th>
        <th>To Stage</th>
        <th>Full</th>
        <th>Half</th>
        <th>Lugg</th>
        <th>Pass</th>
        <th>Ticket Amount</th>
        <th>Remarks</th>
    </tr>
    </thead>
    <tbody>
    @foreach($ticketLogs as $log)
        <td>{{}}</td>
        <td>{{}}</td>
        <td>{{}}</td>
        <td>{{}}</td>
        <td>{{}}</td>
        <td>{{}}</td>
        <td>{{}}</td>
        <td>{{}}</td>
        <td>{{}}</td>
        <td>{{}}</td>
        <td>{{}}</td>
        <td>{{}}</td>
    @endforeach
    </tbody>
</table>