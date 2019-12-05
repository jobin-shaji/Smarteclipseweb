
$(function(){
    $('#searchclick').click(function() {
        var content = $('#packetvalue').val();
        if(content){
            var data = { content : content };
            $.ajax({
                type:'POST',
                url: "allack-list",
                data:data ,
                async: true,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                
                  $('#gps_fix').html(res.data.gps_fix);
                 $('#header').html(res.data.header);
                 $('#imei').html(res.data.imei); 
                 $('#alert_id').html(res.data.alert_id);
                 $('#imei').html(res.data.imei); 
                 $('#date').html(res.data.date); 
                 $('#time').html(res.data.time); 
                 $('#packet_status').html(res.data.packet_status); 
                 $('#latitude').html(res.data.latitude); 
                 $('#latitude_dir').html(res.data.lat_dir);
                 $('#long').html(res.data.longitude); 
                 $('#long_dir').html(res.data.lon_dir); 
                 $('#MCC').html(res.data.mcc); 
                 $('#MNC').html(res.data.mnc); 
                 $('#LAC').html(res.data.lac); 
                 $('#cell_id').html(res.data.cell_id); 
                 $('#SPEED').html(res.data.speed); 
                 $('#heading').html(res.data.heading); 
                 $('#no_of_satelites').html(res.data.no_of_satelites); 
                 $('#gsm_signal_strength').html(res.data.gsm_signal_strength); 
                 $('#ignition').html(res.data.ignition); 
                 $('#main_power_status').html(res.data.main_power_status);
                 $('#vehicle_mode').html(res.data.vehicle_mode);  
                 $('#hdop').html(res.data.hdop);
                   $('#device_time').html(res.data.device_time);

                }
            });
          
        }
    });
});

