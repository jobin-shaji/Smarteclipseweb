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
            url: 'monitor-list',
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
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'name', name: 'name',orderable: false},
            {data: 'register_number', name: 'register_number',orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        
        aLengthMenu: [[50, 100, 100, 'All']]
    });
 }






