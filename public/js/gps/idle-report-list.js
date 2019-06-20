
$(document).ready(function () {
    callBackDataTable();
});

function check(){

    if(document.getElementById('fromDate').value == ''){
        alert('please enter from date');
    }else if(document.getElementById('toDate').value == ''){
        alert('please enter to date');
    }else{
        // var alert_id=$('#alert').val();
         var client=$('meta[name = "client"]').attr('content');
        var from_date = document.getElementById('fromDate').value;
        var to_date = document.getElementById('toDate').value;
        var data = {'client':client, 'from_date':from_date , 'to_date':to_date};
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
            url: 'idle-report-list',
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
            {data: 'motion', name: 'motion'},
            {data: 'sleep', name: 'sleep'},
            {data: 'halt', name: 'halt'},
            {data: 'ac_on', name: 'ac_on'},
            {data: 'ac_off', name: 'ac_off'},
            {data: 'km', name: 'km'},
            {data: 'device_time', name: 'device_time'},
           
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



