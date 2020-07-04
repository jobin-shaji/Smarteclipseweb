@extends('layouts.eclipse') 
@section('title')
   Trip Report Configuration
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new" style="min-height: 630px;">
<div class="page-wrapper-root1">
        <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Trip Report Configuration</li>
                    <b>Trip report configuration</b>
                    </ol>
                    @if(Session::has('message'))
                        <div class="pad margin no-print">
                        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                            {{ Session::get('message') }}  
                        </div>
                        </div>
                        @endif 
        </nav>    


        <div class="row col-md-6 col-md-offset-2 custyle">
            <table class="table table-striped table-bordered ">
            <thead>

                <tr>
                    <th>SL.NO</th>
                    <th>Plan Name</th>
                    <th>Number Of Reports</th>
                    <th>Backup Days</th>
                    <th>Free Vehicle</th>

                    <th class="text-center">Action</th>
                </tr>
            </thead>

                @foreach ($trip_reports_config as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                            {{(array_column(config('eclipse.PLANS'), 'NAME', 'ID'))[$item->plan_id]}}
                        </td>
                        <td>{{$item->number_of_report_per_month}}</td>
                        <td>{{$item->backup_days}}</td>
                        <td>{{$item->free_vehicle}}</td>
                        <td class="text-center">
                             <a class='btn btn-info btn-xs' onclick='editConfig("{{$item->id}}","{{(array_column(config('eclipse.PLANS'), 'NAME', 'ID'))[$item->plan_id]}}","{{$item->number_of_report_per_month}}","{{$item->backup_days}}","{{$item->free_vehicle}}")' style="color:#fff"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a> 
                        </td>
                    </tr>
                @endforeach
                   
            </table>
        </div>
    </div>
</div>
</div>


<!-- Modal -->
<div id="edit_config" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title">Trip report configuration</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
            <div class="row">
                <h4 style="border-bottom: 1px solid; padding: 4px;">PLAN NAME: <i><span id="plan_name"></span></i></h4>   
            </div>
            <div class="row">
            <form  method="POST" action="{{route('trip-report-vehicle-configuration.update')}}">
            {{csrf_field()}}
                <input type="hidden" name="plan_id" id="plan_id">
                <div class="form-group">
                    <label for="number_of_reports">Number of reports:</label>
                    <input type="number_of_reports" name="number_of_reports" class="form-control" id="number_of_reports">
                </div>
                <div class="form-group">
                    <label for="backup_days">Backup days:</label>
                    <input type="backup_days" name="backup_days" class="form-control" id="backup_days">
                </div>
                <div class="form-group">
                    <label for="free_vehicle">Free vehicle:</label>
                    <input type="free_vehicle" name="free_vehicle" class="form-control" id="free_vehicle">
                </div>
                
                <span>
                    <button style="margin-top: 13px; margin-left: 0px;"type="submit" class="btn btn-default">Update trip report configuration</button>
                </span>
               
            </form>
            </div>
      </div>
     
    </div>

  </div>
</div>
@section('script')
<script>
function editConfig(id,name,number_of_reports,backup_days,free_vehicle)
{
    $('#plan_id').val(id);
    $('#plan_name').html(name);
    $('#number_of_reports').val(number_of_reports);
    $('#backup_days').val(backup_days);
    $('#free_vehicle').val(free_vehicle);
    $('#edit_config').modal('show');
}

</script>
@endsection

@endsection