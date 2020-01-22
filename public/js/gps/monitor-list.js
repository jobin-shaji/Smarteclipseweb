
var current_active_tab  = 'list';
var alerts_list         = [];
var audio               = document.getElementById("myAudio");
var critical_alerts     = [];
var read_alerts         = [];

if(localStorage.getItem('read_alerts') == null)
{
    localStorage.setItem('read_alerts', read_alerts);
}
else
{
    read_alerts = localStorage.getItem('read_alerts').split(',');
}

function clicked_vehicle_details(vehicle_id, row_id) 
{
    // clear previous modal data
    clearPreviousModalData();  
    // highlight clicked row
    highLightClickedRow(row_id);

    $('#monitoring_details_tab_contents_loading').show();
    //added code
    $('#monitoring_details_tab_contents').hide();
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
                $('#monitoring_details_tab_contents').show();
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

function clearPreviousModalData()
{
    $('.vehicle-details-value').html('');
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
        {'id' : 'tvc_client_username', 'key' : ['client','user','username']},
        {'id' : 'tvc_client_address', 'key' : ['client','address']},
        {'id' : 'tvc_client_mobile', 'key' : ['client','user','mobile']},
        {'id' : 'tvc_client_email', 'key' : ['client','user','email']},
        {'id' : 'tvc_client_lat', 'key' : ['client','latitude']},
        {'id' : 'tvc_client_lng', 'key' : ['client','longitude']},
        {'id' : 'tvc_client_country', 'key' : ['client','country','name']},
        {'id' : 'tvc_client_state', 'key' : ['client','state','name']},
        {'id' : 'tvc_client_city', 'key' : ['client','city','name']},
        {'id' : 'tvc_client_sub_dealer', 'key' : ['gps_stock','subdealer','name']},
        {'id' : 'tvc_client_package', 'key' : ['client','user','role']},
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
            // console.log(each_element.id);
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
            if( each_element.id == 'tvc_driver_points')
            {
                if(res.data.driver != null)
                {
                $('#'+each_element.id).text( (res.data.driver.points <= 0) ? 0 : res.data.driver.points);
                }
            }
            else
            {
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
            if( each_element.id == 'tvc_client_package')
            {
                var client_package = { 
                    "0":"Not assigned",
                    "1":"Admin",
                    "2":"Distributor",
                    "3":"Dealer",
                    "4": "Freebies",
                    "5":"Servicer",
                    "6": "Fundamental", 
                    "7": "Superior",
                    "8": "Pro",
                    "9":"School",
                    "10":"School-Premium",
                    "11":"Operations",
                    "12":"Trader"
                };
                $('#'+each_element.id).text(client_package[detail]);
            } 
            else if( each_element.id == 'tvc_client_lat')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            } 
            else if( each_element.id == 'tvc_client_lng')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            } 
            else if( each_element.id == 'tvc_client_country')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            } 
            else if( each_element.id == 'tvc_client_state')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_client_city')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_driver_name')
            {
                $('#'+each_element.id).text((detail == '') ? 'Driver not assigned' :detail);
            }
            else if( each_element.id == 'tvc_driver_address')
            {
                $('#'+each_element.id).text((detail == '') ? 'Not available' :detail);
            }
            else if( each_element.id == 'tvc_driver_mobile')
            {
                $('#'+each_element.id).text((detail == '') ? 'Not available' :detail);
            }
            else if( each_element.id == 'tvc_driver_points')
            {
                $('#'+each_element.id).text((detail == '') ? 'Not available' :detail);
            }
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
                $('#'+each_element.id).text((detail == '1') ? 'Received' : 'Not received');
               
            } 
            else if( (each_element.id == 'tvc_device_fuel_status') )
            {
                if( (res.data.vehicle_models != null) )
                {
                    $('#'+each_element.id).text((detail == '' ) ? 'No data available' : calculate_fuel_reading(res.data.vehicle_models.fuel_min, res.data.vehicle_models.fuel_max, res.data.gps.fuel_status)+' %');
                }
            } 
            else if( each_element.id == 'tvc_device_speed')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :round(res.data.gps.speed)+'km/h');
            }
            else if( each_element.id == 'tvc_device_odometer')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :round(res.data.gps.km));
            }
            else if( each_element.id == 'tvc_device_battery_status')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :round(res.data.gps.battery_status)+'%');
            } 
            else if( each_element.id == 'tvc_device_mode')
            {
                var vehicle_modes = { 
                    "M": "Moving",
                    "S": "Sleep", 
                    "H": "Halt" 
                };
                $('#'+each_element.id).text((detail == '') ? 'No data available' : vehicle_modes[detail]);
            } 
            else if( each_element.id == 'tvc_device_ac_status')
            {
              $('#'+each_element.id).text((detail == '1') ? 'On' : 'Off');
            }
            else if( each_element.id == 'tvc_device_main_power_status')
            {
                $('#'+each_element.id).text( (detail == '1') ? 'Connected' : 'Disconnected');
            }
            else if( each_element.id == 'tvc_device_imei')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_serial_no')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_manufacturing_date')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_icc_id')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_imsi')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_e_sim_number')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_batch_number')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_model_name')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_version')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_employee_code')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_satellites')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_calibrated_on')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_login_on')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_created_on')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_lat')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_lon')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_device_time')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else if( each_element.id == 'tvc_device_gsm_signal_strength')
            {
                $('#'+each_element.id).text((detail == '') ? 'No data available' :detail);
            }
            else 
            {
                $('#'+each_element.id).text(detail);
            } 
            
        }
    });
    /***** */
    if(res.data.gps.ota.length == 0)
    {
        table = '<p>No OTA Responses</p>';
    }
    else
    {
       table = '<table border="1">'+
        '<tr>'+
            '<th>Header</th>'+
            '<th>Value</th>'+
            '<th>Updated At</th>'+
        '</tr>';
        res.data.gps.ota.forEach(function(each_ota)
        {
            var header = 'Null';
            if(each_ota.header == 'PU')
            {
                header = 'Primary/Reguvaluelatory Purpose URL';
            }
            else if(each_ota.header == 'EU')
            {
                header = 'Emergency Response System URl';
            }
            else if(each_ota.header == 'EM')
            {
                header = 'Emergency response SMS Number';
            }
            else if(each_ota.header == 'EO')
            {
                header = 'Emergency State OFF';
            }
            else if(each_ota.header == 'ED')
            {
                header = 'Emergency State Time Duration';
            }
            else if(each_ota.header == 'APN')
            {
                header = 'Access Point Name';
            }
            else if(each_ota.header == 'TA')
            {
                header = 'Tilt Angle';
            }
            else if(each_ota.header == 'ST')
            {
                header = 'Sleep Time';
            }
            else if(each_ota.header == 'SL')
            {
                header = 'Speed Limit';
            }
            else if(each_ota.header == 'HBT')
            {
                header = 'Harsh Breaking Threshold';
            }
            else if(each_ota.header == 'HAT')
            {
                header = 'Harsh Acceleration Threshold';
            }
            else if(each_ota.header == 'RTT')
            {
                header = 'Rash Turning Threshold';
            }
            else if(each_ota.header == 'LBT')
            {
                header = 'Low Battery Threshold';
            }
            else if(each_ota.header == 'VN')
            {
                header = 'Vehicle Registration Number';
            }
            else if(each_ota.header == 'UR')
            {
                header = 'Data Update Rate in IGN ON Mode';
            }
            else if(each_ota.header == 'URT')
            {
                header = 'Data Update Rate in Halt Mode';
            }
            else if(each_ota.header == 'URS')
            {
                header = 'Data Update Rate in IGN OFF/Sleep Mode';
            }
            else if(each_ota.header == 'URE')
            {
                header = 'Data Updation Rate in Emergency Mode';
            }
            else if(each_ota.header == 'URF')
            {
                header = 'Data Update Rate of Full Packet';
            }
            else if(each_ota.header == 'URH')
            {
                header = 'Data Update Rate of Health Packets';
            }
            else if(each_ota.header == 'VID')
            {
                header = 'Vendor ID';
            }
            else if(each_ota.header == 'FV')
            {
                header = 'Firmware Version';
            }
            else if(each_ota.header == 'DSL')
            {
                header = 'Default Speed Limit';
            }
            else if(each_ota.header == 'HT')
            {
                header = 'Halt Time';
            }
            else if(each_ota.header == 'M1')
            {
                header = 'Contact Mobile Number';
            }
            else if(each_ota.header == 'M2')
            {
                header = 'Contact Mobile Number 2';
            }
            else if(each_ota.header == 'M3')
            {
                header = 'Contact Mobile Number 3';
            }
            else if(each_ota.header == 'GF')
            {
                header = 'Geofence';
            }
            else if(each_ota.header == 'OM')
            {
                header = 'OTA Updated Mobile';
            }
            else if(each_ota.header == 'OU')
            {
                header = 'OTA Updated URL';
            }
            else
            {
                header = each_ota.header;
            }
            table +='<tr>'+
                '<td>'+header+'</td>'+
                '<td>'+each_ota.value+'</td>'+
                '<td>'+each_ota.updated_at+'</td>'+
            '</tr>';
        });
        table += '</table>'; 
    }
    
    $('#ota').html(table);
    /**** */
        // display vehicle tab
    setActiveTab('vehicle');
}

