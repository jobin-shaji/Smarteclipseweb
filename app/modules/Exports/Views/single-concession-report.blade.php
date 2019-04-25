<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>Concession Type</th>
        <th>No of Passenger</th>
        <th>Actual Amount</th>
        <th>Discount Amount</th>
        <th>Total Collection</th>
    </tr>
    </thead>
    <tbody>
    @foreach($concessions as $concession)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $concession->date }}</td>
            <td>{{ $concession->concession->name }}</td>
            <td>{{ $concession->count }}</td>
            <?php
                $actual_fare=$concession->actual_amount;
                $collected_fare=$concession->total_amount;
                $discount_amount=$actual_fare-$collected_fare;
            ?>
            <td>{{ $actual_fare }}</td>
            <td>{{ $discount_amount }}</td>
            <td>{{ $collected_fare }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

