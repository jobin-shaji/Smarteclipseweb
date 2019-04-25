<table>
    <thead>
    <tr>
        <th>Si.No</th>
        <th>Ticket Number</th>
        <th>Date</th>
        <th>Time</th>
        <th>From Stage</th>
        <th>To Stage</th>
        <th>Full</th>
        <th>Half</th>
        <th>SPL</th>
        <th>lugg</th>
        <th>Pass</th>
        <th>Ticket Amount</th>
        <th>Remark</th>
    </tr>
    </thead>
    <tbody>
    @foreach($StagewiseExport as $Stagewise)
        <tr>
            <td>{{ $loop->iteration }}</td>
           <td>{{ $Stagewise->ticket_code }}</td>
           <td>{{ date('Y-m-d', strtotime($Stagewise->created_at))}}</td>
           <td>{{ date('H:i:s', strtotime($Stagewise->created_at))}}</td>
           <td>{{ $Stagewise->fromStage->name }}</td>
           <td>{{ $Stagewise->toStage->name }}</td>
           <td><?php if($Stagewise->concession_id==11){ echo $Stagewise->count;}else{ echo "0";}?></td>
            <td><?php if($Stagewise->concession_id==12){ echo $Stagewise->count;}else{ echo "0";}?></td>
            <td><?php if($Stagewise->concession_id==8){ echo $Stagewise->count;}else{ echo "0";}?></td>
            <td><?php if($Stagewise->concession_id==13){ echo $Stagewise->count;}else{ echo "0";}?></td>
            <td><?php if($Stagewise->concession_id==13 || $Stagewise->concession_id==8||$Stagewise->concession_id==12 ||$Stagewise->concession_id==11){ echo $Stagewise->count;}else{ echo "0";}?></td>
            <td>{{ $Stagewise->ticket_fare }}</td>
            <td>-</td>
           <!-- <td>{{$Stagewise->count}}</td> -->
        </tr>
    @endforeach
    </tbody>
</table>