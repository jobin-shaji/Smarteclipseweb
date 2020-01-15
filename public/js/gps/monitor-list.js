
var current_active_tab  = 'list';
var alerts_list         = [];
var audio               = document.getElementById("myAudio");
var critical_alerts     = [];


function clicked_vehicle_details(vehicle_id, row_id) 
{   
    // highlight clicked row
    highLightClickedRow(row_id);

    $('#monitoring_details_tab_contents_loading').show();
    $('#sidebar-right').hide();

    if(vehicle_id)
    {
        var data = { vehicle_id :vehicle_id};
        $.ajax({
            type    :'POST',
            url     : 'allvehicle-list',
            data    : data ,
            async   : true,
            headers : {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res){
                $('#monitoring_details_tab_contents_loading').hide();
                $('#sidebar-right').show();
                if(res.success)
                {
                    render_vehicletab(res);
                    render_devicetab(res);
                    render_installationtab(res);
                    render_servicetab(res);
                    render_alerttab(res);
                    render_subscriptiontab(res);
                }
            }
        });
    }
}

function setActiveTab(active_tab_id)
{
    // set active tab
    $('#monitoring_details_tabs').find('li').each(function(){
        $(this).find('a').removeClass('active show');
        if( $(this).find('a').attr('href') == '#tab_content_'+active_tab_id )
        {
            $(this).find('a').addClass('active show');
        }
    });
    // set active tab content
    $('#sidebar-right').find('.tab-pane').each(function(){
        $(this).removeClass('active show in');
        if( $(this).attr('id') == 'tab_content_'+active_tab_id )
        {
            $(this).addClass('active show in');
        }
    });
}

function highLightClickedRow(id)
{
    $('#vehicle_details_table').find('.vehicle_details_table_row').each(function(){
        $(this).removeClass('tablehighlight');
        if( $(this).attr('id') == 'vehicle_details_table_row_'+id )
        {
            $(this).addClass('tablehighlight');
        }
    });
}

function render_vehicletab(res)
{
    [
        /* Vehicle Details */
        {'id' : 'tvc_vehicle_name', 'key' : 'name'},
        {'id' : 'tvc_vehicle_registration_number', 'key' : 'register_number'},
        {'id' : 'tvc_vehicle_type', 'key' : ['vehicle_type','name'] },
        {'id' : 'tvc_vehicle_model', 'key' : ['vehicle_models','name']},
        {'id' : 'tvc_vehicle_make', 'key' : ['vehicle_models','vehicle_make','name']},
        {'id' : 'tvc_vehicle_engine_number', 'key' : 'engine_number'},
        {'id' : 'tvc_vehicle_chassis_number', 'key' : 'chassis_number'},
        {'id' : 'tvc_vehicle_theftmode', 'key' : 'theft_mode'},
        {'id' : 'tvc_vehicle_towing', 'key' : 'towing'},
        {'id' : 'tvc_vehicle_emergency_status', 'key' : 'emergency_status'},
        {'id' : 'tvc_vehicle_created_date', 'key' : 'created_at'},
        /* /Vehicle Details */
        /* Client Details */
        {'id' : 'tvc_client_name', 'key' : ['client','name']},
        {'id' : 'tvc_client_address', 'key' : ['client','address']},
        {'id' : 'tvc_client_lat', 'key' : ['client','latitude']},
        {'id' : 'tvc_client_lng', 'key' : ['client','longitude']},
        {'id' : 'tvc_client_logo', 'key' : ['client','logo']},
        {'id' : 'tvc_client_country', 'key' : ['client','country','name']},
        {'id' : 'tvc_client_state', 'key' : ['client','state','name']},
        {'id' : 'tvc_client_city', 'key' : ['client','city','name']},
        {'id' : 'tvc_client_sub_dealer', 'key' : ['gps_stock','subdealer','name']},
        /* /Client Details */
        /* Driver Details */
        {'id' : 'tvc_driver_name', 'key' : ['driver','name']},
        {'id' : 'tvc_driver_address', 'key' : ['driver','address']},
        {'id' : 'tvc_driver_mobile', 'key' : ['driver','mobile']},
        {'id' : 'tvc_driver_points', 'key' : ['driver','points']},
    ].forEach(function(each_element){
        repaint(each_element.id);
        if(typeof each_element.key == 'string')
        {
            if( each_element.id == 'tvc_vehicle_theftmode')
            {
                $('#'+each_element.id).text( (res.data[each_element.key] == '1') ? 'Enabled' : 'Disabled');
            }
            else if( each_element.id == 'tvc_vehicle_towing')
            {
                $('#'+each_element.id).text( (res.data[each_element.key] == '1') ? 'On Towing' : 'Not Towing');
            }
            else if( each_element.id == 'tvc_vehicle_emergency_status')
            {
                $('#'+each_element.id).text( (res.data[each_element.key] == '1') ? 'On' : 'Off');
            }  
            else
            {
                 $('#'+each_element.id).text(res.data[each_element.key]);
            } 
        }
        else if(typeof each_element.key == 'object')
        {
           
            var detail = res.data;
            each_element.key.forEach(function(key){
                if(detail[key] != null)
                {
                    detail = detail[key];
                }
                else
                {
                    detail = '';
                    return false;
                }
            });
            $('#'+each_element.id).text(detail);
        }
    });
    // display vehicle tab
    setActiveTab('vehicle');
}

