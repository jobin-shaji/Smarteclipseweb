$(document).ready(function () {
    callBackDataTable();
});


function check(){
   
      if(document.getElementById('driver').value == ''){
        alert('please select driver');
    }
    else{
        var driver_id=$('#driver').val();       
        var client=$('meta[name = "client"]').attr('content');
        var from_date = document.getElementById('fromDate').value;
        var to_date = document.getElementById('toDate').value;
        var data = {'driver_id':driver_id,'client':client, 'from_date':from_date , 'to_date':to_date};
        callBackDataTable(data);        
    }
}


function callBackDataTable(data){
    // var  data = {
    
    // }; 

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'performance-score-history-list',
            type: 'POST',
            data:data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', searchable: false},
            {data: 'vehicle.name', name: 'vehicle.name'},
            {data: 'vehicle.register_number', name: 'vehicle.register_number', orderable: false},
            {data: 'driver.name', name: 'driver.name', orderable: false},
            {data: 'gps.serial_no', name: 'gps.serial_no', orderable: false},
            {data: 'description', name: 'description', orderable: false},
            {data: 'points', name: 'points', orderable: false},
            {data: 'date', name: 'date', orderable: false},         
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}





