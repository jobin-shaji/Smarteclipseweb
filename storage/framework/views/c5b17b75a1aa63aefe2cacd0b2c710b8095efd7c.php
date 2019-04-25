<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
      <?php echo $__env->yieldContent('title'); ?>
  </title>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <?php
    $depot = Auth::user()->depot;
    if($depot->count() > 0){
      $id = $depot->first()->id;
    }else{
      $id = null;
    }
  ?>
  <meta name="depot" content="<?php echo e($id); ?>">
  <meta name="domain" content="<?php echo e(url('/')); ?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo e(asset('css/font-awesome.min.css')); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo e(asset('css/ionicons.min.css')); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('css/AdminLTE.min.css')); ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo e(asset('css/_all-skins.min.css')); ?>">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-datepicker.min.css')); ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo e(asset('css/daterangepicker.css')); ?>">
  <!-- hilite css-->
   <link rel="stylesheet" href="<?php echo e(asset('css/hilite.css')); ?>">

   <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">

   <!-- search option in dropdown -->
   <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-select.css')); ?>">

   
   <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-datetimepicker.css')); ?>">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
 
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

</head>