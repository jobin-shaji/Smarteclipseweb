<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>Covered KM</th>
        <th>Missed KM</th>
        <th>Fare</th>
        <th>EPKM</th>
        <
    </tr>
    </thead>
    <tbody>
    @foreach($SingleStateWiseExport as $SingleStateWiseExport)
    <?php 
          $fare=$SingleStateWiseExport->totalCollection->sum('fare');
    ?>
     
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $SingleStateWiseExport->date }}</td> 
            <td>{{$SingleStateWiseExport->covered_km }} </td>                      
            <td>{{$SingleStateWiseExport->missed_km}}</td>          
            <td>{{$fare }}</td>            
            <td><?php  
             $epkm=0;
             $income=$SingleStateWiseExport->totalCollection->sum('fare');
             $km=$SingleStateWiseExport->covered_km;
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