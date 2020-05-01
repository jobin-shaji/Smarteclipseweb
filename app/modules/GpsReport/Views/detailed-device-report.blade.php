@extends('layouts.eclipse')
@section('title')
  Detailed Device Report
@endsection
@section('content')  
<section class="hilite-content">
    <div class="page-wrapper_new mrg-top-50">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Detailed Device Report</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="box-part text-center" style="background-color:#ded8ca;">
                    <i class="fa fa-arrows-h icon" aria-hidden="true"></i>
                    <div class="title">
                       <h4 style="font-size: 17px;">DEVICE TRANSFER REPORT</h4>
                    </div><br>
                    <a class='link' href="gps-transfer-report">View More</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-left: 10px;">
                <div class="box-part text-center" style="background-color:#ded8ca;">
                    <i class="fa fa-arrows-h icon" aria-hidden="true"></i>
                    <div class="title">
                       <h4 style="font-size: 17px;">DEVICE RETURN REPORT</h4>
                    </div><br>
                    <a class='link' href="gps-returned-report">View More</a>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    body{
        background: #eee;
    }
    span{
        font-size:15px;
    }
    .link{
        text-decoration:none; 
        color: #0062cc;
        border-bottom:2px solid #0062cc;
    }
    .box{
        padding:60px 0px;
    }

    .box-part{
        background:#FFF;
        border-radius:0;
        padding:60px 10px;
        margin:30px 0px;
    }
    .icon{
        color:#4183D7;
    }
    .h4{
        font-size: 17px;
    }
</style>
@endsection