
$(function(){
    $('#searchclick').click(function() {
        var content = $('#packetvalue').val();
        if(content){
            var data = { content : content };
            $.ajax({
                type:'POST',
                url: "alllgn-list",
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
                 $('#latitude').val(res.data.latitude); 
                 $('#latitude_dir').val(res.data.lat_dir);
                 $('#long').val(res.data.longitude); 
                 $('#long_dir').val(res.data.lon_dir); 
                 $('#activationKey').val(res.data.activation_key); 
                 $('#SPEED').val(res.data.speed); 
                 $('#device_time').val(res.data.device_time);

                }
            });
          
        }
    });
});
$(function(){
$('#generate').click(function() {
   
            var result = $('#header').val()+$('#imei').val()+ $('#activationKey').val()+
               $('#latitude').val()+ $('#latitude_dir').val()+$('#long').val()+ $('#long_dir').val()
               +$('#date').val()+$('#time').val()+$('#SPEED').val() ; 
            $('#mergedvalue').val(result);
            $('#mergedvalue').show();
    });
});
