$(document).ready(function () {
   
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
      $('#gps_manufactured').text(res.gps_manufactured);
      $('#gps_transferred').text(res.gps_transferred);
      $('#gps_to_be_added_to_stock').text(res.gps_to_be_added_to_stock);
      $('#dealer').text(res.dealers);
      $('#sub_dealer').text(res.subdealers);
      $('#client').text(res.clients);
      $('#vehicle').text(res.vehicles);
      $('#dealer_subdealer').text(res.subdealers);
      $('#dealer_client').text(res.clients);
      $('#gps_new_arrival_dealer').text(res.new_arrivals);
      $('#total_gps_dealer').text(res.total_gps);
      $('#transferred_gps_dealer').text(res.transferred_gps);
      $('#gps_new_arrival_subdealer').text(res.new_arrivals);
      $('#total_gps_subdealer').text(res.total_gps);
      $('#transferred_gps_subdealer').text(res.transferred_gps);
      $('#subdealer_client').text(res.clients);
      $('#client_gps').text(res.gps);
      $('#client_vehicle').text(res.vehicles);
      $('#geofence').text(res.geofence);
      $('#moving').text(res.moving);
      $('#idle').text(res.idle);
      $('#stop').text(res.stop);
      $('#offline').text(res.offline);  
      
      $('#pending_jobs').text(res.pending_jobs);
      $('#pending_service_jobs').text(res.pending_service_jobs);
      $('#completed_jobs').text(res.completed_jobs);
      $('#service_completed_jobs').text(res.service_completed_jobs);  
      $('#gps_today').text(res.gps_today); 
      $('#gps_stock').text(res.gps_stock); 
      $('#gps').text(res.gps); 
      $('#gps_add_to_stock').text(res.gps_add_to_stock); 
      $('#pending_gps').text(res.gps_to_verify); 
      $('#all_pending_jobs').text(res.all_pending_jobs); 
      

      
      
         
}

//updated all aaaaa
function getVehicle(value)
{  

   var url = '/vehicle-detail';
     var data = { 
      gps_id : value
     };
     backgroundPostData(url,data,'vehicle_details',{alert:true});
  document.getElementById("msg").innerHTML = '<button type="submit" onclick="refreshPage()" class="srch btn-primary btn-block">'+'Clear'+'</button>';


}

function refreshPage(){
    window.location.reload();
}

function vehicle_details(res){
  console.log(res);
  var network_status=res.network_status;
  var vehicle_mode=res.mode;
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
  $('#network_status').text(network_status);
  $('#fuel_status').text(res.fuel_status);
  $('#speed').text(res.speed);
  $('#odometer').text(res.odometer);
  $('#mode').text(vehicle_mode);
  $('#satelite').text(res.satelite);
  $('#battery_status').text(res.battery_status);
  $('#ignition').text(res.ignition);
  var address=res.address;
  $('#address').text(address);
  }


  


