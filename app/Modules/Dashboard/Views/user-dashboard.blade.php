@extends('layouts.eclipse')
@section('content')

<!--  -->
<!-- ROOT ROLE-START -->

<style>
  .btn-pop {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: #ccc;
    border: 1px solid transparent;
    padding: 0 .21rem;
    line-height: 2;
    font-size: .75rem !important;
    border-radius: .25rem;
    margin: 0 .1rem .5rem .1rem;
    color: #000;
  }

  .btn-pop:hover {
    background: #f7b018;
  }

  /*************************************/
  .tblUserVehicles {
    width: 100%;
    border-collapse: collapse;
  }

  .tblUserVehicles tr {
    cursor: pointer;
  }

  .tblUserVehicles td {
    padding-left: 4px;
  }

  .tblUserVehicles th {
    text-align: center;
    font-weight: normal;
  }

  .tblUserVehicles tr:hover,
  .tblUserVehicles tr:hover:nth-child(even) {
    background-color: #c7ecee;
    /* Light blue on hover */
  }

  .tblUserVehicles tr:hover:nth-child(odd) {
    background-color: #a9cce3;
    /* Light blue on hover */
  }


  .tblUserVehicles tr:nth-child(even) {
    background-color: #f2f2f2;
    /* Light gray */
  }

  .tblUserVehicles tr:nth-child(odd) {
    background-color: #ffffff;
    /* White */
  }

  .vehListContianerHead {
    border: 1px solid #ccc;
    border-bottom: 0;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.3);
    text-align: center;
    font-weight: bold;
    background-color: gold;
  }

  .vehListContianer {
    border: 1px solid #ccc;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    max-height: 70vh;
    overflow-y: auto;
    padding: 0;
  }
  .refIcon{
    font-size: 1.3em!important;
    float:right;
    padding-top:3px;
    padding-right:3px;
    cursor:pointer;
  }
  .refIcon:hover{
    color: orange;
  }
  .addDevice{
    border: 1px solid #ccc;
    height:auto;
    margin-top:3em;
    border-radius: 4px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    padding: 5px;
    display: none;
  }
  .UserControlPanel{
    border: 1px solid darkgreen;
    height:auto;
    margin-top:3em;
    border-radius: 4px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    padding: 5px;
    display: none;
    background-color: #f4fff4;
  }
  .myInputs{
    border:1px solid #666;
    border-radius: 4px;
  }
  .user_table{
    width: 100%;
    display: none;
  }
  .user_table td{
    border:1px solid #ccc;
    padding-left:4px;
    padding-right: 4px;
    text-align: center;
  }
  .user_table th{
    text-align:center;
    padding-left: 4px;
    padding-right: 4px;
    font-weight:normal;
  }
  .vehiListHead{
    margin: 5px;
    border:1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    width: 100%;
    margin-top:0;
    border-radius: 5px;
    margin-bottom: 0;
    padding: 4px;
    background-color: gold;
  }
  .vehiList{
    margin: 5px;
    border:1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    width: 100%;
    min-height: 10vh;
    margin-top:0;
    border-radius: 5px;
    overflow-y: auto;
    height: 80vh;
  }
  .usersListHead{
    margin: 5px;
    border:1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    width: 100%;
    margin-top:0;
    border-radius: 5px;
    margin-bottom: 0;
    padding: 4px;
    background-color: darkgreen;
  }
  .usersList{
    margin: 5px;
    border:1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    width: 100%;
    min-height: 10vh;
    margin-top:0;
    border-radius: 5px;
    overflow-y: auto;
    height: 80vh;
  }
  .vehiListContainer{
    display: none;
  }
  .UsersControlPanel{
    display: none;
  }
</style>

