@extends('layouts.eclipse')
@section('title')
  Device Creation
@endsection
@section('content')   
<style type="text/css">
  .pac-container { position: relative !important;top: -290px !important;margin:0px }
</style>
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Device</li>
        <b>Create Device</b>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <form  method="POST" action="{{route('setota.operations')}}">
      {{csrf_field()}}  
      <div class="row">
        <div class="col-lg-7">  
         <div class="form-group has-feedback" style="margin: 37px 13px;">
            <label class="srequired">Serial No/imei</label>
            
             <select class="form-control select2 GpsData" id="gps_id" name="gps_id" data-live-search="true" title="Select Serial number" required>
              <option value="" selected="selected" disabled="disabled">Select Serial number</option>
              @foreach($devices as $device)
              <option value="{{$device->id}}">{{$device->serial_no}}/{{$device->imei}}</option>
              @endforeach
            </select>
             @if ($errors->has('gps_id'))
              <span class="help-block">
                  <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
              </span>
            @endif               
          </div>
          </div>
     </div>
      <div class="row" style="margin-left: 40%;width: 100%;height: 100%">
        <div class="col-md-4">
          <div class="card-body_vehicle wizard-content">   
           


            <div class="form-group has-feedback">
               <div class="row">

                    
            </div>
          </div>



                                   
           
                                   
          </div>
        </div>       
       
           
        
          
          </div>
          <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
              <thead>
                <tr>
                  <td >Primary/Regulatory Purpose URL</td>
                  <td><input type="text" id="pu" Value=""></td>
                </tr>
                <tr>               
                  <td>MO</td>
                  <td><input type="text" id="mo" Value=""></td>
                </tr>
                <tr>
                  <td >EO</td>
                  <td><input type="text" id="eo"  Value=""></td>
                </tr>
                <tr> 
                  <td >ED</td>
                  <td><input type="text" id="ed"  Value=""></td>
                </tr>
                <tr> 
                  <td >ST</td>
                  <td><input type="text" id="st"   Value=""></td>
                </tr>
                <tr> 
                  <td >HT</td>
                  <td><input type="text" id="ht" Value=""></td>
                </tr>
                <tr> 
                  <td>SL</td>
                  <td><input type="text"  id="sl" Value=""></td>
                </tr>
                <tr> 
                  <td>HBT</td>
                  <td><input type="text" id="hbt"  Value=""></td>
                </tr>
                <tr> 
                  <td>HAT</td> 
                  <td><input type="text" id="hat" Value=""></td>
                </tr>
                <tr> 
                  <td>RTT</td> 
                  <td><input type="text" id="rtt" Value=""></td> 
                </tr>
                <tr> 
                  <td>LBT</td> 
                  <td><input type="text" id="lbt" Value=""></td> 
                </tr>
                <tr> 
                  <td>TA</td>  
                  <td><input type="text" id="ta" Value=""></td> 
                </tr>
                <tr> 
                  <td>VN</td> 
                  <td><input type="text" id="vn" Value=""></td>
                </tr>  
                <tr> 
                  <td>UR</td> 
                  <td><input type="text" id="ur" Value=""></td> 
                </tr>
                <tr> 
                  <td>URT</td> 
                  <td><input type="text" id="urt"></td> 
                  </tr>
                   <tr> 
                  <td>URS</td> 
                  <td><input type="text" id="urs"  Value=""></td>
                  </tr>

                  <tr>   
                  <td>URE</td> 
                  <td><input type="text" id="ude" Value=""></td>
                  </tr>
                  <tr>  
                  <td>URF</td> 
                  <td><input type="text" id="urf" Value=""></td>
                  </tr>
                  <tr>   
                  <td>URH</td> 
                  <td><input type="text" id="urh"  Value=""></td> 
                </tr>
                <tr> 
                  <td>VID</td>  
                  <td><input type="text" id="vid"></td>
                  </tr>
                  <tr>  
                  <td>FV</td> 
                  <td><input type="text" id="fv"  Value=""></td>
                  </tr>
                  <tr>   
                  <td>DSL</td>  
                  <td><input type="text" id="dsl"  Value=""></td>
                  </tr>
                  <tr>  
                  <td>M1</td> 
                  <td><input type="text" id="m1"  Value=""></td>  
                </tr>
                <tr> 
                  <td>M2</td> 
                  <td><input type="text" id="m2" Value=""></td> 
                </tr>
                <tr> 
                  <td>M3</td> 
                  <td><input type="text" id="m3" Value=""></td> 
                </tr>
                <tr> 
                  <td>OM</td> 
                  <td><input type="text"  Value=""></td>
                  </tr>
                  <tr>     
                  <td>OU</td> 
                  <td><input type="text"  id="ou" Value=""></td>
                  </tr>
                  <tr>   
                  <td>PUV</td> 
                  <td><input type="text" id="puv" Value=""></td> 
                  </tr>
                  <tr>  
                  <td>APN</td> 
                  <td><input type="text" id="apn" Value=""></td>  
                </tr><tr> 
                  <td>PWD</td> 
                  <td><input type="text" id="pwd" Value=""></td> 
                </tr>
                <tr> 
                  <td>RS</td> 
                  <td><input type="text" id="rs" Value=""></td>
                </tr>
                <tr> 
                  <td>EST</td> 
                  <td><input type="text" id="est" Value=""></td>
                </tr>
                  <tr> 

                  <td>FTP</td> 
                  <td><input id="ftp" type="text"  Value=""></td> 
                </tr>
                <tr> 
                  <td>FIP</td> 
                  <td><input type="text" id="fip"  Value=""></td>
                  </tr>
                  <tr>   
                  <td> TM</td> 
                  <td><input type="text"  id="tm" Value=""></td> 
                  </tr>
                  <tr>  
                  <td>TEM</td> 
                  <td><input type="text"  id="tem" Value=""></td> 
                  </tr>
                  <tr>  
                  <td>DIN</td> 
                  <td><input type="text" id="din" Value=""></td>
                  </tr>
                  <tr>  
                  <td>BTP</td> 
                  <td><input type="text" id="btp"  Value=""></td> 
                </tr>
                <tr> 
                  <td>FUE</td>  
                  <td><input type="text" id="fue"  Value=""></td>
                  </tr>
                  <tr>  
                  <td>SPD</td>  
                  <td><input type="text" id="spd" Value=""></td>
                </tr>
                <tr> 
                  <td>IGN</td>  
                  <td><input type="text" id="ign" Value=""></td>
                </tr>
                 <tr> 
                  <td>FLC</td>  
                  <td><input type="text" id="flc" Value=""></td>
                </tr>
                <tr>  
                <td>IMO</td>  
                <td><input type="text" id="imo"  Value=""></td>
                </tr> 


                <tr>  
                <td>NOD</td>  
                <td><input type="text" id="nod"  Value=""></td>
                </tr> 

                <tr>  
                <td>GP1</td>  
                <td><input type="text" id="gp1"  Value=""></td>
                </tr> 

                 <tr>  
                <td>GP2</td>  
                <td><input type="text" id="gp2"  Value=""></td>
                </tr> 

                 <tr>  
                <td>DC1</td>  
                <td><input type="text" id="dc1"  Value=""></td>
                </tr> 

                <tr>  
                <td>DC2</td>  
                <td><input type="text" id="dc2"  Value=""></td>
                </tr> 
                <tr>  
                <td>DC2</td>  
                <td><input type="text" id="dc2"  Value=""></td>
                </tr> 

                 <tr>  
                <td>GPS</td>  
                <td><input type="text" id="gps"  Value=""></td>
                </tr> 

                  <tr>  
                <td>AOF</td>  
                <td><input type="text" id="aof"  Value=""></td>
                </tr> 

                 <tr>  
                <td>FUS</td>  
                <td><input type="text" id="fus"  Value=""></td>
                </tr> 

                 <tr>  
                <td>FPD</td>  
                <td><input type="text" id="fpd"  Value=""></td>
                </tr> 

                 <tr>  
                <td>TDU</td>  
                <td><input type="text" id="tdu"  Value=""></td>
                </tr> 

                  <tr>  
                <td>CDC</td>  
                <td><input type="text" id="cdc"  Value=""></td>
                </tr> 
                                    
              </thead>
            </table>
                      
              <div class="row">
                <div class="col-lg-12">
                <button type="submit" class="btn btn-primary" style="    left: 0px;right: 0px;margin-left: 20px;width: 243px;margin-bottom: 22px;">SET OTA </button>
                </div>
              </div>
            
        </div>
      </div>
    </form>
  </div>
</section>

<div class="clearfix"></div>

@section('script')
    <script src="{{asset('js/gps/set-ota-update.js')}}"></script>
@endsection

@endsection