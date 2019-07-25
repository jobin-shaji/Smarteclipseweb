$(document).ready(function () {
    
    callBackDataTable();

});


function callBackDataTable(){
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
            url: 'vehicle-list',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        createdRow: function ( row, data, index ) {
            if ( data['deleted_at'] ) {
                $('td', row).css('background-color', 'rgb(243, 204, 204)');
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'register_number', name: 'register_number'},
            {data: 'gps.imei', name: 'gps.imei'},
            {data: 'driver.name', name: 'driver.name'},
            {data: 'vehicle_type.name', name: 'vehicle_type.name'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
 }

 function deleteVehicle(vehicle){
    var url = 'vehicle/delete';
    var data = {
        vid : vehicle
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}

 function activateVehicle(vehicle,gps_id){
    var url = 'vehicle/activate';
    var data = {
         id : vehicle,
         gps_id : gps_id
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}





