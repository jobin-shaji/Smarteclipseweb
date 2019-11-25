 
<div id="track_alert" class="modal_for_dash" style="color: red">      
  <div class="modal-content">
    <div class="modal-header">
        <div class="container" style="text-align: center;">
           <h3 style="font-weight: bold;">Emergency Alert</h3>
        </div>
        <button onclick="verifyEmergency()" style="text-align: right;"><i class="fa fa-close"></i></button>
    </div>
    <div class="modal-body" style="text-align: center;">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/Achtung.svg/1200px-Achtung.svg.png" height="120" width="145"> <br>
        Driver :  <h4 id="emergency_vehicle_driver"></h4>
        Vehicle number :  <h4 id="emergency_vehicle_number"></h4>
        Location : <h4 id="emergency_vehicle_location"> </h4>
        Time : <h4 id="emergency_vehicle_time"></h4>
        <input type="hidden" id="em_id">
        <input type="hidden" id="alert_vehicle_id">
        <input type="hidden" id="decrypt_vehicle_id">
        <button onclick="verifyEmergency()">Verify</button>
        <button onclick="track_vehicle()">track</button>
    </div>
  </div>
</div>


@section('script')
 
@endsection