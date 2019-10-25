$(document).ready(function () {
  
    callBackDataTable();
    // viewAlerts(ddata)
});





function callBackDataTable(data=null){
   
    // // var  data = {
    
    // // }; 
    // var flag=read;
    // // alert(flag);

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'alert-list',
            type: 'POST',
            data:data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            },
                createdRow: function ( row, data, index ) {
                if ( data['status'] ==1) {
                    $('td', row).css('background-color', 'rgb(243, 204, 204)');
                }
            },
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'alert_type.description', name: 'alert_type.description', orderable: false, searchable: false},
            {data: 'gps.vehicle.name', name: 'gps.vehicle.name', orderable: false},
            {data: 'gps.vehicle.register_number', name: 'gps.vehicle.register_number', orderable: false},
            // {data: 'location', name: 'location'},
            {data: 'device_time', name: 'device_time', orderable: false},
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





