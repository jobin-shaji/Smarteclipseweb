<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
      @yield('title')
  </title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
   <?php 
     $client = Auth::user()->client;

     
     if($client)
     {
      // $user = Auth::user();
        if($client->count() > 0){
          $id = $client->id;
        }
        else{
          $id = null;
        }
     }
     else
     {
      $id = null;
     }
   
  ?>
  <meta name="client" content="{{$id}}">
  <meta name="domain" content="{{url('/')}}">
  
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
  <!-- hilite css-->
   <link rel="stylesheet" href="{{asset('css/hilite.css')}}">

   <link rel="stylesheet" href="{{asset('css/custom.css')}}">

   <!-- search option in dropdown -->
   <link rel="stylesheet" href="{{asset('css/bootstrap-select.css')}}">

   
   <link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.css')}}">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
 
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

    <link rel='stylesheet' href='https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.css' />
<!--     <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous"> -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/h-style.css')}}">

  
</head>