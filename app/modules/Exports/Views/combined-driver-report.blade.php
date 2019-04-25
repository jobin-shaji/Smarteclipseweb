

<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>WayBill Number</th>
        <th>Conductor</th>
        <th>Conductor Name</th>
        <th>Trip ID</th>
        <th>ETM</th>
        <th>ETM Name</th>
        <th>Vehicle</th>
        <th>Cash</th>
        <th>Advance</th>
        <th>KM</th>

        <th>Missed KM</th>
        <th> Total Amount</th>
        <th>EPKM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($CombinedDriverReportExport as $CombinedDriverReportExport)
    <?php
     $total_collection=$CombinedDriverReportExport->cash;
              $total_advance=$CombinedDriverReportExport->advance;
              $total=$total_collection+$total_advance;

               $covered_km=$CombinedDriverReportExport->km;
          $count_trips=$CombinedDriverReportExport->count_km;
          $route_km=$CombinedDriverReportExport->route->total_km;
          $sum_of_route_km=$route_km*$count_trips;
          $misskm=$sum_of_route_km-$covered_km;
    ?>
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $CombinedDriverReportExport->created_at }}</td> 
            <td>{{ $CombinedDriverReportExport->waybill->code }}</td>                      
            <td>{{ $CombinedDriverReportExport->conductor->name }}</td>
            <td>{{ $CombinedDriverReportExport->conductor->employee_code }}</td>
             <td>{{ $CombinedDriverReportExport->trip_id }}</td>
            <td>{{ $CombinedDriverReportExport->etm->imei }}</td>
            <td>{{ $CombinedDriverReportExport->etm->name }}</td>
            <td>{{ $CombinedDriverReportExport->vehicle->register_number }}</td>
            <td>{{ $total }}</td>
            <td>{{ $CombinedDriverReportExport->advance }}</td>
             <td>{{ $CombinedDriverReportExport->km }}</td>
            <td>{{ $misskm}}</td>



            <td>{{ $CombinedDriverReportExport->cash }}</td>
            <td><?php  
             $epkm=0;
             $income=$CombinedDriverReportExport->cash;
             $km=$CombinedDriverReportExport->km;
             if($km>0){
              $epkm=$income/$km;
             }
             echo $epkm;
            ?>
           </td>
        </tr>
    @endforeach
    </tbody>
</table>