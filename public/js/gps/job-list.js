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
            url: 'list-jobs',
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
            {data: 'job_id', name: 'job_id'},
          
            // {data: 'servicer.name', name: 'servicer.name'},
            {data: 'clients.name', name: 'clients.name'},
            {data: 'job_type', name: 'job_type'},
            {data: 'user.username', name: 'user.username'},
            {data: 'gps.serial_no', name: 'gps.serial_no'},
            {data: 'description', name: 'description'},
            {data: 'location', name: 'location'},
            {data: 'job_date', name: 'job_date'},   
            {data: 'action', name: 'action', orderable: false, searchable: false}
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



