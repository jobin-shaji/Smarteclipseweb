$(document).ready(function () {
    callBackDataTable();
});
function selectRoute(){
    // alert(1);
    var vehicle_id=$('#vehicle').val();
    var route_id=$('#vehicle_route').val();        
    var client=$('meta[name = "client"]').attr('content'); 
    var from_date = document.getElementById('fromDate').value;          
    var to_date = document.getElementById('toDate').value;

    var url = 'already/assign-route';
     var data = {   
                    'vehicle_id':vehicle_id,
                    'client':client,
                    'route_id':route_id,
                    'from_date':from_date, 
                    'to_date':to_date
                };       
    backgroundPostData(url,data,'assignRouteCount',{alert:true});  
}

function assignRouteCount(res)
{
    
    if(res.assign_route_count!=0)
    {
        alert("Already assigned");
    }
    else if(res.assign_route_count==0)
    {
        check();
    }

}


function check(){


    if(document.getElementById('vehicle').value == ''){
        alert('please enter vehicle');
    }
    else if(document.getElementById('vehicle_route').value == ''){
        alert('please select Route');
    }
    else{
       
        var vehicle_id=$('#vehicle').val();
        var route_id=$('#vehicle_route').val();        
        var client=$('meta[name = "client"]').attr('content'); 
        var from_date = document.getElementById('fromDate').value;          
        var to_date = document.getElementById('toDate').value;
        // $to_date = date("Y-m-d", strtotime($toDate));
        var data = { 'vehicle_id':vehicle_id,'client':client, 'route_id':route_id, 'from_date':from_date, 'to_date':to_date};
        // console.log(data);
        callBackDataTable(data);
   }
}


 function callBackDataTable(data=null){   
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'assign-route-vehicle-list',
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
            {data: 'vehicle_route.name', name: 'vehicle_route.name'},
            {data: 'vehicle.name', name: 'vehicle.name'} ,
            {data: 'vehicle.register_number', name: 'vehicle.register_number'} ,
            {data: 'date_from', name: 'date_from'} ,
            {data: 'date_to', name: 'date_to'},   
            {data: 'action', name: 'action', orderable: false, searchable: false}
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



