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
            <?php 
            foreach($config as $key => $value)
            {
            ?>
            <h1><?php echo $value['name']; ?></h1>
             <table class="table table-hover table-bordered  table-striped datatable" style="width:40%;text-align: center;" id="dataTable">
                <thead>
                  <?php 
                  $index = 1;
                  $version=$value['version'];
                  foreach( json_decode($value['value']) as $item => $item_value)
                  {

                    $item_value_data=json_encode($item_value);
                    
                  ?>
                  <tr>
                      <td><?php echo $index; ?></td>
                      <td><?php echo $item_value->type; ?></td>
                      <td><button type="button" onclick='getConfiguration({{$item_value_data}},"{{$item}}","{{$version}}")'>Configure</button></td>
                  </tr>
                  <?php 
                  $index++;
                }
                ?>
                </thead>
              </table>
              <?php 
            }
            ?>
                        
          </div>

              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
          <form  method="POST" action="{{route('configuration.create.p')}}">
            {{csrf_field()}}    
             <input type="text" id="plan_id" name="plan_id" value="">
           
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header text-center">
                      <h4 class="modal-title w-100 font-weight-bold">Configuration</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body mx-3">    

                     
                        <label  data-success="right" >Value</label>
                        <div id="config"></div>  
                         <label  data-success="right" >Plan</label>
                        <input type="text" id="plan_name" name="plan_name" value="">
                         <label  data-success="right" >Version</label>
                      <input type="text" id="version" name="version" value="">
                        
                        
                                          
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                      <button class="btn btn-default">Submit</button>
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