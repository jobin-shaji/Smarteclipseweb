@extends('layouts.eclipse')
@section('content')
<section class="hilite-content" style="min-height: 500px">
  <form  method="POST" action="#">
  {{csrf_field()}}
    <div class="row">
      <div class="col-md-4">
        <div  style ="margin-left: 77px"class="form-group has-feedback">
          <label class="srequired">GPS</label>
          <select class="form-control select2" id="gps_id" name="gps_id"  data-live-search="true" title="Select GPS" required onchange='getallData(this.value)'>
          <option value="">Select GPS</option>
          @foreach($gps as $gps)
          <option value="{{$gps->id}}">{{$gps->imei}} || {{$gps->serial_no}}</option>
          @endforeach
          </select>  
        </div> 
      </div>
    </div>
  </form>
  <section class="content" >
    <div class="row">
      <div class="col-md-12">   
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>PU</label>
          </span>
          <span id="pu" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>MO</label>
          </span>
          <span id="mo" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>EO</label>
          </span>
          <span id="eo" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>ED</label>
          </span>
          <span id="ed" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>ST</label>
          </span>
          <span id="st" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>HT</label>
          </span>
          <span id="ht" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>SL</label>
          </span>
          <span id="sl" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>HBT</label>
          </span>
          <span id="hbt" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>HAT</label>
          </span>
          <span id="hat" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>RTT</label>
          </span>
          <span id="rtt" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>LBT</label>
          </span>
          <span id="lbt" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>TA</label>
          </span>
          <span id="ta" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>VN</label>
          </span>
          <span id="vn" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>UR</label>
          </span>
          <span id="ur" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>URT</label>
          </span>
          <span id="urt" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>URS</label>
          </span>
          <span id="urs" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>URE</label>
          </span>
          <span id="ure" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>URH</label>
          </span>
          <span id="urh" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>VID</label>
          </span>
          <span id="vid" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>FV</label>
          </span>
          <span id="fv" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>DSL</label>
          </span>
          <span id="dsl" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>M1</label>
          </span>
          <span id="m1" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>M2</label>
          </span>
          <span id="m2" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>OM</label>
          </span>
          <span id="om" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>OU</label>
          </span>
          <span id="ou" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>PUV</label>
          </span>
          <span id="puv" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>APN</label>
          </span>
          <span id="apn" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>PWD</label>
          </span>
          <span id="pwd" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>RS</label>
          </span>
          <span id="rs" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>EST</label>
          </span>
          <span id="est" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>FTP</label>
          </span>
          <span id="ftp" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>FIP</label>
          </span>
          <span id="fip" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>TM</label>
          </span>
          <span id="tm" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>TEM</label>
          </span>
          <span id="tem" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>DIN</label>
          </span>
          <span id="din" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>BTP</label>
          </span>
          <span id="btp" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>FUE</label>
          </span>
          <span id="fue" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>SPD</label>
          </span>
          <span id="spd" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey;border: groove 2px grey">
          <span>
            <label>IGN</label>
          </span>
          <span id="ign" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>FLC</label>
          </span>
          <span id="flc" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>IMO</label>
          </span>
          <span id="imo" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>FMT</label>
          </span>
          <span id="fmt" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>NOD</label>
          </span>
          <span id="nod" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>GP1</label>
          </span>
          <span id="gp1" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>GP2</label>
          </span>
          <span id="gp2" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>DL1</label>
          </span>
          <span id="dl1" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>DL2</label>
          </span>
          <span id="dl2" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>GPS</label>
          </span>
          <span id="gps" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>AOF</label>
          </span>
          <span id="aof" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>FUS</label>
          </span>
          <span id="fus" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>FPD</label>
          </span>
          <span id="fpd" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>TDU</label>
          </span>
          <span id="tdu" style="margin-left: 2%">
            
          </span>
        </div>
        <div style="float: left;padding: 2% 2% 2% 2%;border: groove 2px grey">
          <span>
            <label>CDC</label>
          </span>
          <span id="cdc" style="margin-left: 2%">
            
          </span>
        </div>


        
       <!--  <table class="table table-hover table-bordered  table-striped" id="data_table" style="width: 0!important">
          <thead>
            <tr>
              <th>PU</th>
              <th id="pu"></th>
              <th>MO</th>
              <th id="mo"></th>
           
              <th>EO</th>
              <th id="eo"></th>
            </tr>
             <tr>
              <th>ED</th>
              <th id="ed"></th>
            </tr>
             <tr>
              <th>ST</th>
              <th id="st"></th>
            </tr>
             <tr>
              <th>HT</th>
              <th id="ht"></th>
            </tr>
             <tr>
              <th>SL</th>
              <th id="sl"></th>
            </tr>
             <tr>
              <th>HBT</th>
              <th id="hbt"></th>
            </tr>
             <tr>
              <th>HAT</th>
              <th id="hat"></th>
            </tr>
             <tr>
              <th>RTT</th>
              <th id="rtt"></th>
            </tr>
             <tr>
              <th>LBT</th>
              <th id="lbt"></th>
            </tr>
             <tr>
              <th>TA</th>
              <th id="ta"></th>
            </tr>
            <tr>
              <th>VN</th>
              <th id="vn"></th>
            </tr>
            <tr>
              <th>UR</th>
              <th id="ur"></th>
            </tr>
            <tr>
              <th>URT </th>
              <th id="urt"></th>
            </tr>
            <tr>
              <th>URS</th>
              <th id="urs"></th>
            </tr>
            <tr>
              <th>URE</th>
              <th id="ure"></th>
            </tr>
             <tr>
              <th>URF</th>
              <th id="urf"></th>
            </tr>
             <tr>
              <th>URH</th>
              <th id="urh"></th>
            </tr>

             <tr>
              <th>VID</th>
              <th id="vid"></th>
            </tr>
             <tr>
              <th>FV</th>
              <th id="fv"></th>
            </tr>
            <tr>
              <th>DSL</th>
              <th id="dsl"></th>
            </tr>
            <tr>
              <th>M1</th>
              <th id="m1"></th>
            </tr>
            <tr>
              <th>M2</th>
              <th id="m2"></th>
            </tr>
            <tr>
              <th>OM</th>
              <th id="om"></th>
            </tr>
            <tr>
              <th>OU</th>
              <th id="ou"></th>
            </tr>
            <tr>
              <th>PUV</th>
              <th id="puv"></th>
            </tr>
            <tr>
              <th>APN</th>
              <th id="apn"></th>
            </tr>
            <tr>
              <th>PWD</th>
              <th id="pwd"></th>
            </tr>
            <tr>
              <th>RS</th>
              <th id="rs"></th>
            </tr>
            <tr>
              <th>EST</th>
              <th id="est"></th>
            </tr>
            <tr>
              <th>FTP</th>
              <th id="ftp"></th>
            </tr>
            <tr>
              <th>FIP</th>
              <th id="fip"></th>
            </tr>
            <tr>
              <th>TM</th>
              <th id="tm"></th>
            </tr>
            <tr>
              <th>TEM</th>
              <th id="tem"></th>
            </tr>
            <tr>
              <th>DIN</th>
              <th id="din"></th>
            </tr>

            <tr>
              <th>BTP</th>
              <th id="btp"></th>
            </tr>
            <tr>
              <th>FUE</th>
              <th id="fue"></th>
            </tr>
            <tr>
              <th>SPD</th>
              <th id="spd"></th>
            </tr>
            <tr>
              <th>IGN</th>
              <th id="ign"></th>
            </tr>
            <tr>
              <th>FLC</th>
              <th id="flc"></th>
            </tr>
            <tr>
              <th>IMO</th>
              <th id="imo"></th>
            </tr>
            <tr>
              <th>FMT</th>
              <th id="fmt"></th>
            </tr>
            <tr>
              <th>NOD</th>
              <th id="nod"></th>
            </tr>
            <tr>
              <th>GP1</th>
              <th id="gp1"></th>
            </tr>
            <tr>
              <th>GP2</th>
              <th id="gp2"></th>
            </tr>
            <tr>
              <th>DC1</th>
              <th id="dc1"></th>
            </tr>
            <tr>
              <th>DC2</th>
              <th id="dc2"></th>
            </tr>
            <tr>
              <th>GPS</th>
              <th id="gps"></th>
            </tr>
            <tr>
              <th>AOF</th>
              <th id="aof"></th>
            </tr>
            <tr>
              <th>FUS</th>
              <th id="fus"></th>
            </tr>
            <tr>
              <th>FPD</th>
              <th id="fpd"></th>
            </tr>
            <tr>
              <th>TDU</th>
              <th id="tdu"></th>
            </tr>
            <tr>
              <th>CDC </th>
              <th id="cdc"></th>
            </tr>
          </thead>
        </table> -->
      </div>
    </div>
  </section>
</section>


@section('script')
    <script src="{{asset('js/gps/all-gps-config-list.js')}}"></script>
@endsection
@endsection