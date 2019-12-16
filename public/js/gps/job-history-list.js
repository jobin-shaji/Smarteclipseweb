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
            url: 'list-history-jobs',
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
            {data: 'job_id', name: 'job_id', orderable: false},         
            {data: 'clients.name', name: 'clients.name', orderable: false},
            {data: 'vehicle.register_number', name: 'vehicle.register_number'},
            {data: 'job_type', name: 'job_type', orderable: false},
            {data: 'user.username', name: 'user.username', orderable: false},
            {data: 'gps.serial_no', name: 'gps.serial_no', orderable: false},
            {data: 'description', name: 'description', orderable: false},
            {data: 'location', name: 'location', orderable: false},
            {data: 'job_date', name: 'job_date', orderable: false},   
            {data: 'action', name: 'action', orderable: false, searchable: false}
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



