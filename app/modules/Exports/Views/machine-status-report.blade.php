<table>
    <thead>
    <tr>
        <th>Sl.No</th>
        <th>ETM Name</th>
        <th>IMEI</th>
        <th>Status</th>
        <th>Conductor</th>
        <th>Remarks</th>
    </tr>
    </thead>
    <tbody>
    @foreach($machines as $machine)
        <tr>
            <td>{{$loop->iteration }}</td>
            <td>{{$machine->name}}</td>
            <td>{{$machine->imei}}</td>
            <?php
            if($machine->waybill){
                $status = 'Issued';
                $conductor = $machine->waybill->conductor->name;
            }else{
                $status = 'Recieved';
                $conductor = "";
            }
            ?>
            <td>{{$status}}</td>
            <td>{{$conductor}}</td>  
            <td></td>                
        </tr>
    @endforeach
    </tbody>
</table>