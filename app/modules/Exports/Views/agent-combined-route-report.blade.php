<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Route Code</th>
        <th>Covered KM</th>
        <th>Missed KM</th>
        <th>Total Collection</th>
        <th>EPKM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($routes as $route)
        <tr>
            <?php
                $covered_km=$route->covered_km;
                $count_trips=$route->count_km;
                $route_km=$route->route->total_km;
                $sum_of_route_km=$route_km*$count_trips;
                $missed_km=$sum_of_route_km-$covered_km;
                $total_collection_amount=$route->total_collection_amount;
                if($covered_km){
                    $epkm=$total_collection_amount/$covered_km;
                }else{
                    $epkm=0;
                }
            ?>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $route->route->code }}</td>
            <td>{{ $covered_km }}</td>
            <td>{{ $missed_km }}</td>
            <td>{{ $total_collection_amount }}</td>
            <td>{{ $epkm }}</td>
        </tr>
    @endforeach
    </tbody>
</table>