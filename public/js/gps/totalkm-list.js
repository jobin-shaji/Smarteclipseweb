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
     
     if(document.getElementById('vehicle').value == ''){
        alert('Please Select Vehicle');
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
    var vehicle =document.getElementById('vehicle').value;
    var from_date =document.getElementById('fromDate').value;
    var to_date = document.getElementById('toDate').value;
    var  data = {
        vehicle : vehicle,
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
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: true, searchable: false},
            {data: 'gps.vehicle.name', name: 'gps.vehicle.name', orderable: false},
            {data: 'gps.vehicle.register_number', name: 'gps.vehicle.register_number', orderable: false},
            {data: 'km', name: 'km', orderable: false},
        ],        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



