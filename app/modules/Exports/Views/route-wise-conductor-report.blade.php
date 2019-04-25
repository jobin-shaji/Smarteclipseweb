<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>Trip id</th>
        <th>Route Name</th>
        <th>Conductor</th>
        <th>Amount</th>
        <th>Covered Kms</th>
        <th>EPKM</th>
        <th>Gross EPKM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($routewiseconductorExport as $routewiseconductor)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $routewiseconductor->created_at }}</td>
            <td>{{ $routewiseconductor->trip_id }}</td>
            <td>{{ $routewiseconductor->route->code }}</td> 
            <td>{{ $routewiseconductor->conductor->name }}</td> 
             <td>{{ $routewiseconductor->total_collection_amount }}</td> 
            <td>{{ $routewiseconductor->km }}</td> 
            <td><?php  
                $total_km=$routewiseconductor->km;
                $total_revenue=$routewiseconductor->total_collection_amount;
                if($total_km>0){
                    $epkm=$total_revenue/$total_km;
                }else{
                    $epkm=0;
                }
                echo $epkm;?></td>
            <td><?php  $epkm=0;
                $total_km=$routewiseconductor->km;
                $total_revenue=$routewiseconductor->total_collection_amount;
                if($total_km>0){
                    $epkm=$total_revenue/$total_km;
                }else{
                    $epkm=0;
                }
                echo $epkm;?></td>
        </tr>
    @endforeach
    </tbody>
</table>