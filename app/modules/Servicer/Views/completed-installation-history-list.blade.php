@extends('layouts.eclipse')
@section('title')
  Servicer Job List
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
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/On Progress Installation Jobs List</li>
        <b> Progress Installation Jobs List</b>
     </ol>
      @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}
            </div>
          </div>
        @endif
    </nav>

    <!-- <div class="mlt-list">
    <!-- Search and filters -->
    <div align="right" class="search-1">
      <form method="GET" action="{{route('completed.installation.job.list')}}" class="search-top">
        {{csrf_field()}}
        <div class="pull-right cover_list_search">
        <div class="row" >
            <div class="col-lg-12" >
                 <div class="row">
                    <div class="col-lg-8">
                      <div class="form-group" style="width: 100%;">
                         <input type="text" class="form-control" placeholder=" Search for Vehicle" name="new_installation_search_key" id="new_installation_search_key" value="{{ $key }}">
                      </div>
                    </div>

                    <div class="col-lg-2" style="margin: 0 0px 18px 0;">
                      <div class="form-group" style="width: 100%;">
                         <button type="submit"  class="btn btn-primary search_data_list" title="Enter IMEI,Owner,Vehicle,Distributor,Dealer,Service Engineer name">Search</button>
                      </div>
                    </div>
                    <div class="col-lg-2" style="margin: 0 0px 18px 0;">
                      <div class="form-group" style="width: 100%;">
                      <button   type="submit" class="btn btn-primary" onclick="clearSearch()">Clear</button>
                         <!-- <button type="submit"  class="btn btn-primary search_data_list" title="Enter IMEI,Owner,Vehicle,Distributor,Dealer,Service Engineer name">Search</button> -->
                      </div>
                    </div>

                 </div>
          
               </div>
            </div>
        </div>
         
  </form>
    </div> 
          <table class="table table-hover table-bordered  table-striped datatable"  style="width:100%;text-align: center" >
          <thead class="indigo white-text">
                            <tr>
                            <th><b>SL.No</b></th>
                                <th><b>Job Code</b></th>
                                <th><b>User Details</b></th>
                                <th><b>Registration Number<b></th>
                                <th><b>GPS Serial No<b></th>
                                <th><b>Description<b></th>
                                <th><b>Location<b></th>
                                <th><b>Job Date<b></th>
                                <th>Job Completed Date</th> 
                                <th><b>Job Type<b></th>  
                                <th><b>Action</b></th>  
                              </tr>
                            </thead>
                            <tbody>
                              @if($servicer_jobs->count() == 0)
                                    <tr>
                                      <td></td>
                                      <td></td>
                                      
                                      <td></td>
                                      <td></td>
                                      <td><b style="float: right;margin-right: -13px">No data</b></td>
                                      <td><b style="float: left;margin-left: -15px">Available</b></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      
                                </tr>
                                    @endif
                              
              @foreach($servicer_jobs  as $key => $servicer_job)
                            
                <tr>
                <td style="width:4%;">{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
                    <td>{{$servicer_job->job_id}}</td>
                    <td>{{$servicer_job->client_name}} , {{$servicer_job->mobile_number}}
                    <br>{{$servicer_job->user_email}}<br>{{$servicer_job->client_address}}
                    </td>
                    <td>{{$servicer_job->register_number}}</td>
                    <td>{{ ($servicer_job->gps_serial_no) ? $servicer_job->gps_serial_no: ''}}</td>
                    <td>{{$servicer_job->description}}</td>
                    <td>{{$servicer_job->location}}</td>

                    <td>{{$servicer_job->job_date}}</td>
                    <td>{{$servicer_job->job_complete_date}}</td>

                    @if($servicer_job->job_type == 1)
                    <td>Installation</td>
                  
                    @else
                    <td>Service</td>
                    @endif
                   <td> <a href="/job-history/{{Crypt::encrypt($servicer_job->id)}}/details"class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i>View</a></td>      
                  
                   
                </tr>
                @endforeach
            </tbody>
        </table>

      </div>
      <style>
        th {
          background-color:#778899 ;
          color: white;
      } 
      .cover_list_search {
          width: 32%;
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