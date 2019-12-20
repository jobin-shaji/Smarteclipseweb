
$(function(){
    $('#searchclick').click(function() {
        var content = $('#packetvalue').val();
        if(content){
            var data = { content : content };
            $.ajax({
                type:'POST',
                url: "allful-list",
                data:data ,
                async: true,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                alert(res.data.header);
                 $('#header').val(res.data.header);
                 $('#imei').val(res.data.imei);
                 $('#date').val(res.data.date); 
                 $('#time').val(res.data.time); 
                 $('#alert_id').val(res.data.alert_id); 
                 $('#packet_status').val(res.data.packet_status); 
                 $('#latitude').val(res.data.latitude); 
                 $('#latitude_dir').val(res.data.lat_dir);
                 $('#long').val(res.data.longitude); 
                 $('#long_dir').val(res.data.lon_dir); 
                 $('#MCC').val(res.data.mcc); 
                 $('#MNC').val(res.data.mnc); 
                 $('#lac').val(res.data.lac); 
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
                 $('#vendor_id').val(res.data.vendor_id);
                 $('#firmware_version').val(res.data.firmware_version);
                 $('#vehicle_register_num').val(res.data.vehicle_register_num);
                 $('#altitude').val(res.data.altitude);
                 $('#pdop').val(res.data.pdop);
                 $('#nw_op_name').val(res.data.nw_op_name);
                 $('#nmr').val(res.data.nmr);
                 $('#main_input_voltage').val(res.data.main_input_voltage);
                 $('#tamper_alert').val(res.data.tamper_alert);
                 $('#digital_io_status').val(res.data.digital_io_status);
                 $('#internal_battery_voltage').val(res.data.internal_battery_voltage);
                 $('#frame_number').val(res.data.frame_number);
                 $('#checksum').val(res.data.checksum);
                 $('#gps_fix').val(res.data.gps_fix);

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
            $('#long').val()+$('#long_dir').val()+$('#MCC').val()+$('#MNC').val()+$('#lac').val()+ $('#cell_id').val()+
            $('#SPEED').val()+ $('#heading').val()+ $('#no_of_satelites').val()+ $('#hdop').val()+  $('#gsm_signal_strength').val()+
            $('#ignition').val()+$('#main_power_status').val()+$('#vehicle_mode').val()+ $('#vendor_id').val()+ 
            $('#firmware_version').val()+$('#vehicle_register_num').val()+ $('#altitude').val()+$('#pdop').val()+
            $('#nw_op_name').val()+  $('#nmr').val()+ $('#main_input_voltage').val()+
            $('#internal_battery_voltage').val()+$('#tamper_alert').val()+$('#digital_io_status').val()+ $('#frame_number').val()+ $('#checksum').val();
            $('#mergedvalue').val(result);
            $('#mergedvalue').show();
    });
});
