$(document).ready(function () {
    callBackDataTable();
});

function callBackDataTable(){
    var  data = {
    
    }; 


    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'gps-transfer-list',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'gps.name', name: 'gps.name'},
            {data: 'gps.imei', name: 'gps.imei'},
            {data: 'from_user.username', name: 'from_user.username'},
            {data: 'to_user.username', name: 'to_user.username'},
            {data: 'transfer_date', name: 'transfer_date',orderable: false, searchable: false}

            ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}


$('#gpsTransfer').on('change', function() {
   $("#to_user option").css('display','block');
    var gpsID=this.value;
    var data = { gpsID : gpsID };
    $.ajax({
        type:'POST',
        url: '/gps-transfer/user-detils',
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
          var CurrentUser=res.user.id;
          var CurrentUserName=res.user.username;
          $(".from_user_id").val(CurrentUser); 
          $(".from_user_name").val(CurrentUserName); 
          $("#to_user option[value="+CurrentUser+"]").hide();
        }
    });

  });





