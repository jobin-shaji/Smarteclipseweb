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
            url: 'vehicle-models-list',
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
            {data: 'name', name: 'name' },
            {data: 'vehicle_make.name', name: 'vehicle_make.name' },
            {data: 'fuel_capacity', name: 'fuel_capacity' },
            {data: 'fuel_min', name: 'fuel_min' },
            {data: 'fuel_25', name: 'fuel_25' },
            {data: 'fuel_50', name: 'fuel_50' },
            {data: 'fuel_75', name: 'fuel_75' },
            {data: 'fuel_max', name: 'fuel_max' },
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
}
function disableVehicleModels(vehicle_models){
    if(confirm('Are you sure to deactivate this user?')){
        var url = 'vehicle-model/disable';
        var data = {
            id : vehicle_models
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});
    }
}
function enableVehicleModels(vehicle_models){
    if(confirm('Are you sure to activate this user?')){
        var url = 'vehicle-model/enable';
        var data = {
            id : vehicle_models
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});
    }
}

