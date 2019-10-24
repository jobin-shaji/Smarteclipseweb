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
            url: 'subdealer-list',
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
            {data: 'address', name: 'address',orderable: false},           
            {data: 'user.mobile', name: 'user.mobile', orderable: false},
            {data: 'user.email', name: 'user.email',orderable: false},         
            {data: 'action', name: 'action', orderable: false, searchable: false},
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}
function delSubDealers(dealer){
    if(confirm('Are you sure want to deactivate this user?')){
        var url = 'sub-dealer/delete';
        var data = {
            uid : dealer
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}
function activateSubDealer(dealer){
    if(confirm('Are you sure want to activate this user?')){
        var url = 'sub-dealer/activate';
        var data = {
            id : dealer
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}

