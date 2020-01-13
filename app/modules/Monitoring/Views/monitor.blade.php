@extends('layouts.eclipse')
@section('title')
  All Vehicle
@endsection
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('css/monitor.css')}}">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<?php
    $key = '';  
?>
<section style="background:#efefe9;">
  <div class="container">
    <div class="row">
      <div class="board">
        <div class="board-inner">
          <ul class="nav nav-tabs" id="myTab">
            <div class="liner"></div>
            <li class="active">
              <a href="{{url('/monitor_home')}}" data-toggle="tab" title="welcome">
                <span class="round-tabs">
                  <i class="glyphicon glyphicon-home"></i>
                </span> 
              </a>
            </li>
            <li>
              <a href="{{url('/monitor')}}" title="Monitoring">
                <span class="round-tabs">
                  <i class="fa fa-desktop" aria-hidden="true"></i>
                </span> 
              </a>
            </li>
            <li>
              <a href="#messages" data-toggle="tab" title="bootsnipp goodies">
               <span class="round-tabs">
                  <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
               </span> 
              </a>
            </li>
            <li>
              <a href="#settings" data-toggle="tab" title="blah blah">
                <span class="round-tabs">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                </span> 
              </a>
            </li>
            <li>
              <a href="#doner" data-toggle="tab" title="completed">
                <span class="round-tabs">
                  <i class="fa fa-truck" aria-hidden="true"></i>
                </span> 
              </a>
            </li>
          </ul>
        </div>
        <div class="tab-content">
          <div class="tab-pane fade in active" id="home">
            <h3 class="head text-center">Welcome to Bootsnipp</h3>
            <p class="narrow text-center">
                Lorem ipsum dolor sit amet, his ea mollis fabellas principes. Quo mazim facilis tincidunt ut, utinam saperet facilisi an vim.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>                
@endsection
