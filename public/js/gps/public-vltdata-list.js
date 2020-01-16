$(document).ready(function () {
    // callBackDataTable();
});

function check(){       
        callBackDataTable();       
}
function callBackDataTable(value){
     if(value){
    $("#set_ota_button").show();
    $("#set_ota_gps_id").val(value);
  }
  else{
    $("#set_ota_button").hide();
  }
    if(value==null)
    {
        gps=document.getElementById('gps_id').value;        
    }
    else{
        gps=value;
    }
    // console.log(gps);
    var  data = {
        gps : gps,
        header : document.getElementById('header').value   
    };
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'public-vltdata-list',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },             
        fnDrawCallback: function (oSettings, json) {
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index'},
            {data: 'vltdata', name: 'vltdata', orderable: false, searchable: true},
            {data: 'created_at', name: 'created_at' ,orderable: true, searchable: false},
            {data: 'forhuman', name: 'forhuman' ,orderable: false, searchable: false},
            // {data: 'action', name: 'action' ,orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100, 1000, -1], [25, 50, 100, 1000, 'All']]
    });
}
function setOta(imei) { 
    if(document.getElementById('command').value == ''){
        alert('Please enter your command');
    }
    else{
        var command = document.getElementById('command').value;
        var imei = document.getElementById('gps_id').value;
        var data = {'imei':imei, 'command':command};
    } 
    var url = 'unprocessed-setota';
    var purl = getUrl() + '/' + url;
    var triangleCoords = [];
    $.ajax({
        type: 'POST',
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
          if(res.status==1){
            toastr.success(res.message);
          }else{
            toastr.error(res.message);
          }
        }
    });
}

