<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>Covered KM</th>
        <th>Missed KM</th>
        <th> Total</th>
        <th> SRT</th>
        <th> Actual Amount</th>
        <th> GST</th>
       
    </tr>
    </thead>
    <tbody>
    @foreach($CombinedgstReportExport as $CombinedgstReportExport)
    <?php $fare=$CombinedgstReportExport->totalCollection->where('vehicle_type_id',2)->sum('actual_fare');
          $km=$CombinedgstReportExport->covered_km;
                $value=$CombinedgstReportExport->srtcalculation->where('vehicle_type_id',2)->sum('value');
                $srt=$km * $value;
                  $actual_fare=$CombinedgstReportExport->totalCollection->where('vehicle_type_id',2)->sum('fare'); 

                  $total_fare=$CombinedgstReportExport->totalCollection->where('vehicle_type_id',2)->sum('fare');       
                $value=$CombinedgstReportExport->srtcalculation->where('vehicle_type_id',2)->sum('value');              
               $gst= $total_fare-$srt;             
    ?>
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $CombinedgstReportExport->date }}</td>
            <td>{{ $CombinedgstReportExport->covered_km }}</td>  
            <td>{{ $CombinedgstReportExport->missed_km }}</td> 
            <td>{{ $fare }}</td> 
            <td>{{ $srt }}</td> 
            <td>{{ $total_fare }}</td> 
            <td>{{ $gst }}</td>                    
           
        </tr>
    @endforeach
    </tbody>
</table>