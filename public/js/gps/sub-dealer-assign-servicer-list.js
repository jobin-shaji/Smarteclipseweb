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
            url: 'sub-dealer-list-assign-servicer',
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
            {data: 'job_id', name: 'job_id'},
            {data: 'servicer.name', name: 'servicer.name', orderable: false},
            {data: 'clients.name', name: 'clients.name', orderable: false},
            {data: 'gps.serial_no', name: 'gps.serial_no', orderable: false},
            {data: 'job_type', name: 'job_type', orderable: false},
            {data: 'description', name: 'description', orderable: false},
            {data: 'job_date', name: 'job_date', orderable: false},   
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



