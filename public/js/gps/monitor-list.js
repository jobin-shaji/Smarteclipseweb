
function single_vehicle_details(vehicle_id, row_id) 
{   
    console.log(row_id);
    // highlight clicked row
    highLightClickedRow(row_id);

    $("#sidebar-right")
    $('#monitoring_details_tab_contents_loading').show();
    $('#sidebar-right').hide();

    var vehicle_tab_elements = [];
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
        {'id' : 'tvc_client_sub_dealer', 'key' : ['client','subdealer','name']},
                        /* /Client Details */
                        /* Driver Details */
        {'id' : 'tvc_driver_name', 'key' : ['driver','name']},
        {'id' : 'tvc_driver_address', 'key' : ['driver','address']},
        {'id' : 'tvc_driver_mobile', 'key' : ['driver','mobile']},
        {'id' : 'tvc_driver_points', 'key' : ['driver','points']},
    ].forEach(function(each_element){
        repaint(each_element.id);
        //console.log('HERE');
       // $('#tvc_vehicle_theftmode').text('TISMON');
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
            '<th>Alert Status</th>'+
            '<th>Date of Alert</th>'+
            '<th>Device Time</th>'+
        '</tr>';
        res.data.alerts.forEach(function(each_alert)
        {
             // custom alert status
            if( each_alert.status == '1')
            {
                var alert_status = 'Active';
            } 
            else{
                var alert_status = 'Inactive';
            }
            table +='<tr>'+
                    '<td>'+each_alert.alert_type.description+'</td>'+
                    '<td>'+each_alert.latitude+'</td>'+
                    '<td>'+each_alert.longitude+'</td>'+
                    '<td>'+alert_status+'</td>'+
                    '<td>'+each_alert.created_at+'</td>'+
                    '<td>'+each_alert.device_time+'</td>'+
                '</tr>';
           });
        table += '</table>';
        $('#alert_table_wrapper').html(table);
}

function render_subscriptiontab()
{
    
}

round = function(val, precision) {
    if (precision == null) {
      precision = 0;
    }
    if (!precision) {
      return Math.round(val);
    }
    val *= Math.pow(10, precision);
    val += 0.5;
    val = Math.floor(val);
    return val /= Math.pow(10, precision);
  };
function calculate_fuel_reading(fuel_min,fuel_max,fuel_status)
{
    console.log('min', fuel_min);
    console.log('max', fuel_max);
    console.log('stat', fuel_status);
    console.log(( (fuel_min - fuel_status) / (fuel_min - fuel_max) ) * 100);
    return round( ( (fuel_min - fuel_status) / (fuel_min - fuel_max) ) * 100 );
}


function repaint(id)
{
    $('#'+id).text('');
}