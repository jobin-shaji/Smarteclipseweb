function getUrl(){
  return $('meta[name = "domain"]').attr('content');
}
var items = [];
var purl = getUrl() + '/'+'gps-scan' ;
let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
Instascan.Camera.getCameras().then(function (cameras) {
  if (cameras.length > 0) {
    $('#warn').html('Scan QR Code');
    scanner.start(cameras[0]);
  } else {
     $('#warn').html('Camera not found , Please connect your camera');
  }
}).catch(function (e) {
});
scanner.addListener('scan', function (content) {
  var scanned_imei = content.slice(35, 50);
  var imei = scanned_imei.replace(' ');
  var data = { imei : imei };
  $.ajax({
      type:'POST',
      url: purl,
      data:data ,
      async: true,
      headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (res) {
        if(res.status == 1){
           var position = jQuery.inArray(res.gps_id, items);
            if(position !='-1'){
                toastr.info('Item Exists');
            }else{
                items.push(res.gps_id);
                var gps_imei_id=res.gps_id;
                var gps_serial_no=res.gps_serial_no;
                var gps_imei=res.gps_imei;
                var gps_batch_number=res.gps_batch_number;
                var gps_employee_code=res.gps_employee_code;
                $("#gps_id").val(items); 
                var markup = "<tr class='cover_imei_"+gps_imei_id+"'><td>" + gps_serial_no + "</td><td>" + gps_batch_number + "</td><td>" + gps_employee_code + "</td><td><button class='btn btn-xs btn-danger' onclick='deleteValueArray("+gps_imei_id+");'>Remove</button></td></tr>";
                $("table tbody").append(markup);
                var value = $('#gps_id').val();
                if (value) {
                  $("#transfer_button").show();
                }
                toastr.success('Scanned Successfully');
            }
        }else{
          toastr.error('Could not find this device');
        }
      }
  });
  
});

function deleteValueArray(gps_id){
  var item_data = items.indexOf(gps_id)
  if (item_data > -1) {
      items.splice(item_data, 1);
      $('.cover_imei_'+gps_id).remove();
      $('#gps_id').val(items);
      var value = $('#gps_id').val();
      if (value) {
        $("#transfer_button").show();
      }else{
        $("#transfer_button").hide();
      }
    }

}

$(function() {
  $('input[name="type"]').on('click', function() {
    if ($(this).is(':checked'))
      $(this).next('#camera_enable').show();
    else
      $(this).next('#camera_enable').hide();
  });
});









