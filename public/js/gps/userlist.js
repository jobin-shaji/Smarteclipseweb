$(document).ready(function () {
    callBackDataTable();    
});


function callBackDataTable(){

    var  data = {
    
    }; 

  var dtb =  $("#dataTable").DataTable({

        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'user-list',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'username', name: 'username'},
            {data: 'email', name: 'email'},
            {data: 'mobile', name: 'mobile'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });

}

function delUser(user){
    var url = 'users/delete';
    var data = {
        uid : user
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}
