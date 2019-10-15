$(document).ready(function () {
    callBackDataTable();

});

function selectGeofence(){
    var vehicle_id=$('#vehicle').val();
    var geofence_id=$('#vehicle_geofence').val(); 
    var alert_type=$('#alert_type').val();        
    var client=$('meta[name = "client"]').attr('content'); 
    // var from_date = document.getElementById('assignfromDate').value;          
    // var to_date = document.getElementById('assignToDate').value;
    var url = 'already/assign-geofence';
     var data = {   
                    'vehicle_id':vehicle_id,
                    'client':client,
                    'geofence_id':geofence_id,
                    'alert_type':alert_type,
                    // 'from_date':from_date, 
                    // 'to_date':to_date
                };       
    backgroundPostData(url,data,'assignGeofenceCount',{alert:true});  
}

function assignGeofenceCount(res)
{
    if(res.assign_geofence_count!=0)
    {
        alert("Already assigned");
    }
    else if(res.assign_geofence_count==0)
    {
        check();
    }

}

function check(){


    if(document.getElementById('vehicle').value == ''){
        alert('please enter vehicle');
    }
    else if(document.getElementById('vehicle_geofence').value == ''){
        alert('please select geofence');
    }
    else if(document.getElementById('alert_type').value == ''){
        alert('please select alert type');
    }
    else{
        var vehicle_id=$('#vehicle').val();
        var geofence_id=$('#vehicle_geofence').val();   
        var alert_type=$('#alert_type').val();      
        var client=$('meta[name = "client"]').attr('content'); 
        //   var from_date = document.getElementById('assignfromDate').value;          
        // var to_date = document.getElementById('assignToDate').value;
        // $to_date = date("Y-m-d", strtotime($toDate));
        var data = { 'vehicle_id':vehicle_id,'client':client,'geofence_id':geofence_id,'alert_type':alert_type};
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
            url: 'assign-geofence-vehicle-list',
            type: 'POST',
             data:data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'vehicle_geofence.name', name: 'vehicle_geofence.name'},
            {data: 'vehicle.name', name: 'vehicle.name'} ,
            {data: 'vehicle.register_number', name: 'vehicle.register_number'} , 
            {data: 'alert', name: 'alert'} , 
            {data: 'action', name: 'action', orderable: false, searchable: false}
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



