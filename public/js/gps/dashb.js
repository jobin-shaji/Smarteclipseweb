$(document).ready(function () {
   
     var url = 'dash-count';
     var data = { 
     
     };


      backgroundPostData(url,data,'dbcount',{alert:false});


 //    window.setInterval(function(){
 //    	 backgroundPostData(url,data,'dbcount',{alert:false});  

	// }, 5000);
});
 var activeElement;

function dbcount(res){
	    $('#gps').text(res.gps);
      $('#dealer').text(res.dealers);
      $('#sub_dealer').text(res.subdealers);
      $('#client').text(res.clients);
      $('#vehicle').text(res.vehicles);
      $('#dealer_subdealer').text(res.subdealers);
      $('#total_gps_dealer').text(res.total_gps);
      $('#transferred_gps_dealer').text(res.transferred_gps);
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
      
      
}

//updated all aaaaa
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
      var address=res.address;
      $('#address').text(address);
        
  }


  


