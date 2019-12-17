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
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'job_id', name: 'job_id', orderable: false, searchable: false},
            {data: 'servicer.name', name: 'servicer.name', orderable: false, searchable: false},
            {data: 'clients.name', name: 'clients.name', orderable: false, searchable: false},
            {data: 'gps.serial_no', name: 'gps.serial_no', orderable: false, searchable: false},
            {data: 'job_type', name: 'job_type', orderable: false, searchable: false},
            {data: 'description', name: 'description', orderable: false, searchable: false},
            {data: 'job_date', name: 'job_date', orderable: false, searchable: false},   
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



