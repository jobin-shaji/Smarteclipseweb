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
            url: 'gps-list',
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
            {data: 'gps.e_sim_number', name: 'gps.e_sim_number', orderable: false},
            {data: 'gps.batch_number', name: 'gps.batch_number', orderable: false},
            {data: 'gps.employee_code', name: 'gps.employee_code', orderable: false},
            {data: 'gps.version', name: 'gps.version'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

function delGps(gps){
    if(confirm('Are you sure to deactivate this device?')){
        var url = 'gps/delete';
        var data = {
            uid : gps
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}

function activateGps(gps){
    if(confirm('Are you sure to activate this device?')){
        var url = 'gps/activate';
        var data = {
            id : gps
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}


