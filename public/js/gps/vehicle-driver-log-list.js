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
            url: 'vehicle-driver-log-list',
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
            {data: 'vehicle.name', name: 'vehicle.name', orderable: false},
            {data: 'vehicle.register_number', name: 'vehicle.register_number', orderable: false},
            {data: 'fromdriver.name', name: 'fromdriver.name', orderable: false},
            {data: 'todriver.name', name: 'todriver.name', orderable: false},
            {data: 'created_at', name: 'created_at', orderable: false}
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
 }







