<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>Trip id</th>
        <th>Route Name</th>
        <th>Number Of Tickets</th>
        <th>Total Amount</th>
        <th>EPKM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($waybillwisetripExport as $waybilltripwise)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $waybilltripwise->created_at }}</td>
            <td>{{ $waybilltripwise->trip_id }}</td>
            <td>{{ $waybilltripwise->route->code }}</td> 
             <td>{{ $waybilltripwise->total_collection_amount }}</td> 
            <td>{{ $waybilltripwise->km }}</td> 
            <td><?php
                $total_km=$waybilltripwise->km;
                $total_revenue=$waybilltripwise->total_collection_amount;
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