<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>Agent</th>
        <th>Agent Code</th>
        
        <th>Waybill No</th>
        <th>ETM</th>
        <th>Vehicle</th>
        <th>Collection</th>
        <th>Covered Km</th>
        <th>Missed Km</th>
        <th>EPKM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($SingleAgentExport as $SingleAgentExport)
        <tr>
          <?php
            $covered_km=$SingleAgentExport->covered_km;
            $count_trips=$SingleAgentExport->count_km;
            $route_km=$SingleAgentExport->route->total_km;
            $sum_of_route_km=$route_km*$count_trips;
            $missed_km=$sum_of_route_km-$covered_km;
            $collection_amount=$SingleAgentExport->collection_amount;
           
            if($covered_km){
              $epkm=$collection_amount/$covered_km;
            }else{
              $epkm=0;
            }
            
          ?>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $SingleAgentExport->date }}</td> 
            <td>{{ $SingleAgentExport->agent->name }}</td>
            <td>{{ $SingleAgentExport->agent->employee_code }}</td>
            <td>{{ $SingleAgentExport->waybill->code }}</td>
            <td>{{ $SingleAgentExport->etm->imei }}</td>
            <td>{{ $SingleAgentExport->vehicle->register_number }}</td>
            <td>{{ $collection_amount }}</td>            
            <td>{{ $covered_km }}</td>
            <td>{{ $missed_km }}</td>
            <td>{{ $epkm }}</td>
           
        </tr>
    @endforeach
    </tbody>
</table>