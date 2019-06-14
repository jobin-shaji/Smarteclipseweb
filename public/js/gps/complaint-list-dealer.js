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
            url: 'complaint-list',
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
            {data: 'gps.name', name: 'gps.name'},
            {data: 'gps.imei', name: 'gps.imei'},
            {data: 'complaint_type.name', name: 'complaint_type.name'},
            {data: 'discription', name: 'discription'},
            {data: 'created_at', name: 'created_at'},
            {data: 'status', name: 'status'},   
            {data: 'sub_dealer', name: 'sub_dealer'},
            {data: 'client.name', name: 'client.name'},   
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}







