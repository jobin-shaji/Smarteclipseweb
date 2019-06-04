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
            url: 'vehicle-dealer-list',
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
            {data: 'name', name: 'name'},
            {data: 'register_number', name: 'register_number'},
            {data: 'gps.name', name: 'gps.name'},
            {data: 'gps.imei', name: 'gps.imei'},
            {data: 'e_sim_number', name: 'e_sim_number'},
            {data: 'vehicle_type.name', name: 'vehicle_type.name'},
            {data: 'sub_dealer', name: 'sub_dealer'},
            {data: 'client.name', name: 'client.name'},
            {data: 'action', name: 'action', orderable: false, searchable: false}, 
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
 }



