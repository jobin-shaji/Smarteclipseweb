<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap.css" rel="stylesheet"/>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Date</th>
      <th>Vehicle Name</th>
      <th>Duration</th>
      <th>K.M</th>
    </tr>
  </thead>
  <tbody>
    @foreach($vehicle_invoices as $vehicle_invoice)    
    <tr>           
        <td>{{ $loop->iteration }}</td>
        <td>{{ $vehicle_invoice->date }}</td>           
        <td>{{ $vehicle_invoice->gps->vehicle->register_number }}</td>
        <td><?php echo "NA"; ?></td>            
        <td><?php echo "NA"; ?></td>              
    </tr>
    @endforeach
  </tbody>
</table>