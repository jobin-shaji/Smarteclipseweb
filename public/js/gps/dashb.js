$(document).ready(function () {
   
     var url = 'dash-count';
     var data = { 
     
     };

    window.setInterval(function(){
    	 backgroundPostData(url,data,'dbcount',{alert:false});  
	}, 5000);
});

function dbcount(res){
	    $('#gps').text(res.gps);
      $('#dealer').text(res.dealers);
      $('#sub_dealer').text(res.subdealers);
      $('#client').text(res.clients);
      $('#vehicle').text(res.vehicles);
      $('#dealer_subdealer').text(res.subdealers);
      $('#gps_dealer').text(res.gps);
      $('#subdealer_gps').text(res.gps);
      $('#subdealer_client').text(res.clients);
      $('#client_gps').text(res.gps);
      $('#client_vehicle').text(res.vehicles);
       $('#geofence').text(res.geofence);
       $('#vehicle_motion').text(res.moving);
       $('#idle').text(res.idle);
       $('#stop').text(res.stop);
      
      
}
function getVehicle(value)
{  

   var url = '/vehicle-detail';
     var data = { 
      gps_id : value
     };
     backgroundPostData(url,data,'vehicle_details',{alert:false});
}
function vehicle_details(res){
      $('#network_status').text(res.network_status);
      $('#fuel_status').text(res.fuel_status);
      $('#speed').text(res.speed);
      $('#odometer').text(res.odometer);
      $('#mode').text(res.mode);
      $('#satelite').text(res.satelite);
      $('#battery_status').text(res.battery_status);
      $('#address').text(res.address);

     
      
}
