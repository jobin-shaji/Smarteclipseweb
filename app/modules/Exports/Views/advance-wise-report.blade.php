<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>Date</th>
        <th>WayBill Number</th>
        <th>Agent</th>
        <th>Agent Code</th>
        <th>Imei</th>
       <th>ETM Name</th>
        <th>Income</th>
        <th> km</th>
        <th>EPKM</th>
    </tr>
    </thead>
    <tbody>
    @foreach($AdvanceWiseExport as $AdvanceWiseExport)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $AdvanceWiseExport->date }}</td> 
            <td>{{ $AdvanceWiseExport->code }}</td>                      
            <td>{{ $AdvanceWiseExport->agent->name }}</td>
            <td>{{ $AdvanceWiseExport->agent->employee_code }}</td>
            <td>{{ $AdvanceWiseExport->etm->imei }}</td>
            <td>{{ $AdvanceWiseExport->etm->name }}</td>
            <td>{{ $AdvanceWiseExport->trips->sum('total_collection_amount')}}</td>
            <td>{{ $AdvanceWiseExport->trips->where('has_closed',1)->sum('km') }}</td>
            <td><?php  
             $epkm=0;
             $income=$AdvanceWiseExport->trips->sum('total_collection_amount');
             $km=$AdvanceWiseExport->trips->where('has_closed',1)->sum('km');
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