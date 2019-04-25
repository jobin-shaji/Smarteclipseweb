<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>Covered KM</th>
         <th>Missed KM</th>
         <th>Total </th>
         <th>EPKM </th>
        
       
    </tr>
    </thead>
    <tbody>
    @foreach($CombinedstateReportExport as $CombinedstateReportExport)
    <?php
    $fare=$CombinedstateReportExport->totalCollection->sum('fare');
     $covered_km=$CombinedstateReportExport->covered_km;
          $collection_amount=$CombinedstateReportExport->totalCollection->sum('fare');
          $epkm=$collection_amount/$covered_km;
    ?>
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $CombinedstateReportExport->date }}</td>
            <td>{{ $CombinedstateReportExport->covered_km }}</td>
            <td>{{ $CombinedstateReportExport->missed_km }}</td>
            <td>{{ $fare }}</td>  
            <td>{{ $epkm }}</td>               
        </tr>
    @endforeach
    </tbody>
</table>