$(function () {




    const timeout = 9000000;  // 900000 ms = 15 minutes
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
            showClose: true,
            // useCurrent: false,
            // minDate: moment()
            // minDate: new Date(currentYear, currentMonth-3, currentDate),
            // maxDate: new Date(currentYear, currentMonth+3, currentDate)
        });
        $('#fromDate').datetimepicker().on('dp.change', function (e) {
            var startDate = $("#fromDate").val();
            var endDate = $("#toDate").val();
            if( new Date(startDate) > new Date(endDate)){
              alertify.alert("From date should be less than To date").setHeader('<em> Report</em>');
              $("#fromDate").val(endDate);
            }
        });

        $('#toDate').datetimepicker().on('dp.change', function (e) {

            var startDate = $("#fromDate").val();
            var endDate = $("#toDate").val();
            if( new Date(startDate) > new Date(endDate)){
                alertify.alert("To date should be greater than From date").setHeader('<em> Report</em>');
                $("#toDate").val(startDate);
            }
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
    var d = new Date();
    free_date=d.setMonth(d.getMonth() - 1);//// one month
    fundamental_date=d.setMonth(d.getMonth() - 1);// 2 month
    superior_date=d.setMonth(d.getMonth() - 2);// 4 month
    pro_date=d.setMonth(d.getMonth() - 2);///6 month
    var date = new Date();
    var currentMonth = date.getMonth();
    var currentDate = date.getDate();
    var currentYear = date.getFullYear();

    $(".datetimepicker" ).datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        maxDate: new Date()
    });
    $(".datepicker" ).datetimepicker({
        format: 'DD-MM-YYYY',
        defaultDate: null,
        useCurrent: true,
        maxDate: new Date()
     });
    $( ".datepicker_operations" ).datetimepicker({
        format: 'DD-MM-YYYY',
        defaultDate: null,
        useCurrent: true,
        minDate: new Date(currentYear, currentMonth-2, currentDate)
     });
    $( ".datepickerFreebies" ).datetimepicker({
        // format: 'DD-MM-YYYY',
        format: 'YYYY-MM-DD',
        defaultDate: null,
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-1, currentDate)
        // minDate:free_date
    });
    $(".datepickerFundamental").datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: null,
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-2, currentDate)
        // minDate:fundamental_date
    });




    $( ".datepickerSuperior" ).datetimepicker({
        // format: 'DD-MM-YYYY',
        format: 'YYYY-MM-DD',
        useCurrent: true,
        defaultDate: null,
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-4, currentDate)
        // minDate:superior_date
     });
    $(".datepickerPro" ).datetimepicker({
        format: 'YYYY-MM-DD',
        // format: 'DD-MM-YYYY',
        defaultDate: null,
        useCurrent: true,
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-6, currentDate)
        // minDate:pro_date
    });

    $( ".monthpickerFreebies" ).datetimepicker({
        format: 'MM-YYYY',
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-1, currentDate)
    });
    $(".monthpickerFundamental").datetimepicker({
        format: 'MM-YYYY',
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-2, currentDate)
    });
    $( ".monthpickerSuperior" ).datetimepicker({
        format: 'MM-YYYY',
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-4, currentDate)
     });
    $(".monthpickerPro" ).datetimepicker({
        format: 'MM-YYYY',
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-6, currentDate)
    });

    $('.datepickerFundamental').val("");
    $('.datepickerFreebies').val("");
    $('.datepickerSuperior').val("");
    $('.datepickerPro').val("");

    $( ".performancedatepickerSuperior" ).datetimepicker({
        // format: 'DD-MM-YYYY',
        format: 'YYYY-MM-DD',
        useCurrent: true,
        defaultDate: null,
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-4, currentDate)
        // minDate:superior_date
     });
    $(".performancedatepickerPro" ).datetimepicker({
        format: 'YYYY-MM-DD',
        // format: 'DD-MM-YYYY',
        defaultDate: null,
        useCurrent: true,
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-6, currentDate)
        // minDate:pro_date
    });
    $( ".performancedatepickerFreebies" ).datetimepicker({
        // format: 'DD-MM-YYYY',
        format: 'YYYY-MM-DD',
        defaultDate: null,
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-1, currentDate)
        // minDate:free_date
    });
    $(".performancedatepickerFundamental").datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: null,
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-2, currentDate)
        // minDate:fundamental_date
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
   maxDate: moment().millisecond(0).second(0).minute(0).hour(0)

 });
 $(".job_date_picker" ).datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        minDate: new Date()
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
      toastr.error( res.message, res.title);
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

                // console.dir(Object.keys(window));
                // window['callBackDataTables'](res);
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
                }else if(callBack =='fuelGraph'){
                    fuelGraph(res);
                }else if(callBack == 'continuousAlert'){
                    continuousAlert(res);
                }else if(callBack == 'getPlaceName'){
                    getPlaceName(res);
                }else if(callBack == 'verifyAlertResponse'){
                    verifyAlertResponse(res);
                }else if(callBack == 'verifyCriticalAlertResponse'){
                    verifyCriticalAlertResponse(res);
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
                 else if(callBack =='rootTrader'){

                rootTrader(res);
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
                else if(callBack=='kmReport')
                {
                    kmReport(res);
                }else if(callBack=='geofenceResponse')
                {
                    geofenceResponse(res);
                }
                else if(callBack=='gpsData'){
                         gpsData(res);
                }else if(callBack=='gpsDataBth'){
                         gpsDataBth(res);
                }else if(callBack=='alldata'){
                         alldata(res);
                }
                else if(callBack=='gpsDataHlm'){
                         gpsDataHlm(res);
                }
                else if(callBack=='allGpsConfiguredata')
                {
                    allGpsConfiguredata(res);
                }

                else if(callBack=='setOtaParams')
                {
                    setOtaParams(res);
                }
                else if(callBack=='gpsAlert')
                {
                    gpsAlert(res);

                }
                else if(callBack=='gpsAlertTracker')
                {
                    gpsAlertTracker(res);

                }
                 else if(callBack=='getConfigData')
                {
                    getConfigData(res);

                }
                else if(callBack=='jobsComplete')
                {
                    jobsComplete(res);

                }


                else if(callBack=='vehicleModel')
                {
                    vehicleModel(res);

                }
                else if(callBack=='allgpsAlertList')
                {
                    allgpsAlertList(res);

                }
                else if(callBack=='getDeviceTransferList')
                {
                    getDeviceTransferList();
                }
                else if(callBack=='notificationAlertsList')
                {
                    notificationAlertsList(res);
                }
                else if(callBack=='getUploadDocs')
                {
                    getUploadDocs(res);
                }
                else if(callBack=='getUploads'){
                    getUploads(res);
                }
                else if(callBack=='gpsAlertconfirm'){
                    gpsAlertconfirm(res);
                }
                else if(callBack =='monthFuelGraph'){
                    monthFuelGraph(res);
                }

                else if(callBack=='rootVehicle'){
                    rootVehicle(res);
                }







            }
        },
        error: function (err) {
            var message = (err.responseJSON)?err.responseJSON.message:err.responseText;
        }
    });

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
    $('#alert_address').text(res);
    $('#emergency_vehicle_location').text(res);
    $('#header_emergency_vehicle_location').text(res);
    $('#critical_alert_location').text(res);
}

