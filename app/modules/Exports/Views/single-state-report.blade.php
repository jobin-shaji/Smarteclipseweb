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
    @foreach($SinglestateReportExport as $SinglestateReportExport)
    <?php
    $fare=$SinglestateReportExport->totalCollection->sum('fare');
     $covered_km=$SinglestateReportExport->covered_km;
          $collection_amount=$SinglestateReportExport->totalCollection->sum('fare');
          $epkm=$collection_amount/$covered_km;
    ?>
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $SinglestateReportExport->date }}</td>
            <td>{{ $SinglestateReportExport->covered_km }}</td>
            <td>{{ $SinglestateReportExport->missed_km }}</td>
            <td>{{ $fare }}</td>  
            <td>{{ $epkm }}</td>               
        </tr>
    @endforeach
    </tbody>
</table>