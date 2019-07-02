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
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'vehicle.name', name: 'vehicle.name'},
            {data: 'vehicle.register_number', name: 'vehicle.register_number'},
            {data: 'fromdriver.name', name: 'fromdriver.name'},
            {data: 'todriver.name', name: 'todriver.name'},
            {data: 'created_at', name: 'created_at'}
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
 }







