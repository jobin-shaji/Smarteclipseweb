$(document).ready(function () { 
   var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

today = dd + '-' + mm + '-' + yyyy;
    var  data = {
          from_date : today,
          to_date : today
    }; 
    
    // var today = new Date();
    callBackDataTable(data);
});

function check(){
    if(document.getElementById('fromDate').value == ''){
        alert('please enter from date');
    }else if(document.getElementById('toDate').value == ''){
        alert('please enter to date');
    }else{
        

        callBackDataTable();
    }
}

function callBackDataTable(){
    if(document.getElementById('fromDate').value == ''){
         var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        from_date = dd + '-' + mm + '-' + yyyy;
        to_date = dd + '-' + mm + '-' + yyyy;
    }
    else
    {
         from_date =document.getElementById('fromDate').value,
          to_date = document.getElementById('toDate').value
    }
    var  data = {

          from_date : from_date,
          to_date : to_date
        }; 

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'track-report-list',
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



