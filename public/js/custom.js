
// dateTimepicker

    $( ".datetimepicker" ).datetimepicker({ 
        format: 'YYYY-MM-DD HH:mm:ss',
        maxDate: new Date() 
    });

    $( ".datepicker" ).datetimepicker({ 
        format: 'DD-MM-YYYY',
        maxDate: new Date() 
 });

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
    else if(res.status == 'dbcount'){
        dbcount(res);
    }    
    else if(res.status == 'gpsdatacount'){
        gpsdatacount(res);
    } 
     else if(res.status == 'cordinate'){
        initMap(res);
    } 
    else if(res.status == 'geofence'){
        window.location.href='geofence';
    } 
    else if(res.status == 'vehicle_status'){
        vehicle_details(res);
    }  
}

function backgroundPostData(url, data, callBack, options) { 

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
                if (callBack == 'callBackDataTables'){
                    callBackDataTable();
                }else if(callBack == 'vehicleTrack'){
                    vehicleTrack(res);
                }else if(callBack =='selectVehicleTrack'){
                    selectVehicleTrack(res);
                }else if(callBack =='driverScore'){
                    driverScore(res);
                }else if(callBack == 'emergencyAlert'){
                    emergencyAlert(res);
                }else if(callBack == 'getPlaceName'){
                    getPlaceName(res);
                }else if(callBack == 'verifyAlertResponse'){
                    verifyAlertResponse(res);
                }
                else if(callBack =='selectVehicleModeTrack'){
                    selectVehicleModeTrack(res);
                }
                 else if(callBack =='searchLocation'){
                    searchLocation(res);
                }
            }
        },
        error: function (err) {
            var message = (err.responseJSON)?err.responseJSON.message:err.responseText;
            toastr.error(message, 'Error');
        }
    });

}

function emergencyAlert(res){
    console.log(res);
    if(res.alerts.length > 0){
        var latitude=res.alerts[0].latitude;
        var longitude=res.alerts[0].longitude;
        getPlaceNameFromLatLng(latitude,longitude);
        var modal = document.getElementById('emergency');
        modal.style.display = "block";
        document.getElementById("em_id").value = res.alerts[0].id;
        document.getElementById("alert_vehicle_id").value = res.vehicle;
        $('#emergency_vehicle_driver').text(res.alerts[0].vehicle.driver.name);
        $('#emergency_vehicle_number').text(res.alerts[0].vehicle.register_number);
        $('#emergency_vehicle_time').text(res.alerts[0].device_time);
       
    }
}

function getPlaceNameFromLatLng(latitude,longitude){
    var url = 'get-location';
    var data = { 
     'latitude':latitude,
     'longitude':longitude
    };
    backgroundPostData(url,data,'getPlaceName',{alert:false});
   
}
function getPlaceName(res){
    $('#emergency_vehicle_location').text(res);
}

function verifyEmergency(){
    var id = document.getElementById("em_id").value;
    VerifyAlert(id);
}
function track_vehicle(){
    var id = document.getElementById("alert_vehicle_id").value;
    window.location.href = "/vehicles/" + id+"/location";
}

function VerifyAlert(alert_id){
    if(confirm('Are you sure want to verify this alert?')){
        var url = 'alert/verify';
        var data = {
        id : alert_id
        };
        backgroundPostData(url,data,'verifyAlertResponse',{alert:true}); 
    } 
}

function verifyAlertResponse(res){
    if(res){
        var modal = document.getElementById('emergency');
        modal.style.display = "none";
    }
}


