// $(document).ready(function () {
//     callBackDataTable();
// });


function check()
{
    if(document.getElementById('client').value == ''){
        alert('please select client');
    }else if(document.getElementById('servicer').value == ''){
        alert('please select servicer');
    }
    else if(document.getElementById('fromDate').value == ''){
        alert('please select From date');
    }else if(document.getElementById('toDate').value == ''){
        alert('please select To date');
    }else{
        var client_id = document.getElementById('client').value;
        var servicer_id = document.getElementById('servicer').value;
        var from_date = document.getElementById('fromDate').value;
        var to_date = document.getElementById('toDate').value;
        var data = {'client_id':client_id , 'servicer_id':servicer_id , 'from_date':from_date , 'to_date':to_date};
        callBackDataTable(data);
    }
       
}

function callBackDataTable(data){  
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'device-installation-report-list',
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
            {data: 'job_type', name: 'job_type', orderable: false},
            {data: 'servicer.name', name: 'servicer.name'},
            {data: 'gps.serial_no', name: 'gps.serial_no', orderable: false},
            {data: 'description', name: 'description', orderable: false},
            {data: 'location', name: 'location', orderable: false},
            {data: 'job_complete_date', name: 'job_complete_date', orderable: false},   
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

