<table>
    <thead>
    <tr>
        <th>SL.No</th>
        <th>Vehicle</th>
        <th>Alert Type</th>
        <th>DateTime</th>  
    </tr>
    </thead>
     <tbody>
        @foreach($suddenAccelerationReportExport as $suddenAccelerationReportExport)
        <tr>           
            <td>{{ $loop->iteration }}</td>
            <td>{{ $suddenAccelerationReportExport->gps->vehicle->register_number }}</td>           
            <td>{{ $suddenAccelerationReportExport->alertType->description }}</td>
            <td>{{ $suddenAccelerationReportExport->device_time }}</td>         
        </tr>
        @endforeach
    </tbody>
</table>