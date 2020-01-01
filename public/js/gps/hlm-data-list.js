
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
                
                 $('#header').val(res.data.header);
                 $('#imei').val(res.data.imei); 
                 $('#date').val(res.data.date); 
                 $('#time').val(res.data.time); 
                 $('#vendor_id').val(res.data.vendor_id); 
                 $('#firmware_version').val(res.data.firmware_version); 
                 $('#update_rate_ignition_on').val(res.data.update_rate_ignition_on); 
                 $('#update_rate_ignition_off').val(res.data.update_rate_ignition_off); 
                 $('#battery_percentage').val(res.data.battery_percentage);
                 $('#low_battery_threshold_value').val(res.data.low_battery_threshold_value);  
                 $('#memory_percentage').val(res.data.memory_percentage);
                 $('#digital_io_status').val(res.data.digital_io_status);
                 $('#analog_io_status').val(res.data.analog_io_status);
                  $('#device_time').val(res.data.device_time);

                }
            });
          
        }
    });
});

$(function(){
$('#generate').click(function() {
   
 var result = 
              $('#header').val()+$('#vendor_id').val()+$('#firmware_version').val()
              +$('#imei').val()+$('#update_rate_ignition_on').val()+$('#update_rate_ignition_off').val()
              +$('#battery_percentage').val()+$('#low_battery_threshold_value').val()+
              $('#memory_percentage').val()+ $('#digital_io_status').val()+$('#analog_io_status').val()+
              $('#date').val()+$('#time').val() ;
              $('#mergedvalue').val(result);
              $('#mergedvalue').show();
    });
});
