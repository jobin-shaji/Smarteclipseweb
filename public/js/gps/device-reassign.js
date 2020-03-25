 function searchData(){
    
     if(imei == ''){
        alert('please enter imei');
    }
    else{    
    var url = '/device-reassign';
      var imei = document.getElementById('imei').value;
      alert(imei);
      var data = {
          'imei':imei
      };
      backgroundPostData(url,data,'searchDevice',{alert:true}); 
    }
    // alert(imei);
  }
function searchDevice(res){
    // $('#alerttabledata').empty();
    // for (var i = 0; i < res.length; i++) {
    //     var j=i+1;
    //     var alertdatas = '<tr><td>'+j+'</td>'+
    //     '<td>'+res[i].gps.vehicle.name+'</td>'+
    //     '<td>'+res[i].alert_type.description+'</td>'+
    //     '<td>'+res[i].device_time+'</td>'+       
    //     '</tr>';
    //     $("#alerttabledata").append(alertdatas);
    // }
}




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
              $('select[name="gps_id"]').append('<option value="'+ value.gps.id +'">' + value.gps.imei+'||'+ value.gps.serial_no+ '</option>');
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

  
  