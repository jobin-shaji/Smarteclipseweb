$(function () {

    ////// auto log out 

    const timeout = 900000;  // 900000 ms = 15 minutes
    var idleTimer = null;
    $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
        clearTimeout(idleTimer);

        idleTimer = setTimeout(function () {
            document.getElementById('logout-form').submit();
        }, timeout);
    });
    $("body").trigger("mousemove");

    ///////

    var d = new Date();
    var free_months=d.setMonth(d.getMonth() - 3);

    $('.select2').select2();           
        $('#fromDate,#toDate').datetimepicker({
            useCurrent: false,
            minDate: moment()
            // minDate: new Date(currentYear, currentMonth-3, currentDate),
            // maxDate: new Date(currentYear, currentMonth+3, currentDate)
        });
        $('#fromDate').datetimepicker().on('dp.change', function (e) {
            var startdate=$(this).data('fromdate');
            var incrementDay = moment().millisecond(0).second(0).minute(0).hour(0);

            incrementDay.add(1, 'days');

            $('#toDate').data('DateTimePicker').minDate(incrementDay);
            $(this).data("DateTimePicker").hide();
        });
        $('#toDate').datetimepicker().on('dp.change', function (e) {
            
            var decrementDay = moment(new Date(e.date));
            decrementDay.subtract(0, 'days');
            $('#fromDate').data('DateTimePicker').maxDate(decrementDay);
            $(this).data("DateTimePicker").hide();
        });

        





        $('#assignfromDate').datetimepicker().on('dp.change', function (e) {
            var incrementDay = moment(new Date(e.date));
            incrementDay.add(1, 'days');
            $('#assignToDate').data('DateTimePicker').minDate(incrementDay);
            $(this).data("DateTimePicker").hide();
        });

        $('#assignToDate').datetimepicker().on('dp.change', function (e) {
            
            var decrementDay = moment(new Date(e.date));
            decrementDay.subtract(1, 'days');
            $('#assignfromDate').data('DateTimePicker').maxDate(decrementDay);
            $(this).data("DateTimePicker").hide();
        });


            $('#playback_fromDate').datetimepicker().on('dp.change', function (e) {
                var startdate=$(this).data('fromdate');
                var incrementDay = moment(new Date(e.date));
                incrementDay.add(1, 'days');
                $(this).data('DateTimePicker').minDate(startdate);
                $('#playback_toDate').data('DateTimePicker').minDate(incrementDay);
                $(this).data("DateTimePicker").hide();
            });

            $('#playback_toDate').datetimepicker().on('dp.change', function (e) {
                
                var decrementDay = moment(new Date(e.date));
                decrementDay.subtract(1, 'days');
                $('#playback_fromDate').data('DateTimePicker').maxDate(decrementDay);
                $(this).data("DateTimePicker").hide();
            });


            $('#alert_fromDate').datetimepicker().on('dp.change', function (e) {
                var startdate=$(this).data('fromdate');
                var incrementDay = moment(new Date(e.date));
                incrementDay.add(1, 'days');
                $(this).data('DateTimePicker').minDate(startdate);
                $('#alert_toDate').data('DateTimePicker').minDate(incrementDay);
                $(this).data("DateTimePicker").hide();
            });

            $('#alert_toDate').datetimepicker().on('dp.change', function (e) {
                
                var decrementDay = moment(new Date(e.date));
                decrementDay.subtract(1, 'days');
                $('#alert_fromDate').data('DateTimePicker').maxDate(decrementDay);
                $(this).data("DateTimePicker").hide();
            });



        });
 // $('.select2').select2();

// dateTimepicker

var d = new Date();
free_date=d.setMonth(d.getMonth() - 1);

fundamental_date=d.setMonth(d.getMonth() - 2);
superior_date=d.setMonth(d.getMonth() - 4);
pro_date=d.setMonth(d.getMonth() - 6);
    $( ".datetimepicker" ).datetimepicker({ 
        format: 'YYYY-MM-DD HH:mm:ss',
        maxDate: new Date() 
    });

    $( ".datepicker" ).datetimepicker({ 
        format: 'DD-MM-YYYY',
        maxDate: new Date() 
 });
$( ".datepickerFreebies" ).datetimepicker({ 
        format: 'DD-MM-YYYY',
        maxDate: new Date(),
        minDate:free_date
 });
