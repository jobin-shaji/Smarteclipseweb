$(document).ready(function () {
    callBackDataTable();
});
function callBackDataTable(){
    var  data = {
         dealer : $('meta[name = "dealer"]').attr('content')    
    }; 
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'client-list',
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
            {data: 'address', name: 'address',searchable: false},           
             {data: 'user.mobile', name: 'user.mobile'},
           {data: 'user.email', name: 'user.email',searchable: false},         
            {data: 'action', name: 'action', orderable: false, searchable: false},
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}
function delClient(client){
    if(confirm('Are you sure to deactivate this user?')){
        var url = 'client/delete';
        var data = {
            uid : client
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}
function activateClient(client){
    if(confirm('Are you sure to activate this user?')){
        var url = 'client/activate';
        var data = {
            id : client
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true}); 
    } 
}

