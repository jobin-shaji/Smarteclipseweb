@extends('layouts.eclipse') 
@section('title')
    Create Configuration
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Configuration</li>
      <b>Add Configuration</b>
    </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
        @endif 
  </nav>         
  <div class="card-body">
    <div class="table-responsive">
      <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">  <div class="row">
          <div class="col-sm-12">
                     
             <table class="table table-hover table-bordered  table-striped datatable" style="width:40%;text-align: center;" id="dataTable">
                <thead>
                  <tr>
                      <td>1</td>
                      <td>Freebies</td>
                      <td><button type="button" onclick="plan(1)">Configure</button></td>
                  </tr>
                   <tr>
                      <td>2</td>
                      <td>Fundamental</td>
                      <td><button type="button" onclick="plan(2)">Configure</button></td>
                  </tr>
                   <tr>
                      <td>3</td>
                      <td>Superior</td>
                      <td><button type="button" onclick="plan(3)">Configure</button></td>
                  </tr>
                   <tr>
                      <td>4</td>
                      <td>Pro</td>
                      <td><button type="button" onclick="plan(4)">Configure</button></td>
                  </tr>
                </thead>
              </table>
              <input type="plan_id" id="plan_id" value="">
           
          </div>

              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
          <form  method="POST" action="{{route('configuration.create.p')}}">
            {{csrf_field()}}    
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header text-center">
                      <h4 class="modal-title w-100 font-weight-bold">Configuration</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body mx-3">    

                        <label  data-success="right" >Name</label>                    
                        <input type="text" id="name" name="name" required="required" class="form-control validate {{ $errors->has('name') ? ' has-error' : '' }}">
                         @if ($errors->has('name'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('name') }}</strong>
                      </span>
                    @endif
                    <br/>
                        <label  data-success="right" >Value</label>  
                        <textarea type="text" id="config" name="config" required="required" class="form-control validate" ></textarea>
                         <label  data-success="right" >Code</label>                    
                        <input type="text" id="code" name="code" required="required" class="form-control validate" >                      
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                      <button class="btn btn-default">Login</button>
                    </div>
                  </div>
                </div>
              </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="clearfix"></div>
  @section('script')
    <script src="{{asset('js/gps/config-create.js')}}"></script>

 
@endsection
@endsection