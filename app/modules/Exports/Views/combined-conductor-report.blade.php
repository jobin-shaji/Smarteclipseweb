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
    @foreach($CombinedConductorReportExport as $CombinedConductorReportExport)
    <?php 
$collection_amount=$CombinedConductorReportExport->collection_amount;
          $advance_booking_amount=$CombinedConductorReportExport->advance_booking_amount;
          $total_collection_amount=$collection_amount+$advance_booking_amount;

           $covered_km=$CombinedConductorReportExport->covered_km;
          $count_trips=$CombinedConductorReportExport->count_km;
          $route_km=$CombinedConductorReportExport->route->total_km;
          $sum_of_route_km=$route_km*$count_trips;
          $missed_km=$sum_of_route_km-$covered_km;

          $collection_amount=$CombinedConductorReportExport->collection_amount;
        
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
            <td>{{ $CombinedConductorReportExport->created_at }}</td> 
            <td>{{ $CombinedConductorReportExport->conductor->name }}</td>
             <td>{{ $CombinedConductorReportExport->conductor->employee_code }}</td>

            <td>{{ $CombinedConductorReportExport->driver->name }}</td>
             <td>{{ $CombinedConductorReportExport->driver->employee_code }}</td>

             <td>{{ $CombinedConductorReportExport->trip_id }}</td>
             <td>{{ $CombinedConductorReportExport->waybill->code }}</td>
            <td>{{ $CombinedConductorReportExport->etm->imei }}</td>
            <td>{{ $CombinedConductorReportExport->etm->name }}</td>
            <td>{{ $CombinedConductorReportExport->vehicle->register_number }}</td>

            <td>{{ $CombinedConductorReportExport->collection_amount}}</td>
             <td>{{ $CombinedConductorReportExport->advance_booking_amount}}</td>

            <td>{{ $total_collection_amount }}</td>
            <td>{{ $CombinedConductorReportExport->covered_km}}</td>
            <td>{{ $$missed_km }}</td>
            <td>{{$epkm}}</td>
        </tr>
    @endforeach
    </tbody>
</table>