$( ".datepickerFundamental" ).datetimepicker({ 
        format: 'DD-MM-YYYY',
        maxDate: new Date(),
        minDate:fundamental_date
 });
$( ".datepickerSuperior" ).datetimepicker({ 
        format: 'DD-MM-YYYY',
        maxDate: new Date(),
        minDate:superior_date
 });
$( ".datepickerPro" ).datetimepicker({ 
        format: 'DD-MM-YYYY',
        maxDate: new Date(),
        minDate:pro_date
 });

    $( ".date_expiry" ).datetimepicker({ 
        format: 'DD-MM-YYYY',
        // minDate: new Date()
        minDate: moment().millisecond(0).second(0).minute(0).hour(0)    
         
 });
$( ".date_expiry_edit" ).datetimepicker({ 
    format: 'DD-MM-YYYY',  
    minDate: moment().millisecond(0).second(0).minute(0).hour(0)     
    // minDate: moment().subtract(1,'d')
 });

 $( ".manufacturing_date" ).datetimepicker({ 
    format: 'DD-MM-YYYY',
    minDate: '2019-01-01',       
    // maxDate: new Date(),
    maxDate: moment().millisecond(0).second(0).minute(0).hour(0)
    // useCurrent: false
   
 });
 $( ".manufacturing_date_edit" ).datetimepicker({ 
    format: 'DD-MM-YYYY',
    minDate: '2019-01-01',       
    // maxDate: new Date(),
    maxDate: moment().millisecond(0).second(0).minute(0).hour(0)
    // useCurrent: false
   
 });

function getUrl(){
  return $('meta[name = "domain"]').attr('content');
}

function toast(res){
    // alert(res.status);
    
   if(res.status == 1){
        toastr.success( res.message, res.title);

    }
    else if(res.status == 0) {
      
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
    else if(res.status == 'notification'){

        notification(res);
    } 
    
     else if(res.status == 'mobile_already'){

        driverMobileExisted(res);
    } 
    else if(res.status =='driver'){

        servicerDriver(res);
    }
    else if(res.status=='vehicleModeCount')
    {
        vehicleModeCount(res);
    }
     else if(res.status == 'school geofence'){
        window.location.href='/client/profile';
    } 
    else if(res.status == 'edit geofence'){
        window.location.href='/geofence';
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
            
           if(options.alert==true){
            toast(res);
            }
            if (callBack){
                if (callBack == 'callBackDataTables'){

                    callBackDataTable();
                }else if(callBack == 'vehicleTrack'){
                    vehicleTrack(res);
                }else if(callBack =='selectVehicleTrack'){
                    selectVehicleTrack(res);
                }else if(callBack =='driverScore'){
                    driverScore(res);
                }else if(callBack =='driverScoreAlerts'){
                    driverScoreAlerts(res);
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
                }else if(callBack == 'loadMap'){
                    loadMap(res);
                }
                else if(callBack =='rootGpsSale'){
                    
                    rootGpsSale(res);
                }
                else if(callBack =='rootGpsUser'){
                    
                    rootGpsUser(res);
                }
                else if(callBack =='dealerGpsSale'){
                    
                    dealerGpsSale(res);
                }
                else if(callBack =='dealerGpsUser'){
                    
                    dealerGpsUser(res);
                }
                
                else if(callBack =='subDealerGpsSale'){
                    
                    subDealerGpsSale(res);
                }
                else if(callBack =='subDealerGpsUser'){
                    
                    subDealerGpsUser(res);
                }
                else if(callBack =='clientGps'){

                    clientGps(res);
                }
                else if(callBack =='vehicleInvoice'){

                    vehicleInvoice(res);
                }

                else if(callBack =='AssignClientRole'){

                    AssignClientRole(res);
                }
                else if(callBack =='rootSubdealer'){

                    rootSubdealer(res);
                }
                else if(callBack =='assignRouteCount'){

                    assignRouteCount(res);
                }
                else if(callBack =='assignGeofenceCount'){

                    assignGeofenceCount(res);
                }else if(callBack=='notificationCount'){
                         notificationCount(res);
                }else if(callBack=='gpsData'){
                         gpsData(res);

                }else if(callBack=='playBackData'){
                    
                         playBackData(res);
                }

                else if(callBack== 'alertNotification'){
                    alertNotification(res);
                } 
                else if(callBack== 'downloadData'){
                    downloadData(res);
                } 
                else if(callBack== 'modecount'){
                    modecount(res);
                } 
                else if(callBack=='vehicleTrackReport')
                {
                   vehicleTrackReport(res) 
                }
                else if(callBack=='vehicleIdleReport')
                {
                   vehicleIdleReport(res) 
                }
                else if(callBack=='vehicleParkingReport')
                {
                   vehicleParkingReport(res) 
                }
                else if(callBack=='alertsReport')
                {
                   alertsReport(res) 
                }
                else if(callBack=='TotalKM')
                {
                   TotalKM(res) 
                }
                

                


                
               
            }
        },
        error: function (err) {
            var message = (err.responseJSON)?err.responseJSON.message:err.responseText;
            // toastr.error(message, 'Error');
            // console.log(message);
        }
    });

}

