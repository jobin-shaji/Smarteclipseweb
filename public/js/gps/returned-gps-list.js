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
        //order: [[1, 'desc']],
        ajax: {
            url: 'returned-gps-list',
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
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'gps.imei', name: 'gps.imei', orderable: false},
            {data: 'gps.serial_no', name: 'gps.serial_no', orderable: false},
            {data: 'gps.batch_number', name: 'gps.batch_number', orderable: false},
            {data: 'gps.version', name: 'gps.version', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
}
