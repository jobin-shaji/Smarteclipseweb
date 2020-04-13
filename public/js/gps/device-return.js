
$(document).ready(function() {
    $('#client_id').on('change', function() {
      var client_id = $(this).val();
      var data={ client_id : client_id };
      if(client_id) {
        $.ajax({
          type:'POST',
          url: '/select/vehicle',
          data:data ,
          async: true,
          headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
          },
          success:function(data) {
          if(data.vehicle.length != 0){
            $('#gps_id').empty();
            $('#gps_id').focus;
            $('#gps_id').append('<option value="">  Select Device </option>'); 
            $.each(data.vehicle, function(key, value){
              $('select[name="gps_id"]').append('<option value="'+ value.gps.id +'">' + value.gps.imei+' || '+ value.gps.serial_no+ '</option>');
            });
          }else{
            $('#gps_id').empty();
            $('#gps_id').focus;
            $('#gps_id').append('<option value="">  No Device </option>'); 
          }
          }
        });
      }else{
        $('#gps_id').empty();
      }
    });
  });

  
  