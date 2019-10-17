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
            url: 'gps-dealer-list',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        createdRow: function ( row, data, index ) {
            if ( data['deleted_at'] ) {
                $('td', row).css('background-color', 'rgb(243, 204, 204)');
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'gps.imei', name: 'gps.imei' },
            {data: 'gps.serial_no', name: 'gps.serial_no' },
            {data: 'gps.version', name: 'gps.version'},
            {data: 'gps.batch_number', name: 'gps.batch_number'},
            {data: 'gps.employee_code', name: 'gps.employee_code'},
            {data: 'gps.model_name', name: 'gps.model_name'},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}




