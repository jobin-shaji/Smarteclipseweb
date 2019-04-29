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
            url: 'etm-list',
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

            {data: 'purchase_date', name: 'purchase_date'},
            {data: 'version', name: 'version'},
            {data: 'depot.name', name: 'depot.name'},
            {data: 'battery_percentage', name: 'battery_percentage'},
            {data: 'button_count', name: 'button_count'},
            {data: 'device_status', name: 'device_status'},

            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

function delEtm(etm){
    var url = 'etm/delete';
    var data = {
        uid : etm
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}

function activateEtm(etm){
    var url = 'etm/activate';
    var data = {
        id : etm
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}


