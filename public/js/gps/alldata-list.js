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
            url: 'alldata-list',
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
            {data: 'DT_RowIndex', name: 'DT_Row_Index'},
            {data: 'imei', name: 'imei', },
            {data: 'count', name: 'count'},
            {data: 'device_time', name: 'device_time'},
            {data: 'forhuman', name: 'forhuman'},
             {data: 'created_at', name: 'created_at'},
            {data: 'servertime', name: 'servertime'},
            {data: 'vlt_data', name: 'vlt_data'},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}


