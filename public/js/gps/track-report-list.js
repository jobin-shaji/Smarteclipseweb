// $(document).ready(function () { 
//    var today = new Date();
//     var dd = String(today.getDate()).padStart(2, '0');
//     var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
//     var yyyy = today.getFullYear();
//     var vehicle = 0;
//     today = dd + '-' + mm + '-' + yyyy;
//     var  data = {
//           from_date : today,
//           to_date : today,
//            vehicle : vehicle
//     }; 
//     callBackDataTable(data);
// });

// function check(){
//     if(document.getElementById('vehicle').value == ''){
//         alert('please enter vehicle');
//     }
//     // else if(document.getElementById('fromDate').value == ''){
//     //     alert('please enter from date');
//     // }else if(document.getElementById('toDate').value == ''){
//     //     alert('please enter to date');
//     // }
//     else{       
//         var vehicle_id=$('#vehicle').val();
        
//          var client=$('meta[name = "client"]').attr('content');
//         var from_date = document.getElementById('fromDate').value;
//         var to_date = document.getElementById('toDate').value;
//         var data = {'vehicle':vehicle_id,'client':client, 'from_date':from_date , 'to_date':to_date};
//         callBackDataTable(data);       
//     }

// }

// function callBackDataTable(data=null){

//     $("#dataTable").DataTable({
//         bStateSave: true,
//         bDestroy: true,
//         bProcessing: true,
//         serverSide: true,
//         deferRender: true,
//         order: [[1, 'desc']],
//         ajax: {
//             url: 'track-report-list',
//             type: 'POST',
//             data:data,
//             headers: {
//                 'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
//             }
//         },       
//         fnDrawCallback: function (oSettings, json) {
//         },
//         columns: [
//             {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: true, searchable: false},
//             {data: 'gps.vehicle.name', name: 'gps.vehicle.name', orderable: false},
//             {data: 'gps.vehicle.register_number', name: 'gps.vehicle.register_number', orderable: false},
//             {data: 'motion', name: 'motion', orderable: false},
//             {data: 'sleep', name: 'sleep', orderable: false},
//             {data: 'halt', name: 'halt', orderable: false},
//             {data: 'ac_on', name: 'ac_on', orderable: false},
//             {data: 'ac_off', name: 'ac_off', orderable: false},
//             {data: 'km', name: 'km', orderable: false},
//             {data: 'device_time', name: 'device_time', orderable: false},
//         ],        
//         aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
//     });
// }


//updated all aaaaa

function trackMode()
{  
     if(document.getElementById('vehicle').value == ''){
        alert('please enter vehicle');
    }
  
    else{       
        var vehicle_id=$('#vehicle').val();       
        var client=$('meta[name = "client"]').attr('content');
        var from_date = document.getElementById('fromDate').value;
        console.log(from_date);
        var to_date = document.getElementById('toDate').value;
        var data = {'vehicle':vehicle_id,'client':client, 'from_date':from_date , 'to_date':to_date};
        var url = '/track-report-list';
        var data = {
            'vehicle':vehicle_id,
            'client':client, 
            'from_date':from_date , 
            'to_date':to_date
        };
        backgroundPostData(url,data,'vehicleTrackReport',{alert:true});
           
    }

   
}
function vehicleTrackReport(res){
    
    $('#sl').text("1");
      
      $('#sleep').text(res.sleep);
        $('#motion').text(res.motion);
          $('#halt').text(res.halt);
     
        
  }

