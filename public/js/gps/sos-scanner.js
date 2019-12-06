function getUrl(){
  return $('meta[name = "domain"]').attr('content');
}
var items = [];
var purl = getUrl() + '/'+'sos-scan' ;
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
  var imei=content;
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
          var position = jQuery.inArray(res.sos_id, items);
            if(position !='-1'){
                toastr.info('Item Exists');
            }else{
                items.push(res.sos_id);
                var sos_imei_id=res.sos_id;
                var sos_imei=res.sos_imei;
                $("#sos_id").val(items); 
                var value = $('#sos_id').val();
                var old_device_count = $('#scanned_device_count').text();
                var scanned_device_count = parseInt(old_device_count)+1;
                var markup = "<tr class='cover_imei_"+sos_imei_id+"'><td>" + sos_imei + "</td><td><button class='btn btn-xs btn-danger' onclick='deleteValueArray("+sos_imei_id+");'>Remove</button></td></tr>";
                $("table tbody").append(markup);
                $('#scanned_device_count').text(scanned_device_count);
                if (value) {
                  $("#sos_table").show();
                  $("#transfer_button").show();
                }
                toastr.success('Scanned Successfully');
            }
        }else{
          toastr.error('Could not find this button');
        }
      }
  });
  
});

function deleteValueArray(sos_id){
  var item_data = items.indexOf(sos_id)
  if (item_data > -1) {
      items.splice(item_data, 1);
      $('.cover_imei_'+sos_id).remove();
      var old_device_count = $('#scanned_device_count').text();
      var scanned_device_count = parseInt(old_device_count)-1;
      $('#scanned_device_count').text(scanned_device_count);
      $('#sos_id').val(items);
      var value = $('#sos_id').val();
      if (value) {
        $("#sos_table").show();
        $("#transfer_button").show();
      }else{
        $("#sos_table").hide();
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
