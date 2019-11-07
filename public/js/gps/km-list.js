$(document).ready(function () { 
  
    // var today = new Date();
    // callBackDataTable();
});

function check(){
     
    if(document.getElementById('vehicle').value == ''){
        alert('Please Select Vehicle');
    }
    else if(document.getElementById('report').value == ''){
        alert('Please Select Report Type');
    }
    else{
        // callBackDataTable();
        var url = 'km-report-list';
        var vehicle =document.getElementById('vehicle').value;
        var report_type =document.getElementById('report').value;
        var  data = {
            vehicle : vehicle,
            report_type : report_type          
        }; 
        backgroundPostData(url,data,'kmReport',{alert:true});
    }
}


function kmReport(res)
{
    var km =res.dailykm.km/1000;
    $('#total_km').text(km);
    $('#speed').text(res.dailykm.gps.speed);
    // $('#ig_duration').text(res.dailykm.alerts);
}






// function callBackDataTable(){
//     var vehicle =document.getElementById('vehicle').value;
//     var report_type =document.getElementById('report').value;
//     var  data = {
//         vehicle : vehicle,
//         report_type : report_type
      
//     }; 
//     $("#dataTable").DataTable({
//         bStateSave: true,
//         bDestroy: true,
//         bProcessing: true,
//         serverSide: true,
//         deferRender: true,
//         order: [[1, 'desc']],
//         ajax: {
//             url: 'km-report-list',
//             type: 'POST',
//             data: {
//                 'data': data
//             },
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
//             {data: 'totalkm', name: 'totalkm', orderable: false},
//         ],        
//         aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
//     });
// }



