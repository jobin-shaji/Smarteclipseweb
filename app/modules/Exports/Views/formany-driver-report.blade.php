

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
    @foreach($FormanyDriverReportExport as $FormanyDriverReportExport)
    <?php
     $total_collection=$FormanyDriverReportExport->cash;
              $total_advance=$FormanyDriverReportExport->advance;
              $total=$total_collection+$total_advance;

               $covered_km=$FormanyDriverReportExport->km;
          $count_trips=$FormanyDriverReportExport->count_km;
          $route_km=$FormanyDriverReportExport->route->total_km;
          $sum_of_route_km=$route_km*$count_trips;
          $misskm=$sum_of_route_km-$covered_km;
    ?>
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $FormanyDriverReportExport->created_at }}</td> 
            <td>{{ $FormanyDriverReportExport->waybill->code }}</td>                      
            <td>{{ $FormanyDriverReportExport->conductor->name }}</td>
            <td>{{ $FormanyDriverReportExport->conductor->employee_code }}</td>
             <td>{{ $FormanyDriverReportExport->trip_id }}</td>
            <td>{{ $FormanyDriverReportExport->etm->imei }}</td>
            <td>{{ $FormanyDriverReportExport->etm->name }}</td>
            <td>{{ $FormanyDriverReportExport->vehicle->register_number }}</td>
            <td>{{ $total }}</td>
            <td>{{ $FormanyDriverReportExport->advance }}</td>
             <td>{{ $FormanyDriverReportExport->km }}</td>
            <td>{{ $misskm}}</td>



            <td>{{ $FormanyDriverReportExport->cash }}</td>
            <td><?php  
             $epkm=0;
             $income=$FormanyDriverReportExport->cash;
             $km=$FormanyDriverReportExport->km;
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