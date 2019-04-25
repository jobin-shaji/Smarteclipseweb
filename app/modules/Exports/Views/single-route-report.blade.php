<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>Route Code</th>
        <th>Covered KM</th>
        <th>Missed KM</th>
        <th>Collection</th>
        <th>Advance Booking Amount</th>
        <th>Total Collection</th>
        <th>EPKM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($routes as $route)
        <tr>
            <?php
                $covered_km=$route->covered_km;
                $route_km=$route->route->total_km;
                $missed_km=$route_km-$covered_km;
                $collection_amount=$route->collection_amount;
                $advance_booking_amount=$route->advance_booking_amount;
                $total_collection_amount=$collection_amount+$advance_booking_amount;
                if($covered_km){
                    $epkm=$collection_amount/$covered_km;
                }else{
                    $epkm=0;
                }
            ?>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $route->date }}</td>
            <td>{{ $route->route->code }}</td>
            <td>{{ $covered_km }}</td>
            <td>{{ $missed_km }}</td>
            <td>{{ $collection_amount }}</td>
            <td>{{ $advance_booking_amount }}</td>
            <td>{{ $total_collection_amount }}</td>
            <td>{{ $epkm }}</td>
        </tr>
    @endforeach
    </tbody>
</table>