$(document).ready(function () {
    callBackDataTable();
});

function callBackDataTable(data=null){
    // var  data = {
    
    // }; 

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: '/data-usage-list',
            type: 'POST',
            data:data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'gps.name', name: 'gps.name'},
            {data: 'gps.imei', name: 'gps.imei'},
            {data: 'gps.manufacturing_date', name: 'gps.manufacturing_date'},
            {data: 'gps.date_tme', name: 'gps.date_tme'}          
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}







