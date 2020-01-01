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
            url: 'route-batch-list',
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
            {data: 'name', name: 'name' }, 
            {data: 'route.name', name: 'route.name' },                       
            {data: 'action', name: 'action', orderable: false, searchable: false},
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}
function delRouteBatch(route_batch_id){
    var url = 'route-batch/delete';
    var data = {
        uid : route_batch_id
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}
function activateRouteBatch(route_batch_id){
    var url = 'route-batch/activate';
    var data = {
        id : route_batch_id
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}

