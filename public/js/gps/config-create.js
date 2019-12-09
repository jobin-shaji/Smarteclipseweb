$(document).ready(function () {
 
});
 
function plan(id){

  $('#myModal').modal('show');
  $('#plan_id').val(id);
  $('#name').empty();
  $('#code').empty();
  $('#config').empty();
    var url = 'get-config-data';
    var data = {
       id:id
    };   
    backgroundPostData(url,data,'getConfigData',{alert:false});           
  }
//
function getConfigData(res)
{
  var plan_id=$('#plan_id').val();
  $('#name').val(res.config.name);
  $('#code').val(res.config.code);
    var values=res.config.value;
    if(plan_id==1)
    {
      var freebies=JSON.parse(values).freebies;
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
       // $('#config').val();
    }
    if(plan_id==2)
    {
      var fundamental=JSON.parse(values).fundamental;
      var ac_status=fundamental.ac_status;
      var anti_theft_mode=fundamental.anti_theft_mode;
      var api_access=fundamental.api_access;
      var client_domain=fundamental.client_domain;
      var client_logo=fundamental.client_logo;
      var custom_feature=fundamental.custom_feature;
      var daily_report_as_sms=fundamental.daily_report_as_sms;
      var daily_report_summary_to_reg_mail=fundamental.daily_report_summary_to_reg_mail;
      var database_backup=fundamental.database_backup;
      var driver_score=fundamental.driver_score;
      var emergency_alerts=fundamental.emergency_alerts;
      var fuel=fundamental.fuel;
      var geofence_count=fundamental.geofence_count;
      var immobilizer=fundamental.immobilizer;
      var invoice=fundamental.invoice;
      var mobile_application=fundamental.mobile_application;
      var modify_design=fundamental.modify_design;
      var point_of_interest=fundamental.point_of_interest;
      var privillaged_support=fundamental.privillaged_support;
      var radar=fundamental.radar;
      var route_deviation_count=fundamental.route_deviation_count;
      var route_playback_history_month=fundamental.route_playback_history_month;
      var share_in_web_app=fundamental.share_in_web_app;
      var towing_alert=fundamental.towing_alert;
      var white_list=fundamental.white_list;
     
    }
    if(plan_id==3)
    {
       var superior=JSON.parse(values).superior;
       var ac_status=superior.ac_status;
      var anti_theft_mode=superior.anti_theft_mode;
      var api_access=superior.api_access;
      var client_domain=superior.client_domain;
      var client_logo=superior.client_logo;
      var custom_feature=superior.custom_feature;
      var daily_report_as_sms=superior.daily_report_as_sms;
      var daily_report_summary_to_reg_mail=superior.daily_report_summary_to_reg_mail;
      var database_backup=superior.database_backup;
      var driver_score=superior.driver_score;
      var emergency_alerts=superior.emergency_alerts;
      var fuel=superior.fuel;
      var geofence_count=superior.geofence_count;
      var immobilizer=superior.immobilizer;
      var invoice=superior.invoice;
      var mobile_application=superior.mobile_application;
      var modify_design=superior.modify_design;
      var point_of_interest=superior.point_of_interest;
      var privillaged_support=superior.privillaged_support;
      var radar=superior.radar;
      var route_deviation_count=superior.route_deviation_count;
      var route_playback_history_month=superior.route_playback_history_month;
      var share_in_web_app=superior.share_in_web_app;
      var towing_alert=superior.towing_alert;
      var white_list=superior.white_list;
    }
    if(plan_id==4)
    {
       var pro=JSON.parse(values).pro;
       var ac_status=pro.ac_status;
      var anti_theft_mode=pro.anti_theft_mode;
      var api_access=pro.api_access;
      var client_domain=pro.client_domain;
      var client_logo=pro.client_logo;
      var custom_feature=pro.custom_feature;
      var daily_report_as_sms=pro.daily_report_as_sms;
      var daily_report_summary_to_reg_mail=pro.daily_report_summary_to_reg_mail;
      var database_backup=pro.database_backup;
      var driver_score=pro.driver_score;
      var emergency_alerts=pro.emergency_alerts;
      var fuel=pro.fuel;
      var geofence_count=pro.geofence_count;
      var immobilizer=pro.immobilizer;
      var invoice=pro.invoice;
      var mobile_application=pro.mobile_application;
      var modify_design=pro.modify_design;
      var point_of_interest=pro.point_of_interest;
      var privillaged_support=pro.privillaged_support;
      var radar=pro.radar;
      var route_deviation_count=pro.route_deviation_count;
      var route_playback_history_month=pro.route_playback_history_month;
      var share_in_web_app=pro.share_in_web_app;
      var towing_alert=pro.towing_alert;
      var white_list=pro.white_list;
       
    }
    if(ac_status==true){
      ac_input="<input type='checkbox' id='ac_status' name='ac_status' checked>";
    }
    else{
        ac_input="<input type='checkbox' id='ac_status' name='ac_status'>";
    }
    if(anti_theft_mode==true){
      theft_input="<input type='checkbox' id='anti_theft_mode' name='anti_theft_mode' checked>";
    }
    else{
        theft_input="<input type='checkbox' id='anti_theft_mode' name='anti_theft_mode'>";
    }
    if(api_access==true){
      api_access_input="<input type='checkbox' id='api_access' name='api_access' checked>";
    }
    else{
        api_access_input="<input type='checkbox' id='api_access' name='api_access'>";
    }
    if(client_domain==true){
      client_domain_input="<input type='checkbox' id='client_domain' name='client_domain' checked>";
    }
    else{
        client_domain_input="<input type='checkbox' id='client_domain' name='client_domain'>";
    }
    if(client_logo==true){
      client_logo_input="<input type='checkbox' id='client_logo' name='client_logo' checked>";
    }
    else{
        client_logo_input="<input type='checkbox' id='client_logo' name='client_logo'>";
    }
    if(custom_feature==true){
      custom_feature_input="<input type='checkbox' id='custom_feature' name='custom_feature' checked>";
    }
    else{
        custom_feature_input="<input type='checkbox' id='custom_feature' name='custom_feature'>";
    }
    if(daily_report_as_sms==true){
      daily_report_as_sms_input="<input type='checkbox' id='daily_report_as_sms' name='daily_report_as_sms' checked>";
    }
    else{
        daily_report_as_sms_input="<input type='checkbox' id='daily_report_as_sms' name='daily_report_as_sms'>";
    }
    if(daily_report_summary_to_reg_mail==true){
      daily_report_summary_to_reg_mail_input="<input type='checkbox' id='daily_report_summary_to_reg_mail' name='daily_report_summary_to_reg_mail' checked>";
    }
    else{
        daily_report_summary_to_reg_mail_input="<input type='checkbox' id='daily_report_summary_to_reg_mail' name='daily_report_summary_to_reg_mail'>";
    }
    if(database_backup==true){
      database_backup_input="<input type='checkbox' id='database_backup' name='database_backup' checked>";
    }
    else{
        database_backup_input="<input type='checkbox' id='database_backup' name='database_backup'>";
    }
    if(driver_score==true){
      driver_score_input="<input type='checkbox' id='driver_score' name='driver_score' checked>";
    }
    else{
        driver_score_input="<input type='checkbox' id='driver_score' name='driver_score'>";
    }

    if(emergency_alerts==true){
      emergency_alerts_input="<input type='checkbox' id='emergency_alerts' name='emergency_alerts' checked>";
    }
    else{
        emergency_alerts_input="<input type='checkbox' id='emergency_alerts' name='emergency_alerts'>";
    }
    if(fuel==true){
      fuel_input="<input type='checkbox' id='fuel' name='fuel' checked>";
    }
    else{
        fuel_input="<input type='checkbox' id='fuel' name='fuel'>";
    }
    if(geofence_count){
      geofence_count_input="<input type='text' id='geofence_count' name='geofence_count' value='"+geofence_count+"'>";
    }
 
    if(immobilizer==true){
      immobilizer_input="<input type='checkbox' id='immobilizer' name='immobilizer' checked>";
    }
    else{
        immobilizer_input="<input type='checkbox' id='immobilizer' name='immobilizer'>";
    }
    if(invoice==true){
      invoice_input="<input type='checkbox' id='invoice' name='invoice' checked>";
    }
    else{
        invoice_input="<input type='checkbox' id='invoice' name='invoice'>";
    }
    if(mobile_application==true){
      mobile_application_input="<input type='checkbox' id='mobile_application' name='mobile_application' checked>";
    }
    else{
        mobile_application_input="<input type='checkbox' id='mobile_application' name='mobile_application'>";
    }

     if(modify_design==true){
      modify_design_input="<input type='checkbox' id='modify_design' name='modify_design' checked>";
    }
    else{
        modify_design_input="<input type='checkbox' id='modify_design' name='modify_design'>";
    }
     
     if(point_of_interest==true){
      point_of_interest="<input type='checkbox' id='point_of_interest' name='point_of_interest' checked>";
    }
    else{
        point_of_interest="<input type='checkbox' id='point_of_interest' name='point_of_interest'>";
    }
    if(privillaged_support==true){
      privillaged_support="<input type='checkbox' id='privillaged_support' name='privillaged_support' checked>";
    }
    else{
        privillaged_support="<input type='checkbox' id='privillaged_support' name='privillaged_support'>";
    }

    if(radar==true){
      radar="<input type='checkbox' id='radar' name='radar' checked>";
    }
    else{
        radar="<input type='checkbox' id='radar' name='radar'>";
    }

    if(route_deviation_count){
      route_deviation_count="<input type='text' id='route_deviation_count' name='route_deviation_count' value='"+route_deviation_count+"'>";
    }
   
    if(share_in_web_app==true){
      share_in_web_app="<input type='checkbox' id='share_in_web_app' name='share_in_web_app' checked>";
    }
    else{
        share_in_web_app="<input type='checkbox' id='share_in_web_app' name='share_in_web_app'>";
    }
    if(towing_alert==true){
      towing_alert="<input type='checkbox' id='towing_alert' name='towing_alert' checked>";
    }
    else{
        towing_alert="<input type='checkbox' id='towing_alert' name='towing_alert'>";
    }
    if(white_list==true){
      white_list="<input type='checkbox' id='white_list' name='white_list' checked>";
    }
    else{
        white_list="<input type='checkbox' id='white_list' name='white_list'>";
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
}
