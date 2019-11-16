$(document).ready(function () { 
});

function check(){
    $('#total_km').empty();
    $('#speed').empty();
    $('#sleep').empty();
    $('#moving').empty();
    $('#halt').empty();
    $('#sudden_acceleration').empty();
    $('#harsh_braking').empty();
    $('#main_battery_disconnect').empty();
    $('#accident_impact').empty();
    $('#overspeed_count').empty();
    $('#zig_zag').empty();
    $('#alerts').empty();
    $('#route_deviation').empty();
    $('#geofence').empty();
    $('#engine_on_duration').empty();
    $('#engine_off_duration').empty();
    $('#ac_on_duration').empty();
    $('#ac_off_duration').empty();
    $('#ac_halt_on_duration').empty();


    $('#geofence_entry').empty();
    $('#geofence_exit').empty();
    $('#geofence_entry_overspeed').empty();
    $('#geofence_exit_overspeed').empty();





    
     
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

    var km =0;
    $('#total_km').text(km);
    $('#speed').text(res.dailykm.gps.speed);
    $('#sleep').text(res.sleep);
    $('#moving').text(res.motion);
    $('#halt').text(res.halt);
    $('#sudden_acceleration').text(res.sudden_acceleration);
    $('#harsh_braking').text(res.harsh_braking);
    $('#main_battery_disconnect').text(res.main_battery_disconnect);
    $('#accident_impact').text(res.accident_impact);
    $('#overspeed_count').text(res.over_speed);
    $('#zig_zag').text(res.zig_zag);
    $('#alerts').text(res.user_alert);
    $('#route_deviation').text(res.route_deviation);
    $('#geofence').text(res.geofence);
    $('#engine_on_duration').text(res.engine_on_duration);
    $('#engine_off_duration').text(res.engine_off_duration);
      $('#ac_on_duration').text(res.ac_on_duration);
    $('#ac_off_duration').text(res.ac_off_duration);
    $('#ac_halt_on_duration').text(res.ac_halt_on_duration);



    $('#geofence_entry').text(res.geofence_entry);
    $('#geofence_exit').text(res.geofence_exit);
    $('#geofence_entry_overspeed').text(res.geofence_entry_overspeed);
    $('#geofence_exit_overspeed').text(res.geofence_exit_overspeed);




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



