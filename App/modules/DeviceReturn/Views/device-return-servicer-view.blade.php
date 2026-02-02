@extends('layouts.eclipse')
@section('title')
  Device  Return Details
@endsection
@section('content')    
<section class="hilite-content">
  <div class="page-wrapper_new">
    <!-- breadcrumbs -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Device Return Details</li>
        <b> Device Return Details View</b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
          </div>
        </div>
      @endif  
    </nav> <br>

    <!-- /breadcrumbs -->
    <div class="container-fluid">
      <!-- table section -->
      <table class="table" style='width:700px;'>
        <tbody>
          <tr class="success">
            <td><b>Code </b></td>
            <td class='table_row'>{{ $device_return_details->return_code}}</td>
          </tr>
          <tr class="success">
            <td><b>Returned Service Engineer </b></td>
            <td class='table_row'>{{ $device_return_details->servicer->name}}</td>
          </tr>
          <tr class="success">
            <td><b>IMEI </b></td>
            <td class='table_row'>{{ $device_return_details->gps->imei}}</td>
          </tr>
          <tr class="success">
            <td><b>Serial Number </td>
            <td class='table_row'>{{ $device_return_details->gps->serial_no}}</td>
          </tr>
          <tr class="success">
            <td><b>Type of Issues </b></td>
            @if($device_return_details->type_of_issues==0) 
              <td class='table_row'>{{'Hardware'}}</td>
            @endif
            @if($device_return_details->type_of_issues==1) 
              <td class='table_row'>{{'Software'}}</td>
            @endif
          </tr>
          <tr class="success">
            <td><b>Comments </b></td>
            <td class='table_row'>{{ $device_return_details->comments}}</td>
          </tr>
          <tr class="success">
            <td><b>Returned Date </b></td>
            <td class='table_row'>{{ $device_return_details->created_at}}</td>
          </tr>
          <tr class="success">
            <td><b>Status </b></td>
            @if($device_return_details->status==0)
              <td class='table_row'>{{'Submitted'}} </td>              
            @elseif($device_return_details->status==1)
              <td class='table_row'>{{'Cancelled'}} </td>               
            @elseif($device_return_details->status==2)
              <td class='table_row'>{{'Accepted'}} </td> 
            @endif
          </tr>
          <tr class="success">
            <td><b>End User </b></td>
            <td class='table_row'>{{ $device_return_details->client->name}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>



<style>
  table, th, td {
  border: 1px solid black;
  }
  tr:hover {background-color: #D5D4D5;}
  .table_row
  {
    word-break: break-all;
  }
</style>
@endsection