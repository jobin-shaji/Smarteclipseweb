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
    @foreach($CombinedAgentReportExport as $CombinedAgentReportExport)
        <tr>
          <?php
            $covered_km=$CombinedAgentReportExport->covered_km;
            $count_trips=$CombinedAgentReportExport->count_km;
            $route_km=$CombinedAgentReportExport->route->total_km;
            $sum_of_route_km=$route_km*$count_trips;
            $missed_km=$sum_of_route_km-$covered_km;
            $collection_amount=$CombinedAgentReportExport->collection_amount;
           
            if($covered_km){
              $epkm=$collection_amount/$covered_km;
            }else{
              $epkm=0;
            }
            
          ?>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $CombinedAgentReportExport->date }}</td> 
            <td>{{ $CombinedAgentReportExport->agent->name }}</td>
            <td>{{ $CombinedAgentReportExport->agent->employee_code }}</td>
            <td>{{ $CombinedAgentReportExport->waybill->code }}</td>
            <td>{{ $CombinedAgentReportExport->etm->imei }}</td>
            <td>{{ $CombinedAgentReportExport->vehicle->register_number }}</td>
            <td>{{ $collection_amount }}</td>            
            <td>{{ $covered_km }}</td>
            <td>{{ $missed_km }}</td>
            <td>{{ $epkm }}</td>
           
        </tr>
    @endforeach
    </tbody>
</table>