function downloadFile(url,data){

    var purl = getUrl() + '/'+url ;

    $.ajax({
            cache: false,
            type: 'POST',
            url: purl,
            data: data,
             //xhrFields is what did the trick to read the blob to pdf
            xhrFields: {
                responseType: 'blob'
            },
            headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response, status, xhr) {

                var filename = "";                   
                var disposition = xhr.getResponseHeader('Content-Disposition');

                 if (disposition) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                } 
                var linkelem = document.createElement('a');
                try {
                                           var blob = new Blob([response], { type: 'application/octet-stream' });                        

                    if (typeof window.navigator.msSaveBlob !== 'undefined') {
                        //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                        window.navigator.msSaveBlob(blob, filename);
                    } else {
                        var URL = window.URL || window.webkitURL;
                        var downloadUrl = URL.createObjectURL(blob);

                        if (filename) { 
                            // use HTML5 a[download] attribute to specify filename
                            var a = document.createElement("a");

                            // safari doesn't support this yet
                            if (typeof a.download === 'undefined') {
                                window.location = downloadUrl;
                            } else {
                                a.href = downloadUrl;
                                a.download = filename;
                                document.body.appendChild(a);
                                a.target = "_blank";
                                a.click();
                            }
                        } else {
                            window.location = downloadUrl;
                        }
                    }   

                } catch (ex) {
                    console.log(ex);
                } 
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



function downloadAlertReport(){
    
    var url = 'alert-report/export';
    var  vehicles=$('#vehicle').val();
    var  alerts=$('#alert').val();
     if(alerts==null || vehicles==null)
     {
       var alert=0;
       var vehicle=0;
     }
     else
     {
       var alert=alerts;
       var vehicle=vehicles;
     }
     // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'alert':alert,'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'alert':alert,'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}


function downloadGeofenceReport(){
    
    var url = 'geofence-report/export';
    var  vehicles=$('#vehicle').val();   
    if(vehicles==null)
    {
       var vehicle=0;
    }
    else
    {
       var vehicle=vehicles;
    }
     // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}



function downloadTrackReport(){
    
    var url = 'track-report/export';
    var  vehicles=$('#vehicle').val();   
    if(vehicles==null)
    {
       var vehicle=0;
    }
    else
    {
       var vehicle=vehicles;
    }
     // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}
function downloadRouteDeviationReport(){
    
    var url = 'route-report/export';
    var  vehicles=$('#vehicle').val();   
    if(vehicles==null)
    {
       var vehicle=0;
    }
    else
    {
       var vehicle=vehicles;
    }
     // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}

function downloadharshBrakingReport(){
    
    var url = 'harsh-braking-report/export';
    var  vehicles=$('#vehicle').val();   
    if(vehicles==null)
    {
       var vehicle=0;
    }
    else
    {
       var vehicle=vehicles;
    }
     // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}

function downloadSuddenAccelerationReport(){
    
    var url = 'sudden-acceleration-report/export';
    var  vehicles=$('#vehicle').val();   
    if(vehicles==null)
    {
       var vehicle=0;
    }
    else
    {
       var vehicle=vehicles;
    }
     // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}

function downloadOverSpeedReport(){
    
    var url = 'over-speed-report/export';
    var  vehicles=$('#vehicle').val();   
    if(vehicles==null)
    {
       var vehicle=0;
    }
    else
    {
       var vehicle=vehicles;
    }
    // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}


function downloadZigZagDrivingReport(){    
    var url = 'zigzag-driving-report/export';
    var  vehicles=$('#vehicle').val();   
    if(vehicles==null)
    {
       var vehicle=0;
    }
    else
    {
       var vehicle=vehicles;
    }
    // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}


function downloadAccidentImpactAlertReport(){    
    var url = 'accident-imapct-alert-report/export';
    var  vehicles=$('#vehicle').val();   
    if(vehicles==null)
    {
       var vehicle=0;
    }
    else
    {
       var vehicle=vehicles;
    }
    // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}


function downloadMainBatteryDisconnectReport(){    
    var url = 'main-battery-disconnect-report/export';
    var  vehicles=$('#vehicle').val();   
    if(vehicles==null)
    {
       var vehicle=0;
    }
    else
    {
       var vehicle=vehicles;
    }
    // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}


function downloadTotalKMReport(){    
    var url = 'total-km-report/export';
    var  vehicles=$('#vehicle').val();   
    if(vehicles==null)
    {
       var vehicle=0;
    }
    else
    {
       var vehicle=vehicles;
    }
    // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}

function downloadDailyKMReport(){    
    var url = 'daily-km-report/export';
    var  vehicles=$('#vehicle').val();   
    var vehicle=vehicles;
   
    // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}

function downloadIdleReport(){    
    var url = 'idle-report/export';
    var  vehicles=$('#vehicle').val();   
    var vehicle=vehicles;
   
    // console.log(alert);
    var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        downloadFile(url,data);
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}


$(function () {
    /* START OF DEMO JS - NOT NEEDED */
    if (window.location == window.parent.location) {
        $('#fullscreen').html('<span class="glyphicon glyphicon-resize-small"></span>');
        $('#fullscreen').attr('href', 'http://bootsnipp.com/mouse0270/snippets/PbDb5');
        $('#fullscreen').attr('title', 'Back To Bootsnipp');
    }    
    $('#fullscreen').on('click', function(event) {
        event.preventDefault();
        window.parent.location =  $('#fullscreen').attr('href');
    });
    $('#fullscreen').tooltip();
    /* END DEMO OF JS */
    
    $('.navbar-toggler').on('click', function(event) {
        event.preventDefault();
        $(this).closest('.navbar-minimal').toggleClass('open');
    })
    // var url = 'emergency-alert';
    // var data = { 
    
    // };
    // backgroundPostData(url,data,'emergencyAlert',{alert:false});

});




