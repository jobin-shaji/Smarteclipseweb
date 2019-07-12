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
     $sub_dealer=$user->sub_dealer;
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
   
  ?>
  <meta name="client" content="{{$id}}">
  <meta name="domain" content="{{url('/')}}">

      <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="{{ url('/') }}image/png" sizes="16x16" href="assets/images/favicon.ico">
    <title>GPS-Admin</title>
    <!-- Custom CSS -->
    <link href="{{ url('/') }}/assets/libs/flot/css/float-chart.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ url('/') }}/dist/css/style.min1.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css"/>

    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet"> -->



    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/dist/css/st.action-panel.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

     <!--  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
       <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}"> -->
</head>

