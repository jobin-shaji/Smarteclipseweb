<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Eclipse</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="assets/img/icon.png" type="image/x-icon" />
    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: { "families": ["Lato:300,400,700,900"] },
            custom: { "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['assets/css/fonts.min.css'] },
            active: function () {
                sessionStorage.fonts = true;
            }
        });

    </script>


    <script src="assets/Scripts/jquery-3.3.1.js"></script>
    <script src="assets/Scripts/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.4.0/jszip.min.js"></script>
    <script src="assets/Scripts/moment.min.js"></script>
    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css?dp-version=1549984893" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/atlantis.min.css">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css">

</head>

<body data-background-color="dark">
    <style>
        #cover-spin {
            position: fixed;
            width: 100%;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: rgba(255,255,255,0.7);
            z-index: 9999;
            display: none;
        }

        @-webkit-keyframes spin {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        #cover-spin::after {
            content: '';
            display: block;
            position: absolute;
            left: 48%;
            top: 40%;
            width: 40px;
            height: 40px;
            border-style: solid;
            border-color: black;
            border-top-color: transparent;
            border-width: 4px;
            border-radius: 50%;
            -webkit-animation: spin .8s linear infinite;
            animation: spin .8s linear infinite;
        }
    </style>

    <div class="wrapper overlay-sidebar">
        <div class="main-header">

            <!-- End Logo Header -->
            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark">
                <div class="container-fluid"><span class="text" style="font-size:20px;font-weight:100;font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;color:white">HERE RME API DEMO</span></div>
            </nav>
            <!-- End Navbar -->
        </div>


        <div class="main-panel">
                <div class="content" style="margin-top: 0!important">
                    <table id="tblInputForm">
                        <input type="text" name="vehicle" id="txtVehicleID">
                        <tr id="trProcessMedium">
                            <a href="#" style="margin-left: 2%">
                                <img src="../../assets/images/back.png" height="50px" width="50px">
                            </a>
                            <label style="font-weight: 700!important;margin-left: 3%" id="dtStartDate">FROM DATE
                            </label>
                            <input type="datetime-local"  id="dtEnddate" class="dt"/>
                            <label style="font-weight: 700!important;margin-left: 2%">TO DATE
                            </label>
                            <input type="datetime-local" class="dt"/>
                            <select class="btn btn-primary btn-sm bbt" id="cmbSelect">
                                <option>Select Speed</option>
                                <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1X
                                </option>
                                <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2X
                                </option>
                                <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3X
                                </option> 
                                <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4X
                                </option> 
                            </select>
                            <button class="btn btn-primary btn-sm bbt" id="btnPlay">Play</button>
                            <button class="btn btn-primary btn-sm bbt" id="btnPause">Pause</button>
                            <button class="btn btn-primary btn-sm bbt" id="btnStop">Stop</button>
                            </tr>
                        </table>
                    </table>  
                    <div id="markers" style="width:1360px;height:600px">        
                        <div class="custom-template open">
                        </div>
                    </div>
                </div>
            </div>



        <div class="main-panel">
            <div class="content">
                <!--<div id="markers" style="width:1800px;height:780px"></div>-->
                <div id="markers" style="width:1360px;height:595px"></div>
                <div class="page-inner mt--5">
                </div>
            </div>
        </div>

        <div id="cover-spin"></div>

        <!-- Custom template | don't include it in your project! -->
        <!--<div class="custom-template" style="top:230px">-->
        <div class="custom-template" style="top:260px">
            <div class="title">Route PlayBack</div>
            <div class="custom-content">
                <div class="switcher">
                    <table id="tblInputForm">
                        <tr id="trProcessMedium">
                            <td>
                                <label style="font-weight:bold">Process Medium</label>
                            </td>
                            <td>
                                <div class="form-check" id="optprocessMedium">
                                    <label>
                                        <input type="radio" name="optionsRadios" value="" id="optServer">
                                        <span style="font-weight:bold">Server</span>
                                    </label>

                                    <label>
                                        <input type="radio" name="optionsRadios" value="" checked="" id="optJson">
                                        <span>Json</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr id="trVehicle">
                            <td>
                                <label style="font-weight:bold">Vehicle ID</label>
                            </td>
                            <td>
                                <textarea id="txtVehicleID" style="width:140px;resize:none;height:30px" rows="1">  </textarea>
                            </td>
                        </tr>
                        <tr id="trStartDate">
                            <td><label style="font-weight:bold">Start Date</label></td>
                            <td>
                                <input type="datetime-local" id="dtStartDate"
                                       name="meeting-time" value="2018-06-12T10:10:10"
                                       style="width:210px;resize:none" max="new moment(Date()).format('YYYY-MM-DDThh:mm:01')" required>
                            </td>
                        </tr>
                        <tr id="trEndDate">
                            <td><label style="font-weight:bold">End Date</label></td>
                            <td>
                                <input type="datetime-local" id="dtEnddate"
                                       name="meeting-time" value="2018-06-12T10:10:10"
                                       style="width:210px;resize:none" required>
                            </td>

                        </tr>


                        <tr id="trSelectFile">
                            <td><label style="font-weight:bold">Select File</label></td>
                            <td><input type="file" class="form-control-file" id="exampleFormControlFile1"></td>
                        </tr>
                        <tr>
                            <td><label style="font-weight:bold">Select Speed (km/hr)         </label></td>
                            <td>
                                <select id="cmbSelect">
                                    <option value="1">1X</option>
                                    <option value="2">2X</option>
                                    <option value="3">3X</option>
                                    <option value="4">4X</option>
                                    <!--<option value="5">5X</option>
                                <option value="6">6X</option>
                                <option value="7">7X</option>
                                <option value="8">8X</option>
                                <option value="9">9X</option>
                                <option value="10">10X</option>
                                <option value="30">30X</option>
                                <option value="100">100X</option>
                                <option value="300">300X</option>-->
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold">Total Distance</td>
                            <td>
                                <textarea id="lblKMRouteCalculation" style="width:90px;resize:none" rows="1" readonly disabled>  </textarea> km<!--<span > km </span>-->
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold"><u> Display :</u> </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;text-align:right">
                                <!--<label style="font-weight:bold">Display Route</label>-->
                                <label class="form-check-label">
                                    <input class="form-check-input" id="chkRoute" type="checkbox" value="">
                                    <span class="form-check-sign">Route</span>
                                </label>

                                <!--<div class="form-check">
                            </div>-->
                            </td>
                            <td style="font-weight:bold;text-align:right">
                                <label class="form-check-label">
                                    <input class="form-check-input" id="chkWarning" type="checkbox" value="">
                                    <span class="form-check-sign">Warning</span>
                                </label>
                                <!--<div class="form-check">
                            </div>-->
                            </td>

                        </tr>

                        <tr>
                            <td style="font-weight:bold"><u> Coverage :</u> </td>
                        </tr>
                        <tr>
                            <td>
                                <label id="lblSpeed" style="font-weight:bold"> Distance(km) </label>

                            </td>
                            <td>
                                <label id="lblSpeed"><span style="font-weight:bold">Time(min)</span></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <textarea id="lblKMValue" style="width:90px;resize:none" rows="1" readonly disabled>  </textarea>
                            </td>
                            <td>
                                <textarea id="lblSpeedValue" style="width:90px;resize:none" rows="1" readonly disabled>  </textarea>
                            </td>
                        </tr>
                    </table>

                    <button class="btn btn-primary btn-sm" id="btnGetRoute">Route</button>
                    <button class="btn btn-primary btn-sm" id="btnPlay">Play</button>
                    <button class="btn btn-primary btn-sm" id="btnPause">Pause</button>
                    <button class="btn btn-primary btn-sm" id="btnReset">Reset</button>
                </div>
            </div>
            <div class="custom-toggle">
                <i class="flaticon-settings"></i>
            </div>
        </div>
        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <!-- jQuery UI -->
    <script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>
    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>
    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <!-- jQuery Vector Maps -->
    <!--<script src="../assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
    <script src="../assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>-->


    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>



    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <!-- Atlantis JS -->
    <script src="assets/js/atlantis.min.js"></script>
    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting-demo.js"></script>
    <!--<script src="../assets/js/demo.js"></script>-->
    <script>
        var MapResult;
        var PauseFlage = false;
        var inpUserSpeed = 1;
        var totalDistance = 0;
        var TotalKM = 0.00;
        var PreviousLinkID = '';
        var CurrentLinkID = '';
        var setTimeoutfunction;
        var TotalTimeTakeninsec = 0.0;
        var pLinkID = '';
        var tmp = arrayCount;
        var i;
        var blPlayCompleted = false;
        var arrPloyLine = new Array();
        var arrTotalKMLink = new Array();
        var timeoutHandle;
        var previousCoorinates;
        var getAnimationLastLinkID = false;
        var arrAnimation = new Array();
        var traceSpeed_PreviousLinkID = '';
        var traceSpeed_CurrentLinkID = '';
        var TracePoint_FirstLoop = false;
        var TracePoint_CurrentDateTime = new Date();
        var TracePoint_PrevDateTime = new Date();
        var inputCollectionPointGroup = new H.map.Group();
        var arrSlicedCollection = new Array();
        var arrSlicedCount = 0;
        var seqNoGroup = 0
        var tmpSeq = 0
        var warnings;
        var bubbleCollection = new Array();
        var tmpCoords = new H.geo.Strip();
        var linkPolylineforBlackColor;
        var previousDatetimeToCalculate;
        var blDatetimeToCalculate = false;
        var arrCollBlackColor = new Array();
        var blackColrPolygonEnd;
        var blackColrPolygonStart;

        var CalculatetotalHours = 0;
        var CalculatetotalMin = 0;
        var CalculatetotalSec = 0;
        var CalculateDateTime = new Date();
        var CurrentTracePoint;
        var PreviousTracePoint;
        var CalculatepreviousTime = new Date()
        var setTimeoutID ;

        var parisMarker = new H.map.Marker({ lat: 48.8567, lng: 2.3508 });
        var objImg = document.createElement('img');
        objImg.src = 'assets/img/Car.png';
        var outerElement = document.createElement('div')
        var domIcon = new H.map.DomIcon(outerElement);
        var bearsMarker = new H.map.DomMarker({ lat: 48.8567, lng: 2.3508 }, {
            icon: domIcon
        });
        var FirstLoop = false

        var traceSpeed = 0
        var arrayCount = 0
        var hidpi = ('devicePixelRatio' in window && devicePixelRatio > 1);
        var secure = (location.protocol === 'https:') ? true : false; // check if the site was loaded via secure connection
        var app_id = "vvfyuslVdzP04AK3BlBq",
            app_code = "f63d__fBLLCuREIGNr6BjQ";

        var mapContainer = document.getElementById('markers');
        //var platform = new H.service.Platform({ app_code: app_code, app_id: app_id, useCIT: true, useHTTPS: secure });
        var platform = new H.service.Platform({ app_code: app_code, app_id: app_id, useHTTPS: secure });
        var maptypes = platform.createDefaultLayers(hidpi ? 512 : 256, hidpi ? 320 : null);
        //var map = new H.Map(mapContainer, maptypes.normal.map, { center: new H.geo.Point(52.11, 0.68), zoom: 5 });

        //Change Log : REQ_ID-05112019_01 : Load Map position based on GeoLocation
        //Changed By : Rafik
        //Change Date : 05/11/2019
        //Purpose : Need to Load map based on device Location
        //Remarks :

        var map = new H.Map(mapContainer, maptypes.normal.map);
        //var map = new H.Map(mapContainer, maptypes.normal.map, { center: new H.geo.Point(52.11, 0.68), zoom: 5 });
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (location) {
                //debugger;
                currrentlat = location.coords.latitude;
                currentlan = location.coords.longitude;
                map.setCenter({ lat: location.coords.latitude, lng: location.coords.longitude });
                map.setZoom(14);
            });
        }
        map.setCenter({ lat: 10.055860, lng: 76.354247 });
        map.setZoom(14);
        //End of Change Log : REQ_ID-05112019_01 : Load Map position based on GeoLocation

        var zoomToResult = true;


        var mapTileService = platform.getMapTileService({
            type: 'base'
        });
        var parameters = {};

        var uTurn = false;

        new H.mapevents.Behavior(new H.mapevents.MapEvents(map)); // add behavior control
        var ui = H.ui.UI.createDefault(map, maptypes); // add UI

        //platform.configure(H.map.render.panorama.RenderEngine); // setup the Streetlevel imagery
        window.addEventListener('resize', function () { map.getViewPort().resize(); });

        // confidence filter
        var lastRespJsonObj = null;
        var DEFAULT_CONFIDENCE_LINK_STYLE = { lineWidth: 8, strokeColor: 'rgba(18, 65, 145, 0.7)', lineJoin: 'round' };
        var HOVER_LINK_STYLE = { lineWidth: 8, strokeColor: 'rgba(255, 65, 145, 1)', lineJoin: "round" };
        var DEFAULT_OFFSET_STYLE = { lineWidth: 1, strokeColor: 'green', lineJoin: 'round' };
        var DEFAULT_TRACE_STYLE = { lineWidth: 1, strokeColor: 'black', lineJoin: 'round' };
        var linkHighlighted = false;

        // icon/markers
        var icons = {};

        // Info Bubbles for LinkInfo display
        var linkDataInfoBubble;

        var full_geometry = new Array();
        var full_geometry_additional = new Array();
        var arrLinkGroup = new Array();

        var objContainer = new H.map.Group();
        var inputTracePointGroup = new H.map.Group();
        var matchedTracePointGroup = new H.map.Group();
        var objContainerforBlackColr = new H.map.Group();

        var MarkerStartEnd = new H.map.Group();
        var MarkerWarning = new H.map.Group();

        var blacklineStyle;
        blacklineStyle = { lineJoin: "round", lineWidth: 3, strokeColor: "black" };

        //linkPolylineforBlackColor = new H.map.Polyline(tmpCoords, { zIndex: 3, style: blacklineStyle });

        var secure = (location.protocol === 'https:') ? true : false;
        $(document).ready(function () {
            //$('#txtVehicleID').val('14');
            //$('#dtStartDate').val(new moment(Date()).format('2019-10-22T10:00:00'));
            //$('#dtEnddate').val(new moment(Date()).format('2019-10-22T10:02:00'))

            //$('#dtStartDate').val(new moment(Date()).format('2019-10-20T10:00:00'));
            //$('#dtEnddate').val(new moment(Date()).format('2019-10-24T17:25:00'))

            //$('#txtVehicleID').val('13');
            //$('#dtStartDate').val(new moment(Date()).format('YYYY-MM-DDThh:mm:ss'));
            //$('#dtEnddate').val(new moment(Date()).format('YYYY-MM-DDThh:mm:ss'))
            document.getElementById("dtStartDate").max = new moment(Date()).format('YYYY-MM-DDThh:mm:01');
            document.getElementById("dtEnddate").max = new moment(Date()).format('YYYY-MM-DDThh:mm:01');
            $('#optServer').trigger('click');
            $('#chkRoute').attr('disabled', true);
            $('#chkWarning').attr('disabled', true);

        });

        $('#optServer').click(function () {
            $('#trVehicle').show();
            $('#trStartDate').show();
            $('#trEndDate').show();
            $('#trSelectFile').hide();
            $('#btnGetRoute').show();
            Reset();
        });

        $('#optJson').click(function () {
            $('#trVehicle').hide();
            $('#trStartDate').hide();
            $('#trEndDate').hide();
            $('#trSelectFile').show();
            $('#btnGetRoute').hide();
            Reset();
        });

        //$('#chkRoute').click


        $('#chkRoute').change(function () {
            //debugger;
            if ($("#chkRoute").is(':checked')) {
                //debugger;
                objContainer.setVisibility(true);
                map.addObject(objContainer);
                map.addObject(objContainerforBlackColr);
            }
            else {
                objContainer.setVisibility(false);
            }
        });

        $('#chkWarning').change(function () {
            //debugger;
            if ($("#chkWarning").is(':checked')) {
                DisplayWarning();
                ShowBubbles(true);
            }
            else {
                ShowBubbles(false);
            }
        });

        var strFileName = '';
        var JsonData = ''
        $('#exampleFormControlFile1').on('change', function () {
            //debugger;
            if ($('#exampleFormControlFile1').get(0).files.length === 0) {
                return;
            }
            var fileReader = new FileReader();
            fileReader.onload = function () {

                var data = fileReader.result;  // data <-- in this var you have the file data in Base64 format
                if (strFileName == 'gpx') {
                    //debugger;
                    LoadRMEAPI(data);
                }
                else if (strFileName == 'json') {
                    $('#cover-spin').show(0);
                    JsonData = CreateJsonDataFile(data);
                    LoadRMEAPI(JsonData);
                }
                $("#btnPlay").attr("disabled", false);
                $("#btnPause").attr("disabled", true);

            };
            //fileReader.readAsDataURL($('#exampleFormControlFile1').prop('files')[0]);
            fileReader.readAsText($('#exampleFormControlFile1').prop('files')[0]);
            strFileName = $('#exampleFormControlFile1').prop('files')[0].name.split('.')[1];
        });

        function CreateJsonDataFile(data) {
            var tmpstring = '';
            tmpstring = tmpstring + '<?xml version="1.0" encoding="UTF-8" standalone="no" ?>'
            tmpstring = tmpstring + '<gpx xmlns="http://www.topografix.com/GPX/1/1" xmlns:gpxx="http://www.garmin.com/xmlschemas/GpxExtensions/v3" xmlns:gpxtpx="http://www.garmin.com/xmlschemas/TrackPointExtension/v1" creator="mapstogpx.com" version="1.1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd http://www.garmin.com/xmlschemas/GpxExtensions/v3 http://www.garmin.com/xmlschemas/GpxExtensionsv3.xsd http://www.garmin.com/xmlschemas/TrackPointExtension/v1 http://www.garmin.com/xmlschemas/TrackPointExtensionv1.xsd">'
            tmpstring = tmpstring + '<metadata>'
            tmpstring = tmpstring + '<link href="http://www.mapstogpx.com">'
            tmpstring = tmpstring + '<text>XXXXX XXXXXX</text>'
            tmpstring = tmpstring + '</link>'
            //tmpstring = tmpstring + '<time>2019-08-21T15:23:25Z</time>'
            tmpstring = tmpstring + '<time>2019-08-21 15:23:25</time>'
            tmpstring = tmpstring + '</metadata>'
            tmpstring = tmpstring + '<trk>'
            tmpstring = tmpstring + '<name>XXXXX to XXXXX</name>'
            tmpstring = tmpstring + '<number>1</number>'
            tmpstring = tmpstring + '<trkseg>'
            var strLatitude = '';
            var strLongitude = '';
            var stringDatetime = '';
            var strSpeed = '';

            var FlagLatitude = false;
            var FlagLongitude = false;
            var FlagstrDatetime = false;
            var FlagstrSpeed = false;
            //debugger;
            for (var i = 0; i < data.split(',').length - 1; i++) {
                if ((data.split(',')[i].indexOf('latitude') >= 0) && (data.split(',')[i].split(':')[0].replace('"', '').replace('"', '').trim().toUpperCase() == 'LATITUDE')) {
                    //debugger;
                    strLatitude = data.split(',')[i].substring(data.split(',')[i].indexOf('latitude'), data.split(',')[i].length).split(':')[1]
                    FlagLatitude = true;

                }
                if ((data.split(',')[i].indexOf('longitude') >= 0) && (data.split(',')[i].split(':')[0].replace('"', '').replace('"', '').trim().toUpperCase() == 'LONGITUDE')) {
                    strLongitude = data.split(',')[i].substring(data.split(',')[i].indexOf('longitude'), data.split(',')[i].length).split(':')[1].substring(0, 12).replace("}", "").replace("]", "").replace("[", "")
                    FlagLongitude = true;
                }

                if (data.split(',')[i].indexOf('dateTime') >= 0) {
                    if ($('[id="optServer"]').is(':checked')) {
                        stringDatetime = data.split(',')[i].substring(data.split(',')[i].indexOf('dateTime'), data.split(',')[i].length).split(':')[1].split(' ')[0] + 'T' + data.split(',')[i].substring(data.split(',')[i].indexOf('dateTime'), data.split(',')[i].length).split(':')[1].split(' ')[1] + ':' + data.split(',')[i].substring(data.split(',')[i].indexOf('dateTime'), data.split(',')[i].length).split(':')[2] + ':' + data.split(',')[i].substring(data.split(',')[i].indexOf('dateTime'), data.split(',')[i].length).split(':')[3] + 'Z';
                    }
                    else {
                        stringDatetime = data.split(',')[i].substring(data.split(',')[i].indexOf('dateTime'), data.split(',')[i].length).split(':')[1].split(' ')[1] + 'T' + data.split(',')[i].substring(data.split(',')[i].indexOf('dateTime'), data.split(',')[i].length).split(':')[1].split(' ')[2] + ':' + data.split(',')[i].substring(data.split(',')[i].indexOf('dateTime'), data.split(',')[i].length).split(':')[2] + ':' + data.split(',')[i].substring(data.split(',')[i].indexOf('dateTime'), data.split(',')[i].length).split(':')[3];
                    }
                    
                    //stringDatetime = data.split(',')[i].substring(data.split(',')[i].indexOf('dateTime'), data.split(',')[i].length).split(':')[1].split(' ')[1] + 'T' + data.split(',')[i].substring(data.split(',')[i].indexOf('dateTime'), data.split(',')[i].length).split(':')[1].split(' ')[2] + ':' + data.split(',')[i].substring(data.split(',')[i].indexOf('dateTime'), data.split(',')[i].length).split(':')[2] + ':' + data.split(',')[i].substring(data.split(',')[i].indexOf('dateTime'), data.split(',')[i].length).split(':')[3];
                    stringDatetime = stringDatetime.replace('"', '').replace('"', '');
                    FlagstrDatetime = true;
                }
                if (data.split(',')[i].indexOf('speed') >= 0) {
                    strSpeed = data.split(',')[i].substring(data.split(',')[i].indexOf('speed'), data.split(',')[i].length).split(':')[1];
                    strSpeed = strSpeed.replace('"', '').replace('"', '');
                    FlagstrSpeed = true;
                }

                if ((FlagLatitude == true) && (FlagLongitude == true) && (FlagstrDatetime == true) && (FlagstrSpeed == true)) {
                    if ($('[id="optServer"]').is(':checked')) {
                        tmpstring = tmpstring + '<trkpt lat=' + strLatitude + ' lon=' + strLongitude + '>'
                    }
                    else {
                        tmpstring = tmpstring + '<trkpt lat=' + strLatitude + ' lon=' + strLongitude + '">'
                    }
                    tmpstring = tmpstring + '<name>TP' + i + '</name>';
                    //tmpstring = tmpstring + '<time>2019-08-21T15:23:25Z</time>';
                    tmpstring = tmpstring + '<time>' + stringDatetime + '</time>';
                    tmpstring = tmpstring + "<extensions><speed>" + strSpeed + "</speed></extensions>";
                    tmpstring = tmpstring + '</trkpt>';
                    FlagLatitude = false;
                    FlagLongitude = false;
                    FlagstrDatetime = false;
                    FlagstrSpeed = false;
                }
            }
            //debugger;
            tmpstring = tmpstring + '</trkseg>'
            tmpstring = tmpstring + '</trk>'
            tmpstring = tmpstring + '</gpx>'
            tmpstring = tmpstring.replace('undefined', '')
            tmpstring = tmpstring.replace('""', '"');

            return tmpstring;
        }

        function LoadRMEAPI(data) {
            var mapContainer = document.getElementById('markers');
            var url = 'https://rme.api.here.com/2/matchroute.json?app_id=vvfyuslVdzP04AK3BlBq&app_code=f63d__fBLLCuREIGNr6BjQ&routemode=car'

            if (url.indexOf("matchroute.json") >= 0) {
                var zip = new JSZip();
                zip.file("temp.zip", data);
                var content = zip.generate({ type: "base64", compression: "DEFLATE", compressionOptions: { level: 6 } });
                url += "&file=" + encodeURIComponent(content);
                //debugger;
                getJSONP(url, gotRouteMatchResponse);
                objContainer.setVisibility(false);

                $('#chkRoute').attr('disabled', false);
                $('#chkWarning').attr('disabled', false);
            }

        }

        var gotRouteMatchResponse = function (respJsonObj) {
            totalDistance = 0;
            try {
                inputTracePointGroup.removeAll();
                matchedTracePointGroup.removeAll();
            } catch (e) { }

            if (respJsonObj.error != undefined || respJsonObj.faultCode != undefined || respJsonObj.type) {
                alert(respJsonObj.message + "\nStatus: " + respJsonObj.responseCode);
                toggleReverseGeocodeWithHeading = toggleCheckboxesError;
                toggleReverseGeocodeWithoutHeading = toggleCheckboxesError;
                return;
            }
            // safe json
            lastRespJsonObj = respJsonObj;

            // parse links and show on map
            var routeLinks = respJsonObj.RouteLinks;
            var originalTraceStrip = null;
            if (routeLinks == undefined) { // new calculateroute response
                // draw the route
                routeLinks = respJsonObj.response.route[0].leg[0].link;
                // debugger;
                addLinkPointsToObjectContainer(routeLinks, true);
                // draw the original and the matched trace points
                tracePoints = respJsonObj.response.route[0].waypoint;
                //debugger;
                for (var l = 0; l < tracePoints.length; l++) {
                    var p = tracePoints[l];
                    inputTracePointGroup.addObject(new H.map.Marker(new H.geo.Point(p.originalPosition.latitude, p.originalPosition.longitude), { icon: icons["#000000" + l] }));
                    matchedTracePointGroup.addObject(new H.map.Marker(new H.geo.Point(p.mappedPosition.latitude, p.mappedPosition.longitude), { icon: icons["#00FF00" + l] }));
                }
            } else { // old routematch response
                addLinkPointsToObjectContainer(routeLinks, false);
                // draw the original and the matched trace points
                tracePoints = respJsonObj.TracePoints;
                var arrtracePoints_linkIdMatched = new Array();
                tracePoints.forEach(function (elem) {
                    if (arrtracePoints_linkIdMatched.includes(elem.linkIdMatched) == false) {
                        arrtracePoints_linkIdMatched.push(elem.linkIdMatched);
                    }
                });

                var intseqNo = 0;
                var currentLinkID;
                var prevLinkID;
                var blisNeedstobeadded = false;
                var arrCollection = new Array();
                var blIsMultipleTRacePoints = false;
                for (var l = 0; l <= tracePoints.length - 1; l++) {
                    var p = tracePoints[l];
                    inputTracePointGroup.addObject(new H.map.Marker(new H.geo.Point(p.lat, p.lon), { icon: icons["#000000" + l] }));
                    matchedTracePointGroup.addObject(new H.map.Marker(new H.geo.Point(p.latMatched, p.lonMatched), { icon: icons["#00FF00" + l] }));
                    currentLinkID = p.linkIdMatched;
                    blIsMultipleTRacePoints = false;
                    if (p.linkIdMatched != prevLinkID) {
                        var TracePoint_PrevDateTime;
                        var arrSliced = new Array();
                        if ((arrCollection.length > 0) && (blisNeedstobeadded == true)) {
                            if (full_geometry_additional.findIndex(x => x.linkid === prevLinkID) >= full_geometry_additional.findIndex(x => x.linkid === p.linkIdMatched)) {
                                var CollectIndex = new Array();
                                var arrFindProcessedSlice = full_geometry_additional.filter(x => x.linkid === p.linkIdMatched);
                                arrFindProcessedSlice.forEach(function (y) {
                                    if (!CollectIndex.includes(y)) {
                                        CollectIndex.push(full_geometry_additional.findIndex((z => z.linkid === y.linkid) && (z => z.mSecToReachLinkFromStart === y.mSecToReachLinkFromStart)));
                                    }
                                });

                                CollectIndex.filter((x, i, a) => a.indexOf(x) == i).forEach(function (x) {
                                    if (full_geometry_additional.findIndex(x => x.linkid === prevLinkID) <= x) {
                                        arrSliced = full_geometry_additional.slice(
                                            full_geometry_additional.findIndex(x => x.linkid === prevLinkID),
                                            full_geometry_additional.findIndex((z => z.linkid === full_geometry_additional[x].linkid) && (z => z.mSecToReachLinkFromStart === full_geometry_additional[x].mSecToReachLinkFromStart)))
                                    }
                                });
                            }

                            else {
                                arrSliced = full_geometry_additional.slice(
                                    full_geometry_additional.findIndex(x => x.linkid === prevLinkID),
                                    full_geometry_additional.findIndex(x => x.linkid === p.linkIdMatched));
                            }
                            if (arrtracePoints_linkIdMatched[arrtracePoints_linkIdMatched.length - 1] != p.linkIdMatched) {
                                l = l - 1;
                                prevLinkID = tracePoints[l - 1].linkIdMatched;
                            }
                        }
                        else if (arrtracePoints_linkIdMatched[arrtracePoints_linkIdMatched.length - 1] == p.linkIdMatched) {
                            if (tracePoints[l - 1].linkIdMatched != undefined) { // Rafik 
                                prevLinkID = tracePoints[l - 1].linkIdMatched;
                            }
                            
                            arrSliced = full_geometry_additional.slice(
                                full_geometry_additional.findIndex(x => x.linkid === prevLinkID),
                                full_geometry_additional.findIndex(x => x.linkid === p.linkIdMatched));
                        }

                        else {
                            arrSliced = full_geometry_additional.slice(
                                full_geometry_additional.findIndex(x => x.linkid === p.linkIdMatched),
                                full_geometry_additional.findIndex(x => x.linkid === tracePoints[l + 1].linkIdMatched));
                            prevLinkID = p.linkIdMatched;
                        }


                        if ((arrCollection.length > 0) && (blisNeedstobeadded == true)) {
                            blisNeedstobeadded = false;
                            arrCollection = [];
                        }

                        var SpeedCollection = 0;

                        if (arrSliced.length == 0) {
                            if (full_geometry_additional.filter(o => o.linkid === p.linkIdMatched).length > 0) {
                                full_geometry_additional.filter(o => o.linkid === p.linkIdMatched).forEach(function (elem) {
                                    arrCollection.push(elem);
                                });
                                blisNeedstobeadded = true;
                            }
                        }

                        if (arrtracePoints_linkIdMatched[arrtracePoints_linkIdMatched.length - 1] == p.linkIdMatched) {
                            full_geometry_additional.filter(o => o.linkid === p.linkIdMatched).forEach(function (elem) {
                                arrSliced.push(elem);
                            });
                            prevLinkID = p.linkIdMatched;
                        }

                        if (arrSliced.length > 0) {
                            var arrFindUnique = new Array();
                            arrSliced.forEach(function (elem) {
                                if (arrFindUnique.includes(elem.linkid) == false) {
                                    arrFindUnique.push(elem.linkid);
                                }
                            });

                            var SpeedCollection;
                            var millisecondCollection = 0;

                            if (arrFindUnique.length > 0) {
                                arrFindUnique.forEach(function (MatchedID) {

                                    var tmpArr = tracePoints.filter(o => o.linkIdMatched === MatchedID);
                                    if (tmpArr.length > 0) {
                                        if (tmpArr.length > 1) {
                                            for (var k = 0; k < tmpArr.length - 1; k++) {
                                                SpeedCollection += tmpArr[k].speedMps;

                                                if (blDatetimeToCalculate == true) {
                                                    collect_TracePoint_PrevDateTime = previousDatetimeToCalculate;
                                                    blDatetimeToCalculate = false;
                                                }
                                                else {
                                                    var collect_timestamp = Number(tmpArr[k].timestamp);
                                                    localStorage.setItem("mytimestamp", collect_timestamp);
                                                    var mydate = localStorage.getItem("mytimestamp");
                                                    var collect_TracePoint_PrevDateTime = new Date(Number(mydate));

                                                }

                                                var collect_timestamp = Number(tmpArr[k + 1].timestamp);
                                                localStorage.setItem("mytimestamp", collect_timestamp);
                                                var mydate = localStorage.getItem("mytimestamp");
                                                var collect_TracePoint_CurrentDateTime = new Date(Number(mydate));
                                                millisecondCollection += collect_TracePoint_CurrentDateTime.getTime() - collect_TracePoint_PrevDateTime.getTime();
                                                blIsMultipleTRacePoints = true;
                                            }
                                            //debugger;
                                            var collect_timestamp = Number(tmpArr[tmpArr.length - 1].timestamp);
                                            localStorage.setItem("mytimestamp", collect_timestamp);
                                            var mydate = localStorage.getItem("mytimestamp");
                                            var collect_TracePoint_CurrentDateTime = new Date(Number(mydate));
                                            millisecondCollection += collect_TracePoint_CurrentDateTime.getTime() - collect_TracePoint_PrevDateTime.getTime();
                                        }

                                        SpeedCollection += tmpArr[tmpArr.length - 1].speedMps;
                                        if (millisecondCollection < 0) {

                                            var previousTime = Number(tracePoints[tracePoints.findIndex(x => x.linkIdMatched === prevLinkID) - 1]["timestamp"]);
                                            localStorage.setItem("mytimestamp", previousTime);
                                            var previousmydate = localStorage.getItem("mytimestamp");
                                            previousDatetimeToCalculate = new Date(Number(previousmydate));
                                            blDatetimeToCalculate = true;
                                            millisecondCollection = 0;
                                        }
                                    }
                                });
                            }
                            /// Time Calaulation Adjustment
                            if (blDatetimeToCalculate == true) {
                                collect_TracePoint_PrevDateTime = previousDatetimeToCalculate;
                                blDatetimeToCalculate = false;
                            }
                            else {
                                var timestamp = Number(p.timestamp);
                                localStorage.setItem("mytimestamp", timestamp);
                                var mydate = localStorage.getItem("mytimestamp");
                                TracePoint_PrevDateTime = new Date(Number(mydate));
                            }

                            if (arrtracePoints_linkIdMatched[arrtracePoints_linkIdMatched.length - 1] == p.linkIdMatched) {
                                var timestamp = Number(tracePoints[l].timestamp);
                                localStorage.setItem("mytimestamp", timestamp);
                                var mydate = localStorage.getItem("mytimestamp");
                                var TracePoint_CurrentDateTime = new Date(Number(mydate));
                                var Diff = TracePoint_CurrentDateTime.getTime() - TracePoint_PrevDateTime.getTime();
                            }
                            else {
                                var timestamp = Number(tracePoints[l + 1].timestamp);
                                localStorage.setItem("mytimestamp", timestamp);
                                var mydate = localStorage.getItem("mytimestamp");
                                var TracePoint_CurrentDateTime = new Date(Number(mydate));
                                var Diff = TracePoint_CurrentDateTime.getTime() - TracePoint_PrevDateTime.getTime();
                            }


                            //// End Time Calaulation Adjustment
                            intseqNo = intseqNo + 1;
                            if (blIsMultipleTRacePoints == false) {
                                arrSliced.forEach(function (el) {
                                    el.millisecpermeter = SpeedCollection + (Diff / arrSliced.length);
                                    el.seqNo = intseqNo;
                                    el.speedMps = p.speedMps;
                                    SpeedCollection = SpeedCollection + ((Diff / arrSliced.length) * 1000);
                                    el.timestamp = Diff;
                                    el.travelleddatetime = p.timestamp;
                                    el.tracePoints = p.linkIdMatched;
                                });
                            }
                            else {
                                if (blDatetimeToCalculate == true) { millisecondCollection = 0; }
                                else { millisecondCollection += Diff; }
                                arrSliced.forEach(function (el) {
                                    el.millisecpermeter = SpeedCollection / (millisecondCollection / arrSliced.length);
                                    el.seqNo = intseqNo;
                                    el.speedMps = p.speedMps;
                                    SpeedCollection = SpeedCollection + ((millisecondCollection / arrSliced.length) * 1000);
                                    el.timestamp = millisecondCollection;
                                    el.travelleddatetime = p.timestamp;
                                    el.tracePoints = prevLinkID;
                                });
                            }
                            blIsMultipleTRacePoints = false;


                            arrSlicedCount = arrSlicedCount + 1;
                            arrSlicedCollection.push({ 'id': arrSlicedCount, 'slicedArray': arrSliced });


                            if (arrFindUnique.length > 0) {
                                arrFindUnique.forEach(function (MatchedID) {

                                    var linkPolyline;

                                    var lineStyle1;
                                    var Routelink = routeLinks.find(o => o.linkId === MatchedID);
                                    //var speed = full_geometry_additional.find(o => o.linkid === MatchedID)["speedMps"] * 3.6;
                                    //var speed = full_geometry_additional.find(o => o.linkid === MatchedID)["speedMps"] / 3.6;
                                    var speed = full_geometry_additional.find(o => o.linkid === MatchedID)["speedMps"];
                                    var coords1 = Routelink.shape.split(" ");
                                    var coords2 = new H.geo.Strip();
                                    for (var c = 0; c < coords1.length; c += 2) {
                                        coords2.pushLatLngAlt(coords1[c], coords1[c + 1], null);

                                    }

                                    if (speed == 0) { // Start Position
                                        lineStyle1 = { lineJoin: "round", lineWidth: 8, strokeColor: "#97c2f0" };
                                    }
                                    else if (speed > 80) {
                                        lineStyle1 = { lineJoin: "round", lineWidth: 10, strokeColor: "red" };
                                    }
                                    else if ((speed > 50) && (speed < 80)) {
                                        lineStyle1 = { lineJoin: "round", lineWidth: 10, strokeColor: "#FFBF00" }; //"Amber"
                                    }
                                    else {
                                        lineStyle1 = { lineJoin: "round", lineWidth: 10, strokeColor: "#97c2f0" };
                                    }
                                    linkPolyline = new H.map.Polyline(coords2, { zIndex: 3, style: lineStyle1 });
                                    linkPolyline.setData(Routelink);
                                    linkPolyline.addEventListener('tap', createTapLinkHandler(linkPolyline));
                                    objContainer.addObject(linkPolyline);
                                    if (routeLinks[l] != undefined) { // Rafik
                                        arrPloyLine.push({ 'linkID': routeLinks[l].linkId, 'polyline': linkPolyline });
                                    }
                                    

                                });
                            }
                        }
                        // prevLinkID = p.linkIdMatched;
                    }
                }
            }
            if (originalTraceStrip !== null) {
                objContainer.addObject(new H.map.Polyline(originalTraceStrip, { zIndex: 4, style: DEFAULT_TRACE_STYLE }));
            }

            if (zoomToResult) map.setViewBounds(objContainer.getBounds());
            zoomToResult = true;
            //should display the warnings … warnings = respJsonObj.Warnings;  if (warnings.length > 0) …
            warnings = respJsonObj.Warnings;
            DisplayWarning();
            mapVersion = respJsonObj.mapVersion; // RME's map version. Use it to cross reference with PDE.
            $('#cover-spin').hide(0);
        };

        var gis = {
            ///**
            //* All coordinates expected EPSG:4326
            //* @param {Array} start Expected [lon, lat]
            //* @param {Array} end Expected [lon, lat]
            //* @return {number} Distance - meter.
            //*/
            calculateDistance: function (start, end) {
                var lat1 = parseFloat(start[1]),
                    lon1 = parseFloat(start[0]),
                    lat2 = parseFloat(end[1]),
                    lon2 = parseFloat(end[0]);

                return gis.sphericalCosinus(lat1, lon1, lat2, lon2);
            },

            ///**
            //* All coordinates expected EPSG:4326
            //* @param {number} lat1 Start Latitude
            //* @param {number} lon1 Start Longitude
            //* @param {number} lat2 End Latitude
            //* @param {number} lon2 End Longitude
            //* @return {number} Distance - meters.
            //*/
            sphericalCosinus: function (lat1, lon1, lat2, lon2) {
                var radius = 6371e3; // meters
                var dLon = gis.toRad(lon2 - lon1),
                    lat1 = gis.toRad(lat1),
                    lat2 = gis.toRad(lat2),
                    distance = Math.acos(Math.sin(lat1) * Math.sin(lat2) +
                        Math.cos(lat1) * Math.cos(lat2) * Math.cos(dLon)) * radius;

                return distance;
            },

            ///**
            //* @param {Array} coord Expected [lon, lat] EPSG:4326
            //* @param {number} bearing Bearing in degrees
            //* @param {number} distance Distance in meters
            //* @return {Array} Lon-lat coordinate.
            //*/
            createCoord: function (coord, bearing, distance) {
                /** http://www.movable-type.co.uk/scripts/latlong.html
                * φ is latitude, λ is longitude,
                * θ is the bearing (clockwise from north),
                * δ is the angular distance d/R;
                * d being the distance travelled, R the earth’s radius*
                **/
                var
                    radius = 6371e3, // meters
                    δ = Number(distance) / radius, // angular distance in radians
                    θ = gis.toRad(Number(bearing));
                φ1 = gis.toRad(coord[1]),
                    λ1 = gis.toRad(coord[0]);

                var φ2 = Math.asin(Math.sin(φ1) * Math.cos(δ) +
                    Math.cos(φ1) * Math.sin(δ) * Math.cos(θ));

                var λ2 = λ1 + Math.atan2(Math.sin(θ) * Math.sin(δ) * Math.cos(φ1),
                    Math.cos(δ) - Math.sin(φ1) * Math.sin(φ2));
                // normalise to -180..+180°
                λ2 = (λ2 + 3 * Math.PI) % (2 * Math.PI) - Math.PI;

                return [gis.toDeg(λ2), gis.toDeg(φ2)];
            },
            ///**
            // * All coordinates expected EPSG:4326
            // * @param {Array} start Expected [lon, lat]
            // * @param {Array} end Expected [lon, lat]
            // * @return {number} Bearing in degrees.
            // */
            getBearing: function (start, end) {
                var
                    startLat = gis.toRad(start[1]),
                    startLong = gis.toRad(start[0]),
                    endLat = gis.toRad(end[1]),
                    endLong = gis.toRad(end[0]),
                    dLong = endLong - startLong;

                var dPhi = Math.log(Math.tan(endLat / 2.0 + Math.PI / 4.0) /
                    Math.tan(startLat / 2.0 + Math.PI / 4.0));

                if (Math.abs(dLong) > Math.PI) {
                    dLong = (dLong > 0.0) ? -(2.0 * Math.PI - dLong) : (2.0 * Math.PI + dLong);
                }

                return (gis.toDeg(Math.atan2(dLong, dPhi)) + 360.0) % 360.0;
            },
            toDeg: function (n) { return n * 180 / Math.PI; },
            toRad: function (n) { return n * Math.PI / 180; }
        };

        function getAllPointsbetweenPoints(Startpoint, EndPoint, linkID, travelledSec, traveledDistance) {
            var pLat = 0.00;
            var pLng = 0.00;
            var pCoordinates;

            var cLat = 0.00;
            var cLng = 0.00;
            var NoofPoints = 100;
            var start = [Startpoint['lat'], Startpoint['lng']];
            var end = [EndPoint['lat'], EndPoint['lng']];
            var total_distance = gis.calculateDistance(start, end); // meters
            var percent = 20;
            var distance = (percent / 100) * total_distance;
            var bearing = gis.getBearing(start, end);
            var new_coord = gis.createCoord(start, bearing, distance);

            var milliSecondstoCross = travelledSec / total_distance;
            var meterDistance = traveledDistance / total_distance;
            for (var i = 0; i < total_distance; i++) {
                bearing = gis.getBearing(start, end);
                new_coord = gis.createCoord(start, bearing, i);
                if (i > 0) {
                    if (pCoordinates != new_coord[0]) {

                        tmpCoords = new H.geo.Strip();
                        StartPoint = new H.geo.Point(pCoordinates[0], pCoordinates[1]);
                        EndPoint = new H.geo.Point(new_coord[0], new_coord[1]);
                        tmpCoords.pushPoint(StartPoint)
                        tmpCoords.pushPoint(EndPoint)
                        linkPolylineforBlackColor = new H.map.Polyline(tmpCoords, { zIndex: 3, style: blacklineStyle });
                        full_geometry_additional.push({
                            'attributes': new H.geo.Point(new_coord[0], new_coord[1]),
                            'linkid': linkID, 'mSecToReachLinkFromStart': travelledSec,
                            'linkLength': traveledDistance,
                            'pointType': 'I',
                            'speedMps': 0,
                            'timestamp': 0,
                            'breakDetected': 0,
                            'breakDuration': 0,
                            'millisecpermeter': 0,
                            'seqNo': 0,
                            'travelleddatetime': 0,
                            //'blackpolyline': arrCollBlackColor
                            'blackpolyline': linkPolylineforBlackColor,
                            'tracePoints': 0
                        });

                    }
                    linkPolylineforBlackColor.setVisibility(false);
                    objContainerforBlackColr.addObject(linkPolylineforBlackColor);

                    arrLinkGroup.push({ 'linkid': linkID, 'segments': (new_coord.length / 2), 'mSecToReachLinkFromStart': travelledSec, 'linkLength': traveledDistance });
                    inputCollectionPointGroup.addObject(new H.map.Marker(new H.geo.Point(new_coord[0], new_coord[1]), { icon: icons["#000000"] }));
                }
                pCoordinates = new_coord;
                pLat = new_coord[0]; pLng = new_coord[1];
            }
        }


        /**
Creates and adds links which then gets stored in internal object container
*/
        var addLinkPointsToObjectContainer = function (routeLinks, callingCalculateRoute) {
            var lLinkId = -99999999999999999;
            for (var l = 0; l < routeLinks.length; l++) {
                var coords1 = callingCalculateRoute ? routeLinks[l].shape : routeLinks[l].shape.split(" "); //in calculateroute resource ths shape is already returned as array
                var coords2 = new H.geo.Strip();
                if (routeLinks[l].offset && routeLinks[l].offset < 1) {
                    if (routeLinks[l].linkId < 0) {
                        distance = (1 - routeLinks[l].offset) * (callingCalculateRoute ? routeLinks[l].length : routeLinks[l].linkLength); //if  offset is set calculate new length of the link, caclulateroute.json resource returns back the link length in the length json field while matchroute.json returns it in linkLength
                    } else {
                        distance = routeLinks[l].offset * (callingCalculateRoute ? routeLinks[l].length : routeLinks[l].linkLength); //if  offset is set calculate new length of the link
                    }
                }
                totalDistance = totalDistance + routeLinks[l]['linkLength'];
                arrCollBlackColor = []
                if (routeLinks[l].linkId != pLinkID) {
                    for (var c = 0; c < coords1.length; c += 2) {
                        coords2.pushLatLngAlt(coords1[c], coords1[c + 1], null); //if it is not offset link, just add new point
                        full_geometry.push(new H.geo.Point(coords1[c], coords1[c + 1]));
                        var objLatLan = new H.geo.Point(coords1[c], coords1[c + 1]);
                        //debugger;
                        if (previousCoorinates != undefined) {

                            if ((previousCoorinates["lat"] != objLatLan["lat"]) || (previousCoorinates["lng"] != objLatLan["lng"])) {
                                getAllPointsbetweenPoints(previousCoorinates, objLatLan, routeLinks[l].linkId, routeLinks[l].mSecToReachLinkFromStart, routeLinks[l].linkLength)
                            }
                        }
                        previousCoorinates = objLatLan;
                    }
                    pLinkID = routeLinks[l].linkId;
                    lLinkId = Math.abs(routeLinks[l].linkId);
                }
            }
            totalDistance = (totalDistance / 1000).toFixed(2)
            $('#lblKMRouteCalculation').val(totalDistance); //.toFixed(2);


            /**
Helper to create the line style based on the links confidence value
*/
            function makeConfidenceAwareStyle(c) {
                if (c === undefined) {
                    // support rme versions without confidence on result.
                    return DEFAULT_CONFIDENCE_LINK_STYLE;
                }
                var color;
                var MAX_CONF = 1.0;
                if (c > MAX_CONF) {
                    color = 'green';
                } else if (c <= 0.01) {
                    color = 'red';
                } else {
                    var greenPart = c;
                    var redPart = MAX_CONF - c;

                    var red = Math.floor(255 * redPart / MAX_CONF);
                    var green = Math.floor(255 * greenPart / MAX_CONF);

                    color = 'rgba(' + red + ', ' + green + ', 0, 0.7)';

                }
                return { lineWidth: 8, strokeColor: color, lineJoin: 'round' };
            }


            //var getCoordsWithOffset = function (coords1, distance, currentLink, numberOfLinks) {
            function getCoordsWithOffset(coords1, distance, currentLink, numberOfLinks) {
                var temp = [];
                var prevCoord = [coords1[0], coords1[1]];
                for (var c = 0; c < coords1.length; c += 2) {
                    var linkLength = getKartesianDistanceInMeter(prevCoord[0], prevCoord[1], coords1[c], coords1[c + 1]);  //calculate distance to the next point           // if this is a link with offset, do calculations for the offset
                    if ((distance - linkLength) < 0) {        //if offset is not reached add new point
                        // var midPoint = getMidPoint(prevCoord[0], prevCoord[1], coords1[c], coords1[c+1], linkLength - distance);  //if offset is reached calculate new point based on the distance from the first point, and angle of the link.
                        var midPoint = getMidPoint(prevCoord[0], prevCoord[1], coords1[c], coords1[c + 1], distance);  //if offset is reached calculate new point based on the distance from the first point, and angle of the link.
                        var midPointIndex = c;
                        break;
                    } else {
                        distance = distance - linkLength;

                    }
                    prevCoord[0] = coords1[c];
                    prevCoord[1] = coords1[c + 1];
                }
                if (!midPoint) {
                    var midPoint = getMidPoint(coords1[coords1.length - 4], coords1[coords1.length - 3], coords1[coords1.length - 2], coords1[coords1.length - 1], distance);  //if offset is reached calculate new point based on the distance from the first point, and angle of the link.
                    var midPointIndex = coords1.length - 2;
                }
                if (currentLink == 0 || uTurn) {
                    if (uTurn) uTurn = false;
                    temp.push(String(midPoint[0]));
                    temp.push(String(midPoint[1]));
                    for (var c = midPointIndex; c < coords1.length; c += 1) {
                        temp.push(coords1[c]);
                    }
                } else {
                    if (currentLink != numberOfLinks - 1) uTurn = true;
                    for (var c = 0; c < midPointIndex; c += 1) {
                        temp.push(coords1[c]);
                    }
                    temp.push(midPoint[0]);
                    temp.push(midPoint[1]);
                }

                return temp;
            }

            var extractedStrip = new H.geo.Strip();
            for (var i = 0; i < full_geometry.length; i++) {
                extractedStrip.pushPoint(full_geometry[i]);
            }
            extractedPolyline = new H.map.Polyline(extractedStrip);
        }

        var getKartesianDistanceInMeter = function (lat1, lon1, lat2, lon2) {

            var earthRadius = 6371000;
            // convert input parameters from decimal degrees into radians
            var phi1 = (lat1) * Math.PI / 180;
            var phi2 = (lat2) * Math.PI / 180;
            var dphi = phi2 - phi1;
            var dl = (lon2 - lon1) * (Math.PI / 180);

            var a = Math.sin(dphi / 2) * Math.sin(dphi / 2) +
                Math.cos(phi1) * Math.cos(phi2) *
                Math.sin(dl / 2) * Math.sin(dl / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return earthRadius * c;
        }

        var getMidPoint = function (lat1, lon1, lat2, lon2, distance) {
            /* var lon = ratio*lon1 + (1.0 - ratio)*lon2;
             var lat = ratio*lat1 + (1.0 - ratio)*lat2;*/

            var heading = getHeading(lat2, lon2, lat1, lon1);
            var shiftedLatLon = shiftLatLon(lat1, lon1, ((parseFloat(heading) + 180) % 360), distance);  // only 180 degrees to go into the opposite direction

            return shiftedLatLon;
        }

        function getHeading(lat1, lng1, lat2, lng2) {
            var phi1 = lat1 * (Math.PI / 180),
                phi2 = lat2 * (Math.PI / 180),
                dl = (lng2 - lng1) * (Math.PI / 180),
                y = Math.sin(dl) * Math.cos(phi2),
                x = Math.cos(phi1) * Math.sin(phi2) - Math.sin(phi1) * Math.cos(phi2) * Math.cos(dl),
                t = Math.atan2(y, x);

            return Math.round(((t * 180 / Math.PI) + 360) % 360);
        };

        /**
        This method shifts the given lat and long along given bearing to the given distance
        */
        function shiftLatLon(latDegrees, lonDegrees, bearing, distance) {
            var earthRadius = 6371000;
            // convert input parameters from decimal degrees into radians
            var latRad = (latDegrees) * Math.PI / 180;
            var lonRad = (lonDegrees) * Math.PI / 180;

            var bearingRad = bearing * Math.PI / 180;
            var distRad = distance / earthRadius;

            var latNewRad = Math.asin(Math.sin(latRad) * Math.cos(distRad) + Math.cos(latRad) * Math.sin(distRad)
                * Math.cos(bearingRad));
            var lonNewRad = lonRad
                + Math.atan2(Math.sin(bearingRad) * Math.sin(distRad) * Math.cos(latRad), Math.cos(distRad) - Math.sin(latRad)
                    * Math.sin(latNewRad));

            // convert input parameters from radians into decimal degrees
            var latNewDegrees = latNewRad * 180 / Math.PI;
            var lonNewDegrees = lonNewRad * 180 / Math.PI;
            var latLonRet = [];
            latLonRet.push(latNewDegrees);
            latLonRet.push(lonNewDegrees);
            return latLonRet;
        }


        /**
Create matched/unmatched markers that can be used to draw the original/matched tracepoints. They are just created and stored
*/
        var createIcons = function (count) {
            for (var i = 0; i < count; i++) {
                if (icons["red" + i] === undefined)
                    icons["red" + i] = createIcon("red", i);
                if (icons["blue" + i] === undefined)
                    icons["blue" + i] = createIcon("blue", i);
                if (icons["#000000" + i] === undefined)
                    icons["#000000" + i] = createIcon("#000000", i);
                if (icons["00FF00" + i] === undefined)
                    icons["#00FF00" + i] = createIcon("#00FF00", i);
            }
        }

        /**
            Creates icons with Text (used for tracepoint sequence number)
        */
        var createIcon = function (color, text) {
            var canvas = document.createElement('canvas'),
                width = 28,
                height = 16,
                fontSize = 10;

            canvas.width = width;
            canvas.height = height;

            ctx = canvas.getContext('2d');

            ctx.strokeStyle = color;
            ctx.beginPath();
            ctx.moveTo(14, 16);
            ctx.lineTo(14, 9);
            ctx.stroke();
            ctx.closePath();

            ctx.font = 'bold ' + fontSize + 'px Arial';
            ctx.fillStyle = color;
            ctx.textAlign = 'center';
            ctx.fillText(text, 14, 8);

            var icon = new mapsjs.map.Icon(canvas,
                ({
                    'anchor': {
                        'x': 14,
                        'y': 16
                    }
                }));
            delete canvas;
            return icon;
        };

        /**
            Helper to highlight a link
        */
        function createPointerEnterLinkHandler(polyline) {
            return function (e) {
                linkHighlighted = true;
                polyline.setStyle(HOVER_LINK_STYLE);
            };
        }

        /**
        Helper to disable highlight of a link
*/
        function createPointerLeaveLinkHandler(polyline) {
            return function (e) {
                linkHighlighted = false;
                polyline.setStyle(makeConfidenceAwareStyle(polyline.getData().confidence));
            };
        }

        /**
            Shows popup with link info
        */
        function createTapLinkHandler(polyline) {
            return function (e) {
                var strip = polyline.getStrip();
                var lowIndex = Math.floor((strip.getPointCount() - 1) / 2);
                var highIndex = Math.ceil(strip.getPointCount() / 2);
                var center;
                if (lowIndex === highIndex) {
                    center = strip.extractPoint(lowIndex);
                } else {
                    var lowPoint = strip.extractPoint(lowIndex);
                    var highPoint = strip.extractPoint(highIndex);
                    center = new H.geo.Point((lowPoint.lat + highPoint.lat) / 2, (lowPoint.lng + highPoint.lng) / 2);
                }

                var linkInfo = JSON.stringify(polyline.getData(), undefined, 5);
                linkInfo = "<textarea readonly rows='10' cols='50' style='background-color:black;border:0;font-size:12px;max-width:350px;max-height:400px;color:white'>" + linkInfo + "</textarea>";
                if (!linkDataInfoBubble) {
                    linkDataInfoBubble = new H.ui.InfoBubble(center, { content: linkInfo });
                    ui.addBubble(linkDataInfoBubble);
                }
                else {
                    linkDataInfoBubble.setPosition(center);
                    linkDataInfoBubble.setContent(linkInfo);
                }
                linkDataInfoBubble.open();
            };
        }



        function getJSONP(url, callback) {
            var cbnum = "s" + getJSONP.counter++;
            var cbname = "getJSONP." + cbnum;
            url += "&callback=" + cbname;
            var script = document.createElement("script");
            getJSONP[cbnum] = function (response) {
                try {
                    callback(response);
                }
                finally {
                    //debugger
                    $('#cover-spin').hide(0);
                    delete getJSONP[cbnum];
                    script.parentNode.removeChild(script);
                }
            };
            script.src = url;
            script.onerror = function (data) {
                alert("Could not connect to RME.\nCheck connectivity and trace size.");
            }
            document.body.appendChild(script);
        } getJSONP.counter = 0;

        function LoadMap() {
            //debugger;
            var platform = new H.service.Platform({
                //app_code: app_code, app_id: app_id, useCIT: true, useHTTPS: secure
                //app_id: 'TaOmetCynYBijA1KVxCm',
                //app_code: 'vspm-I24X2Ezl1A0EWnK3Q',
                app_id: 'vvfyuslVdzP04AK3BlBq',
                app_code: 'f63d__fBLLCuREIGNr6BjQ',
                useHTTPS: true
            });
            var pixelRatio = window.devicePixelRatio || 1;
            var defaultLayers = platform.createDefaultLayers({
                tileSize: pixelRatio === 1 ? 256 : 512,
                ppi: pixelRatio === 1 ? undefined : 320
            });
            // platform.configure(H.map.render.panorama.RenderEngine);
            return {
                Platform: platform,
                PixelRatio: pixelRatio,
                DefaultLayers: defaultLayers
            };

        }

        function LoadLatLan(dataLat, dataLon, pixelRatio, defaultLayers) {
            $('#markers').empty();
            var map = new H.Map(document.getElementById('markers'),
                defaultLayers.normal.map, {
                    center: { lat: dataLat, lng: dataLon },
                    zoom: 3,
                    pixelRatio: pixelRatio
                });
            var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

            // Create the default UI components
            var ui = H.ui.UI.createDefault(map, defaultLayers);

            var parisMarker = new H.map.Marker({ lat: dataLat, lng: dataLon });
            map.addObject(parisMarker);

        }

        $('#cmbSelect').click(function () {
            inpUserSpeed = $('#cmbSelect').val();
        }
        );

        function getInputfromServer() {

            var Objdata = {
                "vehicleid": $('#txtVehicleID').val(),
                "fromDateTime": $('#dtStartDate').val(),
                "toDateTime": $('#dtEnddate').val()
            }

            //debugger;
            $.ajax({
                type: "POST",                
                url: 'http://app.smarteclipse.com/api/v1/vehicle_playback',                
                data: Objdata,
                async: false,
                //dataType: "json",
                //contentType: "application/json; charset=utf-8",
                success: function (response) {
                    // debugger;
                    if (response == undefined) {
                        alert('No input available');
                        $('#cover-spin').hide(0);
                    }
                    //if (response.locations.length > 0) {
                    if (response.playback == undefined) {
                        alert('No data to display the Route');
                        $('#cover-spin').hide(0);
                        $("#btnPlay").attr("disabled", true);
                        return;
                    }

                    if (response.playback.length > 0) {
                        JsonData = CreateJsonDataFile(JSON.stringify(response));
                        LoadRMEAPI(JsonData);
                        $("#btnPlay").attr("disabled", false);
                    }
                    else {
                        alert('No data to display the Route');
                        $('#cover-spin').hide(0);
                        $("#btnPlay").attr("disabled", true);
                        return;
                    }
                },
                failure: function (response) {
                    $("#btnPlay").attr("disabled", false);
                    $('#cover-spin').hide(0);
                },
                error: function (response) {
                    $("#btnPlay").attr("disabled", false);
                    $('#cover-spin').hide(0);
                }
            });
        }

        $('#btnGetRoute').click(function () {

            if ($('#txtVehicleID').val() <= 0) {
                alert('The Vehicle ID should not be 0')
                return;
            }

            if ($('#dtEnddate').val() <= $('#dtStartDate').val()) {
                alert('The End date should not less than or Equal to Start Date')
                return;
            }
            //            debugger;
            Reset(true);
            $('#cover-spin').show(0);
            getInputfromServer();

        });

        function DisplayWarning() {
            if (warnings.length > 0) {
                warnings.filter(o => o.category === 1010).forEach(function (elem) {
                    //debugger;
                    var breakDuration = 0;
                    var bubble;
                    if (elem.breakDuration == undefined) {
                        breakDuration = Math.abs(tracePoints[elem.tracePointSeqNum]['breakDuration']) / 1000
                    }
                    else {
                        breakDuration = elem.breakDuration;
                    }
                    var svgMarkup = '<svg width="130" height="30" ' +
                        'xmlns="http://www.w3.org/2000/svg">' +
                        '<rect stroke="white" fill="#1b468d" x="1" y="1" width="150" ' +
                        'height="22" /><text x="1" y="18" font-size="10pt" ' +
                        'font-family="Arial" font-weight="bold" text-anchor="left" ' +
                        'fill="white">' + 'Break Dur. : ' + breakDuration + ' sec' + '</text></svg>';

                    bubble = new H.ui.InfoBubble({ lat: tracePoints[elem.toTracePointSeqNum]['latMatched'], lng: tracePoints[elem.toTracePointSeqNum]['lonMatched'] }, {
                        content: svgMarkup
                    });

                    bubbleCollection.push(bubble)
                });
            }
        }

        function ShowBubbles(isVisisble) {
            if (isVisisble == true) {
                bubbleCollection.forEach(function (elem) {
                    ui.addBubble(elem);
                });
            }
            else {
                bubbleCollection.forEach(function (elem) {
                    ui.removeBubble(elem);
                })

            }

        }

        $('#btnPlay').click(function () {
            //objContainer.setVisibility(false);
            localStorage.setItem("justOnce", "false");
            map.addObject(objContainerforBlackColr);
            var optServerChecked = $('[id="optServer"]').is(':checked');
            var optJsonChecked = $('[id="optJson"]').is(':checked');
            if (optServerChecked == true) {
            }
            else if (optJsonChecked == true) {
                if ($('#exampleFormControlFile1').get(0).files.length === 0) {
                    alert("Kindly select the File to simulate the Route");
                    $("#btnPlay").attr("disabled", false);
                    return;
                }
            }

            //debugger;

            CurrentLinkID = '';
            PreviousLinkID = '';
            TotalTimeTakeninsec = 0;
            TotalKM = 0;

            $('#lblSpeedValue').val(0);
            $('#lblKMValue').val(0);

            //$("#btnPlay").attr("disabled", true);
            $("#btnPause").attr("disabled", false);
            $("#btnReset").attr("disabled", false);
            $('#cmbSelect').attr("disabled", true);

            PauseFlage = false;
            $("#btnPause").html('Pause');

            var svgMarkup = '<svg height="24" version="1.1" width="24" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><g transform="translate(0 -1028.4)"><path d="m12 0c-4.4183 2.3685e-15 -8 3.5817-8 8 0 1.421 0.3816 2.75 1.0312 3.906 0.1079 0.192 0.221 0.381 0.3438 0.563l6.625 11.531 6.625-11.531c0.102-0.151 0.19-0.311 0.281-0.469l0.063-0.094c0.649-1.156 1.031-2.485 1.031-3.906 0-4.4183-3.582-8-8-8zm0 4c2.209 0 4 1.7909 4 4 0 2.209-1.791 4-4 4-2.2091 0-4-1.791-4-4 0-2.2091 1.7909-4 4-4z" fill="#0b8203" transform="translate(0 1028.4)"/><path d="m12 3c-2.7614 0-5 2.2386-5 5 0 2.761 2.2386 5 5 5 2.761 0 5-2.239 5-5 0-2.7614-2.239-5-5-5zm0 2c1.657 0 3 1.3431 3 3s-1.343 3-3 3-3-1.3431-3-3 1.343-3 3-3z" fill="#0b8203" transform="translate(0 1028.4)"/></g></svg>'
            var startIcon = new H.map.Icon(svgMarkup, { size: { w: 30, h: 30 } })

            var svgMarkup = '<svg height="24" version="1.1" width="24" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><g transform="translate(0 -1028.4)"><path d="m12 0c-4.4183 2.3685e-15 -8 3.5817-8 8 0 1.421 0.3816 2.75 1.0312 3.906 0.1079 0.192 0.221 0.381 0.3438 0.563l6.625 11.531 6.625-11.531c0.102-0.151 0.19-0.311 0.281-0.469l0.063-0.094c0.649-1.156 1.031-2.485 1.031-3.906 0-4.4183-3.582-8-8-8zm0 4c2.209 0 4 1.7909 4 4 0 2.209-1.791 4-4 4-2.2091 0-4-1.791-4-4 0-2.2091 1.7909-4 4-4z" fill="#f52105" transform="translate(0 1028.4)"/><path d="m12 3c-2.7614 0-5 2.2386-5 5 0 2.761 2.2386 5 5 5 2.761 0 5-2.239 5-5 0-2.7614-2.239-5-5-5zm0 2c1.657 0 3 1.3431 3 3s-1.343 3-3 3-3-1.3431-3-3 1.343-3 3-3z" fill="#f52105" transform="translate(0 1028.4)"/></g></svg>'
            var endIcon = new H.map.Icon(svgMarkup, { size: { w: 30, h: 30 } })

            MarkerStartEnd.addObject(new H.map.Marker(new H.geo.Point(full_geometry[0]['lat'], full_geometry[0]['lng']), { icon: startIcon }));
            MarkerStartEnd.addObject(new H.map.Marker(new H.geo.Point(full_geometry[full_geometry.length - 1]['lat'], full_geometry[full_geometry.length - 1]['lng']), { icon: endIcon }));

            map.addObject(MarkerStartEnd);

            DisplayWarning();
            blPlayCompleted = false;
            clearInterval(timeoutHandle);
            clearTimeout(timeoutHandle);

            CalculateDateTime = new Date();
            CalculatepreviousTime = new Date()
            //debugger;
            arrayCount = Pausecontinue('', inpUserSpeed);
        });

        function ClearInterval() {
            clearInterval(timeoutHandle);
        }

        function Pausecontinue(intStartLinkID, inpUserSpeed) {

            arrAnimation = []
            getAnimationLastLinkID == false;
            traceSpeed = 0;
            var items = full_geometry_additional;
            var id;
            var tracespeed = 0;
            traceSpeed_PreviousLinkID = -1
            if (((arrayCount == undefined) && (blPlayCompleted == false)) || ((arrayCount == '') && (blPlayCompleted == false))) {
                //debugger
                arrayCount = 0
                StartLoop(arrayCount);
            }
            else {
                //debugger
                //i = arrayCount + 1
                i = arrayCount
                seqNoGroup = full_geometry_additional[arrayCount]['seqNo'];
                traceSpeed_PreviousLinkID = full_geometry_additional[arrayCount]['seqNo'];
                StartLoop(i)
            }

            function StartLoop(arrayCount) {
                var traceSpeedCalc = 0

                for (arrayCount; arrayCount <= full_geometry_additional.length - 2; arrayCount++) {
                    traceSpeed_CurrentLinkID = full_geometry_additional[arrayCount]['linkid']
                    if (seqNoGroup != traceSpeed_PreviousLinkID) {
                        seqNoGroup = seqNoGroup + 1;
                        if (full_geometry_additional.filter(o => o.seqNo === seqNoGroup).length > 0) {
                            if (full_geometry_additional[arrayCount]["timestamp"] > 0) {
                                tmpSeq = full_geometry_additional[arrayCount]["timestamp"] / full_geometry_additional.filter(o => o.seqNo === seqNoGroup).length + 1;
                            }
                        }
                    }
                    tracespeed = tracespeed + tmpSeq;
                    loopLinks(arrayCount, tracespeed)
                    traceSpeed_PreviousLinkID = full_geometry_additional[arrayCount]['seqNo'];
                }
            }

            function ClearTimeOut() {
                for (var k in arrAnimation) {
                    clearTimeout(arrAnimation[k]);
                    clearTimeout(setTimeoutID);
                }

            }

            function loopLinks(i, tracespeed) {
                arrAnimation.push(setTimeoutID = setTimeout(function cb() {
                    //debugger
                    if (PauseFlage == true) {
                        //debugger
                        arrayCount = i;
                        ClearTimeOut();
                        return
                    }
                    if (FirstLoop == true) {
                        map.removeObject(bearsMarker);
                    }
                    //debugger;
                    CurrentLinkID = full_geometry_additional[i]['linkid']
                    CurrentTracePoint = full_geometry_additional[i]["tracePoints"]

                    if (CurrentLinkID != PreviousLinkID) {
                        TotalKM = TotalKM + (full_geometry_additional[i]['linkLength'] / 1000);
                        $('#lblKMValue').val(TotalKM.toFixed(2))


                        //console.log(PreviousLinkID + ',' + time);
                    }

                    var today = new Date();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    //TotalTimeTakeninsec = TotalTimeTakeninsec + time;
                    CalculatetotalHours = parseInt(moment.utc(moment(today, "DD/MM/YYYY HH:mm:ss").diff(moment(CalculateDateTime, "DD/MM/YYYY HH:mm:ss"))).format("HH:mm:ss").split(':')[0])
                    CalculatetotalMin = parseInt(moment.utc(moment(today, "DD/MM/YYYY HH:mm:ss").diff(moment(CalculateDateTime, "DD/MM/YYYY HH:mm:ss"))).format("HH:mm:ss").split(':')[1])
                    CalculatetotalSec = parseInt(moment.utc(moment(today, "DD/MM/YYYY HH:mm:ss").diff(moment(CalculateDateTime, "DD/MM/YYYY HH:mm:ss"))).format("HH:mm:ss").split(':')[2])

                    //moment.utc(moment(today, "DD/MM/YYYY HH:mm:ss").diff(moment(CalculateDateTime, "DD/MM/YYYY HH:mm:ss"))).format("HH:mm:ss")
                    $('#lblSpeedValue').val(CalculatetotalHours + ":" + CalculatetotalMin + ":" + CalculatetotalSec)

                    if (PreviousTracePoint != CurrentTracePoint) {
                        //debugger;
                        console.log(PreviousTracePoint + ',' + CalculatetotalHours + ":" + CalculatetotalMin + ":" + CalculatetotalSec)
                    }

                    var RotateDegree;
                    RotateDegree = getDegree(full_geometry_additional[i]['attributes']['lat'], full_geometry_additional[i]['attributes']['lng'], full_geometry_additional[i + 1]['attributes']['lat'], full_geometry_additional[i + 1]['attributes']['lng']);

                    objImg.src = 'assets/img/Car.png';
                    el = objImg;
                    var carDirection = RotateDegree;
                    if (el.style.transform.includes("rotate")) {
                        el.style.transform = el.style.transform.replace(/rotate(.*)/, "rotate(" + carDirection + "deg)");
                    } else {
                        el.style.transform = el.style.transform + "rotate(" + carDirection + "deg)";
                    }
                    outerElement.appendChild(el);
                    //outerElement.style.top = "-20px";
                    //outerElement.style.top = "-13px";
                    outerElement.style.top = "-20px";
                    var domIcon = new H.map.DomIcon(outerElement);

                    bearsMarker = new H.map.DomMarker({ lat: full_geometry_additional[i]['attributes']['lat'], lng: full_geometry_additional[i]['attributes']['lng'] }, {
                        icon: domIcon
                    });
                    if (FirstLoop == false) {
                        map.setZoom(18, true);

                    }
                    map.setCenter({ lat: full_geometry_additional[i]['attributes']['lat'], lng: full_geometry_additional[i]['attributes']['lng'] }, true);
                    //var bubble;
                    bearsMarker.addEventListener('pointerenter', function (evt) {
                        var hoverhtml;
                        var collect_timestamp = Number(full_geometry_additional[i].travelleddatetime);
                        localStorage.setItem("mytimestamp", collect_timestamp);
                        var mydate = localStorage.getItem("mytimestamp");
                        var collect_TracePoint_PrevDateTime = new Date(Number(mydate));
                        collect_TracePoint_PrevDateTime.setHours(collect_TracePoint_PrevDateTime.getHours() - 5);
                        collect_TracePoint_PrevDateTime.setMinutes(collect_TracePoint_PrevDateTime.getMinutes() - 30);
                        //debugger;
                        hoverhtml = "<textarea readonly rows='10' cols='50' style='background-color:black;border:0;font-size:12px;max-width:190px;max-height:50px;color:white'>"
                            //+ "Speed : " + (full_geometry_additional[i]['speedMps'] * 3.6).toFixed(2) + " km / hr"
                            //+ "Speed : " + (full_geometry_additional[i]['speedMps'] / 3.6).toFixed(2) + " km / hr"
                            + "Speed : " + full_geometry_additional[i]['speedMps'] + " km / hr"
                            + "\r\n" + "Time Stamp : " + moment(collect_TracePoint_PrevDateTime).format("DD-MM-YYYY HH:mm:ss")
                            //+ "\r\n" + "Time Stamp : " + collect_TracePoint_PrevDateTime.getDate() + "/" + collect_TracePoint_PrevDateTime.getMonth() + "/" + collect_TracePoint_PrevDateTime.getFullYear() + " " + ('0' + collect_TracePoint_PrevDateTime.getHours()).slice(-2) + ":" + ('0' + collect_TracePoint_PrevDateTime.getMinutes()).slice(-2) + ":" + ('0' + collect_TracePoint_PrevDateTime.getSeconds()).slice(-2)
                        //+ "\r\n" + "Tracepoints : " + full_geometry_additional[i]['tracePoints']
                        //+ "\r\n" + "LinkID : " + full_geometry_additional[i]['linkid']
                        "</textarea>";
                        bubble = new H.ui.InfoBubble({ lat: full_geometry_additional[i]['attributes']['lat'], lng: full_geometry_additional[i]['attributes']['lng'] }, {
                            content: hoverhtml

                        });
                        ui.addBubble(bubble);
                    }, false);
                    bearsMarker.addEventListener('pointerleave', function (evt) {
                        bubble.close();
                    }, false);
                    tmpCoords = new H.geo.Strip();

                    //console.log(full_geometry_additional[i]['attributes']['lat'] + ',' + full_geometry_additional[i]['attributes']['lng']
                    //    + ' Next point : ' + full_geometry_additional[i + 1]['attributes']['lat'] + ',' + full_geometry_additional[i + 1]['attributes']['lng']
                    //)
                    tmpCoords.pushPoint(new H.geo.Point(full_geometry_additional[i]['attributes']['lat'], full_geometry_additional[i]['attributes']['lng']))
                    tmpCoords.pushPoint(new H.geo.Point(full_geometry_additional[i + 1]['attributes']['lat'], full_geometry_additional[i + 1]['attributes']['lng']))
                    linkPolylineforBlackColor = new H.map.Polyline(tmpCoords, { zIndex: 3, style: blacklineStyle });
                    objContainerforBlackColr.addObject(linkPolylineforBlackColor);
                    map.addObject(bearsMarker);
                    FirstLoop = true;
                    PreviousLinkID = full_geometry_additional[i]['linkid'];
                    PreviousTracePoint = full_geometry_additional[i]["tracePoints"]
                }, tracespeed / inpUserSpeed));
                //i += 1;
            };
        }

        $('#btnPause').click(function () {
            $("#btnPlay").attr("disabled", true);
            $("#btnPause").attr("disabled", false);
            $("#btnReset").attr("disabled", false);


            if (PauseFlage == undefined) {
                $('#cmbSelect').attr("disabled", false);
                PauseFlage = false;
                clearInterval(timeoutHandle);
                //clearTimeout(timeoutHandle);
                setTimeout(function () { }, 5000);
                tmp = Pausecontinue(arrayCount, inpUserSpeed);

                $("#btnPause").html('Pause');
            }
            else if (PauseFlage == true) {
                $('#cmbSelect').attr("disabled", true);
                PauseFlage = false;
                clearInterval(timeoutHandle);
                // clearTimeout(timeoutHandle);
                setTimeout(function () { }, 5000);
                tmp = Pausecontinue(arrayCount, inpUserSpeed);
                $("#btnPause").html('Pause');
                clearTimeout(setTimeoutfunction);
            }
            else if (PauseFlage == false) {
                PauseFlage = true;
                clearInterval(timeoutHandle);
                $('#cmbSelect').attr("disabled", false);
                //clearTimeout(timeoutHandle);
                setTimeout(function () { }, 5000);
                $("#btnPause").html('Continue');
            }

        });

        function Reset(blResetServerProcessed = false) {
            full_geometry_additional = new Array();
            full_geometry = new Array();
            arrLinkGroup = new Array();
            arrayCount = 0;

            $('#lblSpeedValue').val('0');
            $('#lblKMValue').val('');
            $('#lblKMRouteCalculation').val('0');
            $('#exampleFormControlFile1').val('');
            $('#cmbSelect').prop('selectedIndex', 0);
            $('#cmbSelect').attr("disabled", false);

            if ((bearsMarker != null) && (FirstLoop == true)) {
                map.removeObject(bearsMarker);
                bearsMarker = null;
            }
            FirstLoop = false;
            inpUserSpeed = 1; // default Speed
            PauseFlage = true;
            $("#btnPause").html('Pause');
            TotalTimeTakeninsec = 0;
            TotalKM = 0;
            CurrentLinkID = '';
            PreviousLinkID = '';
            MarkerStartEnd.removeAll();
            objContainer.removeAll();
            traceSpeed = 0
            blPlayCompleted = false;
            clearTimeout(setTimeoutfunction);
           
            if (blResetServerProcessed == false) {
                $('#txtVehicleID').val('0');
                $('#dtStartDate').val(new moment(Date()).format('YYYY-MM-DDThh:mm:ss'));
                $('#dtEnddate').val(new moment(Date()).format('YYYY-MM-DDThh:mm:ss'))
                

            }
           // Pausecontinue.ClearTimeOut();
            
            $('#chkRoute').prop("checked", false);
            $('#chkWarning').prop("checked", false);

            $('#chkRoute').attr('disabled', true);
            $('#chkWarning').attr('disabled', true);
            ShowBubbles(false);
            bubbleCollection = new Array();
            objContainerforBlackColr.removeAll();

            if (arrAnimation.length > 0) {
                ReloadPage();
            }

            //debugger;
            for (var k in arrAnimation) {
                clearTimeout(arrAnimation[k]);
                clearTimeout(k);
               
            }
            //debugger;

            for (var k = 0; k < arrAnimation.length - 1; k++) {
                clearTimeout(arrAnimation[k]);
                arrAnimation.splice(k, 1);
            }
            arrAnimation = new Array();
            localStorage.setItem("mytimestamp", "")

           

            //debugger;
            
            //window.location.reload();
            
            //if (!localStorage.justOnce == false) {
            //    //localStorage.setItem("justOnce", "false");
            //    localStorage.setItem("justOnce", "true");
            //    window.location.reload();
            //}

            //localStorage.setItem("justOnce", "true");
            //window.onload();
            //location.reload(true);
            //if (pageLoad == false) {
            //    location.reload();
            //    pageLoad = true;
            //}

            //location.reload();
            //full_geometry_additional = []
            //if (blResetServerProcessed) {
            //    map.removeObject(objContainerforBlackColr);
            //}
            //
        }


        function ReloadPage() {
            window.location.reload();
        }

        //window.onload = function () {
        //    if (!localStorage.justOnce) {
        //        localStorage.setItem("justOnce", "true");
        //        window.location.reload();
        //    }
        //}

        //(function windowrefreshonlyonce() {
        //    if (window.localStorage) {
        //        if (!localStorage.getItem('firstLoad')) {
        //            localStorage['firstLoad'] = true;
        //            window.location.reload();
        //        }
        //        else
        //            localStorage.removeItem('firstLoad');
        //    }
        //})();



        $('#btnReset').click(function () {
            //debugger;
            if ((PauseFlage == false) && ($('#exampleFormControlFile1').get(0).files.length !== 0) && ($("#btnPause").is(":enabled"))) {
                alert('Kindly pause the Simulation to reset the Route.');
                return;
            }
            $("#btnPlay").attr("disabled", true);
            $("#btnPause").attr("disabled", true);
            $("#btnReset").attr("disabled", false);
            Reset();
        });

        updateMarkerDirection = function updateMarkerDirection(parisMarker, RotateDegree, Hlat, Hlng, isNeedToPrintonMap) {
            if (isNeedToPrintonMap == false) {
                return;
            }
            var outerElement = document.createElement('div')
            //outerElement.style.alignContent = "Left";
            var objImg = document.createElement('img');
            objImg.src = 'assets/img/Car.png';
            el = objImg;
            var carDirection = RotateDegree;
            //            console.log(RotateDegree);

            if (el.style.transform.includes("rotate")) {
                el.style.transform = el.style.transform.replace(/rotate(.*)/, "rotate(" + carDirection + "deg)");
            } else {
                el.style.transform = el.style.transform + "rotate(" + carDirection + "deg)";
            }
            outerElement.appendChild(el);
            outerElement.style.top = "-20px";
            if (FirstLoop == true) {
                map.removeObject(bearsMarker);
            }
            var domIcon = new H.map.DomIcon(outerElement);
            bearsMarker = new H.map.DomMarker({ lat: Hlat, lng: Hlng }, {
                icon: domIcon
            });
            //console.log(Hlat + ',' + Hlng);
            map.addObject(bearsMarker);
            if (FirstLoop == false) {
                map.setZoom(18, true);

            }
            map.setCenter({ lat: Hlat, lng: Hlng }, true);
            FirstLoop = true;
        }

        function getDegree(lat1, long1, lat2, long2) {
            //debugger;
            var dLon = (long2 - long1);
            var y = Math.sin(dLon) * Math.cos(lat2);
            var x = Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1)
                * Math.cos(lat2) * Math.cos(dLon);
            var brng = Math.atan2(y, x);
            brng = radianstoDegree(brng);
            brng = (brng + 360) % 360;
            //if ($('[id="optServer"]').is(':checked') == true) {
            //    brng = 360 - brng; // count degrees counter-clockwise - remove to make clockwise
            //}

            brng = 360 - brng;
            return brng;
        }

        function radianstoDegree(x) {
            return x * 180.0 / Math.PI;
        }


    </script>
</body>
</html>