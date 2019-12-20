
$(function(){
    $('#searchclick').click(function() {
        var content = $('#packetvalue').val();
        if(content){
            var data = { content : content };
            $.ajax({
                type:'POST',
                url: "allalt-list",
                data:data ,
                async: true,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                
                  $('#gps_fix').val(res.data.gps_fix);
                 $('#header').val(res.data.header);
                 $('#imei').val(res.data.imei); 
                 $('#alert_id').val(res.data.alert_id);
                 $('#imei').val(res.data.imei); 
                 $('#date').val(res.data.date); 
                 $('#time').val(res.data.time); 
                 $('#packet_status').val(res.data.packet_status); 
                 $('#latitude').val(res.data.latitude); 
                 $('#latitude_dir').val(res.data.lat_dir);
                 $('#long').val(res.data.longitude); 
                 $('#long_dir').val(res.data.lon_dir); 
                 $('#MCC').val(res.data.mcc); 
                 $('#MNC').val(res.data.mnc); 
                 $('#LAC').val(res.data.lac); 
                 $('#cell_id').val(res.data.cell_id); 
                 $('#SPEED').val(res.data.speed); 
                 $('#heading').val(res.data.heading); 
                 $('#no_of_satelites').val(res.data.no_of_satelites); 
                 $('#gsm_signal_strength').val(res.data.gsm_signal_strength); 
                 $('#ignition').val(res.data.ignition); 
                 $('#main_power_status').val(res.data.main_power_status);
                 $('#vehicle_mode').val(res.data.vehicle_mode);  
                 $('#hdop').val(res.data.hdop);
                 $('#device_time').val(res.data.device_time);

                }
            });
          
        }
    });
});

$(function(){
$('#generate').click(function() {
   
 var result =    
            $('#header').val()+$('#imei').val()+ $('#alert_id').val()+$('#packet_status').val()+
            $('#gps_fix').val()+$('#date').val()+ $('#time').val()+$('#latitude').val()+ $('#latitude_dir').val()+ 
            $('#long').val()+$('#long_dir').val()+$('#MCC').val()+$('#MNC').val()+$('#LAC').val()+ $('#cell_id').val()+
            $('#SPEED').val()+ $('#heading').val()+ $('#no_of_satelites').val()+ $('#hdop').val()+  $('#gsm_signal_strength').val()+
            $('#ignition').val()+$('#main_power_status').val()+$('#vehicle_mode').val();
            $('#mergedvalue').val(result);
            $('#mergedvalue').show();
    });
});