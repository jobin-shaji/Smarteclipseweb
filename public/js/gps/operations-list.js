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
        // order: [[1, 'desc']],
        ajax: {
            url: 'operations-list',
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
            {data: 'name', name: 'name', orderable: false },            
            {data: 'address', name: 'address', orderable: false,searchable: false},           
            {data: 'user.mobile', name: 'user.mobile', orderable: false},
            {data: 'user.email', name: 'user.email', orderable: false},
            {data: 'working_status', name: 'working_status', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},           
        ],        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
}
function delDealers(dealer){
    if(confirm('Are you sure to deactivate this user?')){
        var url = 'dealer/delete';
        var data = {
            uid : dealer
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}
function activateDealer(dealer){
    if(confirm('Are you sure to activate this user?')){
        var url = 'dealer/activate';
        var data = {
            id : dealer
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}

function disableOperations(operations){
    if(confirm('Are you sure to deactivate this user?')){
        var url = 'operations/disable';
        var data = {
            id : operations
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}
function enableOperations(operations){
    if(confirm('Are you sure to activate this user?')){
        var url = 'operations/enable';
        var data = {
            id : operations
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}

