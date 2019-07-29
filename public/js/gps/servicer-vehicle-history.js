$(document).ready(function () {
     var servicer_job_id=$('#servicer_job_id').val();
      var data = {'servicer_job_id':servicer_job_id};
       
    callBackDataTable(data);

});


function create_vehicle(){


    if(document.getElementById('name').value == ''){
        alert('please enter name');
    }
    else if(document.getElementById('register_number').value == ''){
        alert('please select register_number');
    }
    else if(document.getElementById('vehicle_type_id').value == ''){
        alert('please enter vehicle type');
    }
    else if(document.getElementById('gps_id').value == ''){
        alert('please enter gps');
    }
    
    else{
       
        var name=$('#name').val();
         var client_id=$('#client_id').val();
         var servicer_job_id=$('#servicer_job_id').val();

        var register_number=$('#register_number').val(); 
        var vehicle_type_id=$('#vehicle_type_id').val(); 
        var gps_id=$('#gps_id').val(); 
        var data = { 'client_id':client_id,'servicer_job_id':servicer_job_id,'name':name,'register_number':register_number, 'vehicle_type_id':vehicle_type_id, 'gps_id':gps_id};
       
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
            url: 'servicer/vehicles/history',
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
            {data: 'name', name: 'name'},
            {data: 'register_number', name: 'register_number'} ,
            {data: 'gps.name', name: 'gps.name'} ,    
            {data: 'action', name: 'action', orderable: false, searchable: false},       
        ],
        
        // aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



