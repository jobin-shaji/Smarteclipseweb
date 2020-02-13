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
            $("#set_ota_gps_id").val(res.gps_id);
            $('#packet_datas').empty();
            if(res.status == 1)
            {
                var packet_data='<tr><td>Header</td><td>'+res.packet_data.header+'</td></tr>'+
                        '<tr><td>Imei</td><td >'+res.packet_data.imei+'</td></tr>'+ 
                        '<tr><td>alert id</td><td>'+res.packet_data.alert_id+'</td></tr>'+
                        '<tr><td>Packet Status</td><td>'+res.packet_data.packet_status+'</td></tr>'+
                        '<tr><td>Device Date</td><td>'+res.packet_data.device_time+'</td></tr>'+
                        '<tr><td>Latitude</td><td>'+res.packet_data.latitude+'</td></tr>'+
                        '<tr><td>Latitude Direction</td><td>'+res.packet_data.lat_dir+'</td></tr>'+
                        '<tr><td>Longitude</td><td>'+res.packet_data.longitude+'</td></tr>'+
                        '<tr><td>Longitude Direction</td><td>'+res.packet_data.lon_dir+'</td></tr>'+
                        '<tr><td>Mcc </td><td>'+res.packet_data.mcc+'</td></tr>'+
                        '<tr><td>Mnc </td><td>'+res.packet_data.mnc+'</td></tr>'+
                        '<tr><td>Lac </td><td>'+res.packet_data.lac+'</td></tr>'+
                        '<tr><td>Cell Id </td><td>'+res.packet_data.cell_id+'</td></tr>'+
                        '<tr><td>Heading</td><td>'+res.packet_data.heading+'</td></tr>'+
                        '<tr><td>speed</td><td>'+res.packet_data.speed+'</td></tr>'+
                        '<tr><td>No of Satelites</td><td>'+res.packet_data.no_of_satelites+'</td></tr>'+
                        '<tr><td>Hdop</td><td>'+res.packet_data.hdop+'</td></tr>'+
                        '<tr><td>Signal Strength</td><td>'+res.packet_data.gsm_signal_strength+'</td></tr>'+        
                        '<tr><td>ignition</td><td>'+res.packet_data.ignition+'</td></tr>'+
                        '<tr><td>main power status</td><td>'+res.packet_data.main_power_status+'</td></tr>'+
                        '<tr><td>Vehicle Mode</td><td>'+res.packet_data.vehicle_mode+'</td></tr>';  
                    $("#packet_datas").append(packet_data);         
            }else{
                $("#packet_datas").append("No data available");
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
    var url = 'setota';
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
