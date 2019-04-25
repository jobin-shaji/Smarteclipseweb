<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Route</th>
        <th>Date</th>
        <th>Trip Code</th>
        <th>Waybill No</th>
        <th>Vehicle</th>
        <th>Driver</th>
        <th>Conductor</th>
        <th>Start Time</th>
        <th>Close Time</th>
        <th>Start Location</th>
        <th>End Location</th>
        <th>KM</th>
        <th>Total Collection</th>
        <th>FPKM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($routes as $route)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $route->route->code }}</td>
            <td>{{ $route->created_at }}</td>
            <td>{{ $route->trip_id }}</td>
            <td>{{ $route->waybill->code }}</td>
            <td>{{ $route->vehicle->register_number }}</td>
            <td>{{ $route->driver->name }}</td>
            <td>{{ $route->conductor->name }}</td>
            <td>{{ $route->start_time }}</td>
            <td>{{ $route->closed_time }}</td>
            <td>{{ $route->fromStage->name }}</td>
            <td>{{ $route->toStage->name }}</td>
            <td>{{ $route->km }}</td>
            <td>{{ $route->total_collection_amount }}</td>
            <?php
                $km=$route->km;
                $total_collection_amount=$route->total_collection_amount;
                if($km > 0){
                    $fpkm=$total_collection_amount/$km;
                }else{
                    $fpkm=0;
                }
            ?>
            <td>{{ $fpkm }}</td>
        </tr>
    @endforeach
    </tbody>
</table>