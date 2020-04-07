function searchButtonClicked()
{
    var status  = false;       
    var imei    = document.getElementById('imei').value;        
    if( imei == '')
    {
        alert('Please select GPS');
    } 
    else
    {
        status = true;
    }
    return status;
}

function clickedPacketDetails(vlt_data_id,imei,vlt_data)
{
    var url = 'console-data-packet-view';
    var data = {
        vlt_data_id:vlt_data_id, imei:imei, vlt_data:vlt_data
    };   
    $.ajax({
        type:'POST',
        url: url,
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            
        },
        success: function (res) 
        {
            $('#packet_datas').empty();
            if(res.data.header == "ACK"||res.data.header == "AVK")
            {
                var packet_data='<tr><td>Header</td><td>'+res.data.header+'</td></tr>'+
                        '<tr><td>Imei</td><td >'+res.data.imei+'</td></tr>'+ 
                        '<tr><td>alert id</td><td>'+res.data.alert_id+'</td></tr>'+
                        '<tr><td>Packet Status</td><td>'+res.data.packet_status+'</td></tr>'+
                        '<tr><td>GNSS Fix</td><td>'+res.data.gps_fix+'</td></tr>'+
                        '<tr><td>Device Date</td><td>'+res.data.date+'</td></tr>'+
                        '<tr><td>Time</td><td>'+res.data.time+'</td></tr>'+
                        '<tr><td>Device Time</td><td>'+res.data.time+'</td></tr>'+
                        '<tr><td>Latitude</td><td>'+res.data.latitude+'</td></tr>'+
                        '<tr><td>Latitude Direction</td><td>'+res.data.lat_dir+'</td></tr>'+
                        '<tr><td>Longitude</td><td>'+res.data.longitude+'</td></tr>'+
                        '<tr><td>Longitude Direction</td><td>'+res.data.lon_dir+'</td></tr>'+
                        '<tr><td>Mcc </td><td>'+res.data.mcc+'</td></tr>'+
                        '<tr><td>Mnc </td><td>'+res.data.mnc+'</td></tr>'+
                        '<tr><td>Lac </td><td>'+res.data.lac+'</td></tr>'+
                        '<tr><td>Cell Id </td><td>'+res.data.cell_id+'</td></tr>'+
                        '<tr><td>Heading</td><td>'+res.data.heading+'</td></tr>'+
                        '<tr><td>speed</td><td>'+res.data.speed+'</td></tr>'+
                        '<tr><td>No of Satelites</td><td>'+res.data.no_of_satelites+'</td></tr>'+
                        '<tr><td>Hdop</td><td>'+res.data.hdop+'</td></tr>'+
                        '<tr><td> GSM Signal Strength</td><td>'+res.data.gsm_signal_strength+'</td></tr>'+        
                        '<tr><td>ignition</td><td>'+res.data.ignition+'</td></tr>'+
                        '<tr><td>main power status</td><td>'+res.data.main_power_status+'</td></tr>'+
                        '<tr><td>Vehicle Mode</td><td>'+res.data.vehicle_mode+'</td></tr>'+
                        '<tr><td>Key and Values</td><td>'+res.data.response+'</td></tr>';  
                    $("#packet_datas").append(packet_data);         
            }else if(res.data.header == "ALT")
            {
                var packet_data='<tr><td>Header</td><td>'+res.data.header+'</td></tr>'+
                '<tr><td>Imei</td><td >'+res.data.imei+'</td></tr>'+ 
                '<tr><td>alert id</td><td>'+res.data.alert_id+'</td></tr>'+
                '<tr><td>Packet Status</td><td>'+res.data.packet_status+'</td></tr>'+
                '<tr><td>GNSS Fix</td><td>'+res.data.gps_fix+'</td></tr>'+
                '<tr><td>Device Date</td><td>'+res.data.date+'</td></tr>'+
                '<tr><td>Time</td><td>'+res.data.time+'</td></tr>'+
                '<tr><td>Device Time</td><td>'+res.data.device_time+'</td></tr>'+
                '<tr><td>Latitude</td><td>'+res.data.latitude+'</td></tr>'+
                '<tr><td>Latitude Direction</td><td>'+res.data.lat_dir+'</td></tr>'+
                '<tr><td>Longitude</td><td>'+res.data.longitude+'</td></tr>'+
                '<tr><td>Longitude Direction</td><td>'+res.data.lon_dir+'</td></tr>'+
                '<tr><td>Mcc </td><td>'+res.data.mcc+'</td></tr>'+
                '<tr><td>Mnc </td><td>'+res.data.mnc+'</td></tr>'+
                '<tr><td>Lac </td><td>'+res.data.lac+'</td></tr>'+
                '<tr><td>Cell Id </td><td>'+res.data.cell_id+'</td></tr>'+
                '<tr><td>Heading</td><td>'+res.data.heading+'</td></tr>'+
                '<tr><td>speed</td><td>'+res.data.speed+'</td></tr>'+
                '<tr><td>No of Satelites</td><td>'+res.data.no_of_satelites+'</td></tr>'+
                '<tr><td>Hdop</td><td>'+res.data.hdop+'</td></tr>'+
                '<tr><td>Signal Strength</td><td>'+res.data.gsm_signal_strength+'</td></tr>'+        
                '<tr><td>ignition</td><td>'+res.data.ignition+'</td></tr>'+
                '<tr><td>main power status</td><td>'+res.data.main_power_status+'</td></tr>'+
                '<tr><td>Vehicle Mode</td><td>'+res.data.vehicle_mode+'</td></tr>'
                ;  
            $("#packet_datas").append(packet_data);      
            }
            else if(res.data.header == "CRT")
            {
                var packet_data='<tr><td>Header</td><td>'+res.data.header+'</td></tr>'+
                '<tr><td>Imei</td><td >'+res.data.imei+'</td></tr>'+ 
                '<tr><td>alert id</td><td>'+res.data.alert_id+'</td></tr>'+
                '<tr><td>Packet Status</td><td>'+res.data.packet_status+'</td></tr>'+
                '<tr><td>GNSS Fix</td><td>'+res.data.gps_fix+'</td></tr>'+
                '<tr><td>Device Date</td><td>'+res.data.date+'</td></tr>'+
                '<tr><td>Time</td><td>'+res.data.time+'</td></tr>'+
                '<tr><td>Device Time</td><td>'+res.data.device_time+'</td></tr>'+
                '<tr><td>Latitude</td><td>'+res.data.latitude+'</td></tr>'+
                '<tr><td>Latitude Direction</td><td>'+res.data.lat_dir+'</td></tr>'+
                '<tr><td>Longitude</td><td>'+res.data.longitude+'</td></tr>'+
                '<tr><td>Longitude Direction</td><td>'+res.data.lon_dir+'</td></tr>'+
                '<tr><td>Mcc </td><td>'+res.data.mcc+'</td></tr>'+
                '<tr><td>Mnc </td><td>'+res.data.mnc+'</td></tr>'+
                '<tr><td>Lac </td><td>'+res.data.lac+'</td></tr>'+
                '<tr><td>Cell Id </td><td>'+res.data.cell_id+'</td></tr>'+
                '<tr><td>Heading</td><td>'+res.data.heading+'</td></tr>'+
                '<tr><td>speed</td><td>'+res.data.speed+'</td></tr>'+
                '<tr><td>No of Satelites</td><td>'+res.data.no_of_satelites+'</td></tr>'+
                '<tr><td>Hdop</td><td>'+res.data.hdop+'</td></tr>'+
                '<tr><td>Signal Strength</td><td>'+res.data.gsm_signal_strength+'</td></tr>'+        
                '<tr><td>ignition</td><td>'+res.data.ignition+'</td></tr>'+
                '<tr><td>main power status</td><td>'+res.data.main_power_status+'</td></tr>'+
                '<tr><td>GF Id</td><td>'+res.data.gf_id+'</td></tr>'+
                '<tr><td>Vehicle Mode</td><td>'+res.data.vehicle_mode+'</td></tr>'
                ;  
            $("#packet_datas").append(packet_data);      
            } else if(res.data.header == "EPB")
            {
                var packet_data='<tr><td>Header</td><td>'+res.data.header+'</td></tr>'+
                '<tr><td>Imei</td><td >'+res.data.imei+'</td></tr>'+ 
                '<tr><td>alert id</td><td>'+res.data.alert_id+'</td></tr>'+
                '<tr><td>Packet Status</td><td>'+res.data.packet_status+'</td></tr>'+
                '<tr><td>GNSS Fix</td><td>'+res.data.gps_fix+'</td></tr>'+
                '<tr><td>Device Date</td><td>'+res.data.date+'</td></tr>'+
                '<tr><td>Time</td><td>'+res.data.time+'</td></tr>'+
                '<tr><td>Device Time</td><td>'+res.data.device_time+'</td></tr>'+
                '<tr><td>Latitude</td><td>'+res.data.latitude+'</td></tr>'+
                '<tr><td>Latitude Direction</td><td>'+res.data.lat_dir+'</td></tr>'+
                '<tr><td>Longitude</td><td>'+res.data.longitude+'</td></tr>'+
                '<tr><td>Longitude Direction</td><td>'+res.data.lon_dir+'</td></tr>'+
                '<tr><td>Mcc </td><td>'+res.data.mcc+'</td></tr>'+
                '<tr><td>Mnc </td><td>'+res.data.mnc+'</td></tr>'+
                '<tr><td>Lac </td><td>'+res.data.lac+'</td></tr>'+
                '<tr><td>Cell Id </td><td>'+res.data.cell_id+'</td></tr>'+
                '<tr><td>Heading</td><td>'+res.data.heading+'</td></tr>'+
                '<tr><td>speed</td><td>'+res.data.speed+'</td></tr>'+
                '<tr><td>No of Satelites</td><td>'+res.data.no_of_satelites+'</td></tr>'+
                '<tr><td>Hdop</td><td>'+res.data.hdop+'</td></tr>'+
                '<tr><td>Signal Strength</td><td>'+res.data.gsm_signal_strength+'</td></tr>'+        
                '<tr><td>ignition</td><td>'+res.data.ignition+'</td></tr>'+
                '<tr><td>main power status</td><td>'+res.data.main_power_status+'</td></tr>'+
                '<tr><td>Vehicle Mode</td><td>'+res.data.vehicle_mode+'</td></tr>'
                ;  
            $("#packet_datas").append(packet_data);      
            }else if(res.data.header == "FUL")
            {
                var packet_data='<tr><td>Header</td><td>'+res.data.header+'</td></tr>'+
                '<tr><td>Imei</td><td >'+res.data.imei+'</td></tr>'+ 
                '<tr><td>alert id</td><td>'+res.data.alert_id+'</td></tr>'+
                '<tr><td>Packet Status</td><td>'+res.data.packet_status+'</td></tr>'+
                '<tr><td>GNSS Fix</td><td>'+res.data.gps_fix+'</td></tr>'+
                '<tr><td>Device Date</td><td>'+res.data.date+'</td></tr>'+
                '<tr><td>Time</td><td>'+res.data.time+'</td></tr>'+
                '<tr><td>Device Time</td><td>'+res.data.device_time+'</td></tr>'+
                '<tr><td>Latitude</td><td>'+res.data.latitude+'</td></tr>'+
                '<tr><td>Latitude Direction</td><td>'+res.data.lat_dir+'</td></tr>'+
                '<tr><td>Longitude</td><td>'+res.data.longitude+'</td></tr>'+
                '<tr><td>Longitude Direction</td><td>'+res.data.lon_dir+'</td></tr>'+
                '<tr><td>Mcc </td><td>'+res.data.mcc+'</td></tr>'+
                '<tr><td>Mnc </td><td>'+res.data.mnc+'</td></tr>'+
                '<tr><td>Lac </td><td>'+res.data.lac+'</td></tr>'+
                '<tr><td>Cell Id </td><td>'+res.data.cell_id+'</td></tr>'+
                '<tr><td>Heading</td><td>'+res.data.heading+'</td></tr>'+
                '<tr><td>speed</td><td>'+res.data.speed+'</td></tr>'+
                '<tr><td>No of Satelites</td><td>'+res.data.no_of_satelites+'</td></tr>'+
                '<tr><td>Hdop</td><td>'+res.data.hdop+'</td></tr>'+
                '<tr><td>Signal Strength</td><td>'+res.data.gsm_signal_strength+'</td></tr>'+        
                '<tr><td>ignition</td><td>'+res.data.ignition+'</td></tr>'+
                '<tr><td>main power status</td><td>'+res.data.main_power_status+'</td></tr>'+
                '<tr><td>Vehicle Mode</td><td>'+res.data.vehicle_mode+'</td></tr>'+
                '<tr><td>Vendor ID</td><td>'+res.data.vendor_id+'</td></tr>'+
                '<tr><td>Firmware Version</td><td>'+res.data.firmware_version+'</td></tr>'+
                '<tr><td>Vehicele Reg No</td><td>'+res.data.vehicle_register_num+'</td></tr>'+
                '<tr><td>Altitude</td><td>'+res.data.altitude+'</td></tr>'+
                '<tr><td>Pdop</td><td>'+res.data.pdop+'</td></tr>'+
                '<tr><td>Network Operator Name</td><td>'+res.data.nw_op_name+'</td></tr>'+
                '<tr><td>NMR</td><td style=" word-wrap: anywhere; width: 50px">'+res.data.nmr+'</td></tr>'+
                '<tr><td>Main Input Voltage</td><td>'+res.data.main_input_voltage+'</td></tr>'+
                '<tr><td>Tamper Alert</td><td>'+res.data.tamper_alert+'</td></tr>'+
                '<tr><td>Digital I/O Status</td><td>'+res.data.digital_io_status+'</td></tr>'+
                '<tr><td>Internal Battery Voltage</td><td>'+res.data.internal_battery_voltage+'</td></tr>'+
                '<tr><td>Frame Number</td><td>'+res.data.frame_number+'</td></tr>'+  
                '<tr><td>Check Sum</td><td>'+res.data.checksum+'</td></tr>'
                +
                '<tr><td>Gps Fix</td><td>'+res.data.gps_fix+'</td></tr>'
                ;  
            $("#packet_datas").append(packet_data);      
            }
            else if(res.data.header == "HLM")
            {
                var packet_data='<tr><td style="padding:0.5rem;">Header</td><td>'+res.data.header+'</td></tr>'+
                '<tr><td style="padding:0.5rem;">Imei</td><td >'+res.data.imei+'</td></tr>'+ 
                '<tr><td style="padding:0.5rem;">Device Date</td><td>'+res.data.date+'</td></tr>'+
                '<tr><td style="padding:0.5rem;">Time</td><td>'+res.data.time+'</td></tr>'+
                '<tr><td style="padding:0.5rem;">Device Time</td><td>'+res.data.device_time+'</td></tr>'+
                '<tr><td style="padding:0.5rem;">Vendor ID</td><td>'+res.data.vendor_id+'</td></tr>'+
                '<tr><td style="padding:0.5rem;">Firmware Version</td><td>'+res.data.firmware_version+'</td></tr>'+
                '<tr><td style="padding:0.5rem;">update rate - Ignition ON</td><td>'+res.data.update_rate_ignition_on+'</td></tr>'+
                '<tr><td style="padding:0.5rem;">update rate - Ignition OFF</td><td>'+res.data.update_rate_ignition_off+'</td></tr>'+
                '<tr><td style="padding:0.5rem;">Battery Percentage</td><td>'+res.data.battery_percentage+'</td></tr>'+
                '<tr><td style="padding:0.5rem;">Low Battery Threshold Value</td><td>'+res.data.low_battery_threshold_value+'</td></tr>'+
                '<tr><td style="padding:0.5rem;">Memory percentage</td><td>'+res.data.memory_percentage+'</td></tr>'+
                '<tr><td style="padding:0.5rem;">Digital I/O status</td><td>'+res.data.digital_io_status+'</td></tr>'+
                '<tr><td style="padding:0.5rem;">Analog Input Status</td><td>'+res.data.analog_io_status+'</td></tr>'
                ;  
            $("#packet_datas").append(packet_data);      
            }
            else if(res.data.header == "LGN")
            {
                var packet_data='<tr><td>Header</td><td>'+res.data.header+'</td></tr>'+
                '<tr><td>Imei</td><td >'+res.data.imei+'</td></tr>'+ 
                '<tr><td>Device Date</td><td>'+res.data.date+'</td></tr>'+
                '<tr><td>Time</td><td>'+res.data.time+'</td></tr>'+
                '<tr><td>Device Time</td><td>'+res.data.device_time+'</td></tr>'+
                '<tr><td>Latitude</td><td>'+res.data.latitude+'</td></tr>'+
                '<tr><td>Latitude Direction</td><td>'+res.data.lat_dir+'</td></tr>'+
                '<tr><td>Longitude</td><td>'+res.data.longitude+'</td></tr>'+
                '<tr><td>Longitude Direction</td><td>'+res.data.lon_dir+'</td></tr>'+
                '<tr><td>Activation Key</td><td>'+res.data.activation_key+'</td></tr>'+
                '<tr><td>Speed</td><td>'+res.data.speed+'</td></tr>'
                ;  
            $("#packet_datas").append(packet_data);      
            }
            //  else if(res.data.header == "NRM")
            // {
            //     var packet_data='<tr><td>Header</td><td>'+res.data.header+'</td></tr>'+
            //     '<tr><td>Imei</td><td >'+res.data.imei+'</td></tr>'+ 
            //     '<tr><td>Device Date</td><td>'+res.data.date+'</td></tr>'+
            //     '<tr><td>Time</td><td>'+res.data.time+'</td></tr>'+
            //     '<tr><td>Device Time</td><td>'+res.data.device_time+'</td></tr>'+
            //     '<tr><td>Latitude</td><td>'+res.data.latitude+'</td></tr>'+
            //     '<tr><td>Latitude Direction</td><td>'+res.data.lat_dir+'</td></tr>'+
            //     '<tr><td>Longitude</td><td>'+res.data.longitude+'</td></tr>'+
            //     '<tr><td>Longitude Direction</td><td>'+res.data.lon_dir+'</td></tr>'+
            //     '<tr><td>Activation Key</td><td>'+res.data.activation_key+'</td></tr>'+
            //     '<tr><td>Speed</td><td>'+res.data.speed+'</td></tr>'
            //      ;  
            // $("#packet_datas").append(packet_data);      
            // }
            else if(res.data.header == "NRM")
            {
                var packet_data='<tr><td>Header</td><td>'+res.data.header+'</td></tr>'+
                '<tr><td>Imei</td><td >'+res.data.imei+'</td></tr>'+ 
                '<tr><td>Device Date</td><td>'+res.data.date+'</td></tr>'+
                '<tr><td>Time</td><td>'+res.data.time+'</td></tr>'+
                '<tr><td>Device Time</td><td>'+res.data.device_time+'</td></tr>'+
                '<tr><td>Code</td><td>'+res.data.code+'</td></tr>'+
                '<tr><td>Packet Status</td><td>'+res.data.packet_status+'</td></tr>'+
                '<tr><td>Latitude</td><td>'+res.data.latitude+'</td></tr>'+
                '<tr><td>Latitude Direction</td><td>'+res.data.lat_dir+'</td></tr>'+
                '<tr><td>Longitude</td><td>'+res.data.longitude+'</td></tr>'+
                '<tr><td>Longitude Direction</td><td>'+res.data.lon_dir+'</td></tr>'+
                '<tr><td>Mcc </td><td>'+res.data.mcc+'</td></tr>'+
                '<tr><td>Mnc </td><td>'+res.data.mnc+'</td></tr>'+
                '<tr><td>Lac </td><td>'+res.data.lac+'</td></tr>'+
                '<tr><td>Cell Id </td><td>'+res.data.cell_id+'</td></tr>'+
                '<tr><td>Speed</td><td>'+res.data.speed+'</td></tr>'+ 
                '<tr><td>GNSS Fix</td><td>'+res.data.gps_fix+'</td></tr>'+
                '<tr><td>Heading</td><td>'+res.data.heading+'</td></tr>'+     
                '<tr><td>No of Satelites</td><td>'+res.data.no_of_satelites+'</td></tr>'+
                '<tr><td>Hdop</td><td>'+res.data.hdop+'</td></tr>'+
                '<tr><td>Signal Strength</td><td>'+res.data.gsm_signal_strength+'</td></tr>'+
                '<tr><td>ignition</td><td>'+res.data.ignition+'</td></tr>'+
                '<tr><td>main power status</td><td>'+res.data.main_power_status+'</td></tr>'+
                '<tr><td>Vehicle Mode</td><td>'+res.data.vehicle_mode+'</td></tr>'
                ;  
            $("#packet_datas").append(packet_data);      
            }else if(res.data.header == "BTH"){
                // $('#batchtabledata').empty();
                for (var i = 0; i < Object.keys(res.data).length; i++) 
                {
                    if(Object.keys(res.data)[i] != 'header')
                    {
                        $("#packet_datas").append('<tr><td>'+res.data[i]+'</td>'+'</tr>');
                    }
                }
            }
            else{
                $("#packet_datas").append("No data available");
            }
        }

    });
}

function sendCommandToDevice(imei)
{
    var url = 'get-gps-id-from-imei';
    var data = {
        imei:imei
    };   
    $.ajax({
        type:'POST',
        url: url,
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            
        },
        success: function (res) 
        {
            if(res.status == 1)
            {
                $("#set_ota_gps_id").val(res.gps_id);
            }
        }

    });
}

function setOta(gps_id) {
    if(document.getElementById('command').value == ''){
        alert('Please enter your command');
    }
    else{
        var command = document.getElementById('command').value;
        var data = {'gps_id':gps_id, 'command':command};
    }
    var url = 'console-set-ota';
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            if(res.status==1){
                $('#command').val('');
                toastr.success(res.message);
            }else{
                toastr.error(res.message);
            }
        }
    });
    }
