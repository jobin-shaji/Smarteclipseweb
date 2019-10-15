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
            url: 'sos-list',
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
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'imei', name: 'imei', orderable: false},
            {data: 'model_name', name: 'model_name', orderable: false},
            {data: 'manufacturing_date', name: 'manufacturing_date', orderable: false},
            {data: 'brand', name: 'brand', orderable: false},
            {data: 'version', name: 'version'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

function delSos(sos){
    if(confirm('Are you sure want to deactivate this sos?')){
        var url = 'sos/delete';
        var data = {
            uid : sos
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}

function activateSos(sos){
    if(confirm('Are you sure want to activate this device?')){
        var url = 'sos/activate';
        var data = {
            id : sos
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}


