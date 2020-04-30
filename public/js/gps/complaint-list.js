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
            url: 'complaint-list',
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
            {data: 'ticket.code', name: 'ticket.code', orderable: false},
            {data: 'vehicle_gps.vehicle.register_number', name: 'vehicle_gps.vehicle.register_number', orderable: false},
            {data: 'gps.serial_no', name: 'gps.serial_no', orderable: false},
            {data: 'complaint_category', name: 'complaint_category' , orderable: false},
            {data: 'complaint_type.name', name: 'complaint_type.name' , orderable: false},
            {data: 'title', name: 'title', orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'assigned_to', name: 'assigned_to', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},        
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();

}






