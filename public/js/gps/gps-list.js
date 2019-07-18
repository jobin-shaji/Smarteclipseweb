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
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'name', name: 'name', searchable: false},
            {data: 'imei', name: 'imei'},
            {data: 'manufacturing_date', name: 'manufacturing_date'},
            {data: 'e_sim_number', name: 'e_sim_number'},
            {data: 'brand', name: 'brand'},
            {data: 'model_name', name: 'model_name'},
            {data: 'version', name: 'version'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

function delGps(gps){
    var url = 'gps/delete';
    var data = {
        uid : gps
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}

function activateGps(gps){
    var url = 'gps/activate';
    var data = {
        id : gps
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}


