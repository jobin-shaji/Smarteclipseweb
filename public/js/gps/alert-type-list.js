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
            url: 'alert-types-list',
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
            {data: 'code', name: 'code' },            
            {data: 'description', name: 'description',searchable: false},                      
            {data: 'action', name: 'action', orderable: false, searchable: false},           
        ],        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}
function delAlertType(alert_type){
    var url = 'alert-type/delete';
    var data = {
        uid : alert_type
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}
function activateAlertType(alert_type){
    var url = 'alert-type/activate';
    var data = {
        id : alert_type
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}

