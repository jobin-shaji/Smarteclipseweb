$(document).ready(function () {
    callBackDataTable();
});


function check(){
    if(document.getElementById('vehicle').value == ''){
        alert('please select vehicle');
    }
     else if(document.getElementById('alert').value == ''){
        alert('please select alert');
    }
    else if(document.getElementById('fromDate').value == ''){
        alert('please enter from date');
    }else if(document.getElementById('toDate').value == ''){
        alert('please enter to date');
    }else{
        var alert_id=$('#alert').val();
        var vehicle_id=$('#vehicle').val();        
        var client=$('meta[name = "client"]').attr('content');
        var from_date = document.getElementById('fromDate').value;
        var to_date = document.getElementById('toDate').value;
        var data = { 'alertID':alert_id,'vehicle_id':vehicle_id,'alert_id':alert_id,'client':client, 'from_date':from_date , 'to_date':to_date};
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
            url: '/alert-list',
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
            {data: 'alert_type.description', name: 'alert_type.description'},
            {data: 'vehicle.name', name: 'vehicle.name'},
            {data: 'vehicle.register_number', name: 'vehicle.register_number'},
            // {data: 'location', name: 'location'},
            {data: 'device_time', name: 'device_time'},
            {data: 'action', name: 'action', orderable: false, searchable: false},           
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