<title></title>
<meta name="viewport" content="initial-scale=1.0">
<meta charset="utf-8">
<link href='https://fonts.googleapis.com/css?family=Raleway:300,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="style.css" type="text/css" media="all">
<script src="modernizr.js"></script>
<div class="page-wrapper page-wrapper-root page-wrapper_new">
  <div class="page-wrapper-root1">
    <section class="content">
      <div class="row">

        <div class="col-lg-7 col-xs-7">
        
          <div class="vehListContianerHead">List of active vehicles</div>
          <div class="container vehListContianer"></div>

        <div>


        @if(auth()->id()==806063)
        <div style="margin-top: 10px;">
          <i class="fa fa-user-plus i.fa.fa-user-plus" onclick="ShowManageUserPanel()" aria-hidden="true" style="float: right;color:darkgreen;font-size:1.5em;margin-top:3px;margin-right:0.4em;display:block;cursor:pointer;"></i>
          <div style="float: right;margin-right:0.8em;font-size:small;margin-top:10px;">Manage User</div>

          <i class="fa fa-users i.fa.fa-users" onclick="ShowManageUsersPanel()" aria-hidden="true" style="float: right;color:darkgreen;font-size:1.5em;margin-top:3px;margin-right:0.4em;display:block;cursor:pointer;"></i>
          <div style="float: right;margin-right:0.8em;font-size:small;margin-top:10px;">Users</div>


          </div>
        @endif
        </div>


          <div class="addDevice">
            <div style="color: #666;margin-bottom:7px;width:100%;border-bottom:1px solid #ccc;background-color:#fff;">Add/Remove vehicles to your login</div>
            <input style="width: 12em;text-align:center;" class="myInputs" id="inpRegNo" placeholder="Reg No"/> 
            <button type="button" onclick="AddVehicle('check')" style="border:1px solid blue;border-radius:5px;">Check</button>
            <button type="button" onclick="AddVehicle('otp')" style="border:1px solid #ccc;border-radius:5px;margin-left:1em;">Request OTP</button>
             <input style="width: 4em;text-align:center;" class="myInputs" id="inpOTP" placeholder="OTP"/>
            
             <button id="butAdd" type="button" onclick="AddVehicle('add')" style="border:1px solid #ccc;border-radius:5px;">Add</button>
            <button id="butDel" type="button" onclick="AddVehicle('delete')" style="border:1px solid #ccc;border-radius:5px;display:none;color:red;">Delete</button>
          </div>

          <div style="color: #666;border:0; margin-top:12px;width:100%;background-color:#f8f9fa;color:blue;text-align:center;" id="message"></div>          

          <div class="UserControlPanel">
            <div style="color: #666;margin-bottom:7px;width:100%;border-bottom:1px solid #ccc;background-color:darkgreen;color:white;padding-left:10px;">User control panel</div>
            <div style="margin-bottom: 1em;">
              <input style="width: 14em;text-align:center;" class="myInputs" id="inpUser" placeholder="Name/email/mobile" value="8122004444"/> 
              <button type="button" onclick="UserActivities('search')" style="border:1px solid blue;border-radius:5px;">Search</button>
            </div>
            <div style="margin-bottom: 1em;border:1px solid #ccc;border-radius:5px;background-color:white;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);">
              <table class="user_table">
                <tbody>
                <tr>
                <th rowspan="2">ID</th><th rowspan="2">username</th><th rowspan="2">mobile</th><th rowspan="2">email</th>
                <th rowspan="2" style="border-left: 1px solid #ccc;">role</th><th colspan="2" style="border-left: 1px solid #ccc;font-weight:normal;">vehicles</th>
                </tr>
                <tr>
                  <th style="border-left: 1px solid #ccc;">own</th><th>total</th>
                </tr>
                <tr style="background-color: palegreen;">
                  <td><span id="usr_id"></span></td>
                  <td><span id="usr_username"></span></td>
                  <td><span id="usr_mobile"></span></td>
                  <td><span id="usr_email"></span></td>
                  <td><span id="usr_role"></span></td>
                  <td><span id="usr_vehown"></span></td>
                  <td><span id="usr_vehoth"></span></td>
                </tr>
                <tr><td colspan="2"><div style="margin: 0.2em;"><b><span id="user_active"></span></b></div></td>
              <td colspan="8" style="text-align: left;">
                <button type="button" onclick="UserActivities('activate')" id="butActivateUser" style="border:1px solid blue;border-radius:5px;">Activate USer</button>
              
              <button id="butAdd" type="button" onclick="UserActivities('password')" style="margin-left:0.7em;float:right;border:1px solid #ccc;border-radius:5px;">Set</button>
              <input style="width: 8em;text-align:center;float:right;" class="myInputs" id="inpPassword" placeholder="New Password"/>
                


              </td>


              </tr>
              </tbody></table>
            </div>
            
           
          </div>
          

        </div>






        <div class="col-lg-5 col-xs-5">

          <div class="vehiListContainer">
            <div class="vehiListHead">
              <input style="width: 14em;text-align:center;" class="myInputs" id="inpVehiSrch" placeholder="RegNo/imei" value=""/> 
              <button type="button" onclick="AdminListVehicles()" style="border:1px solid blue;border-radius:5px;">Search</button>
              <i class="fa fa-times closeButton" onclick="$('.vehiListContainer').hide()"  aria-hidden="true" style="cursor:pointer; float: right;font-size:x-large;"></i>
            </div>
            <div class="vehiList">
              <div style="margin:5px; margin-bottom: 1em;width:100%;text-align:center;">
                <div id="adminVehicleList"></div>
              </div>
            </div>
          </div>


          <div class="UsersControlPanel">
            <div class="usersListHead">
              <input style="width: 14em;text-align:center;" class="myInputs" id="inpUserSrch" placeholder="Username/mobile/email" value=""/> 
              <button type="button" onclick="AdminListUsers()" style="border:1px solid blue;border-radius:5px;">Search</button>
              <i class="fa fa-times closeButton" onclick="$('.UsersControlPanel').hide()"  aria-hidden="true" style="cursor:pointer; float: right;font-size:x-large;color:white;"></i>
            </div>
            <div class="userList">
              <div style="margin:5px; margin-bottom: 1em;width:100%;text-align:center;">
                <div id="adminUsersList"></div>
              </div>
            </div>
          </div>


        </div>

      </div>

      <div class="row">

      </div>
    </section>
  </div>