function render_installationtab(res)
{
    var no_data_found = true;
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
            no_data_found = false;
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

    if( no_data_found )
    {
        $('#installation_table_wrapper').html('<p>No installation found</p>');
    }
    else
    {
        $('#installation_table_wrapper').html(table);
    }
    
}

function render_servicetab(res)
{
    var no_data_found = true;
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
            no_data_found = false;
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
    if( no_data_found )
    {
        $('#service_table_wrapper').html('<p>No service(s) found</p>');
    }
    else
    {
        $('#service_table_wrapper').html(table);
    }
    
}

function render_alerttab(res)
{
    if(res.data.alerts.length == 0)
    {
        table = '<p>No alerts found</p>';
    }
    else
    {
       table = '<table border="1">'+
        '<tr>'+
            '<th>Alert</th>'+
            '<th>Latitude</th>'+
            '<th>Longitude</th>'+
            '<th>Date & Time of alert</th>'+
        '</tr>';
        res.data.alerts.forEach(function(each_alert)
        {
            table +='<tr>'+
                '<td>'+each_alert.alert_type.description+'</td>'+
                '<td>'+each_alert.latitude+'</td>'+
                '<td>'+each_alert.longitude+'</td>'+
                '<td>'+each_alert.device_time+'</td>'+
            '</tr>';
        });
        table += '</table>'; 
    }
    
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

function markAlertAsRead(id)
{
    if($.inArray(id, read_alerts) == -1)
    {
        read_alerts.push(id.toString());
        localStorage.setItem('read_alerts', read_alerts);
        // remove the read alert
        $('.eam-body > eam-each_alert-'+id).remove();
        // if there is only on alert in the modal and that too read
        // remove that alert and close the modal
        if( (read_alerts.length - critical_alerts.length) == 0 )
        {
            $('#emergeny_alert_modal').hide();
        }
    }
}

function clearSearch()
{
    document.getElementById('monitoring_module_search_key').value = '';
}

$(document).ready(function(){
    $('.mlt').click(function(){
        current_active_tab = $(this).attr('value');
        // set color
        $('.mlt').removeClass('vst-theme-color'); //.addClass('vst-theme-color');
        $(this).addClass('vst-theme-color');
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
                    var html = '';
                    res.data.forEach(function(alert)
                    {
                        if(alert.vehicle == null)
                        {
                            return false;
                        }
                        var need_to_append          = true;
                        var critical_alerts_html    = '';
                        // critical alerts tab
                        critical_alerts.forEach(function(critical_alert){
                            if(alert.id == critical_alert.id)
                            {
                                need_to_append = false;
                                return false;
                            }
                        });
                        // alert tab contents
                        critical_alerts_html = prepareAlertTabContent(alert);
                        // append to alerts tab
                        if(need_to_append)
                        {
                            critical_alerts.push(alert);  
                            $('#critical_alerts_table').prepend(critical_alerts_html);
                        }

                        if( !isAlertNeedsToDisplay(alert) )
                        {
                            return false;
                        }
                        // modal contents
                        html += prepareAlertModalContent(alert);
                    });

                    // trigger alert modal
                    if( (html != '') && (current_active_tab != 'map'))
                    {
                        audio.play();
                        $('#eam_body').html(html);
                        $('#emergeny_alert_modal').show();
                    }
                }
                else
                {
                    $('#critical_alerts_table').html('<p>No alerts found</p>');
                    $('#emergeny_alert_modal').hide();
                }
            }
        });

    }, 5000);
});

