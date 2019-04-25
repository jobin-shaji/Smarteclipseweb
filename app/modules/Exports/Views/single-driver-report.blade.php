<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>WayBill Number</th>
        <th>Conductor Name</th>
        <th>Conductor Code </th>
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
    @foreach($SingledriverReportExport as $SingledriverReportExport)
    <?php
     $total_collection=$SingledriverReportExport->cash;
              $total_advance=$SingledriverReportExport->advance;
              $total=$total_collection+$total_advance;

               $covered_km=$SingledriverReportExport->km;
          $count_trips=$SingledriverReportExport->count_km;
          $route_km=$SingledriverReportExport->route->total_km;
          $sum_of_route_km=$route_km*$count_trips;
          $misskm=$sum_of_route_km-$covered_km;
    ?>
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $SingledriverReportExport->created_at }}</td> 
            <td>{{ $SingledriverReportExport->waybill->code }}</td>                      
            <td>{{ $SingledriverReportExport->conductor->name }}</td>
            <td>{{ $SingledriverReportExport->conductor->employee_code }}</td>
            <td>{{ $SingledriverReportExport->trip_id }}</td>
            <td>{{ $SingledriverReportExport->etm->imei }}</td>
            <td>{{ $SingledriverReportExport->etm->name }}</td>
            <td>{{ $SingledriverReportExport->vehicle->register_number }}</td>
            <td>{{ $total }}</td>
            <td>{{ $SingledriverReportExport->advance }}</td>
             <td>{{ $SingledriverReportExport->km }}</td>
            <td>{{ $misskm}}</td>



            <td>{{ $SingledriverReportExport->cash }}</td>
            <td><?php  
             $epkm=0;
             $income=$SingledriverReportExport->cash;
             $km=$SingledriverReportExport->km;
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