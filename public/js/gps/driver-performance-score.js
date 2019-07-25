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


function callBackDataTable(data=null){
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
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            
            {data: 'vehicle.name', name: 'vehicle.name'},
            {data: 'vehicle.register_number', name: 'vehicle.register_number'},
            {data: 'driver.name', name: 'driver.name'},
            {data: 'gps.imei', name: 'gps.imei'},
            {data: 'description', name: 'description'},
            
            {data: 'points', name: 'points'},
            // {data: 'location', name: 'location'},
            {data: 'created_at', name: 'created_at'},
            // {data: 'action', name: 'action', orderable: false, searchable: false},           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

function VerifyAlert(alert_id){
    if(confirm('Are you sure want to verify this alert?')){
        var url = 'alert/verify';
        var data = {
        id : alert_id
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true}); 
    } 
}





