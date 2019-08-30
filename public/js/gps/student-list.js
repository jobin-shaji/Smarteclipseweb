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
            url: 'student-list',
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
            {data: 'name', name: 'name' },
            {data: 'gender', name: 'gender' },           
            {data: 'class', name: 'class' },
            {data: 'parent_name', name: 'parent_name' },
            {data: 'address', name: 'address',searchable: false},           
            {data: 'mobile', name: 'mobile'},    
            {data: 'email', name: 'email' },  
            {data: 'route_batch.name', name: 'route_batch.name' },
            {data: 'nfc', name: 'nfc' },          
            {data: 'action', name: 'action', orderable: false, searchable: false},
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}
function delStudent(student){
    var url = 'student/delete';
    var data = {
        id : student
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}
function activateStudent(student){
    var url = 'student/activate';
    var data = {
        id : student
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}


