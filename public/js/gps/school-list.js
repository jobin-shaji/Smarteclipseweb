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
            url: 'school-list',
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
            {data: 'mobile', name: 'mobile'},             
            {data: 'action', name: 'action', orderable: false, searchable: false},
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}
function delSchool(school){
    var url = 'school/delete';
    var data = {
        uid : school
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}
function activateSchool(school){
    var url = 'school/activate';
    var data = {
        id : school
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}

