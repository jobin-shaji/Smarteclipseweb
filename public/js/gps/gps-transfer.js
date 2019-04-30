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
            url: 'etm-transfer-list',
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
            {data: 'etm_details.name', name: 'etm_details.name'},
            {data: 'from_depot_details.name', name: 'from_depot_details.name'},
            {data: 'to_depot_details.name', name: 'to_depot_details.name'},
            {data: 'tarnferDate', name: 'tarnferDate',orderable: false, searchable: false}

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
          var CurrentUser=res.dealer.user_id;
          var CurrentUserName=res.dealer.name;
          $(".from_user_id").val(CurrentUser); 
          $(".from_user_name").val(CurrentUserName); 
          $("#to_user option[value="+CurrentUser+"]").hide();
        }
    });

  });





