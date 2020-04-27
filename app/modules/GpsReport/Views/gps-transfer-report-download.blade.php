<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

</style>
  <div style="position:absolute;left:520px;top:10px" class="cls_003">
    <img src="assets/images/smart_eclipse_logo.png" alt="Logo" height="30px" width="150px">
  </div>
</head>
<body>
@if(count($transfer_summary) != 0)
<h4>From Date: {{$from_date}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To Date: {{$to_date}}</h4>

<h2>Report Summary</h2>
<table>
  <thead>
    <tr>
      <th>From -> To</th>
      <th>Distributors</th>
      <th>Dealers</th>
      <th>Sub Dealers</th>
      <th>End Users</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    @foreach($transfer_summary as $each_data)
      <tr>
        <td>{{$each_data['from']}}</td>
        <td>{{$each_data['to_distributers']}}</td>
        <td>{{$each_data['to_dealers']}}</td>
        <td>{{$each_data['to_sub_dealers']}}</td>
        <td>{{$each_data['to_clients']}}</td>
        <td><b>{{$each_data['total']}}</b></td>
      </tr>
      @endforeach
  </tbody>
</table>
@endif
@if(count($manufacturer_to_distributor_details) != 0)
<br>
<h3>Transferred List - Manufacturers To Distributors</h3>
<table>
  <thead>
      <tr>
        <th>Manufacturer Name</th>
        <th>Distributor Name</th>
        <th>Transferred</th>
      </tr>
  </thead>
  <tbody>
  <?php $total  = 0; ?>
  @foreach($manufacturer_to_distributor_details as $each_data)
    <tr>
      <td>{{$each_data['transfer_from']}}</td>
      <td>{{$each_data['transfer_to']}}</td>
      <td>{{$each_data['transferred_count']}}</td>
      <?php 
          $total = $total + $each_data['transferred_count'];
      ?>
    </tr>
  @endforeach
  <tr>
      <td></td>
      <td><b>Total</b></td>
      <td><b>{{$total}}</b></td>
  </tr>
  </tbody>
</table>
@endif
@if(count($distributor_to_dealer_details) != 0)
<br>
<h3>Transferred List - Distributors To Dealers</h3>
<table>
  <thead>
      <tr>
        <th>Distributor Name</th>
        <th>Dealer Name</th>
        <th>Transferred</th>
      </tr>
  </thead>
  <tbody>
  <?php $total  = 0; ?>
  @foreach($distributor_to_dealer_details as $each_data)
    <tr>
      <td>{{$each_data['transfer_from']}}</td>
      <td>{{$each_data['transfer_to']}}</td>
      <td>{{$each_data['transferred_count']}}</td>
      <?php 
          $total = $total + $each_data['transferred_count'];
      ?>
    </tr>
  @endforeach
  <tr>
      <td></td>
      <td><b>Total</b></td>
      <td><b>{{$total}}</b></td>
  </tr>
  </tbody>
</table>
@endif
@if(count($dealer_to_sub_dealer_details) != 0)
<br>
<h3>Transferred List - Dealers To Sub Dealers</h3>
<table>
  <thead>
      <tr>
        <th>Dealer Name</th>
        <th>Sub Dealer Name</th>
        <th>Transferred</th>
      </tr>
  </thead>
  <tbody>
  <?php $total  = 0; ?>
  @foreach($dealer_to_sub_dealer_details as $each_data)
    <tr>
      <td>{{$each_data['transfer_from']}}</td>
      <td>{{$each_data['transfer_to']}}</td>
      <td>{{$each_data['transferred_count']}}</td>
      <?php 
          $total = $total + $each_data['transferred_count'];
      ?>
    </tr>
  @endforeach
  <tr>
      <td></td>
      <td><b>Total</b></td>
      <td><b>{{$total}}</b></td>
  </tr>
  </tbody>
</table>
@endif
@if(count($dealer_to_client_details) != 0)
<br>
<h3>Transferred List - Dealers To End Users</h3>
<table>
  <thead>
      <tr>
        <th>Dealer Name</th>
        <th>End User Name</th>
        <th>Transferred</th>
      </tr>
  </thead>
  <tbody>
  <?php $total  = 0; ?>
  @foreach($dealer_to_client_details as $each_data)
    <tr>
      <td>{{$each_data['transfer_from']}}</td>
      <td>{{$each_data['transfer_to']}}</td>
      <td>{{$each_data['transferred_count']}}</td>
      <?php 
          $total = $total + $each_data['transferred_count'];
      ?>
    </tr>
  @endforeach
  <tr>
      <td></td>
      <td><b>Total</b></td>
      <td><b>{{$total}}</b></td>
  </tr>
  </tbody>
</table>
@endif
@if(count($sub_dealer_to_client_details) != 0)
<br>
<h3>Transferred List - Sub Dealers To End Users</h3>
<table>
  <thead>
      <tr>
        <th>Sub Dealer Name</th>
        <th>End User Name</th>
        <th>Transferred</th>
      </tr>
  </thead>
  <tbody>
  <?php $total  = 0; ?>
  @foreach($sub_dealer_to_client_details as $each_data)
    <tr>
      <td>{{$each_data['transfer_from']}}</td>
      <td>{{$each_data['transfer_to']}}</td>
      <td>{{$each_data['transferred_count']}}</td>
      <?php 
          $total = $total + $each_data['transferred_count'];
      ?>
    </tr>
  @endforeach
  <tr>
      <td></td>
      <td><b>Total</b></td>
      <td><b>{{$total}}</b></td>
  </tr>
  </tbody>
</table>
@endif

</body>
</html>