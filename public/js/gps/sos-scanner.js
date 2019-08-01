var items = [];
var purl = getUrl() + '/'+'sos-scan' ;
let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
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
                var markup = "<tr class='cover_imei_"+sos_imei_id+"'><td>" + sos_imei + "</td><td><button class='btn btn-xs btn-danger' onclick='deleteValueArray("+sos_imei_id+");'>Remove</button></td></tr>";
                $("table tbody").append(markup);
                toastr.success('Scanned Successfully');
            }
        }else{
          toastr.error('Already Transferred');
        }
      }
  });
  
});

function deleteValueArray(sos_id){
  var item_data = items.indexOf(sos_id)
  if (item_data > -1) {
       items.splice(item_data, 1);
       $('.cover_imei_'+sos_id).remove();
       $('#sos_id').val(items);
    }

}

Instascan.Camera.getCameras().then(function (cameras) {
  if (cameras.length > 0) {
    scanner.start(cameras[0]);
  } else {
    console.error('No cameras found.');
  }
}).catch(function (e) {
  console.error(e);
});