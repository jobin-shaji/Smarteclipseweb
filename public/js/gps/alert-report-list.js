
$(document).ready(function () {
    callBackDataTable();
});

function check(){
    if(document.getElementById('vehicle').value == ''){
        alert('please enter vehicle');
    }
    // else if(document.getElementById('fromDate').value == ''){
    //     alert('please enter from date');
    // }else if(document.getElementById('toDate').value == ''){
    //     alert('please enter to date');
    // }
    else{
        var alert_id=$('#alert').val();
        var vehicle_id=$('#vehicle').val();
        
        var client=$('meta[name = "client"]').attr('content');
        var from_date = document.getElementById('alert_fromDate').value;
        var to_date = document.getElementById('alert_toDate').value;
        var data = { 'alertID':alert_id,'vehicle_id':vehicle_id,'client':client, 'from_date':from_date , 'to_date':to_date};
        callBackDataTable(data);
        //      var  data = {
        //     client : $('meta[name = "client"]').attr('content'),
        //     from_date : document.getElementById('fromDate').value,
        //     to_date : document.getElementById('toDate').value,
        // };      
            // callBackDataTable(data);
    }
}
 $('#alert').on('change', function() {
    check();
 });

function callBackDataTable(data=null){
     

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'alert-report-list',
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
            {data: 'gps.vehicle.register_number', name: 'gps.vehicle.register_number'},
                   
            {data: 'alert_type.description', name: 'alert_type.description', searchable: false},
            // {data: 'location', name: 'location'},
            {data: 'device_time', name: 'device_time'},
             {data: 'action', name: 'action', orderable: false, searchable: false}
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



function refresh(){
    if(document.getElementById('fromDate').value == '' || document.getElementById('toDate').value == ''){
        callBackDataTable();
    }
    else{                      
    var from_date = document.getElementById('fromDate').value;
    var to_date = document.getElementById('toDate').value;
    var data = { 'agent':agent,'depot':depot, 'from_date':from_date , 'to_date':to_date};
    callBackDataTable(data);
    }   
}






