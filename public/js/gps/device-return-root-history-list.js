$(document).ready(function () {
    callBackDataTable();
});

function acceptDeviceReturn(device_return_id){
    if(confirm('Are you sure to accept this?')){
        var url = '/device-return/accept';
        var data = {
            id : device_return_id
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true}); 
      
    } 
    setTimeout(function() {
        document.location.reload()
    }, 5000);
}
function callBackDataTable(){
    var  data = {
    
    }; 

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        //order: [[1, 'desc']],
        ajax: {
            url: 'device-return-root-history-list',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        createdRow: function ( row, data, index ) {
            if ( data['status'] == 'Accepted') {
                $('td', row).css('background-color', 'rgb(48, 197, 137, 0.22)');
            }
        },
        fnDrawCallback: function (oSettings, json) {

        },
        
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'return_code', name: 'return_code', orderable: false},
            {data: 'gps.imei', name: 'gps.imei' , orderable: false},
            {data: 'gps.serial_no', name: 'gps.serial_no' , orderable: false},
            {data: 'servicer.name', name: 'servicer.name', orderable: false},
            {data: 'sub_dealer', name: 'sub_dealer', orderable: false},
            {data: 'dealer', name: 'dealer', orderable: false},
            {data: 'distributor', name: 'distributor', orderable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });

}