function isAlertNeedsToDisplay(alert)
{
   return ( (alert.vehicle != null) && ($.inArray(alert.id.toString(), read_alerts) == -1) ) ? true : false;
}

function prepareAlertModalContent(alert)
{
    var alert_title = getAlertTitle(alert);
    return '<div class="eam-each_alert each_popup_alert eam-each_alert-'+alert.id+'">'
        +'<p style="background:#f00; padding:6px 0;  color:#fff; font-weight:700;font-size:18px;border-top-left-radius: 7px;border-top-right-radius: 7px; ">'+alert_title+'</p>'
        +'<p class="p-padding">'+alert.vehicle.name+' with registration number '+alert.vehicle.register_number+' has got '+alert_title+'</p>'
        +'<p style="margin-top:7px;font-size:12px;font-weight:10"> <button style="border-radius: 5px;padding: 5px 5px;"><a href="/monitor-map" target="_blank">View map</a></button>'
        +' <button style="border-radius: 5px;padding: 5px 5px;" onclick="markAlertAsRead('+alert.id+')">Mark as read</button> </p>'
        +'<h6></h6>'
        +'</div>';
}

function prepareAlertTabContent(alert)
{
    var alert_title = getAlertTitle(alert);
    return '<div class="alert-page-dispaly" id="'+alert.id+'">'
        +'<div class="eam-each_alert">'
        +'<p class="t-alert">'+alert_title.charAt(0).toUpperCase()+'</p>'
        +'<p>'+alert.vehicle.name+' with registration number '+alert.vehicle.register_number+' has got '+alert_title+'</p>'
        +'<p style="width:auto; float: left;"> <button class="bt-1"><a href="/monitor-map" target="_blank">View map</a></button> </p>'
        +'<p style="width:auto; float: left;"> <button onclick="clearAlert('+alert.id+')" class="bt-2">Clear</button> </p>'
        +'</div></div>';
}

function getAlertTitle(alert)
{
    var title = 'Alert';
    if(alert.emergency_status == '1')
    {
        title = 'Emergency Alert';
    }
    else if(alert.tilt_status == '1')
    {
        title = 'Tilt Alert';
    }
    return title;
}

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

