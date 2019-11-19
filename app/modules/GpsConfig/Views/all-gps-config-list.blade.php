@extends('layouts.eclipse')
@section('content')
<section class="hilite-content">
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
      <div class="col-md-6">   
        <table class="table table-hover table-bordered  table-striped" id="data_table">
          <thead>
            <tr>
              <th>PU</th>
              <th id="pu"></th>
            </tr>
            <tr>
              <th>MO</th>
              <th id="mo"></th>
            </tr>
             <tr>
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
              <th id="fdp"></th>
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
        </table>
      </div>
    </div>
  </section>
</section>


@section('script')
    <script src="{{asset('js/gps/all-gps-config-list.js')}}"></script>
@endsection
@endsection