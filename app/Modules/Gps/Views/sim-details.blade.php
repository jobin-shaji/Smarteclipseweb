@extends('layouts.eclipse') 
@section('title')
   Device Details
@endsection
<style>
body {
  font-family: 'Helvetica Neue', sans-serif;
  background: #fff;
  margin: 0;
  padding: 0;
}
.invoice-container {
  max-width: 900px;
  margin: 40px auto;
  background: #fdfdfd;
  /* border: 1px solid #ccc; */
  box-shadow: 0 0 8px rgba(0,0,0,0.01);
  padding: 40px;
  border-radius: 4px;
}
.header {
  text-align: center;
  margin-bottom: 30px;
}
.header h1 {
  font-size: 32px;
  color: #444;
  margin: 0;
}
.header .subtext {
  font-size: 14px;
  color: #888;
}
.section-title {
  font-size: 18px;
  margin: 20px 0 10px;
  color: #333;
  border-bottom: 2px solid #eee;
  padding-bottom: 4px;
}
.info-table, .items-table, .summary-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}
.info-table td, .items-table th, .items-table td, .summary-table td {
  border: 1px solid #ddd;
  padding: 8px;
  vertical-align: top;
}
.items-table th {
  background-color: #444;
  color: #fff;
  font-size: 14px;
}
.summary-table td {
  font-size: 14px;
}
.summary-table td:last-child, .items-table td:last-child {
  text-align: right;
}
.footer {
  text-align: center;
  color: #888;
  font-size: 12px;
  margin-top: 30px;
  padding-top: 10px;
  border-top: 1px solid #eee;
}
</style>
@section('content')

<div class="page-wrapper page-wrapper_new">

  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Device Details</li>
        <b>Device Details</b>
         @if(Session::has('message'))
        <div class="pad margin no-print" style="margin-top:-1%;margin-left:1%">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
        @endif 
      </ol>
    </nav>
    <div class="container-fluid">
      <div class="card-body">
       
      <div class="invoice-container">
  <table class="info-table">
    <tr>
      <td><br>
          VST IOT SOLUTIONS PVT. LTD<br>
          52/2208A BHAGATH SINGH ROAD DESOM, VYTILA<br>
          Phone: 9746120384<br>
          Email: vstadmin@vstiotsolutions.com<br>
          GSTIN: 32AAHCV6151D1ZL | State: 32-Kerala</td>
      <td><strong>To:</strong><br>
          {{$gps->delivery_name}}<br>
          {{$gps->delivery_address}}<br>
          Invoice No.:{{$gps->order_id}}<br>
          Date:  {{$gps->gps->pay_date}} <br>
          Sales Person: namitha</td>
    </tr>
  </table>

  <div class="section-title">Items</div>

@php

$totalAmount = $gps->total_amount; // Example total amount inclusive of 18% GST
  $gstRate = 18; // Combined GST
  $taxMultiplier = 1 + ($gstRate / 100);

  $baseAmount = $totalAmount / $taxMultiplier;
  $totalGST = $totalAmount - $baseAmount;
  $cgst = $sgst = $totalGST / 2;
  
  @endphp
<table class="items-table">
  <tr>
    <th>#</th>
    <th>Item Name</th>
    <th>HSN/SAC</th>
    <th>Qty</th>
    <th>Unit Price</th>
    <th>GST</th>
    <th>Total</th>
  </tr>
  <tr>
    <td>1</td>
    <td>
      @if(!$gps->gps->mob_app)
      DATA RENEWAL FOR ONE YEAR (WITHOUT APPLICATION)
      @else
      DATA RENEWAL FOR ONE YEAR (WITH APPLICATION)
      @endif
  </td>
    <td></td>
    <td>1 Nos</td>
    <td> {{number_format($baseAmount,2)}}</td>
    <td> {{number_format($totalGST,2)}} (18%)</td>
    <td> {{$gps->total_amount}}</td>
  </tr>
</table>
<div class="section-title">Additional Details</div>
  <p><strong>IMEI & VEHICLE NO:</strong>{{$gps->gps->imei}}<br>
  {{$gps->gps->vehicle_no}}</p>
<div class="section-title">Summary</div>
<table class="summary-table">
  <tr><td>Sub Total</td><td>{{number_format($baseAmount,2)}}</td></tr>
  <tr><td>SGST@9%</td><td> {{number_format($sgst,2)}}</td></tr>
  <tr><td>CGST@9%</td><td>{{number_format($cgst,2)}}</td></tr>
  <tr><td><strong>Total</strong></td><td><strong> {{$gps->total_amount}}</strong></td></tr>
  <tr><td>Received</td><td>{{$gps->total_amount}}</td></tr>
  <tr><td>Balance</td><td> 0.00</td></tr>
</table>

  
 
</div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
@endsection