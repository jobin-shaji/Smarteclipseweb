function getUrl(){
  return $('meta[name = "domain"]').attr('content');
}

function toast(res){
    // alert(res.status);
    
   if(res.status == 1){
        toastr.success( res.message, res.title);
        console.log( res.message, res.title);
    }
    else if(res.status == 0) {
        console.log('Error', res.message);
        toastr.error(res.message, 'Error');
    }
    
}

function apiBackgroundPostData(url, data, callBack, options) { 

    var purl = getUrl() + '/'+url ;

    var defaults = {
        type: 'POST',
        alert: false
    };

    jQuery.extend(defaults, options);
    $.ajax({
        type: defaults.type,
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {

            toast(res);
            if (callBack){
                if(callBack=='gpsData'){
                         gpsData(res);
                }
           }
        },
        error: function (err) {
            var message = (err.responseJSON)?err.responseJSON.message:err.responseText;
            toastr.error(message, 'Error');
        }
    });

}


function getPolygonData(url, data, callBack, options) { 

    var purl = getUrl() + '/'+url ;

    var defaults = {
        type: 'POST',
        alert: false
    };

    jQuery.extend(defaults, options);
    $.ajax({
        type: defaults.type,
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            toast(res);
           if (callBack){
                if (callBack == 'initMap'){
                    initMap();
                }
            }
          
        },
        error: function (err) {
            var message = (err.responseJSON)?err.responseJSON.message:err.responseText;
            toastr.error(message, 'Error');
        }
    });

}
    function getdata(id){ 
 
    var url = 'get-gps-data';
    var data = {
       id:id 
    };   
    apiBackgroundPostData(url,data,'gpsData',{alert:false});           
}

function gpsData(res)
{
    $("#allDataTable tr").remove(); 
    var gps=' <tr><td>Header</td><td>'+res.gpsData.header+'</td></tr>'+
            '<tr><td>Imei</td><td >'+res.gpsData.imei+'</td></tr>'+ 
            '<tr><td>alert id</td><td>'+res.gpsData.alert_id+'</td></tr>'+
            '<tr><td>Packet Status</td><td>'+res.gpsData.packet_status+'</td></tr>'+
            '<tr><td>Device Date</td><td>'+res.gpsData.device_time+'</td></tr>'+
            '<tr><td>Latitude</td><td>'+res.gpsData.latitude+'</td></tr>'+
            '<tr><td>Latitude Direction</td><td>'+res.gpsData.lat_dir+'</td></tr>'+
            '<tr><td>Longitude</td><td>'+res.gpsData.longitude+'</td></tr>'+
            '<tr><td>Longitude Direction</td><td>'+res.gpsData.lon_dir+'</td></tr>'+
            '<tr><td>Mcc </td><td>'+res.gpsData.mcc+'</td></tr>'+
            '<tr><td>Mnc </td><td>'+res.gpsData.mnc+'</td></tr>'+
            '<tr><td>Lac </td><td>'+res.gpsData.lac+'</td></tr>'+
            '<tr><td>Cell Id </td><td>'+res.gpsData.cell_id+'</td></tr>'+
            '<tr><td>Heading</td><td>'+res.gpsData.heading+'</td></tr>'+
            '<tr><td>speed</td><td>'+res.gpsData.speed+'</td></tr>'+
            '<tr><td>No of Satelites</td><td>'+res.gpsData.no_of_satelites+'</td></tr>'+
            '<tr><td>Hdop</td><td>'+res.gpsData.hdop+'</td></tr>'+
            '<tr><td>Signal Strength</td><td>'+res.gpsData.gsm_signal_strength+'</td></tr>'+        
            '<tr><td>ignition</td><td>'+res.gpsData.ignition+'</td></tr>'+
            '<tr><td>main power status</td><td>'+res.gpsData.main_power_status+'</td></tr>'+
            '<tr><td>Vehicle Mode</td><td>'+res.gpsData.vehicle_mode+'</td></tr>'
        ;  
        $("#allDataTable").append(gps); 
    // console.log(res);
    $('#gpsDataModal').modal('show');
}