</div>

<!-- ROOT ROLE-END -->


</section>
<style>
  .address {
    cursor: pointer;

  }

  .inner-left {
    float: left;
    display: block;
  }

  .box-2 {
    width: 100%;
    float: left;
    display: block;
  }

  .small-box>.view-last {
    float: left;
    width: 100%;
    margin-bottom: 0px;
  }

  .mrg-bt-0 {

    font-size: 14px;
    margin-bottom: 0px;
  }

  .a-tag {
    width: 100%;
    float: left;
    margin-top: 1px;
  }

  .small-box>.a-tag .small-box-footer1 {
    text-align: center;
    padding: 3px 0;
    color: #fff;
    color: rgba(255, 255, 255, 0.8);
    z-index: 10;
    width: 100%;
    float: left;
    background: rgba(0, 0, 0, 0.1);
  }

  .small-box>.small-box-footer2 {
    margin-bottom: -18px;
  }
</style>
@section('script')

<script src="{{asset('js/gps/mdb.js')}}"></script>
<script src="{{asset('js/gps/dashb.js')}}"></script>


@role('client')
<link rel="stylesheet" href="{{asset('css/firebaselivetrack-new-css.css')}}" type="text/css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<script src="{{asset('js/gps/dashb-client.js')}}"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{config('eclipse.keys.googleMap')}}&libraries=places&callback=initMap"></script>
<script type="text/javascript">
  // refresh button on the map should be hidden when the dashboard loads
  window.onload = function() {
    document.getElementById('map_refresh_button').style.display = "none";
  }
