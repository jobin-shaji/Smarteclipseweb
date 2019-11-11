<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
   <?php 
     // $client = Auth::user()->client;
     // if($client)
     // {
     //  // $user = Auth::user();
     //    if($client->count() > 0){
     //      $id = $client->id;
     //    }else{
     //      $id = null;
     //    }
     // }
     // else
     // {
     //  $id = null;
     // }
   
  ?>
    <?php 
     $client = Auth::user()->client;

     $user = Auth::user();
     $root=$user->root;    
     $dealer=$user->dealer;
     $sub_dealer=$user->subDealer;
     if($client)
     {      
        if($client->count() > 0){
          $id = $client->id;
        }
        else{
          $id = null;
        }
     }
     else if($root)
     {
      $id = $root->id;
     }
     else if($dealer)
     {
      $id = $dealer->id;
     }

     else if($sub_dealer)
     {

      $id = $sub_dealer->id;
     }
     else
     {
      $id=null;

     } 
  ?>
  <meta name="client" content="{{$id}}">
  <meta name="domain" content="{{url('/')}}">

      <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <?php
      $url=url()->current();
      $rayfleet_key="rayfleet";
      $eclipse_key="eclipse";
      if (strpos($url, $rayfleet_key) == true) {  ?>
          <title>RAYFLEET</title> 
      <?php } 
      else if (strpos($url, $eclipse_key) == true) { ?>
          <title>SMART ECLIPSE</title>
      <?php }
      else { ?>
          <title>SMART ECLIPSE</title> 
    <?php } ?>  
    
    <!-- Custom CSS -->
    <link href="{{ url('/') }}/assets/libs/flot/css/float-chart.css" rel="stylesheet">

    
    <link href="{{ url('/') }}/dist/css/style.min1.css" rel="stylesheet">

    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>

  <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.min.css')}}">
  
  <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
  <link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/dash-popup.css')}}">
    <link rel="stylesheet" href="{{asset('css/relative.css')}}">
    



    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/dist/css/st.action-panel.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
   <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<!-- JavaScript -->

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@yield('pre-css')

  
   <link rel="stylesheet" href="https://use.typekit.net/ins2wgm.css">

    <!-- Load styles -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/app.css?id=a9b4a1e556de29ef2d1c"> -->

    <!-- Load JS -->
    <script src="//ssl.google-analytics.com/ga.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>


     <!--  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
       <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}"> -->
</head>