function verifyEmergency(){
    var alert_id = document.getElementById("emergency_alert_id").value;
    var decrypt_id = document.getElementById("decrypt_vehicle_id").value;
    var firebase_key = document.getElementById("firebase_key").value;
    VerifyAlert(alert_id,decrypt_id);
    notify.markFirebaseEmergencyNotificationAsRead(firebase_key);
}

function verifyHeaderEmergency(){
    var alert_id = document.getElementById("header_emergency_alert_id").value;
    var decrypt_id = document.getElementById("header_decrypt_vehicle_id").value;
    var firebase_key = document.getElementById("firebase_key").value;
    VerifyAlert(alert_id,decrypt_id);
    notify.markFirebaseEmergencyNotificationAsRead(firebase_key);
}

function track_vehicle(){
    var id = document.getElementById("alert_vehicle_id").value;
    window.location.href = "/vehicles/" + id+"/location";
}

function VerifyAlert(alert_id,decrypt_vehicle_id){
        if(typeof(Storage) !== "undefined") {
            localStorage.setItem("qwertasdfgzxcvb", decrypt_vehicle_id);
        }
        var url = 'emergency-alert/verify';
        var data = {
            id : alert_id
        };
        backgroundPostData(url,data,'verifyAlertResponse',{alert:false});

}

function verifyAlertResponse(res){
    // console.log(res);
    if(res){
        var modal = document.getElementById('emergency');
        modal.style.display = "none";
        $("#header-emergency").hide();
    }
}


