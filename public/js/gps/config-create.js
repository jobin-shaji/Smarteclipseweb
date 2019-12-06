$(document).ready(function () {
 
});
 
function plan(id){
 // $("#myModal").reset();
  $('#myModal').modal('show');
  $('#plan_id').val(id);
    // alert(id);

    // var url = 'get-gps-data-hlm';
    var url = 'get-config-data';
    var data = {
       id:id
    };   
    backgroundPostData(url,data,'getConfigData',{alert:false});           
  }
// 

function getConfigData(res)
{
   var plan_id=$('#plan_id').val();
   $('#name').val(res.config.name);
    $('#code').val(res.config.code);
    var values=res.config.value;
    // console.log(JSON.parse(values).freebies);
    if(plan_id==1)
    {
       $('#config').val();
    }
    if(plan_id==2)
    {
      var fundamental=JSON.parse(values).fundamental;
      console.log(fundamental);
      // document.getElementById("config").value = JSON.parse(values); 
       $('#config').val(freebies.pro.ac_status);
    }
    if(plan_id==3)
    {
       $('#config').val(JSON.parse(values).superior);
    }
    if(plan_id==4)
    {
       $('#config').val(JSON.parse(values).pro);
    }

    var gps=' <tr><td>Ac Status</td><td>'+res.gpsData.header+'</td></tr>'+
            '<tr><td>Imei</td><td >'+res.gpsData.imei+'</td></tr>'+
            '<tr><td>alert id</td><td>'+res.gpsData.alert_id+'</td></tr>'+
            '<tr><td>Packet Status</td><td>'+res.gpsData.packet_status+'</td></tr>'+
            '<tr><td>Device Date</td><td>'+res.gpsData.device_time+'</td></tr>'+
            '<tr><td>Latitude</td><td>'+res.gpsData.latitude+'</td></tr>'+
            '<tr><td>Latitude Direction</td><td>'+res.gpsData.lat_dir+'</td></tr>'+
            '<tr><td>Longitude</td><td>'+res.gpsData.longitude+'</td></tr>'+
            '<tr><td>Longitude Direction</td><td>'+res.gpsData.lon_dir+'</td></tr>'+
            '<tr><td>Mcc </td><td>'+res.gpsData.mcc+'</td></tr>'+
            '<tr><td>Mnc </td><td>'+res.gpsData.mnc+'</td></tr>'+
            '<tr><td>Lac </td><td>'+res.gpsData.lac+'</td></tr>'+
            '<tr><td>Cell Id </td><td>'+res.gpsData.cell_id+'</td></tr>'+
            '<tr><td>Heading</td><td>'+res.gpsData.heading+'</td></tr>'+
            '<tr><td>speed</td><td>'+res.gpsData.speed+'</td></tr>'+
            '<tr><td>No of Satelites</td><td>'+res.gpsData.no_of_satelites+'</td></tr>'+
            '<tr><td>Hdop</td><td>'+res.gpsData.hdop+'</td></tr>'+
            '<tr><td>Signal Strength</td><td>'+res.gpsData.gsm_signal_strength+'</td></tr>'+        
            '<tr><td>ignition</td><td>'+res.gpsData.ignition+'</td></tr>'+
            '<tr><td>main power status</td><td>'+res.gpsData.main_power_status+'</td></tr>'+
            '<tr><td>Gpx-fix</td><td>'+res.gpsData.gps_fix+'</td></tr>'+

            '<tr><td>Vehicle Mode</td><td>'+res.gpsData.vehicle_mode+'</td></tr>'
        ;  
        $("#config").append(gps);

}
