$(document).ready(function () {
    callBackDataTable();

});


function check(){


    if(document.getElementById('vehicle').value == ''){
        alert('please enter vehicle');
    }
    else if(document.getElementById('vehicle_geofence').value == ''){
        alert('please select Geofence');
    }
    else{
       
        var vehicle_id=$('#vehicle').val();
        var geofence_id=$('#vehicle_geofence').val();        
        var client=$('meta[name = "client"]').attr('content'); 
          var from_date = document.getElementById('fromDate').value;          
        var to_date = document.getElementById('toDate').value;
        // $to_date = date("Y-m-d", strtotime($toDate));
        var data = { 'vehicle_id':vehicle_id,'client':client, 'geofence_id':geofence_id, 'from_date':from_date, 'to_date':to_date};
        // console.log(data);
        callBackDataTable(data);
   }
}




 function callBackDataTable(data=null){   

 // var data = {
 //        client: $('meta[name = "client"]').attr('content'),
 //       vehicle_id : document.getElementById('vehicle').value,
 //        route_id : document.getElementById('vehicle_route').value,
 //         from_date : document.getElementById('fromDate').value,
 //        to_date : document.getElementById('toDate').value,
        
 //    };   
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: '/assign-geofence-vehicle-list',
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
            {data: 'vehicle_geofence.name', name: 'vehicle_geofence.name'},
            {data: 'vehicle.name', name: 'vehicle.name'} ,
            {data: 'vehicle.register_number', name: 'vehicle.register_number'} ,
            {data: 'date_from', name: 'date_from'} ,
            {data: 'date_to', name: 'date_to'},   

             {data: 'action', name: 'action', orderable: false, searchable: false}
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



