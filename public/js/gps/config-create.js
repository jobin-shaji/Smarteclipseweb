$(document).ready(function () {
 
});
 



function getConfiguration(data,name,version)
{
  // alert(name);
  console.log(data);
  $('#myModal').modal('show');
  $('#name').empty();
  $('#version').empty();
  $('#config').empty();
  var freebies=data.configuration;
  var ac_status=freebies.ac_status;
  var anti_theft_mode=freebies.anti_theft_mode;
  var api_access=freebies.api_access;
  var client_domain=freebies.client_domain;
  var client_logo=freebies.client_logo;
  var custom_feature=freebies.custom_feature;
  var daily_report_as_sms=freebies.daily_report_as_sms;
  var daily_report_summary_to_reg_mail=freebies.daily_report_summary_to_reg_mail;
  var database_backup=freebies.database_backup;
  var driver_score=freebies.driver_score;
  var emergency_alerts=freebies.emergency_alerts;
  var fuel=freebies.fuel;
  var geofence_count=freebies.geofence_count;
  var immobilizer=freebies.immobilizer;
  var invoice=freebies.invoice;
  var mobile_application=freebies.mobile_application;
  var modify_design=freebies.modify_design;
  var point_of_interest=freebies.point_of_interest;
  var privillaged_support=freebies.privillaged_support;
  var radar=freebies.radar;
  
  var route_deviation_count=freebies.route_deviation_count;
  var route_playback_history_month=freebies.route_playback_history_month;
  var share_in_web_app=freebies.share_in_web_app;
  var towing_alert=freebies.towing_alert;
  var white_list=freebies.white_list;
    if(ac_status===true){
      ac_input="<input type='checkbox' id='ac_status' name='ac_status' value='true' checked='checked'>";
    }
    else{
        ac_input="<input type='checkbox' id='ac_status' name='ac_status' value='true' >";
    }
    if(anti_theft_mode===true){
      theft_input="<input type='checkbox' id='anti_theft_mode' name='anti_theft_mode' value='true' checked>";
    }
    else{
        theft_input="<input type='checkbox' id='anti_theft_mode' name='anti_theft_mode' value='true'>";
    }
    if(api_access===true){
      api_access_input="<input type='checkbox' id='api_access' name='api_access' value='true' checked>";
    }
    else{
        api_access_input="<input type='checkbox' id='api_access' name='api_access' value='true'>";
    }
    if(client_domain===true){
      client_domain_input="<input type='checkbox' id='client_domain' name='client_domain' value='true' checked>";
    }
    else{
        client_domain_input="<input type='checkbox' id='client_domain' name='client_domain' value='true'>";
    }
    if(client_logo===true){
      client_logo_input="<input type='checkbox' id='client_logo' name='client_logo'  value='true' checked>";
    }
    else{
        client_logo_input="<input type='checkbox' id='client_logo' name='client_logo' value='true'>";
    }
    if(custom_feature===true){
      custom_feature_input="<input type='checkbox' id='custom_feature' name='custom_feature' value='true' checked>";
    }
    else{
        custom_feature_input="<input type='checkbox' id='custom_feature' name='custom_feature' value='true'>";
    }
    if(daily_report_as_sms===true){
      daily_report_as_sms_input="<input type='checkbox' id='daily_report_as_sms' name='daily_report_as_sms' value='true' checked>";
    }
    else{
        daily_report_as_sms_input="<input type='checkbox' id='daily_report_as_sms' name='daily_report_as_sms' value='true'>";
    }
    if(daily_report_summary_to_reg_mail===true){
      daily_report_summary_to_reg_mail_input="<input type='checkbox' id='daily_report_summary_to_reg_mail' value='true' name='daily_report_summary_to_reg_mail' checked>";
    }
    else{
        daily_report_summary_to_reg_mail_input="<input type='checkbox' id='daily_report_summary_to_reg_mail' name='daily_report_summary_to_reg_mail' value='true'>";
    }
    if(database_backup===true){
      database_backup_input="<input type='checkbox' id='database_backup' name='database_backup' value='true' checked>";
    }
    else{
        database_backup_input="<input type='checkbox' id='database_backup' name='database_backup' value='true'>";
    }
    if(driver_score===true){
      driver_score_input="<input type='checkbox' id='driver_score' name='driver_score' value='true' checked>";
    }
    else{
        driver_score_input="<input type='checkbox' id='driver_score' name='driver_score' value='true'>";
    }

    if(emergency_alerts===true){
      emergency_alerts_input="<input type='checkbox' id='emergency_alerts' name='emergency_alerts' value='true' checked>";
    }
    else{
        emergency_alerts_input="<input type='checkbox' id='emergency_alerts' name='emergency_alerts' value='true'>";
    }
    if(fuel===true){
      fuel_input="<input type='checkbox' id='fuel' name='fuel' value='true' checked>";
    }
    else{
        fuel_input="<input type='checkbox' id='fuel' name='fuel' value='true'>";
    }
    if(geofence_count){
      geofence_count_input="<input type='text' id='geofence_count' name='geofence_count' value='"+geofence_count+"'>";
    }
 
    if(immobilizer===true){
      immobilizer_input="<input type='checkbox' id='immobilizer' name='immobilizer' value='true' checked>";
    }
    else{
        immobilizer_input="<input type='checkbox' id='immobilizer' name='immobilizer' value='true'>";
    }
    if(invoice===true){
      invoice_input="<input type='checkbox' id='invoice' name='invoice' value='true' checked>";
    }
    else{
        invoice_input="<input type='checkbox' id='invoice' name='invoice' value='true'>";
    }
    if(mobile_application===true){
      mobile_application_input="<input type='checkbox' id='mobile_application' name='mobile_application' value='true' checked>";
    }
    else{
        mobile_application_input="<input type='checkbox' id='mobile_application' name='mobile_application' value='true'>";
    }

     if(modify_design===true){
      modify_design_input="<input type='checkbox' id='modify_design' name='modify_design' value='true' checked>";
    }
    else{
        modify_design_input="<input type='checkbox' id='modify_design' name='modify_design' value='true'>";
    }
     
     if(point_of_interest===true){
      point_of_interest="<input type='checkbox' id='point_of_interest' name='point_of_interest' value='true' checked>";
    }
    else{
        point_of_interest="<input type='checkbox' id='point_of_interest' name='point_of_interest' value='true'>";
    }
    if(privillaged_support===true){
      privillaged_support="<input type='checkbox' id='privillaged_support' name='privillaged_support' value='true' checked>";
    }
    else{
        privillaged_support="<input type='checkbox' id='privillaged_support' name='privillaged_support' value='true' >";
    }

    if(radar===true){
      radar="<input type='checkbox' id='radar' name='radar' value='true' checked>";
    }
    else{
        radar="<input type='checkbox' id='radar' name='radar' value='true'>";
    }

    if(route_deviation_count){
      route_deviation_count="<input type='text' id='route_deviation_count' name='route_deviation_count' value='"+route_deviation_count+"'>";
    }
   
    if(share_in_web_app===true){
      share_in_web_app="<input type='checkbox' id='share_in_web_app' name='share_in_web_app' value='true' checked>";
    }
    else{
        share_in_web_app="<input type='checkbox' id='share_in_web_app' name='share_in_web_app' value='true'>";
    }
    if(towing_alert===true){
      towing_alert="<input type='checkbox' id='towing_alert' name='towing_alert' value='true' checked>";
    }
    else{
        towing_alert="<input type='checkbox' id='towing_alert' name='towing_alert' value='true'>";
    }
    if(white_list===true){
      white_list="<input type='checkbox' id='white_list' name='white_list' value='true' checked>";
    }
    else{
        white_list="<input type='checkbox' id='white_list' name='white_list' value='true'>";
    }
    if(route_playback_history_month){
      route_playback_history_month="<input type='text' id='route_playback_history_month' name='route_playback_history_month' value='"+route_playback_history_month+"'>";
    }
   
    var plan='<tr><td>Ac Status</td><td>'+ac_input+'</td></tr>'+
            '<tr><td>Theft Mode</td><td >'+theft_input+'</td></tr>'+
            '<tr><td> Api Access</td><td>'+api_access_input+'</td></tr>'+
            '<tr><td>Packet Status</td><td>'+client_domain_input+'</td></tr>'+
            '<tr><td>Client Domain</td><td>'+client_logo_input+'</td></tr>'+
            '<tr><td>Custom Feature</td><td>'+custom_feature_input+'</td></tr>'+
            '<tr><td>Daily Report as sms </td><td>'+daily_report_as_sms_input+'</td></tr>'+
            '<tr><td>Daily Report Summary to reg email</td><td>'+daily_report_summary_to_reg_mail_input+'</td></tr>'+
            '<tr><td> Database Backup</td><td>'+database_backup_input+'</td></tr>'+
            '<tr><td>Driver Score </td><td>'+driver_score_input+'</td></tr>'+
            '<tr><td>Employee Alerts </td><td>'+emergency_alerts_input+'</td></tr>'+
            '<tr><td>Fuel </td><td>'+fuel_input+'</td></tr>'+
            '<tr><td>Geofence Count </td><td>'+geofence_count_input+'</td></tr>'+
            '<tr><td>Immobilizer</td><td>'+immobilizer_input+'</td></tr>'+
            '<tr><td>Invoice</td><td>'+invoice_input+'</td></tr>'+
            '<tr><td>Mobile Application</td><td>'+mobile_application_input+'</td></tr>'+
            '<tr><td>Modify Design</td><td>'+modify_design_input+'</td></tr>'+
            '<tr><td>Point of interest</td><td>'+point_of_interest+'</td></tr>'+        
            '<tr><td>Privillaged support</td><td>'+privillaged_support+'</td></tr>'+
            '<tr><td>Radar</td><td>'+radar+'</td></tr>'+
            '<tr><td>Route Deviation Count</td><td>'+route_deviation_count+'</td></tr>'+
            '<tr><td>Share in web app</td><td>'+share_in_web_app+'</td></tr>'+
            '<tr><td>Towing Alert</td><td>'+towing_alert+'</td></tr>'+
            '<tr><td>White List</td><td>'+white_list+'</td></tr>'+
            '<tr><td>Route Play Back Month</td><td>'+route_playback_history_month+'</td></tr>';  
            // console.log(plan);
        $("#config").append(plan);
        $('#plan_id').val(name);
        $('#plan_name').val(data.type);


        // $('#version').val(version);
        
        var url = 'get-config-data';
        var data = {
          name:data.type
        };   
        backgroundPostData(url,data,'getConfigData',{alert:false});   
}

//
function getConfigData(res)
{
  console.log(res);
$('#version').val(res.version.version);
}
