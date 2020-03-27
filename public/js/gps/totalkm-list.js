$(document).ready(function () { 
    // document.getElementById('excel').style.visibility = 'hidden';
//    var today = new Date();
//     var dd = String(today.getDate()).padStart(2, '0');
//     var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
//     var yyyy = today.getFullYear();

// today = dd + '-' + mm + '-' + yyyy;
//     var  data = {
//           from_date : today,
//           to_date : today
//     }; 
    
    // var today = new Date();
    callBackDataTable();
});

function check()
{
    if(document.getElementById('vehicle').value == '')
    {
        alert('Please Select Vehicle');
    }
    else{
        callBackDataTable();
    }
}
function callBackDataTable()
{
    var vehicle_id  =   document.getElementById('vehicle').value;
    var  data       =   { vehicle_id : vehicle_id }; 
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'totalkm-report-list',
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
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false},
            {data: 'vehicle_name', name: 'vehicle_name', orderable: false},
            {data: 'vehicle_register_number', name: 'vehicle_register_number', orderable: false},
            {data: 'totalkm', name: 'totalkm', orderable: false},
        ],        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



