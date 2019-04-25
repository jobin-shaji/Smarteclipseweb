<table>
    <thead>
    <tr>
        <th>Si.No</th>
        <th>Trip No</th>
        <th>Trip Date</th>
        <th>KMs</th>
        <th>No Of Full Ticket</th>
        <th>No Of Half Ticket </th>
        <th>No Of Luggage Ticket</th>
        <th>No Of Prisoner Ticket</th>
        <th>No Of Old Women Ticket</th>
        <th>Full Ticket Amount</th>
        <th>Half Ticket Amount</th>
        <th>Net Total Amount </th>
        <th>EPKM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($TripwiseExport as $Tripwise)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $Tripwise->trip_id }}</td>
            <td>{{ $Tripwise->created_at }}</td>
            <td>{{ $Tripwise->km }}</td>
            <td>{{ $Tripwise->full_ticket }}</td>
            <td>{{ $Tripwise->half_ticket }}</td>
            <td>{{ $Tripwise->luggage_ticket }}</td>
            <td>-</td>
            <td>{{ $Tripwise->old_woman }}</td>
            <td>{{ $Tripwise->full_ticket_amount }}</td>
            <td>{{ $Tripwise->half_ticket_amount }}</td>
            <td>{{ $Tripwise->total_collection_amount }}</td>
            <td>-</td>
        </tr>
    @endforeach
    </tbody>
</table>