function render_devicetab(res)
{
    [
        {'id' : 'tvc_device_imei', 'key' : ['gps','imei']},
        {'id' : 'tvc_device_serial_no', 'key' : ['gps','serial_no']},
        {'id' : 'tvc_device_manufacturing_date', 'key' : ['gps','manufacturing_date']},
        {'id' : 'tvc_device_icc_id', 'key' : ['gps','icc_id']},
        {'id' : 'tvc_device_imsi', 'key' : ['gps','imsi']},
        {'id' : 'tvc_device_e_sim_number', 'key' : ['gps','e_sim_number']},
        {'id' : 'tvc_device_batch_number', 'key' : ['gps','batch_number']},
        {'id' : 'tvc_device_model_name', 'key' : ['gps','model_name']},
        {'id' : 'tvc_device_version', 'key' : ['gps','version']},
        {'id' : 'tvc_device_employee_code', 'key' : ['gps','employee_code']},
        {'id' : 'tvc_device_satellites', 'key' : ['gps','no_of_satellites']},
        {'id' : 'tvc_device_emergency_status', 'key' : ['gps','emergency_status']},
        {'id' : 'tvc_device_gps_fix', 'key' : ['gps','gps_fix_on']},
        {'id' : 'tvc_device_calibrated_on', 'key' : ['gps','calibrated_on']},
        {'id' : 'tvc_device_login_on', 'key' : ['gps','login_on']},
        {'id' : 'tvc_device_created_on', 'key' : ['gps','created_at']},
        {'id' : 'tvc_device_mode', 'key' : ['gps','mode']},
        {'id' : 'tvc_device_lat', 'key' : ['gps','lat']},
        {'id' : 'tvc_device_lon', 'key' : ['gps','lon']},
        {'id' : 'tvc_device_fuel_status', 'key' : ['gps','fuel_status']},
        {'id' : 'tvc_device_speed', 'key' : ['gps','speed']},
        {'id' : 'tvc_device_odometer', 'key' : ['gps','odometer']},
        {'id' : 'tvc_device_battery_status', 'key' : ['gps','battery_status']},
        {'id' : 'tvc_device_main_power_status', 'key' : ['gps','main_power_status']},
        {'id' : 'tvc_device_device_time', 'key' : ['gps','device_time']},
        {'id' : 'tvc_device_ignition', 'key' : ['gps','ignition']},
        {'id' : 'tvc_device_gsm_signal_strength', 'key' : ['gps','gsm_signal_strength']},
        {'id' : 'tvc_device_ac_status', 'key' : ['gps','ac_status']},
    ].forEach(function(each_element){
        repaint(each_element.id);
        if(typeof each_element.key == 'string')
        {
            $('#'+each_element.id).text(res.data[each_element.key]);
        }
        else if(typeof each_element.key == 'object')
        {
            var detail = res.data;
            each_element.key.forEach(function(key){
                if(detail[key] != null)
                {
                    detail = detail[key];
                }
                else
                {
                    detail = '';
                    return false;
                }
            });
            
             // custom ignition status
            if( each_element.id == 'tvc_device_ignition')
            {
                $('#'+each_element.id).text((detail == '1') ? 'On' : 'Off');
            } 
            else if( each_element.id == 'tvc_device_emergency_status')
            {
                $('#'+each_element.id).text((detail == '1') ? 'On' : 'Off');
              
            } 
            else if( each_element.id == 'tvc_device_gps_fix')
            {
                $('#'+each_element.id).text((detail == '1') ? 'GPS Valid' : 'GPS Invalid');
               
            } 
            else if( (each_element.id == 'tvc_device_fuel_status') )
            {
                if( (res.data.vehicle_models != null) )
                {
                    $('#'+each_element.id).text( calculate_fuel_reading(res.data.vehicle_models.fuel_min, res.data.vehicle_models.fuel_max, res.data.gps.fuel_status)+' %');
                }
            } 
            else if( each_element.id == 'tvc_device_speed')
            {
                $('#'+each_element.id).text(round(res.data.gps.speed)+'km/h');
            }
            else if( each_element.id == 'tvc_device_odometer')
            {
                $('#'+each_element.id).text(round(res.data.gps.km));
            }
            else if( each_element.id == 'tvc_device_battery_status')
            {
                $('#'+each_element.id).text(round(res.data.gps.battery_status)+'%');
            } 
            else if( each_element.id == 'tvc_device_mode')
            {
                var vehicle_modes = { 
                    "M": "Moving",
                    "S": "Sleep", 
                    "H": "Halt" 
                };
                $('#'+each_element.id).text(vehicle_modes[detail]);
            } 
            else if( each_element.id == 'tvc_device_ac_status')
            {
              $('#'+each_element.id).text((detail == '1') ? 'Ac On' : 'Ac Off');
            }
            else if( each_element.id == 'tvc_device_main_power_status')
            {
                $('#'+each_element.id).text( (detail == '1') ? 'Connected' : 'Disconnected');
            }
            else 
            {
                $('#'+each_element.id).text(detail);
            } 
        }
    });
        // display vehicle tab
    setActiveTab('vehicle');
}