</script>
{{--
<script src="{{asset('js/gps/GoogleRadar.js')}}"></script>
<script src="{{asset('dist/js/st.action-panel.js')}}"></script>
--}}
<style type="text/css">
  #f75 {
    width: 4%;
    padding: 8% 8% 7% 3%;
    margin-right: 3%;
    float: left;
    background: #c78307;
  }

  #f50 {
    width: 4%;
    padding: 8% 8% 7% 3%;
    margin-right: 3%;
    float: left;
    background: #f79f1c;
  }

  #f25 {
    width: 4%;
    padding: 8% 8% 7% 3%;
    margin-right: 3%;
    float: left;
    background: #f51902;
  }

  #f0 {
    width: 4%;
    padding: 8% 8% 7% 3%;
    margin-right: 3%;
    float: left;
    background: #cecece;
  }

  .fuel-outer ul li:last-child {
    margin-right: 0;
  }
</style>
@endrole


<script>
  $(document).ready(function() {
    GetDashVehiclesView();
    window.setInterval(function() {
      GetDashVehiclesView();
   }, 10000);
   
  });
  function GetDashVehiclesView() {
    $(".refIcon").css("color", "orange");
    var purl = getUrl() + '/' + 'GetDashVehiclesView';

    var defaults = {type: 'POST',      alert: false    };
    var data = {'mode':'dash','userid': @json(auth()->id())};

    jQuery.extend(defaults, {
      alert: false
    });

    $.ajax({
      type: defaults.type,
      url: purl,
      data: data,
      async: true,
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(res) {
        $(".vehListContianer").html(res);
        $(".refIcon").css("color", "#666");
      },
      error: function(err) {
        $(".refIcon").css("color", "red");
        console.log(err);
        var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
      }
    });
  }
  function ShowAddNewPanel(){
    $(".UserControlPanel").hide();
    $(".vehiListContainer").hide();
    $(".UsersControlPanel").hide();
    $(".addDevice").toggle();
  }
  function ShowManageUserPanel(){
    $(".addDevice").hide();
    $(".vehiListContainer").hide();
    $(".UsersControlPanel").hide();
    $(".UserControlPanel").toggle();
  }
  function ShowManageUsersPanel(){
    $(".addDevice").hide();
    $(".vehiListContainer").hide();
    $(".UserControlPanel").hide();
    $(".UsersControlPanel").toggle();
  }
  function ShowVehiclesPanel(){
    $(".addDevice").hide();
    $(".UserControlPanel").hide();
    $(".UsersControlPanel").hide();
    $(".vehiListContainer").toggle();

  }
  function OnVehicleClicked(imei){

  }
  function AddVehicle(mode){
    $("#message").html('Please wait...');

    $("#butAdd").hide();
    $("#butDel").hide();

    $("#message").css("color", "orange");
    $(".refIcon").css("color", "orange");
    var purl = getUrl() + '/' + 'AddVehicle';

    var defaults = {type: 'POST',      alert: false    };
    var data = {'mode':mode, 'userid': @json(auth()->id()),'regno':$('#inpRegNo').val(),'otp':$('#inpOTP').val()};
    jQuery.extend(defaults, {
      alert: false
    });

    $.ajax({
      type: defaults.type,
      url: purl,
      data: data,
      async: true,
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(res) {
        
        $("#message").html(res.mess);
        $("#message").css("color", res.color);
        $(".refIcon").css("color", "#666");
        
        if(res.mess.indexOf("Vehicle exists in your login")===0 && mode==="check"){
          $("#butAdd").hide();
          $("#butDel").show();
        }else{
          $("#butAdd").show();
          $("#butDel").hide();
        }
        GetDashVehiclesView();
      },
      error: function(err) {
        $(".refIcon").css("color", "red");
        $("#message").html("Server Error");
        $("#message").css("color", "red");
        var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
      }
    });
  }

  function UserActivities(mode)
  {
    $("#message").html('Please wait...');

    $("#butAdd").hide();
    $("#butDel").hide();

    $("#message").css("color", "orange");
    $(".refIcon").css("color", "orange");
    var purl = getUrl() + '/' + 'UserActivities';

    var defaults = {type: 'POST',      alert: false    };
    var data = {'mode':mode, 'userid': @json(auth()->id()),'user':$('#inpUser').val(),'pass':$('#inpPassword').val()};
    jQuery.extend(defaults, {
      alert: false
    });

    $.ajax({
      type: defaults.type,
      url: purl,
      data: data,
      async: true,
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(res) {
        //console.log(res);
        $("#message").html(res.mess);
        $("#message").css("color", res.color);
        $(".refIcon").css("color", "#666");
        if(res.data.length>0){
          $(".user_table").show();
          $("#usr_id").html(res.data[0].id);
          $("#usr_username").html(res.data[0].username);
          $("#usr_mobile").html(res.data[0].mobile);
          $("#usr_email").html(res.data[0].email);
          $("#usr_role").html(res.data[0].role);
          $("#usr_vehown").html(res.vehicles[0].cnt);
          $("#usr_vehoth").html(res.others[0].cnt);

          //$("#butActivateUser").hide();
          if(res.model){
            $("#user_active").html("User active");
            $("#user_active").css("color","blue");
          }else{
            $("#user_active").html("User not active");
            $("#user_active").css("color","red");
            //$("#butActivateUser").show();
          }
          
        }else{
          $(".user_table").hide();
          $("#user_active").html("");
        }
        

      },
      error: function(err) {
        $(".refIcon").css("color", "red");
        $("#message").html("Server Error");
        $("#message").css("color", "red");
        var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
      }
    });
  }
  
  function AdminListUsers()
  {
    $('.usersList').show(500);
    $("#message").html('Please wait...');

    $("#butAdd").hide();
    $("#butDel").hide();

    $("#message").css("color", "orange");
    $(".refIcon").css("color", "orange");
    var purl = getUrl() + '/' + 'AdminListUsers';
    var defaults = {type: 'POST',      alert: false    };
    var data = {'mode':'', 'userid': @json(auth()->id()),'search':$('#inpUserSrch').val()};
    jQuery.extend(defaults, {
      alert: false
    });

    $.ajax({
      type: defaults.type,
      url: purl,
      data: data,
      async: true,
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(res) {
        //console.log(res);
        $("#adminUsersList").html(res.html);

        $(".refIcon").css("color", "#666");
        $("#message").html(res.mess);

      },
      error: function(err) {
        console.log(err)
        $(".refIcon").css("color", "red");
        $("#message").html("Server Error");
        $("#message").css("color", "red");
        var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
      }
    });
  }
  function AdminListVehicles()
  {
    $('.vehiList').show(500);
    $("#message").html('Please wait...');

    $("#butAdd").hide();
    $("#butDel").hide();

    $("#message").css("color", "orange");
    $(".refIcon").css("color", "orange");
    var purl = getUrl() + '/' + 'AdminListVehicles';
    var defaults = {type: 'POST',      alert: false    };
    var data = {'mode':'', 'userid': @json(auth()->id()),'search':$('#inpVehiSrch').val()};
    jQuery.extend(defaults, {
      alert: false
    });

    $.ajax({
      type: defaults.type,
      url: purl,
      data: data,
      async: true,
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(res) {
        console.log(res);
        $("#adminVehicleList").html(res.html);

        $(".refIcon").css("color", "#666");
        $("#message").html(res.mess);

      },
      error: function(err) {
        $(".refIcon").css("color", "red");
        $("#message").html("Server Error");
        $("#message").css("color", "red");
        var message = (err.responseJSON) ? err.responseJSON.message : err.responseText;
      }
    });
  }

</script>


@endsection
@endsection