function emergencyAlert(res){
    if(res.status == 'success'){
        var latitude=res.alerts[0].latitude;
        var longitude=res.alerts[0].longitude;
        getPlaceNameFromLatLng(latitude,longitude);
        var vehicle_id=res.alerts[0].gps.vehicle.id;
        if(localStorage.getItem("qwertasdfgzxcvb") == vehicle_id ){
            $("#header-emergency").show();
            document.getElementById("header_em_id").value = res.alerts[0].id;
            document.getElementById("header_alert_vehicle_id").value = res.vehicle;
            document.getElementById("header_decrypt_vehicle_id").value = vehicle_id;
            $('#header_emergency_vehicle_driver').text(res.alerts[0].gps.vehicle.driver.name);
            $('#header_emergency_vehicle_number').text(res.alerts[0].gps.vehicle.register_number);
            $('#header_emergency_vehicle_time').text(res.alerts[0].device_time);
        }else{
            var modal = document.getElementById('emergency');
            modal.style.display = "block";
            document.getElementById("em_id").value = res.alerts[0].id;
            document.getElementById("alert_vehicle_id").value = res.vehicle;
            document.getElementById("decrypt_vehicle_id").value = vehicle_id;
            $('#emergency_vehicle_driver').text(res.alerts[0].gps.vehicle.driver.name);
            $('#emergency_vehicle_number').text(res.alerts[0].gps.vehicle.register_number);
            $('#emergency_vehicle_time').text(res.alerts[0].device_time);
        }
       
    }
}

function openPremium(){
        var modal = document.getElementById('headerModal');
        modal.style.display = "block";
}

function closePremium(){
        var modal = document.getElementById('headerModal');
        modal.style.display = "none";
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
    $('#header_emergency_vehicle_location').text(res);
}

function verifyEmergency(){
    var id = document.getElementById("alert_vehicle_id").value;
    var decrypt_id = document.getElementById("decrypt_vehicle_id").value;
    VerifyAlert(id,decrypt_id);
}

function verifyHeaderEmergency(){
    var id = document.getElementById("header_alert_vehicle_id").value;
    var decrypt_id = document.getElementById("header_decrypt_vehicle_id").value;
    VerifyAlert(id,decrypt_id);
}

function track_vehicle(){
    var id = document.getElementById("alert_vehicle_id").value;
    window.location.href = "/vehicles/" + id+"/location";
}

function VerifyAlert(vehicle_id,decrypt_vehicle_id){
   
        if(typeof(Storage) !== "undefined") {
            localStorage.setItem("qwertasdfgzxcvb", decrypt_vehicle_id);
        }
        var url = 'emergency-alert/verify';
        var data = {
        id : vehicle_id
        };
        backgroundPostData(url,data,'verifyAlertResponse',{alert:false}); 
     
}

function verifyAlertResponse(res){
    if(res){
        var modal = document.getElementById('emergency');
        modal.style.display = "none";
        $("#header-emergency").hide();
    }
}


