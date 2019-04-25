<table>
    <thead>
    <tr>
        <th>Si.No</th>
        <th>Waybill No</th>
        <th>Date</th>
        <th>ETM</th>
        <th>Vehicle</th>
        <th>Conductor</th>
        <th>Driver</th>
        <th>Number of Trips</th>
        <th>Income</th>
        <th>Km</th>
        <th>EPKM</th>
        
    </tr>
    </thead>
    <tbody>
    @foreach($dailycashcollectionExport as $dailycashcollection)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $dailycashcollection->code }}</td>
            <td>{{ $dailycashcollection->date }}</td>
            <td>{{ $dailycashcollection->etm->name }}</td>
            <td>{{ $dailycashcollection->vehicle->register_number }}</td>
            <td>{{ $dailycashcollection->conductor->name }}</td>
            <td>{{ $dailycashcollection->driver->name }}</td>
            <td>
                <?php  $count_trips=$dailycashcollection->trips->where('has_closed',1)->count('id');
                echo $count_trips; ?>

            </td>
            <td>{{ $dailycashcollection->trips->sum('total_collection_amount')}}</td>
            <td>{{ $dailycashcollection->trips->where('has_closed',1)->sum('km') }}</td>
            <td><?php  
             $epkm=0;
             $income=$dailycashcollection->trips->sum('total_collection_amount');
             $km=$dailycashcollection->trips->where('has_closed',1)->sum('km');
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