// function downloadFile(url,data){
//     var purl = getUrl() + '/'+url ;
//     $.ajax({
//             cache: false,
//             type: 'POST',
//             url: purl,
//             data: data,
//              //xhrFields is what did the trick to read the blob to pdf
//             xhrFields: {
//                 responseType: 'blob'
//             },
//             headers: {
//             'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
//             },
//             success: function (response, status, xhr) {
//                 console.log(response);
//                 var filename = "";
//                 var disposition = xhr.getResponseHeader('Content-Disposition');

//                  if (disposition) {
//                     var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
//                     var matches = filenameRegex.exec(disposition);
//                     if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
//                 }
//                 var linkelem = document.createElement('a');
//                 try
//                 {
//                     // var BOM = "\uFEFF";
//                     // var  response = BOM + response;
//                     // console.log(response);
//                     var blob = new Blob([response], { type: 'application/octet-stream' });

//                     if (typeof window.navigator.msSaveBlob !== 'undefined') {
//                         //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
//                         window.navigator.msSaveBlob(blob, filename);
//                     } else {
//                         var URL = window.URL || window.webkitURL;
//                         var downloadUrl = URL.createObjectURL(blob);

//                         if (filename) {
//                             // use HTML5 a[download] attribute to specify filename
//                             var a = document.createElement("a");
//                             // console.log(typeof a.download);
//                             // safari doesn't support this yet
//                             if (typeof a.download === 'undefined') {
//                                 // window.location = downloadUrl;
//                             } else {
//                                 // console.log(blob);
//                                 a.href = downloadUrl;
//                                 a.download = filename;
//                                 document.body.appendChild(a);
//                                 a.target = "_blank";
//                                 a.click();
//                             }
//                         } else {
//                             window.location = downloadUrl;
//                         }
//                     }

//                 } catch (ex) {
//                     console.log(ex);
//                 }
//             }
//         });
// }

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
// console.log(xhr);
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
                            // console.log(typeof a.download);
                            // safari doesn't support this yet
                            if (typeof a.download === 'undefined') {
                                // window.location = downloadUrl;
                            } else {
                                // console.log(blob);
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
        }
    });

}




