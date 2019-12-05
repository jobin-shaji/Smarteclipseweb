
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
                
                 $('#header').html(res.data.header);
                 $('#imei').html(res.data.imei); 
                 $('#date').html(res.data.date); 
                 $('#time').html(res.data.time); 
                 $('#latitude').html(res.data.latitude); 
                 $('#latitude_dir').html(res.data.lat_dir);
                 $('#long').html(res.data.longitude); 
                 $('#long_dir').html(res.data.lon_dir); 
                 $('#activationKey').html(res.data.activationKey); 
                 $('#SPEED').html(res.data.speed); 
                 $('#device_time').html(res.data.device_time);

                }
            });
          
        }
    });
});

