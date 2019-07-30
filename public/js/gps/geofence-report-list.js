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
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'vehicle.name', name: 'vehicle.name'},
            {data: 'vehicle.register_number', name: 'vehicle.register_number'},
            {data: 'alert.description', name: 'alert.description'},
            {data: 'device_time', name: 'device_time'},

        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



