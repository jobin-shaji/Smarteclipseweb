$(document).ready(function () {
  $(".loader_transfer").hide();
});
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
  var scanned_serial_no = content.slice(12, 31);
  var serial_no = scanned_serial_no.replace(' ');
  var data = { serial_no : serial_no };
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
                var gps_batch_number=res.gps_batch_number;
                var gps_employee_code=res.gps_employee_code;
                $("#gps_id").val(items); 
                var markup = "<tr class='cover_imei_"+gps_imei_id+"'><td>" + gps_serial_no + "</td><td>" + gps_batch_number + "</td><td>" + gps_employee_code + "</td><td><button class='btn btn-xs btn-danger' onclick='return deleteValueArray("+gps_imei_id+");'>Remove</button></td></tr>";
                $("tbody").append(markup);
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


    function addcode(){

        var content = $('#scanner').val();
        if(content){
          if(confirm('Do you want to add this?')){
            $('textarea[id="scanner"]').hide();
            $("#add_qr_button").hide();
            $("#reset_qr_button").hide();
            $(".loader_transfer").show();
            var content_length = content.length;
            if(content_length >= 170 && content_length <= 180)
            {
              var scanned_serial_no = content.substr(12, 19);
              var serial_no = scanned_serial_no.replace(' ');
              serialNumberScan(serial_no);
            }
            else if(content_length >= 19)
            {
             
              var serial_no = content;
             
              serialNumberScan(serial_no);
            }
           
            else{
              $(".loader_transfer").hide();
              $('textarea[id="scanner"]').show();
              $("#add_qr_button").show();
              $("#reset_qr_button").show();
              $('textarea[id="scanner"]').val(null);
              alert('Invalid record! Please scan one item at a time');
            }
          }
          else
          {
            $("#stock_add_transfer").val("");
            $('textarea[id="scanner"]').val(null);
          }
        }else{
          alert('Please scan QR code ');
        }
    }
   
    function serialNumberScan(serial_no)
    {
      
      var data = { serial_no : serial_no };
      console.log(data);
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
              $("#stock_add_transfer").empty();
              var devices = res.devices;
              var select = document.getElementById('stock_add_transfer');
              var option1 = document.createElement('option');
              option1.value = "";
              option1.innerHTML = "Select Device";
              select.appendChild(option1);
              devices.forEach(device => {
                if(device.gps){
                  var option = document.createElement('option');
                  option.value = device.gps.serial_no;
                  option.innerHTML = "IMEI:- "+device.gps.imei+" , Serial Number:- "+device.gps.serial_no;
                  select.appendChild(option);
                }
             });
              $(".loader_transfer").hide();
              $('textarea[id="scanner"]').show();
              $("#add_qr_button").show();
              $("#reset_qr_button").show();
              $('textarea[id="scanner"]').val(null); 
              var position = jQuery.inArray(res.gps_id, items);
                if(position !='-1'){
                    toastr.info('Item Exists');
                }else{
                    items.push(res.gps_id);
                    var gps_imei_id=res.gps_id;
                    var gps_serial_no=res.gps_serial_no;
                    var gps_batch_number=res.gps_batch_number;
                    var gps_employee_code=res.gps_employee_code;
                    $("#gps_id").val(items);
                    var old_device_count = $('#scanned_device_count').text();
                    var scanned_device_count = parseInt(old_device_count)+1;
                    $('#scanned_device_count').text(scanned_device_count);
                    var role = $('#role').val();
                    if(role=='root'){
                      var markup = "<tr class='cover_imei_"+gps_imei_id+"'><td>" + gps_serial_no + "</td><td>" + gps_batch_number + "</td><td>" + gps_employee_code + "</td><td><button class='btn btn-xs btn-danger' onclick='return deleteValueArray("+gps_imei_id+");'>Remove</button></td></tr>";
                    }else{
                      var markup = "<tr class='cover_imei_"+gps_imei_id+"'><td>" + gps_serial_no + "</td><td>" + gps_batch_number + "</td><td><button class='btn btn-xs btn-danger' onclick='return deleteValueArray("+gps_imei_id+");'>Remove</button></td></tr>";
                    }
                    $("table tbody").append(markup);
                    var value = $('#gps_id').val();
                    if (value) {
                      $("#stock_table_heading").show();
                      $("#stock_table").show();
                      $("#transfer_button").show();
                    }
                    document.getElementById('scanner').value = "";
                    $("#scanner").focus();
                    toastr.success('Scanned Successfully');
                }
            }else if(res.status == 0){
              $(".loader_transfer").hide();
              $('textarea[id="scanner"]').show();
              $("#add_qr_button").show();
              $("#reset_qr_button").show();
              $('textarea[id="scanner"]').val(null);
              toastr.error('Could not find this device');
            }else if(res.status == 2){
              $(".loader_transfer").hide();
              $('textarea[id="scanner"]').show();
              $("#add_qr_button").show();
              $("#reset_qr_button").show();
              $('textarea[id="scanner"]').val(null);
              toastr.error('Device not found in stock');
            }else if(res.status == 3){
              $(".loader_transfer").hide();
              $('textarea[id="scanner"]').show();
              $("#add_qr_button").show();
              $("#reset_qr_button").show();
              $('textarea[id="scanner"]').val(null);
              toastr.error('Device already transferred');
            }else if(res.status == 4){
              $(".loader_transfer").hide();
              $('textarea[id="scanner"]').show();
              $("#add_qr_button").show();
              $("#reset_qr_button").show();
              $('textarea[id="scanner"]').val(null);
              toastr.error('Please accept this device for transaction');
            }
          }
      });
    }

$(function(){
  $('#reset_qr_button').click(function() {
    if(confirm('Do you want to clear this?'))
    {
      document.getElementById('scanner').value = "";
    }
  });
});

function deleteValueArray(gps_id)
{
  if( confirm('Do you want to remove this ?') )
  {
    var item_data = items.indexOf(gps_id);
    if (item_data > -1) {
      items.splice(item_data, 1);
      $('.cover_imei_'+gps_id).remove();
      var old_device_count = $('#scanned_device_count').text();
      var scanned_device_count = parseInt(old_device_count)-1;
      $('#scanned_device_count').text(scanned_device_count);
      $('#gps_id').val(items); 
      var value = $('#gps_id').val();
      if (value) {
        $("#stock_table_heading").show();
        $("#stock_table").show();
        $("#transfer_button").show();
      }else{
        $("#stock_table_heading").hide();
        $("#stock_table").hide();
        $("#transfer_button").hide();
      }
    }

    $.ajax({
      type:'POST',
      url: '/gps-scan-remove',
      data:{gps_id : gps_id} ,
      async: true,
      headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
          
      },
      success: function (res) {
        $("#stock_add_transfer").empty();
        var devices = res.devices;
        var select = document.getElementById('stock_add_transfer');
        var option = document.createElement('option');
        option.value = "";
        option.innerHTML = "Select Device";
        select.appendChild(option);
        devices.forEach(device => {
        var option1 = document.createElement('option');
        option1.value = device.gps.serial_no;
        option1.innerHTML = "IMEI:- "+device.gps.imei+" , Serial Number:- "+device.gps.serial_no;
        select.appendChild(option1);
        });
      } 
    });
  }
  else
  {
    return false;
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