function render_installationtab(res)
{
    var table = '<table border="1">'+
        '<tr>'+
            '<th>Servicer Name</th>'+
            '<th>Job Date</th>'+
            '<th>Job Completed Date</th>'+
            '<th>Location</th>'+
            '<th>Description</th>'+
            '<th>Comments</th>'+
        '</tr>';
    res.data.jobs.forEach(function(each_job){
        if(each_job.job_type == '1')
        {
            table +='<tr>'+
                '<td>'+each_job.servicer.name+'</td>'+
                '<td>'+each_job.job_date+'</td>'+
                '<td>'+each_job.job_complete_date+'</td>'+
                '<td>'+each_job.location+'</td>'+
                '<td>'+each_job.description+'</td>'+
                '<td>'+each_job.comment+'</td>'+
            '</tr>';
        }
    });
    table += '</table>';
    $('#installation_table_wrapper').html(table);
}

function render_servicetab(res)
{
    var table = '<table border="1">'+
        '<tr>'+
            '<th>Servicer Name</th>'+
            '<th>Job Date</th>'+
            '<th>Job Completed Date</th>'+
            '<th>Location</th>'+
            '<th>Description</th>'+
            '<th>Comments</th>'+
        '</tr>';
    res.data.jobs.forEach(function(each_job){
        if(each_job.job_type == '2')
        {
            table +='<tr>'+
                '<td>'+each_job.servicer.name+'</td>'+
                '<td>'+each_job.job_date+'</td>'+
                '<td>'+each_job.job_complete_date+'</td>'+
                '<td>'+each_job.location+'</td>'+
                '<td>'+each_job.description+'</td>'+
                '<td>'+each_job.comment+'</td>'+
            '</tr>';
        }
    });
    table += '</table>';
    $('#service_table_wrapper').html(table);
}

function render_alerttab(res)
{
    var table = '<table border="1">'+
        '<tr>'+
            '<th>Alert</th>'+
            '<th>Latitude</th>'+
            '<th>Longitude</th>'+
            '<th>Date of Alert</th>'+
            '<th>Device Time</th>'+
        '</tr>';
    res.data.alerts.forEach(function(each_alert)
    {
        table +='<tr>'+
            '<td>'+each_alert.alert_type.description+'</td>'+
            '<td>'+each_alert.latitude+'</td>'+
            '<td>'+each_alert.longitude+'</td>'+
            '<td>'+each_alert.created_at+'</td>'+
            '<td>'+each_alert.device_time+'</td>'+
        '</tr>';
   });
    table += '</table>';
    $('#alert_table_wrapper').html(table);
}

function render_subscriptiontab()
{
    return true;
}

round = function(val, precision) {
    if (precision == null)
    {
        precision = 0;
    }
    if (!precision) 
    {
        return Math.round(val);
    }
    val *= Math.pow(10, precision);
    val += 0.5;
    val = Math.floor(val);
    return val /= Math.pow(10, precision);
};

function calculate_fuel_reading(fuel_min,fuel_max,fuel_status)
{
    return round( ( (fuel_min - fuel_status) / (fuel_min - fuel_max) ) * 100 );
}

