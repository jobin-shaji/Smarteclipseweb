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
            url: 'sub-dealer-list',
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
            {data: 'name', name: 'name' },            
            {data: 'address', name: 'address',searchable: false, orderable: false},           
            {data: 'user.mobile', name: 'user.mobile', orderable: false},
            {data: 'user.email', name: 'user.email', orderable: false},          
            {data: 'dealer.name', name: 'dealer.name',orderable: false},
            {data: 'working_status', name: 'working_status',orderable: false},        
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });

}

function disableSubDealers(sub_dealer){
    if(confirm('Are you sure want to deactivate this user?')){
        var url = 'sub-dealer/disable';
        var data = {
            id : sub_dealer
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}
function enableSubDealer(sub_dealer){
    if(confirm('Are you sure want to activate this user?')){
        var url = 'sub-dealer/enable';
        var data = {
            id : sub_dealer
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true}); 
    } 
}
