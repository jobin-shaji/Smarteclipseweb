
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
                
                 $('#header').html(res.data.header);
                  $('#imei').html(res.data.imei);
                 $('#imei').html(res.data.imei); 
                 $('#date').html(res.data.date); 
                 $('#time').html(res.data.time); 
                 $('#alert_id').html(res.data.alert_id); 
                 $('#packet_status').html(res.data.packet_status); 
                 $('#latitude').html(res.data.latitude); 
                 $('#latitude_dir').html(res.data.lat_dir);
                 $('#long').html(res.data.longitude); 
                 $('#long_dir').html(res.data.lon_dir); 
                 $('#MCC').html(res.data.mcc); 
                 $('#MNC').html(res.data.mnc); 
                 $('#lac').html(res.data.lac); 
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
                 $('#vendor_id').html(res.data.vendor_id);
                 $('#firmware_version').html(res.data.firmware_version);
                 $('#vehicle_register_num').html(res.data.vehicle_register_num);
                 $('#altitude').html(res.data.altitude);
                 $('#pdop').html(res.data.pdop);
                 $('#nw_op_name').html(res.data.nw_op_name);
                 $('#nmr').html(res.data.nmr);
                 $('#main_input_voltage').html(res.data.main_input_voltage);
                 $('#tamper_alert').html(res.data.tamper_alert);
                 $('#digital_io_status').html(res.data.digital_io_status);
                 $('#internal_battery_voltage').html(res.data.internal_battery_voltage);
                 $('#frame_number').html(res.data.frame_number);
                 $('#checksum').html(res.data.checksum);
                 $('#gps_fix').html(res.data.gps_fix);

                }
            });
          
        }
    });
});

