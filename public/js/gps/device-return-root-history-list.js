$(document).ready(function () {
    callBackDataTable();
});


function callBackDataTable(){
     // var showAdminColumns =  role ==3 ? true:false;

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
            url: 'device-return-root-history-list',
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
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'servicer.name', name: 'servicer.name', orderable: false},
            {data: 'gps.imei', name: 'gps.imei' , orderable: false},
            {data: 'gps.serial_no', name: 'gps.serial_no' , orderable: false},
            {data: 'type_of_issues', name: 'type_of_issues', orderable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
                 
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });

}






