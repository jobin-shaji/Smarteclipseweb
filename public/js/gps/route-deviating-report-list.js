$(document).ready(function () {
    callBackDataTable();
});
function check(){
    if(document.getElementById('vehicle').value == ''){
        alert('please select vehicle');
    }
    // else if(document.getElementById('fromDate').value == ''){
    //     alert('please enter from date');
    // }else if(document.getElementById('toDate').value == ''){
    //     alert('please enter to date');
    // }
    else{
        callBackDataTable();
    }
}

function callBackDataTable(){
    var  data = {
          from_date : document.getElementById('fromDate').value,
          to_date : document.getElementById('toDate').value,
          vehicle : document.getElementById('vehicle').value,
    }; 


    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'route-deviation-report-list',
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
            {data: 'vehicle.name', name: 'vehicle.name'},
            {data: 'vehicle.register_number', name: 'vehicle.register_number'},
            {data: 'route.name', name: 'route.name'},
            {data: 'location', name: 'location'},
            {data: 'deviating_time', name: 'deviating_time'},

        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



