$(document).ready(function () {
    callBackDataTable();
});

function cancelDeviceReturn(device_return_id){
    if(confirm('Are you sure to cancel this?')){
        var url = '/device-return/cancel';
        var data = {
            id : device_return_id
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true}); 
    } 
}
function callBackDataTable(){
     // var showAdminColumns =  role ==3 ? true:false;

    var  data = {
    
    }; 

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'device-return-list',
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
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'gps.imei', name: 'gps.imei' , orderable: false},
            {data: 'gps.serial_no', name: 'gps.serial_no', orderable: false},
            {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
            {data: 'type_of_issues', name: 'type_of_issues', orderable: false},
            {data: 'comments', name: 'comments', orderable: false},
            {data: 'status', name: 'status', orderable: false},
             {data: 'action', name: 'action', orderable: false, searchable: false},        
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });

}






