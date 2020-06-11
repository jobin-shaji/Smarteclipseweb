$(document).ready(function () {

   hideFuelBlocks();

  var url = 'dash-count';
  var data = {

  };


      backgroundPostData(url,data,'dbcount',{alert:true});


 //    window.setInterval(function(){
 //    	 backgroundPostData(url,data,'dbcount',{alert:false});

	// }, 5000);
});
 var activeElement;

function dbcount(res){
      $('#gps').text(res.gps);
      $('#refurbished_gps').text(res.gps_refurbished_stock);
      $('#gps_manufactured').text(res.gps_manufactured);
      $('#gps_transferred').text(res.gps_transferred);
      $('#gps_to_be_added_to_stock').text(res.gps_to_be_added_to_stock);
      $('#gps_returned').text(res.gps_returned);
      $('#gps_returned_request').text(res.gps_returned_request);
      $('#dealer').text(res.dealers);
      $('#sub_dealer').text(res.subdealers);
      $('#client').text(res.clients);
      $('#vehicle').text(res.vehicles);
      $('#dealer_subdealer').text(res.subdealers);
      $('#dealer_traders').text(res.traders);
      $('#dealer_client').text(res.clients);
      $('#gps_new_arrival_dealer').text(res.new_arrivals);
      $('#in_stock_gps_dealer').text(res.in_stock_gps_dealer);
      $('#transferred_gps_dealer').text(res.transferred_gps);
      $('#transferred_gps_awaiting').text(res.transferred_gps_awaiting);
      $('#gps_new_arrival_subdealer').text(res.new_arrivals);
      $('#total_gps_subdealer').text(res.total_gps);
      $('#gps_in_stock_subdealer').text(res.gps_in_stock);
      $('#transferred_gps_from_dealer_to_trader').text(res.dealer_to_trader_transferred_gps_count);
      $('#transferred_gps_from_dealer_to_client').text(res.dealer_to_client_transferred_gps_count);
      $('#transferred_gps_from_dealer_to_trader_awaiting').text(res.gps_awaiting_confirmation_from_trader);
      $('#subdealer_client').text(res.clients);
      $('#subdealer_trader').text(res.traders);
      $('#subdealer_complaints').text(res.subdealer_complaints);

      $('#gps_new_arrival_trader').text(res.new_arrivals);
      $('#total_gps_trader').text(res.total_gps);
      $('#gps_in_stock_trader').text(res.gps_in_stock_trader);
      $('#transferred_gps_trader').text(res.trader_to_client_transferred_gps_count);
      $('#clients_under_traders').text(res.clients);
      $('#trader_complaints').text(res.trader_complaints);

      $('#client_gps').text(res.gps);
      $('#client_vehicle').text(res.vehicles);
      $('#geofence').text(res.geofence);
      $('#moving').text(res.moving);
      $('#idle').text(res.idle);
      $('#stop').text(res.stop);
      $('#offline').text(res.offline);

      $('#new_installation_jobs').text(res.new_installation_jobs);
      $('#on_progress_installation_jobs').text(res.on_progress_installation_jobs);
      $('#pending_service_jobs').text(res.pending_service_jobs);
      $('#completed_jobs').text(res.completed_jobs);
      $('#service_completed_jobs').text(res.service_completed_jobs);
      $('#gps_today').text(res.gps_today);
      $('#gps_stock').text(res.gps_stock);
      $('#gps').text(res.gps);
      $('#gps_add_to_stock').text(res.gps_add_to_stock);
      $('#pending_gps').text(res.gps_to_verify);
      $('#all_pending_jobs').text(res.servicer_all_pending_jobs);
      $('#new_reinstallation_jobs').text(res.new_reinstallation_jobs);
      $('#on_progress_reinstallation_jobs').text(res.on_progress_reinstallation_jobs);
      $('#completed_reinstallation_jobs').text(res.completed_reinstallation_jobs);





}

//updated all aaaaa
function getVehicle(value, displayRefreshButton)
{
  var url = '/vehicle-detail';
  var data = {
    gps_id : value
  };
  backgroundPostData(url,data,'vehicle_details',{alert:true});
  if(typeof displayRefreshButton != 'undefined')
  {
    // map updated. display refresh button
    document.getElementById('map_refresh_button').style.display="block";
  }
  //document.getElementById("msg").innerHTML = '<button type="submit" onclick="refreshPage()" class="srch btn-primary btn-block">'+'Clear'+'</button>';
}

function refreshPage(){
    window.location.reload();
}

function hideFuelBlocks()
{
  $('#fuel_100, #fuel_75, #fuel_50, #fuel_25, #fuel_0, #upgrade').hide();
}

function vehicle_details(res){
  hideFuelBlocks()
  //console.log(res);
  var network_status=res.network_status;
  var vehicle_mode=res.mode;
  var fuel=res.fuel_status;
  if(network_status=="Connection Lost"){
    $("#network_offline").show();
    $("#network_online").hide();
  }else{
    $("#network_online").show();
    $("#network_offline").hide();
  }
  if(vehicle_mode=="Moving"){
    $("#vehicle_moving").show();
    $("#vehicle_status").hide();
    $("#vehicle_halt").hide();
    $("#vehicle_sleep").hide();
    $("#vehicle_stop").hide();
  }else if(vehicle_mode=="Halt"){
    $("#vehicle_moving").hide();
    $("#vehicle_status").hide();
    $("#vehicle_halt").show();
    $("#vehicle_sleep").hide();
    $("#vehicle_stop").hide();
  }else if(vehicle_mode=="Sleep"){
    $("#vehicle_moving").hide();
    $("#vehicle_status").hide();
    $("#vehicle_halt").hide();
    $("#vehicle_sleep").show();
    $("#vehicle_stop").hide();
  }else{
    $("#vehicle_moving").hide();
    $("#vehicle_status").hide();
    $("#vehicle_halt").hide();
    $("#vehicle_sleep").hide();
    $("#vehicle_stop").show();
  }
  // manage fuel status
  if(fuel < 1)
  {
    $('#fuel_0').show();
    $('.fa-spinner').hide();
  }
  else if((fuel > 0) && (fuel <= 25))
  {
    $('#fuel_25').show();
    $('.fa-spinner').hide();
  }
  else if((fuel > 25) && (fuel <= 50))
  {
    $('#fuel_50').show();
    $('.fa-spinner').hide();
  }
  else if((fuel > 50) && (fuel <= 75))
  {
    $('#fuel_75').show();
    $('.fa-spinner').hide();
  }
  else if(fuel > 75)
  {
    $('#fuel_100').show();
    $('.fa-spinner').hide();
  }
  else
  {
    $('#upgrade').show();
    document.getElementById("upgradefuel").innerHTML = "Upgrade Version";
    $('.fa-spinner').hide();
  }

  $('#network_status').text(network_status);
  // $('#fuel_status').text(res.fuel_status);
  $('#speed').text(res.speed);
  $('#odometer').text(res.odometer);
  $('#mode').text(vehicle_mode);
  $('#satelite').text(res.satelite);
  $('#battery_status').text(res.battery_status);
  $('#ignition').text(res.ignition);
  var address=res.address;
  $('#address').text(address);
  }