function downloadFile(url,data){

    var purl = getUrl() + '/'+url ;
console.log(data);
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
                        console.log(downloadUrl);
                        // if (filename) { 
                        //     // use HTML5 a[download] attribute to specify filename
                        //     var a = document.createElement("a");
                        //     // console.log(typeof a.download);
                        //     // safari doesn't support this yet
                        //     if (typeof a.download === 'undefined') {
                        //         // window.location = downloadUrl;
                        //     } else {

                        //         a.href = downloadUrl;
                        //         a.download = filename;
                        //         document.body.appendChild(a);
                        //         a.target = "_blank";
                        //         a.click();
                        //     }
                        // } else {
                        //     window.location = downloadUrl;
                        // }
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
     // console.log(alerts);
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
         // backgroundPostData(url,data,'downloadData',{alert:false});
         
         
        // 
    }else{
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    }
}
function downloadData(res)
{
    console.log(res.data);
    // if(res.length!=0)
    // {
    //     downloadFile(url,data);
    // }
    // else
    // {
    //     alert("No records");
    // }
    
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


// function downloadTotalKMReport(){    
//     var url = 'total-km-report/export';
//     var  vehicles=$('#vehicle').val();   
//     if(vehicles==null)
//     {
//        var vehicle=0;
//     }
//     else
//     {
//        var vehicle=vehicles;
//     }
//     // console.log(alert);
//     var fromDate=$('#fromDate').val();
//     var toDate=$('#toDate').val();
//     if(fromDate){
//         var data = {
//         id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
//         };
//         console.log(url);
//         downloadFile(url,data);
//     }else{
//         var data = {
//             id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
//         };
//         downloadFile(url,data);
//     }
// }

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



// function selectDealer(dealer)
// {
//     var url = 'select/subdealer';
//     var data = {
//         dealer : dealer      
//     };
//     backgroundPostData(url,data,'rootSubdealer',{alert:true}); 
// }

// function TotalKM(res)
// {
//     console.log(res);
//     //  $("#sub_dealer").empty();
//     //   // var sub_dealer='  <option value=""  >select</option>';  
//     //     // $("#sub_dealer").append(sub_dealer); 
//     // var length=res.sub_dealers.length
//     // for (var i = 0; i < length; i++) {     
//     //      sub_dealer='  <option value="'+res.sub_dealers[i].id+'"  >'+res.sub_dealers[i].name+'</option>';  
//     //     $("#sub_dealer").append(sub_dealer);  
//     // } 
// }









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
  

    setInterval(function() {
        var url = 'emergency-alert';
        var data = { 
        };
        backgroundPostData(url,data,'emergencyAlert',{alert:false});
    }, 8000);

});

function clearLocalStorage(){
    localStorage.removeItem("qwertasdfgzxcvb");
}



function documents(){  
    var url = 'notification';
    var data = {};   
    backgroundPostData(url,data,'notification',{alert:false});           
}
function notification(res){
    $("#notification").empty();
   var expired_documents;

    length=res.expired_documents.length;
    for (var i = 0; i < length; i++) {
     register_number=res.expired_documents[i].vehicle.register_number;
      vehicle_name=res.expired_documents[i].vehicle.name;
     document_name=res.expired_documents[i].document_type.name;
      expiry_date=res.expired_documents[i].expiry_date;
        var expired_documents='  <div class="d-flex no-block align-items-center p-10" >'+
        '<span class="btn btn-success btn-circle"><i class="mdi mdi-file"></i></span>'+
        '<div class="m-l-10">'+
        '<small class="font-light">'+document_name+' expired on '+expiry_date+' </small><br>'+                                        
        '<small class="font-light">'+vehicle_name+'</small><br>'+                                                                     
        '<small class="font-light">'+register_number+'</small><br>'+                                    
        '</div></div>';  
        $("#notification").append(expired_documents);       
    }  

    expire_length=res.expire_documents.length;
 $("#expire_notification").empty();
    for (var i = 0; i < expire_length; i++) { 
        
    expire_register_number=res.expire_documents[i].vehicle.register_number;
      expire_vehicle_name=res.expire_documents[i].vehicle.name;
     expire_document_name=res.expire_documents[i].document_type.name;
      expire_expiry_date=res.expire_documents[i].expiry_date;
     
        var expire_documents='  <div class="d-flex no-block align-items-center p-10"  >'+
        '<span class="btn btn-success btn-circle"><i class="mdi mdi-file"></i></span>'+
        '<div class="m-l-10" >'+
        '<small class="font-light">'+expire_document_name+' expires on '+expire_expiry_date+' </small><br>'+                                        
        '<small class="font-light">'+expire_vehicle_name+'</small><br>'+                                                                     
        '<small class="font-light">'+expire_register_number+'</small><br>'+                                    
        '</div></div>';  
         $("#expire_notification").append(expire_documents); 
      } 

       if(expire_length==0)
      {
        var expire_documents='  <div class="d-flex no-block align-items-center p-10"  >'+
        '<span class="btn btn-success btn-circle"><i class="fa fa-check"></i></span>'+
        '<div class="m-l-10" >'+
        '<small class="font-light"> No expired Documents</small><br>'+                                        
                                       
        '</div></div>';  
         $("#expire_notification").append(expire_documents);   
      }              
}

