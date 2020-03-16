@extends('layouts.eclipse')
@section('title')
  Servicer Job List
@endsection
@section('content')

<div class="page-wrapper_new">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Installation Pending Jobs List</li>
        <b>Installation Pending Jobs List</b>
     </ol>
      @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}
            </div>
          </div>
        @endif
    </nav>

 
        <table class="table table-hover table-bordered  table-striped datatable"  style="width:100%;text-align: center" >
        <thead class="indigo white-text">
        <tr>
        <!-- <th><b>SL.No</b></th> -->
            <th><b>Job Code</b></th>
            <th><b>User Details</b></th>
            <th><b>Assignee<b></th>
            <th><b>GPS Serial No<b></th>
            <th><b>Description<b></th>
            <th><b>Location<b></th>
            <th><b>Job Date<b></th>
            <th><b>Status<b></th>  
            <th><b>Action</b></th>  

        </tr>
    </thead>
    <tbody>
    @if($servicer_jobs->count() == 0)
                            <tr>
                              <td></td>
                              <td></td>
                              <td><b style="float: right;margin-right: -13px">No data</b></td>
                              <td><b style="float: left;margin-left: -15px">Available</b></td>
                              <td></td>
                              <td></td>
                            </tr>
                            @endif
                         
        @foreach($servicer_jobs as $servicer_job)
                      
        <tr>
       
            <td>{{$servicer_job->job_id}}</td>
          
            <td>{{$servicer_job->clients->name}} , {{$servicer_job->clients->user->mobile}}
            <br>{{$servicer_job->clients->user->email}}<br>{{$servicer_job->clients->address}}
              </td>
            <td>{{$servicer_job->user->username}}</td>
            <td>{{$servicer_job->gps->serial_no}}</td>
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
  </style>
@endsection

  @section('script')
    
  @endsection