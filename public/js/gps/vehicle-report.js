$(document).ready(function () { 
    $(".loader-1").hide();
});

function check()
{
    $('#total_km').empty();
    $('#speed').empty();
    $('#sleep').empty();
    $('#moving').empty();
    $('#halt').empty();
    $('#stop_duration').empty();
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

    $('#last_updated_time').empty();

     
    if(document.getElementById('vehicle').value == '')
    {
        alert('Please Select Vehicle');
    }
    else if(document.getElementById('report').value == '')
    {
        alert('Please Select Report Type');
    }
    else
    {
        var url             =   'vehicle-report-list';
        var vehicle_id      =   document.getElementById('vehicle').value;
        var report_type     =   document.getElementById('report').value;
        var  data = {
            vehicle_id : vehicle_id,
            report_type : report_type          
        }; 

        $(".loader-1").show();
        backgroundPostData(url,data,'vehicleReport',{alert:true});
         vehicleAlertCount();
    }
}





function vehicleAlertCount(){
    var vehicle_id      =   document.getElementById('vehicle').value;
    var report_type     =   document.getElementById('report').value;
   
    var data = new FormData();
    data.append('vehicle_id', vehicle_id);
    data.append('report_type', report_type);
  
    var url = url_ms_alerts + "/vehicle-alert-count";
    ajaxRequestMs(url,data,'POST',successAlertCount,failedAlert)

}
function successAlertCount(response){



    var sudden_acceleration         =   response.data.sudden_acceleration.alert_count;
    var harsh_braking               =   response.data.harsh_braking.alert_count;
    var main_battery_disconnect     =   response.data.main_battery_disconnect.alert_count;
    var accident_impact             =   response.data.accident_impact.alert_count;
    var over_speed                  =   response.data.overspeed_count.alert_count;
    var zig_zag                     =   response.data.zig_zag_alert.alert_count;
    var user_alert                  =   response.data.total.alert_count;
    var geofence_entry              =   response.data.geofence_entry.alert_count;
    var geofence_exit               =   response.data.geofence_exit.alert_count;
    var geofence_entry_overspeed    =   response.data.geofence_entry_overspeed.alert_count;
    var geofence_exit_overspeed     =   response.data.geofence_exit_overspeed.alert_count;
    if(sudden_acceleration == 0)
    {
        sudden_acceleration         =   "No alerts";
    }
    if(harsh_braking == 0)
    {
        harsh_braking               =   "No alerts";
    }
    if(main_battery_disconnect == 0)
    {
        main_battery_disconnect     =   "No alerts";
    }
    if(accident_impact == 0)
    {
        accident_impact             =   "No alerts";
    }
    if(over_speed == 0)
    {
        over_speed                  =   "No alerts";
    }
    if(zig_zag == 0)
    {
        zig_zag                     =   "No alerts";
    }
    if(user_alert == 0)
    {
        user_alert                  =   "No alerts";
    }
    if(geofence_entry == 0)
    {
        geofence_entry              =   "No alerts";
    }
    if(geofence_exit == 0)
    {
        geofence_exit               =   "No alerts";
    }
    if(geofence_entry_overspeed == 0)
    {
        geofence_entry_overspeed    =   "No alerts";
    }
    if(geofence_exit_overspeed == 0)
    {
        geofence_exit_overspeed     =   "No alerts";
    }
    $('#sudden_acceleration').text(sudden_acceleration);
    $('#harsh_braking').text(harsh_braking);
    $('#main_battery_disconnect').text(main_battery_disconnect);
    $('#accident_impact').text(accident_impact);
    $('#overspeed_count').text(over_speed);
    $('#zig_zag').text(zig_zag);
    $('#alerts').text(user_alert);
    $('#geofence_entry').text(geofence_entry);
    $('#geofence_exit').text(geofence_exit);
    $('#geofence_entry_overspeed').text(geofence_entry_overspeed);
    $('#geofence_exit_overspeed').text(geofence_exit_overspeed);
}
function failedAlert(error)
{

}


function vehicleReport(res)
{
    $(".loader-1").hide();
    var km                          =   res.dailykm;
    var route_deviation             =   res.route_deviation;   
    if(route_deviation == 0)
    {
        route_deviation             =   "No alerts";
    }
   var  last_updated_time           ="Last data received :"+res.last_updated_time;
    $('#total_km').text(km);
    $('#sleep').text(res.sleep);
    $('#moving').text(res.motion);
    $('#halt').text(res.halt);
    $('#stop_duration').text(res.stop_duration);
    $('#route_deviation').text(route_deviation);
    $('#engine_on_duration').text(res.engine_on_duration);
    $('#engine_off_duration').text(res.engine_off_duration);
    $('#ac_on_duration').text(res.ac_on_duration);
    $('#ac_off_duration').text(res.ac_off_duration);
    $('#ac_halt_on_duration').text(res.ac_halt_on_duration);
    $('#last_updated_time').text(last_updated_time);
    
}