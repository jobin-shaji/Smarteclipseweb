<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>WayBill Number</th>
        <th>Conductor</th>
        <th>ETM</th>
        <th>Vehicle</th>
        <th>Income</th>
        <th> km</th>
        <th>EPKM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($conductorwiseExport as $conductorwise)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $conductorwise->date }}</td> 
            <td>{{ $conductorwise->code }}</td>                      
            <td>{{ $conductorwise->conductor->name }}</td>
            <td>{{ $conductorwise->etm->imei }}</td>
            <td>{{ $conductorwise->vehicle->register_number }}</td>
            <td>{{ $conductorwise->trips->sum('total_collection_amount')}}</td>
            <td>{{ $conductorwise->trips->where('has_closed',1)->sum('km') }}</td>
            <td><?php  
             $epkm=0;
             $income=$conductorwise->trips->sum('total_collection_amount');
             $km=$conductorwise->trips->where('has_closed',1)->sum('km');
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