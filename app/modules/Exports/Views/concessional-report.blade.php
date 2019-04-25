<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>Waybill No.</th>
        <th>Ticket No.</th>
        <th>Voucher No</th>
        <th>Category Name</th>
        <th>From</th>
        <th>To</th>
        <th>No of Passenger</th>
        <th>Actual Fare</th>
        <th>Discount Amount</th>
        <th>Fare Collection</th>
    </tr>
    </thead>
    <tbody>
    @foreach($concessions as $concession)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $concession->created_at }}</td>
            <td>{{ $concession->waybill->code }}</td>
            <td>{{ $concession->ticket_code }}</td>
            <td>{{ $concession->pass_number }}</td>
            <td>{{ $concession->concession->name }}</td>
            <td>{{ $concession->fromStage->name }}</td>
            <td>{{ $concession->toStage->name }}</td>
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