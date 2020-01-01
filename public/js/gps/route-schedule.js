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
            url: 'route-schedule-list',
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
            {data: 'route_batch.name', name: 'route_batch.name' }, 
            {data: 'route.name', name: 'route.name' }, 
            {data: 'vehicle.register_number', name: 'vehicle.register_number' }, 
            {data: 'driver.name', name: 'driver.name' }, 
            {data: 'helper.helper_code', name: 'helper.helper_code' }, 
            {data: 'helper.name', name: 'helper.name' }, 
            {data: 'action', name: 'action', orderable: false, searchable: false},
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}
function deleteScheduleRoute(scheduled_route_id){
    var url = 'route/schedule-delete';
    var data = {
        uid : scheduled_route_id
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}
function activateScheduleRoute(scheduled_route_id){
    var url = 'route/schedule-activate';
    var data = {
        id : scheduled_route_id
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}

$('.route_batch').on('change', function() {
    var routeBatchID=this.value;
    var data = { routeBatchID : routeBatchID };
    $.ajax({
        type:'POST',
        url: '/route/route-batch',
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
          var route_id=res.route_batch.route_id;
          var route_name=res.route_batch.route.name;
          $(".route_id").val(route_id); 
          $(".route_name").val(route_name); 
        }
    });
});

$('.vehicle_id').on('change', function() {
    var vehicleID=this.value;
    var data = { vehicleID : vehicleID };
    $.ajax({
        type:'POST',
        url: '/route/vehicle-driver',
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
          var driver_id=res.vehicle.driver_id;
          var driver_name=res.vehicle.driver.name;
          $(".driver_id").val(driver_id); 
          $(".driver_name").val(driver_name); 
        }
    });
});