@extends('layouts.gps') 
@section('title')
   Complaint Details
@endsection
@section('content')

    <section class="content-header">
     <h1>Complaint Details</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  
<section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <div class="row">
        <div class="col-md-6">
          <div class="box box-success">
              <div class="box-header ui-sortable-handle" style="cursor: move;">
                <i class="fa fa-file-text-o"></i>
                <h3 class="box-title">Detalied view of complaint</h3>
              </div>
              <div class="box-body">
                <ul class="list-group">
                  <li class="list-group-item">
                  <b>Ticket Code:</b> {{ $complaint->ticket_code}}
                  </li>
                  <li class="list-group-item">
                  <b>GPS Name:</b> {{ $complaint->gps->name}}
                  </li>
                  <li class="list-group-item">
                  <b>IMEI:</b> {{ $complaint->gps->imei}}
                  </li>
                  <li class="list-group-item">
                  <b>Complaint Type:</b> {{ $complaint->complaintType->name}}
                  </li>
                  <li class="list-group-item">
                  <b>Description:</b> {{ $complaint->description}}
                  </li>
                  <li class="list-group-item">
                    @if($complaint->status==0)
                      <?php $solved_user=$complaint->user->username;?>
                      <b>Status:</b> Resolved By {{ $solved_user}}
                    @elseif($complaint->status==1)
                      <b>Status:</b> Submitted
                    @else
                      <?php $solved_user=$complaint->user->username; ?>
                      <b>Status:</b> Accepted By {{ $solved_user}}
                    @endif
                  </li>
                </ul>
              </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box box-primary">
              <div class="box-header ui-sortable-handle" style="cursor: move;">
                <i class="fa fa-comments"></i>
                <h3 class="box-title">Comments</h3>
              </div>
              <div class="box-body">
                <ul class="list-group">
                  @foreach ($complaint_comments as $comment )
                  <li class="list-group-item">
                  <small class="label label-primary" style="font-size: 13px; margin: 0px 12px;"><i class="fa fa-comments"></i> {{$comment->comment}}  ||  {{$comment->created_at}}</small>
                  
                  </li>
                  @endforeach
                </ul>
              </div>
          </div>
        </div>
      </div>
</section>

<div class="clearfix"></div>

@endsection