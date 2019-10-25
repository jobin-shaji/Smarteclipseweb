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
            url: 'gps-sub-dealer-list',
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
            {data: 'gps.employee_code', name: 'gps.employee_code', orderable: false},
            {data: 'gps.model_name', name: 'gps.model_name', orderable: false},
            {data: 'client', name: 'client', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},  
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

function deactivateGpsStatus(gps_id){
    if(confirm('Are you sure want to deactivate this device?')){
        var url = 'gps-status/deactivate';
        var data = {
            id : gps_id
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}
function activateGpsStatus(gps_id){
    if(confirm('Are you sure want to activate this device?')){
        var url = 'gps-status/activate';
        var data = {
            id : gps_id
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}