function repaint(id)
{
    $('#'+id).text('');
}

$(document).ready(function(){
    $('.mlt').click(function(){
        current_active_tab = $(this).attr('value');
    });
    setInterval(function(){
        $.ajax({
            type    :'POST',
            url     : 'check-emergency-alerts',
            data    : {},
            async   : true,
            headers : {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res){
                // prepare content
                if(res.data.length > 0)
                {                 
                    audio.play();
                    var html = '';
                    res.data.forEach(function(alert)
                    {
                        var need_to_append          = true;
                        var critical_alerts_html    = '';
                        console.log(critical_alerts);

                        critical_alerts.forEach(function(critical_alert){
                            if(alert.id == critical_alert.id)
                            {
                                need_to_append = false;
                                return false;
                               // critical_alerts.push(alert);
                            }
                        }); 

                        if(alert.vehicle == null)
                        {
                            return;
                        }
                        var alert_title = '';
                        if( alert.emergency_status == 1 )
                        {
                            alert_title = 'Emergency Alert';
                            alert_icon  =  'E';
                        }
                        else if( alert.tilt_status == 1 )
                        {
                            alert_title = 'Tilt Alert';
                            alert_icon  =  'T';
                        }
                        else
                        {
                            alert_title = 'Alert';
                            alert_icon  =  'A';
                        }


                        html += '<div class="eam-each_alert eam-each_alert-1">'
                        +'<p style="background:#f00; padding:6px 0;  color:#fff; font-weight:700;font-size:18px;border-top-left-radius: 7px;border-top-right-radius: 7px; ">'+alert_title+'</p>'
                        +'<p class="p-padding">'+alert.vehicle.name+' with registration number '+alert.vehicle.register_number+' has got '+alert_title+'</p>'
                        +'<p style="margin-top:7px;"> <button style="border-radius: 5px;padding: 5px 8px;"><a href="/monitor-map" target="_blank">View map</a></button> </p>'
                        +'</div>';
                        critical_alerts_html = '<div class="alert-page-dispaly" id="'+alert.id+'">'
                        +'<div class="eam-each_alert">'
                        +'<p class="t-alert">'+alert_icon+'</p>'
                        +'<p>'+alert.vehicle.name+' with registration number '+alert.vehicle.register_number+' has got '+alert_title+'</p>'
                        +'<p style="width:auto; float: left;"> <button class="bt-1"><a href="/monitor-map" target="_blank">View map</a></button> </p>'
                        +'<p style="width:auto; float: left;"> <button onclick="clearAlert('+alert.id+')" class="bt-2">Clear</button> </p>'
                        +'</div></div>';

                        if(need_to_append)
                        {
                            critical_alerts.push(alert);
                            // append to alerts tab
                            $('#critical_alerts_table').prepend(critical_alerts_html);
                        }

                       // alertAddonqueue(alert.id,alert.lat,alert.lon,html);
                    });

                    
                    $('#eam_body').html(html);

                    if(current_active_tab != 'map')
                    {
                        // trigger modal
                        $('#emergeny_alert_modal').show();
                    }
                }
                else
                {

                    $('#emergeny_alert_modal').hide();
                }
            }
        });

    }, 5000); 
});

function alertAddonqueue(alert_id,lat,lng,html)
    {
     if(alerts_list.length > 0)
      {
           alerts_list.find(function(x,i){  
                                                                                                                                                                                                                                                                              if(x != undefined)
           {
            
            if(alerts_list['id'] != alert_id){
              var alert_data ={
                "id":alert_id,
                "lat":lat,
                "lng":lng,
                "html":html,
              }  
              alerts_list.push(alert_data);
             }
            }
           },alert_id);

      }else{
        var alert_data ={
            "id":alert_id,
            "lat":lat,
            "lng":lng,
            "html":html,
         }
        alerts_list.push(alert_data);
      }

    }
        

function clearAlert(alert_id)
{
    $("#"+alert_id).remove();
    critical_alerts.splice(critical_alerts.findIndex(function(i){
        return i.id == alert_id;
    }), 1);
}



$('.mlt-map, .mlt-alert').css('display','none');

$('#mlt_list').click(function(){
    $('.mlt-list').css('display','block');
    $('.mlt-map, .mlt-alert').css('display','none');
});

$('#mlt_map').click(function(){
    $('.mlt-map').css('display','block');
    $('.mlt-list, .mlt-alert').css('display','none');
});

$('#mlt_alert').click(function(){
    $('.mlt-alert').css('display','block');
    $('.mlt-list, .mlt-map').css('display','none');
});

