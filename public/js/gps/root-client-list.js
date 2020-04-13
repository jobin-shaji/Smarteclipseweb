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
            url: 'root-client-list',
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
            {data: 'subdealer', name: 'subdealer', orderable: false}, 
            {data: 'trader', name: 'trader', orderable: false},
            {data: 'working_status', name: 'working_status', orderable: false},       
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();

}

function disableEndUser(end_user){
    if(confirm('Are you sure to deactivate this user?')){
        var url = 'client/disable';
        var data = {
            id : end_user
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}
function enableEndUser(end_user){
    if(confirm('Are you sure to activate this user?')){
        var url = 'client/enable';
        var data = {
            id : end_user
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}

