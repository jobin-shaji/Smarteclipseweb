$(document).ready(function () {
  
    window.setInterval(function(){
       var gps_id=$('#gps_id').val();
       singleGpsData(gps_id); 

  }, 5000);


});

function singleGpsData(value){
  console.log(value);
  var url = 'allgpsdata-list';

     var data = { 
         gps : value   
     };
     console
   // window.setInterval(function(){
      apiBackgroundPostData(url,data,'alldata',{alert:false});  

  // }, 5000);
  // console.log(value);
}
function alldata(res){
   $('#datas').empty();
    $('#gps_table').empty(); 
  var gps_table;  
  if(res.last_data!=null)
  {

    var gps='<tr><td>Header</td><td>'+res.last_data.header+'</td></tr>'+
            '<tr><td>Imei</td><td >'+res.last_data.imei+'</td></tr>'+ 
            '<tr><td>alert id</td><td>'+res.last_data.alert_id+'</td></tr>'+
            '<tr><td>Packet Status</td><td>'+res.last_data.packet_status+'</td></tr>'+
            '<tr><td>Device Date</td><td>'+res.last_data.device_time+'</td></tr>'+
            '<tr><td>Latitude</td><td>'+res.last_data.latitude+'</td></tr>'+
            '<tr><td>Latitude Direction</td><td>'+res.last_data.lat_dir+'</td></tr>'+
            '<tr><td>Longitude</td><td>'+res.last_data.longitude+'</td></tr>'+
            '<tr><td>Longitude Direction</td><td>'+res.last_data.lon_dir+'</td></tr>'+
            '<tr><td>Mcc </td><td>'+res.last_data.mcc+'</td></tr>'+
            '<tr><td>Mnc </td><td>'+res.last_data.mnc+'</td></tr>'+
            '<tr><td>Lac </td><td>'+res.last_data.lac+'</td></tr>'+
            '<tr><td>Cell Id </td><td>'+res.last_data.cell_id+'</td></tr>'+
            '<tr><td>Heading</td><td>'+res.last_data.heading+'</td></tr>'+
            '<tr><td>speed</td><td>'+res.last_data.speed+'</td></tr>'+
            '<tr><td>No of Satelites</td><td>'+res.last_data.no_of_satelites+'</td></tr>'+
            '<tr><td>Hdop</td><td>'+res.last_data.hdop+'</td></tr>'+
            '<tr><td>Signal Strength</td><td>'+res.last_data.gsm_signal_strength+'</td></tr>'+        
            '<tr><td>ignition</td><td>'+res.last_data.ignition+'</td></tr>'+
            '<tr><td>main power status</td><td>'+res.last_data.main_power_status+'</td></tr>'+
            '<tr><td>Vehicle Mode</td><td>'+res.last_data.vehicle_mode+'</td></tr>'
        ;  
        $("#datas").append(gps);
      }
        for(var i=0; i < res.items.length; i++){
          var j=i+1;
           gps_table += '<tr><td>'+j+'</td>'+
           '<td>'+res.items[i].device_time+'</td>'+
           '<td>'+res.items[i].vlt_data+'</td></tr>';  
        }
        
        $("#gps_table").append(gps_table); 
  
}
