$(document).ready(function () {

    callBackDataTable();
});
 
function check(){
     if(document.getElementById('vehicle').value == ''){
        alert('please select Vehicle');
    }
    // else if(document.getElementById('fromDate').value == ''){
    //     alert('please enter from date');
    // }else if(document.getElementById('toDate').value == ''){
    //     alert('please enter to date');
    // }
    else{
         var client=$('meta[name = "client"]').attr('content');
        var from_date = document.getElementById('fromDate').value;
        var to_date = document.getElementById('toDate').value;
        var vehicle = document.getElementById('vehicle').value;
        var data = {'client':client,'vehicle':vehicle, 'from_date':from_date , 'to_date':to_date};
        callBackDataTable(data);
       
    }
}

function callBackDataTable(data=null){
    

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'geofence-report-list',
            type: 'POST',
            data:data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {
            

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: true, searchable: false},
            {data: 'gps.vehicle.name', name: 'gps.vehicle.name', orderable: false},
            {data: 'gps.vehicle.register_number', name: 'gps.vehicle.register_number', orderable: false},
            {data: 'alert.description', name: 'alert.description', orderable: false},
            {data: 'device_time', name: 'device_time', orderable: false},

        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



