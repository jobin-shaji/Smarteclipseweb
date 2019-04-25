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
    @foreach($FormanyAgentReportExport as $FormanyAgentReportExport)
        <tr>
          <?php
            $covered_km=$FormanyAgentReportExport->covered_km;
            $count_trips=$FormanyAgentReportExport->count_km;
            $route_km=$FormanyAgentReportExport->route->total_km;
            $sum_of_route_km=$route_km*$count_trips;
            $missed_km=$sum_of_route_km-$covered_km;
            $collection_amount=$FormanyAgentReportExport->collection_amount;
           
            if($covered_km){
              $epkm=$collection_amount/$covered_km;
            }else{
              $epkm=0;
            }
            
          ?>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $FormanyAgentReportExport->date }}</td> 
            <td>{{ $FormanyAgentReportExport->agent->name }}</td>
            <td>{{ $FormanyAgentReportExport->agent->employee_code }}</td>
            <td>{{ $FormanyAgentReportExport->waybill->code }}</td>
            <td>{{ $FormanyAgentReportExport->etm->imei }}</td>
            <td>{{ $FormanyAgentReportExport->vehicle->register_number }}</td>
            <td>{{ $collection_amount }}</td>            
            <td>{{ $covered_km }}</td>
            <td>{{ $missed_km }}</td>
            <td>{{ $epkm }}</td>
           
        </tr>
    @endforeach
    </tbody>
</table>