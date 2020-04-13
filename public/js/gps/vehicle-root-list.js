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
            url: 'vehicle-root-list',
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
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'register_number', name: 'register_number'},
            {data: 'serial_no', name: 'serial_no'},
            {data: 'vehicle_type_name', name: 'vehicle_type_name'},
            {data: 'dealer', name: 'dealer'},
            {data: 'sub_dealer', name: 'sub_dealer'},
            {data: 'trader',name:'trader'},
            {data: 'client.name', name: 'client.name'},
            {data: 'action', name: 'action', orderable: false, searchable: false}, 
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
 }



