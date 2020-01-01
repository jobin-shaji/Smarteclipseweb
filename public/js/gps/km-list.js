$(document).ready(function () { 
     $("#loader-1").hide();
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

        $("#loader-1").show();
        backgroundPostData(url,data,'kmReport',{alert:true});
    }
}


function kmReport(res)
{
    $("#loader-1").hide();
    var km =0;
    var sudden_acceleration=res.sudden_acceleration;
    var harsh_braking=res.harsh_braking;
    var main_battery_disconnect=res.main_battery_disconnect;
    var accident_impact=res.accident_impact;
    var over_speed=res.over_speed;
    var zig_zag=res.zig_zag;
    var user_alert=res.user_alert;
    var route_deviation=res.route_deviation;
    var geofence_entry=res.geofence_entry;
    var geofence_exit=res.geofence_exit;
    var geofence_entry_overspeed=res.geofence_entry_overspeed;
    var geofence_exit_overspeed=res.geofence_exit_overspeed;

    if(sudden_acceleration == 0){
        sudden_acceleration = "No alerts";
    }
    if(harsh_braking == 0){
        harsh_braking = "No alerts";
    }
    if(main_battery_disconnect == 0){
        main_battery_disconnect = "No alerts";
    }
    if(accident_impact == 0){
        accident_impact = "No alerts";
    }
    if(over_speed == 0){
        over_speed = "No alerts";
    }
    if(zig_zag == 0){
        zig_zag = "No alerts";
    }
    if(user_alert == 0){
        user_alert = "No alerts";
    }
    if(route_deviation == 0){
        route_deviation = "No alerts";
    }
    if(geofence_entry == 0){
        geofence_entry = "No alerts";
    }
    if(geofence_exit == 0){
        geofence_exit = "No alerts";
    }
    if(geofence_entry_overspeed == 0){
        geofence_entry_overspeed = "No alerts";
    }
    if(geofence_exit_overspeed == 0){
        geofence_exit_overspeed = "No alerts";
    }

    $('#total_km').text(km);
    // $('#speed').text(res.dailykm.gps.speed);
    $('#sleep').text(res.sleep);
    $('#moving').text(res.motion);
    $('#halt').text(res.halt);
    $('#sudden_acceleration').text(sudden_acceleration);
    $('#harsh_braking').text(harsh_braking);
    $('#main_battery_disconnect').text(main_battery_disconnect);
    $('#accident_impact').text(accident_impact);
    $('#overspeed_count').text(over_speed);
    $('#zig_zag').text(zig_zag);
    $('#alerts').text(user_alert);
    $('#route_deviation').text(route_deviation);
    $('#geofence_entry').text(geofence_entry);
    $('#geofence_exit').text(geofence_exit);
    $('#geofence_entry_overspeed').text(geofence_entry_overspeed);
    $('#geofence_exit_overspeed').text(geofence_exit_overspeed);
    $('#engine_on_duration').text(res.engine_on_duration);
    $('#engine_off_duration').text(res.engine_off_duration);
    $('#ac_on_duration').text(res.ac_on_duration);
    $('#ac_off_duration').text(res.ac_off_duration);
    $('#ac_halt_on_duration').text(res.ac_halt_on_duration);
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



