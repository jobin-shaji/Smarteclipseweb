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
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'name', name: 'name' },            
            {data: 'address', name: 'address',searchable: false},           
            {data: 'user.mobile', name: 'user.mobile'},
            {data: 'user.email', name: 'user.email',searchable: false},          
            {data: 'dealer.name', name: 'dealer.name',searchable: false},
            {data: 'working_status', name: 'working_status',searchable: false},        
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });

}

function disableSubDealers(sub_dealer){
    var url = 'sub-dealer/disable';
    var data = {
        id : sub_dealer
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}
function enableSubDealer(sub_dealer){
    var url = 'sub-dealer/enable';
    var data = {
        id : sub_dealer
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}
