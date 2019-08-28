$(document).ready(function () {
    callBackDataTable();
});


function callBackDataTable(){
    
    // var  data = {
    //     gps : value    
    // }; 
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'vltdata-list',
            type: 'POST',
            // data: data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },             
        fnDrawCallback: function (oSettings, json) {
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index'},
            {data: 'vltdata', name: 'vltdata', orderable: false, searchable: true},
            {data: 'created_at', name: 'created_at' ,orderable: true, searchable: false},
            {data: 'forhuman', name: 'forhuman' ,orderable: false, searchable: false},
            {data: 'action', name: 'action' ,orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}


