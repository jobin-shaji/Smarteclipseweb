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
            url: 'list-servicer-complaints-history',
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
            {data: 'ticket.code', name: 'ticket.code'},
            {data: 'gps.imei', name: 'gps.imei'},
            {data: 'complaint_type.name', name: 'complaint_type.name'},
            {data: 'description', name: 'description'},
            {data: 'created_at', name: 'created_at'},
             {data: 'closed_on', name: 'closed_on'},
            {data: 'assigned_by', name: 'assigned_by'},
        ],        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });

}






