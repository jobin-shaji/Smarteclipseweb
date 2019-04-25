<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>Conductor</th>
        <th>Conductor Code</th>
        <th>Driver</th>
        <th>Driver Code</th>
        <th>Trip ID</th>
        <th>Waybill No</th>
        <th>Imei</th>
        <th>ETM Name</th>
        <th>Vehicle</th>
        <th>Collection</th>
        <th>Advance Booking Amount</th>
        <th>Total Collection</th>
        <th>Covered Km</th>
        <th>Missed Km</th>
        <th>EPKM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($FormanyConductorReportExport as $FormanyConductorReportExport)
    <?php 
$collection_amount=$FormanyConductorReportExport->collection_amount;
          $advance_booking_amount=$FormanyConductorReportExport->advance_booking_amount;
          $total_collection_amount=$collection_amount+$advance_booking_amount;

           $covered_km=$FormanyConductorReportExport->covered_km;
          $count_trips=$FormanyConductorReportExport->count_km;
          $route_km=$FormanyConductorReportExport->route->total_km;
          $sum_of_route_km=$route_km*$count_trips;
          $missed_km=$sum_of_route_km-$covered_km;

          $collection_amount=$FormanyConductorReportExport->collection_amount;
        
          if($covered_km)
          {
              $epkm=$collection_amount/$covered_km;
          }
          else
          {
            $epkm=0;
          }
         
    ?>
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $FormanyConductorReportExport->created_at }}</td> 
            <td>{{ $FormanyConductorReportExport->conductor->name }}</td>
             <td>{{ $FormanyConductorReportExport->conductor->employee_code }}</td>

            <td>{{ $FormanyConductorReportExport->driver->name }}</td>
             <td>{{ $FormanyConductorReportExport->driver->employee_code }}</td>

             <td>{{ $FormanyConductorReportExport->trip_id }}</td>
             <td>{{ $FormanyConductorReportExport->waybill->code }}</td>
            <td>{{ $FormanyConductorReportExport->etm->imei }}</td>
            <td>{{ $FormanyConductorReportExport->etm->name }}</td>
            <td>{{ $FormanyConductorReportExport->vehicle->register_number }}</td>

            <td>{{ $FormanyConductorReportExport->collection_amount}}</td>
             <td>{{ $FormanyConductorReportExport->advance_booking_amount}}</td>

            <td>{{ $total_collection_amount }}</td>
            <td>{{ $FormanyConductorReportExport->covered_km}}</td>
            <td>{{ $$missed_km }}</td>
            <td>{{$epkm}}</td>
        </tr>
    @endforeach
    </tbody>
</table>