function clientAlerts(){ 
  var flag;
    var url = 'alert-notification';
    var data = {
        flag:1
    };   
    backgroundPostData(url,data,'alertNotification',{alert:false});           
}
 function alertNotification(res){
    $("#alert_notification").empty();
    length=res.alert.length;

    for (var i = 0; i < length; i++) {
     description=res.alert[i].alert_type.description;

        var alert='<a class="dropdown-item" >'+description+'</a>';  
        $("#alert_notification").append(alert);       
    }   
}

function downloadLabel(id){
    var url = 'gps-transfer-label/export';
    var data = {
        id : id
    };
  downloadFile(url,data);
}

function downloadSosLabel(id){
    var url = 'sos-transfer-label/export';
    var data = {
        id : id
    };
  downloadFile(url,data);
}

function getClientServicerGps(res){
    if(res)
    {       
        var url = 'servicer-client-gps';
        var data = {
             client_id : res
        };   
        backgroundPostData(url,data,'clientGps',{alert:false});   
    }
    
           
}
function clientGps(res)
{
     $("#gps").empty();
    var expired_documents;
    length=res.devices.length;
   // console.log(res.devices[0].imei);
 for (var i = 0; i < length; i++) {
         var gps='  <option value="'+res.devices[i].id+'"  >'+res.devices[i].serial_no+'</option>';  
         $("#gps").append(gps);   
     }    
}
function driverMobileExisted(res)
{
    var closable = alertify.alert().setting('closable');
    alertify.alert()
    .setting({
        'label':'OK',
        'message': 'Already Registered Mobile number' ,
        'onok': function(){ alertify.success('ok');}
    }).show();

}


function downloadInvoice(){    
    var url = 'invoice/export';
    var  vehicle=$('#vehicle').val();   
   var fromDate=$('#fromDate').val();
    var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
        };
        backgroundPostData(url,data,{alert:false});
    }
    else
    {
        // alert("Please select");
        // var data = {
        // id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        // };
        // downloadFile(url,data);
    }
}


function vehicleInvoice(res){    
  // alert(res);
}

$(".cover_track_data").hover(function () {
    $(this).find('.track_status').toggleClass("track_status_hover");
});



$('.cover_vehicle_track_list .cover_track_data').click(function(){
    
    $('.cover_track_data').removeClass("track_status_active");
    $('.cover_track_data .track_status').removeClass("track_status_active_hover");

    $(this).addClass("track_status_active");
    $(this).find('.track_status').addClass("track_status_active_hover");

   
});

function selectDealer(dealer)
{
    var url = 'select/subdealer';
    var data = {
        dealer : dealer      
    };
    backgroundPostData(url,data,'rootSubdealer',{alert:true}); 
}

function rootSubdealer(res)
{
     $("#sub_dealer").empty();
      // var sub_dealer='  <option value=""  >select</option>';  
        // $("#sub_dealer").append(sub_dealer); 
    var length=res.sub_dealers.length
    for (var i = 0; i < length; i++) {     
         sub_dealer='  <option value="'+res.sub_dealers[i].id+'"  >'+res.sub_dealers[i].name+'</option>';  
        $("#sub_dealer").append(sub_dealer);  
    } 
}


// ---------------check notification-----------------------------------
    setInterval(function() {
       
        var url = 'notification_alert_count';
        var data = {};
        backgroundPostData(url,data,'notificationCount',{alert:false});
    }, 8000);//hai

    $( document ).ready(function() {
        var flag;
        var url = 'notification_alert_count';
        var data = {};
        backgroundPostData(url,data,'notificationCount',{alert:false});
      });
// ---------------check notification-----------------------------------

    function notificationCount(res){
        
        if(res.status=="success"){
            var count_notification=res.notification_count;
            
                $("#bell_notification_count").text(count_notification);
                      
        }
    }

   