$(document).ready(function () {
   // $('#loader').hide();
  window.setInterval(function(){
    var gps_id=$('#gps_id').val();
    singleGpsData(gps_id); 
  }, 5000);
});

function singleGpsData(value){
  if(value){
    // $("#set_ota_button").show();
    // $("#set_ota_gps_id").val(value);
  }
  var url = 'allgpsdata-list-public';
  var data = { 
     gps : value   
  };
  apiBackgroundPostData(url,data,'alldata',{alert:false});  
}
function alldata(res){
  console.log(res);
  $('#datas').empty();
  $('#gps_table').empty(); 
  $('#last_update_time').empty(); 
  // $('#loader').show();
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
            '<tr><td>Vehicle Mode</td><td>'+res.last_data.vehicle_mode+'</td></tr>';  
        $("#datas").append(gps);         
      }else{
         $('#loader').hide();
        $("#datas").append("No data available");
      }
      for(var i=0; i < res.items.length; i++){

        gps_table += '<tr><td style="padding:15px">'+res.items[i].vlt_data+'</td></tr>'; 
        $('#loader').hide(); 
      }
      $("#gps_table").append(gps_table); 
      if(res.last_updated!=0)
      { 
       
        var  update_time = '<tr><td style="padding:15px">Last Updated: '+res.last_updated+'</td></tr>';       
        $("#last_update_time").append(update_time); 
      }
     
}

function setOta(gps_id) {
  if(document.getElementById('command').value == ''){
    alert('Please enter your command');
  }
  else{
    var command = document.getElementById('command').value;
    var gps_id = document.getElementById('gps_id').value;
    var data = {'gps_id':gps_id, 'command':command};
  }
    var url = 'setota';
    var purl = getUrl() + '/' + url;
    var triangleCoords = [];
    $.ajax({
        type: 'POST',
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
          if(res.status==1){
            toastr.success(res.message);
          }else{
            toastr.error(res.message);
          }
        }
    });

}
