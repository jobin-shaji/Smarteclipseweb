@extends('layouts.eclipse')
@section('title')
Reinstallation Job List
@endsection
@section('content')
<?php
$perPage    = 10;
$page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$key        = (isset($_GET['new_installation_search_key'])) ? $_GET['new_installation_search_key'] : '';
?>
<div class="page-wrapper_new">
   <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/ New Reinstallation Jobs List</li>
            <b> New Reinstallation Jobs List</b>
        </ol>
        @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}
            </div>
          </div>
        @endif
    </nav>

  
    <!-- Search and filters -->

    <div align="right" class="search-1">
        <form method="GET" action="{{route('reinstallation-job-list')}}" class="search-top">
        {{csrf_field()}}
            <div class="pull-right cover_list_search">
                <div class="row" >
                    <div class="col-lg-12" >
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group" style="width: 100%;">
                                    <input type="text" class="form-control" placeholder="Enter Job Code, Serial No, UserDetails" name="new_installation_search_key" id="new_installation_search_key" autocomplete='off'  size="100" value="{{ $key }}">
                                </div>
                            </div>
                            <div class="col-lg-2" style="margin: 0 0px 18px 0;">
                                <div class="form-group" style="width: 100%;">
                                    <button type="submit"  class="btn btn-primary search_data_list" title="Enter Job Code, Serial No,user name,End User Details">Search</button>
                                </div>
                            </div>
                            <div class="col-lg-2" style="margin: 0 0px 18px 0;">
                                <div class="form-group" style="width: 50%;">
                                    <button type="submit" class="btninst btninst-primary" onclick="clearSearch()">Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div> 
    <table class="table table-hover table-bordered  datatable"  style="width:95%;text-align: center;margin-left: 36px !important;table-layout: fixed;" >
    <!-- <table class="table table-hover table-bordered  table-striped datatable"  style="width:70%;text-align: center" > -->
        <thead class="indigo white-text">
            <tr>
                <th><b>SL.No</b></th>
                <th><b>Job Code</b></th>
                <th><b>End User Details</b></th>
                <!-- <th><b>Assignee<b></th> it shows username of dealer/subdealer.The assignee
                                should be the owner of servicer,so this field is not required  -->
                <th><b>GPS Serial No<b></th>
                <th><b>Description<b></th>
                <th><b>Location<b></th>
                <th><b>Job Date<b></th>
                <th><b>Status<b></th>  
                <th><b>Action</b></th>  
            </tr>
        </thead>
        <tbody style="word-break: break-all;">
            @if($servicer_jobs->count() == 0)
                <tr>
                    <td colspan="9"><b>No Data Available</b></td>
                </tr>
            @endif

            @foreach($servicer_jobs  as $key => $servicer_job)
                <tr>
                    <td style="width:4%;">{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
                    <td>{{$servicer_job->job_id}}</td>
                    <td>{{$servicer_job->client_name}} , {{$servicer_job->mobile_number}}
                    <br>{{$servicer_job->user_email}}<br>{{$servicer_job->client_address}}
                    </td>
                    <!-- <td>{{$servicer_job->user_name}}</td> -->
                    <td>{{ ($servicer_job->gps_serial_no) ? $servicer_job->gps_serial_no: ''}}</td>
                    <td>{{$servicer_job->description}}</td>
                    <td>{{$servicer_job->location}}</td>
                    <td>{{$servicer_job->job_date}}</td>
                    @if($servicer_job->status == 0)
                    <td>Cancel</td>
                    @elseif ($servicer_job->status == 1)
                    <td>Assigned</td>
                    @elseif ($servicer_job->status == 2)
                    <td>Pending</td>
                    @else
                    <td>Completed</td>
                    @endif
                    @if($servicer_job->status == 0)
                    <td><font color='red'>Cancelled</font></td>
                    @elseif ($servicer_job->status == 1)
                    <td> <a href="/job/{{Crypt::encrypt($servicer_job->id)}}/details"class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i>Start Installation</a></td>      
                    @else
                    <td> <a href="/job/{{Crypt::encrypt($servicer_job->id)}}/details"class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i>Start Installation</a></td>     
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $servicer_jobs->appends(Request::all())->links() }}
</div>
<style>
    .table td, .table th 
    {
        padding: 7px 7px;
        vertical-align: top;
        border-top: 0px solid #dee2e6;
    }
    th 
    {
        background-color:#778899 ;
        color: white;
    } 
    .cover_list_search 
    {
        width: 35%;
        size:100;
    }
    .btninst {
        background: #3ab3bf;
        border: none;
        color: white;
        padding: 8px;
        font-size: 14px;
        margin: 3px;
    }
    .btninst-primary {
        color: #fff!important;
        background-color: #3ab3bf;
    }
</style>
@endsection

@section('script')
<script type="text/javascript">
    function clearSearch()
    {
        document.getElementById('new_installation_search_key').value = '';
    }

</script>
@endsection