function downloadAlertReport(){
    var url = 'alert-report/export';
    var  vehicles=$('#vehicle').val();
    var  alerts=$('#alert').val();

     if(alerts==0 || vehicles==null)
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

function downloadGpsUnprocessedDataReport(){
    var url = 'gps-unprocessed-records/export';
    var imei=$('#imei').val();
    var date=$('#date').val();

    var data = {
    'imei':imei,'date':date
    };
    downloadFile(url,data);
}

function downloadGpsProcessedDataReport(){
    var url = 'gps-processed-records/export';
    var imei=$('#imei').val();
    var date=$('#date').val();
    var data = {
    'imei':imei,'date':date
    };
    downloadFile(url,data);
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
    // var fromDate=$('#fromDate').val();
    // var toDate=$('#toDate').val();
    // if(fromDate){
    //     var data = {
    //     id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate,'toDate':toDate
    //     };


    //     downloadFile(url,data);
    // }else{

        var data = {
            id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle
        };
        downloadFile(url,data);
    // }
}




function downloadDailyKMReport(){
    var url = 'daily-km-report/export';
    var  vehicles=$('#vehicle').val();
    var vehicle=vehicles;

    // console.log(alert);
    var fromDate=$('#fromDate').val();
    // var toDate=$('#toDate').val();
    if(fromDate){
        var data = {
        id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'fromDate':fromDate
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
});

function clearLocalStorage(){
    localStorage.removeItem("qwertasdfgzxcvb");
    localStorage.setItem('login', 0);
}



function documents(){
    var url = 'notification';
    var data = {};
    backgroundPostData(url,data,'notification',{alert:false});
}
function notification(res){
    if(res){
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
            '<small class="font-light"> No expiring  Documents</small><br>'+
            '</div></div>';
            $("#expire_notification").append(expire_documents);
        }
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


// code
function jobtypeonchange(){
   $("#client").val("");


$('#gps').find('option').remove();




}

function getClientServicerGps(client_id){
    if(client_id)
    {
        var job_type = $("#job_type option:selected").val();
        if(job_type==""||job_type==undefined){
            alert('Please select job type!');
            client_id=0;
            // $("#gps option[value='']").remove();
            // $("#gps").append(new Option("Select GPS", ""));
        }
        var url = 'servicer-client-gps';
        var data = {
             client_id : client_id,
             job_type:job_type
        };
        backgroundPostData(url,data,'clientGps',{alert:false});
    }
}

function clientGps(res)
{
    if(res.code == 1)
    {
        $("#gps").empty();
        var expired_documents;
        length=res.devices.length;
        if(length==0)
        {
            var gps='<option value=" ">No GPS</option>';
            $("#gps").append(gps);
        }
        else
        {
            for (var i = 0; i < length; i++) {
             var gps='  <option value="'+res.devices[i].id+'"  >'+res.devices[i].serial_no+'</option>';
             $("#gps").append(gps);
            }
        }

        $('#search_place').val(res.location);
    }
    else if(res.code == 2)
    {
        $("#gps").empty();
        var gps='<option value=" ">No GPS</option>';
        $("#gps").append(gps);
        $('#search_place').val(res.location);
    }else
    {
        $("#search_place").val('');
        $("#gps").val('');
        $('#client option').prop('selected', function() {
            return this.defaultSelected;
        });

    }
}


function getvehicleModel(res){
    if(res)
    {
        var url = 'get-vehicle-models';
        var data = {
             make_id : res
        };
        backgroundPostData(url,data,'vehicleModel',{alert:false});
    }


}
function vehicleModel(res)
{
    console.log(res);
     $("#model").empty();

    length=res.vehicle_models.length;
   // console.log(res.devices[0].imei);
    for (var i = 0; i < length; i++) {
         var models='  <option value="'+res.vehicle_models[i].id+'"  >'+res.vehicle_models[i].name+'</option>';
         $("#model").append(models);
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

function selectTrader(dealer_id)
{

    var url = 'select/trader';
    var data = {
        dealer_id : dealer_id
    };
    backgroundPostData(url,data,'rootTrader',{alert:true});


}
function rootSubdealer(res)
    {
        $("#sub_dealer").empty();
        var length=res.sub_dealers.length
        sub_dealer_text='<option value="">Choose Dealer from the list</option>';
        for (var i = 0; i < length; i++)
        {
         sub_dealer +='<option value="'+res.sub_dealers[i].id+'"  >'+res.sub_dealers[i].name+'</option>';
        }
        $("#sub_dealer").append(sub_dealer_text+sub_dealer);
    }



function rootTrader(res)
   {
         $("#trader").empty();
         var length=res.traders.length
         trader_text='<option value="">Choose Sub Dealer from the list</option>';
         if(length == 0)
          {
              trader='<option value="">No Sub Dealer</option>';
              $("#trader").append(trader);
          }else
          {
              for (var i = 0; i < length; i++)
               {
              trader+='  <option value="'+res.traders[i].id+'"  >'+res.traders[i].name+'</option>';
               }
              $("#trader").append(trader_text+trader);
        }
   }
   function selectVehicle(client_id)
{

    var url = 'select/vehicle';
    var data = {
        client_id : client_id
    };
    backgroundPostData(url,data,'rootVehicle',{alert:true});


}
function rootVehicle(res)
{
    
        $("#device").empty();
    
        var length=res.vehicle.length
    
        device_text='<option value="">Choose device from the list</option>';
        if(length == 0)
        {
            device='<option value="">No Device</option>';
            $("#device").append(device);
        }else
        {
            for (var i = 0; i < length; i++)
            {
            device+='  <option value="'+res.vehicle[i].gps.id+'"  >'+res.vehicle[i].gps.imei+'||'+res.vehicle[i].gps.serial_no+'</option>';
            }
            $("#device").append(device_text+device);
    }
}


    //     if(res.emergency_response.status == 'success')
    //     {
    //         var latitude=res.emergency_response.alerts[0].latitude;
    //         var longitude=res.emergency_response.alerts[0].longitude;
    //         getPlaceNameFromLatLng(latitude,longitude);
    //         var vehicle_id=res.emergency_response.alerts[0].gps.vehicle.id;
    //         var alert_id=res.emergency_response.alerts[0].id;
    //         var encrypted_vehicle_id=res.emergency_response.vehicle;
    //         if(res.emergency_response.alerts[0].gps.vehicle.driver != null)
    //         {
    //             var driver_name = res.emergency_response.alerts[0].gps.vehicle.driver.name;
    //         }
    //         else
    //         {
    //             var driver_name = 'Not Assigned';
    //         }
    //         var register_number = res.emergency_response.alerts[0].gps.vehicle.register_number;
    //         var alert_time = res.emergency_response.alerts[0].device_time;
    //         if(localStorage.getItem("qwertasdfgzxcvb") == vehicle_id ){
    //             $("#header-emergency").show();
    //             document.getElementById("header_em_id").value = alert_id;
    //             document.getElementById("header_alert_vehicle_id").value = encrypted_vehicle_id;
    //             document.getElementById("header_decrypt_vehicle_id").value = vehicle_id;
    //             $('#header_emergency_vehicle_number').text(register_number);
    //             $('#header_emergency_vehicle_time').text(alert_time);
    //         }else{
    //             var modal = document.getElementById('emergency');
    //             modal.style.display = "block";
    //             document.getElementById("em_id").value = alert_id;
    //             document.getElementById("alert_vehicle_id").value = encrypted_vehicle_id;
    //             document.getElementById("decrypt_vehicle_id").value = vehicle_id;
    //             $('#emergency_vehicle_number').text(register_number);
    //             $('#emergency_vehicle_time').text(alert_time);
    //         }
    //     }
    //     var  role=$('#header_role').val();
    //     if(role=='62608e08adc29a8d6dbc9754e659f125')
    //     {
    //         // alert(role);
    //         //clientAlerts();
    //     }
    // }

    
/////////////////////////Km Report/////////////////////////
function downloadKMReport(){
    var url = 'km-report/export';
    var  vehicle=$('#vehicle').val();
    var  report_type=$('#report').val();
    if(vehicle==null)
    {
       alert("Please select Vehicle")
    }
    else if(report_type==null)
    {
      alert("Please select Report Type")
    }
    else
    {

        var data = {
    id : $('meta[name = "client"]').attr('content'),'vehicle':vehicle,'report_type':report_type
    };
    downloadFile(url,data);
    }

}
function getdata(id){
    var url = 'get-gps-data';
    var data = {
       id:id
    };
    backgroundPostData(url,data,'gpsData',{alert:false});
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
            '<tr><td>Gpx-fix</td><td>'+res.gpsData.gps_fix+'</td></tr>'+

            '<tr><td>Vehicle Mode</td><td>'+res.gpsData.vehicle_mode+'</td></tr>'
        ;
        $("#allDataTable").append(gps);
    // console.log(res);
    $('#gpsDataModal').modal('show');
}


 function getdataBTHList(id){

    var url = 'get-gps-data-bth';
    var data = {
       id:id
    };
    backgroundPostData(url,data,'gpsDataBth',{alert:false});
  }


function gpsDataBth(res)
{

    $("#allDataTable tr").remove();
    var gps=res.gpsData;

        $("#allDataTable").append(gps);
    // console.log(res);
    $('#gpsDataModal').modal('show');
}

function getdataHLMList(id){

    var url = 'get-gps-data-hlm';
    var data = {
       id:id
    };
    backgroundPostData(url,data,'gpsDataHlm',{alert:false});
  }


function gpsDataHlm(res)
{
// console.log(res.gpsData.header);
    $("#allHLMDataTable tr").remove();
    var gps=' <tr><td>Header</td><td>'+res.gpsData.header+'</td></tr>'+
            '<tr><td>Imei</td><td >'+res.gpsData.imei+'</td></tr>'+
            '<tr><td>Vendor Id</td><td>'+res.gpsData.vendor_id+'</td></tr>'+
            '<tr><td>Firmware Version</td><td>'+res.gpsData.firmware_version+'</td></tr>'+
            '<tr><td>Device Date</td><td>'+res.gpsData.device_time+'</td></tr>'+
            '<tr><td>Update ignition rate on</td><td>'+res.gpsData.update_rate_ignition_on+'</td></tr>'+
            '<tr><td> Update ignition rate off</td><td>'+res.gpsData.update_rate_ignition_off+'</td></tr>'+
            '<tr><td>Battery percentage</td><td>'+res.gpsData.battery_percentage+'</td></tr>'+
            '<tr><td> Low battery Threshold value</td><td>'+res.gpsData.low_battery_threshold_value+'</td></tr>'+
            '<tr><td>Memory Percentage </td><td>'+res.gpsData.memory_percentage+'</td></tr>'+
            '<tr><td>Digital IO Status Mode</td><td>'+res.gpsData.digital_io_status+'</td></tr>'+
            '<tr><td>Analog IO Status Mode</td><td>'+res.gpsData.analog_io_status+'</td></tr>'+
            '<tr><td>Date</td><td>'+res.gpsData.date+'</td></tr>'+
            '<tr><td>Time</td><td>'+res.gpsData.time+'</td></tr>';
        $("#allHLMDataTable").append(gps);
    // console.log(res);
    $('#gpsHLMDataModal').modal('show');
}

// function dateDiff(value){
//      var fromDate=$('#fromDate').val();
//      var to_date=value
//      // alert(to_date);
//      if(fromDate!=null||to_date!=null)
//      {
//         if(fromDate>to_date)
//         {
//             document.getElementById("toDate").value = "";
//             alert("Please Select Proper date" );
//         }
//      }
// }
// function fromDateDiff(value){
//      var fromDate=value;
//      var to_date=$('#toDate').val()
//      if(fromDate!=''&&to_date!='')
//      {
//         if(to_date<fromDate)
//         {
//             document.getElementById("fromDate").value = "";
//             alert("Please Select Proper date" );
//         }
//     }
// }
function downloadMonitoringReport(){
    var selected = [];
    var report = document.getElementById("report_type");
    var chks = report.getElementsByTagName("INPUT");
    for (var i = 0; i < chks.length; i++) {
        if (chks[i].checked) {
            selected.push(chks[i].value);
        }
    }
    if(selected.length!=0){
        var vehicle_id=$('#vehicle_id').val();
        var url = 'monitoring-report/export';
        var data = {
            id : $('meta[name = "client"]').attr('content'),
            vehicle_id:vehicle_id,
            report_type:selected
        };
        downloadFile(url,data);
    }
    else{
        alert("Please select report type");
    }
}
function getUploadDocs(res)
{
    // console.log(res);
    if(res.count==3){
        if (confirm('Do you want to delete')){
            var url = '/delete-already-existing';
            var data = {
                expiry_date:res.data.expiry_date,
                document_type_id:res.data.document_type_id,
                // path:res.data.path,
                vehicle_id:res.data.vehicle_id
            };
            backgroundPostData(url,data,'getUploads',{alert:true});
        }else{
            alert("Please delete the document manually");
            location.reload();
        }
    }
    else if(res.count==4){
        alert("Expiry date mismatch");
    }
    else{
        alert("Successfully Created");
        location.reload();
    }
}
function getUploads(res){
    location.reload();
}
// set a flag for login
localStorage.setItem('login', 1);








// ---------------check notification-----------------------------------

    setInterval(function() {
        alertCount();
        clientAlerts();
    }, 8000);

    $( document ).ready(function() {
        alertCount();
        clientAlerts();
    });

    function alertCount()
    {
        $.ajax({
            type:'post',
            // data:data,
            url: url_ms_alerts+'/alert-count',
            dataType: "json",
            success: function (res) 
            {                   
                notificationCount(res.data) ;
            }
        });
    }
// ---------------check notification-----------------------------------

    function notificationCount(res){
            var count_notification=res;
            $("#bell_notification_count").text(count_notification);
    }
    function clientAlerts(){       
        $.ajax({
            type:'post',
            // data:data,
            url: url_ms_alerts+"/last-five-unread-alerts",
            dataType: "json",
            success: function (res) 
            { 
                alertNotification(res.data) ;
            }
        });
    }
        function alertNotification(res)
        {
            $('#load-2').show();           
            if(res)
            {
            $("#alert_notification").empty();
            // display each alerts
            for (var i = 0; i < res.length; i++)
            {
                $("#alert_notification").append('<div class="dropdown-item psudo-link"  data-toggle="modal"  data-target="#myModal3" onclick="gpsAlertUpdate(\''+res[i]._id+'\')">'+res[i].alert_type.description+'<br>('+res[i].gps.connected_vehicle_registration_number+')</div>');
            }
            if(res.length==0){
                $("#alert_notification").append('<div class="dropdown-item" >No alerts found</div>');
            }
            }
        }
        function gpsAlertUpdate(value)
        {
            $("#load2").css("display", "none");
            var data={ id:  value}; 
            $.ajax({
                type:'POST',
                data:data,
                url: url_ms_alerts+"/alert-mark-as-read",
                dataType: "json",
                success: function (res) 
                {         
                    gpsAlertconfirm(res.data.alert) ;
                }
            });
        }
        function gpsAlertconfirm(res)
        {           
            var latitude                =   res.latitude;
            var longitude               =   res.longitude;
            getPlaceNameFromLatLng(latitude,longitude);
            $("#load-2").css("display", "none");
            $('#alert_'+res._id).removeClass('alert');
            var alert_content = res.alert_type.description+' on vehicle '+res.gps.connected_vehicle_name+'('+res.gps.connected_vehicle_registration_number+') at '+res.device_time;
            $('#alert_content').text(alert_content);           
        }