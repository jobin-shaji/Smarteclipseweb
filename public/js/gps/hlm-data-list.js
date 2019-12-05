
$(function(){
    $('#searchclick').click(function() {
        var content = $('#packetvalue').val();
        if(content){
            var data = { content : content };
            $.ajax({
                type:'POST',
                url: "allhlm-list",
                data:data ,
                async: true,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                
                 $('#header').html(res.data.header);
                 $('#imei').html(res.data.imei); 
                 $('#date').html(res.data.date); 
                 $('#time').html(res.data.time); 
                 $('#vendor_id').html(res.data.vendor_id); 
                 $('#firmware_version').html(res.data.firmware_version); 
                 $('#update_rate_ignition_on').html(res.data.update_rate_ignition_on); 
                 $('#update_rate_ignition_off').html(res.data.update_rate_ignition_off); 
                 $('#battery_percentage').html(res.data.battery_percentage);
                 $('#low_battery_threshold_value').html(res.data.low_battery_threshold_value);  
                 $('#memory_percentage').html(res.data.memory_percentage);
                 $('#digital_io_status').html(res.data.digital_io_status);
                 $('#memory_percentage').html(res.data.memory_percentage);
                 $('#analog_io_status').html(res.data.analog_io_status);
                 $('#device_time').html(res.data.device_time);

                }
            });
          
        }
    });
});

