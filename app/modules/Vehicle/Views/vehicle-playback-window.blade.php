<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>GPS Vehicle Playback</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{asset('playback/assets/img/icon.png')}}" type="image/x-icon" />
    <!-- Fonts and icons -->
    <script src="{{asset('playback/assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
        WebFont.load({
            google: { "families": ["Lato:300,400,700,900"] },
            custom: { "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{asset("playback/assets/css/fonts.min.css")}}'] },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <script src="{{asset('playback/assets/Scripts/jquery-3.3.1.js')}}"></script>
    <script src="{{asset('playback/assets/Scripts/jquery-3.3.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.4.0/jszip.min.js"></script>
    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css?dp-version=1549984893" />
    <link rel="stylesheet" href="{{asset('playback/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('playback/assets/css/atlantis.min.css')}}">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{asset('playback/assets/css/demo.css')}}">

</head>
<body data-background-color="dark">
    <div class="wrapper overlay-sidebar">
        
        <div class="main-panel">
            <div class="content">
                <!--<div id="markers" style="width:1800px;height:780px"></div>-->
                <div id="markers" style="width:1360px;height:595px"></div>
                <div class="page-inner mt--5">
                </div>
            </div>
        </div>
        <!-- Custom template | don't include it in your project! -->
        <div class="custom-template" style="top:230px">
            <div class="title">Route PlayBack</div>
            <div class="custom-content">
                <div class="switcher">
                    <table>
                        <tr style="width:90px">
                            <td><label>Select File</label></td>
                            <td><input type="file" class="form-control-file" id="exampleFormControlFile1"></td>
                        </tr>
                        <tr style="width:90px">
                            <td><label>Select Speed (km/hr)         </label></td>
                            <td>
                                <!--<select class="form-control form-control" style="color:white" id="defaultSelect">-->
                                <select id="cmbSelect">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="60">60</option>
                                    <option value="70">70</option>
                                    <option value="80">80</option>
                                    <option value="90">90</option>
                                    <option value="100">100</option>
                                    <option value="1000">1000</option>
                                    <option value="1870">1870</option>
                                    <option value="2000">2000</option>
                                    <option value="3000">3000</option>
                                    <option value="6000">6000</option>
                                    <option value="7000">7000</option>
                                </select>
                            </td>
                        </tr>
                        <tr style="width:90px">
                            <td>Total Distance</td>
                            <td>
                                <textarea id="lblKMRouteCalculation" style="width:90px;resize:none" rows="1" readonly disabled>  </textarea> km<!--<span > km </span>-->
                            </td>
                        </tr>

                        <tr style="width:90px">
                            <td style="font:bold"> Coverage : </td>
                            <!--<td>
                                <textarea id="lblKMCurrentCoverage" style="width:90px;resize:none" rows="1" readonly disabled>  </textarea> <span> km </span>
                            </td>-->

                        </tr>
                        <tr style="width:90px">
                            <td>
                                <label id="lblSpeed"> Distance(km) </label>
                            </td>
                            <td>
                                <label id="lblSpeed"><span style="font:bold">Time(min)</span></label>
                            </td>
                        </tr>
                        <tr style="width:90px">
                            <td>
                                <textarea id="lblKMValue" style="width:90px;resize:none" rows="1" readonly disabled>  </textarea>
                            </td>
                            <td>
                                <textarea id="lblSpeedValue" style="width:90px;resize:none" rows="1" readonly disabled>  </textarea>
                            </td>
                        </tr>
                    </table>
                    <button class="btn btn-primary" id="btnPlay">Play</button>
                    <button class="btn btn-primary" id="btnPause">Pause</button>
                    <button class="btn btn-primary" id="btnReset">Reset</button>
                </div>
            </div>
            <div class="custom-toggle">
                <i class="flaticon-settings"></i>
            </div>
        </div>
        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="{{asset('playback/assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{asset('playback/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('playback/assets/js/core/bootstrap.min.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{asset('playback/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script src="{{asset('playback/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>
    <!-- jQuery Scrollbar -->
    <script src="{{asset('playback/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

    <!-- Chart JS -->
    <script src="{{asset('playback/assets/js/plugin/chart.js/chart.min.js')}}"></script>
    <!-- jQuery Sparkline -->
    <script src="{{asset('playback/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>
    <!-- Chart Circle -->
    <script src="{{asset('playback/assets/js/plugin/chart-circle/circles.min.js')}}"></script>
    <!-- Datatables -->
    <script src="{{asset('playback/assets/js/plugin/datatables/datatables.min.js')}}"></script>
    <!-- Bootstrap Notify -->
    <script src="{{asset('playback/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
    <!-- jQuery Vector Maps -->
    <!--<script src="../assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
    <script src="../assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>-->


    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>
    <!-- Sweet Alert -->
    <script src="{{asset('playback/assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
    <!-- Atlantis JS -->
    <script src="{{asset('playback/assets/js/atlantis.min.js')}}"></script>
    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{asset('playback/assets/js/setting-demo.js')}}"></script>
    <!--<script src="../assets/js/demo.js"></script>-->
    <script>
        var MapResult;
        var PauseFlage = false;
        var inpUserSpeed = 10;
        var totalDistance = 0;
        var TotalKM = 0.00;
        var PreviousLinkID = '';
        var CurrentLinkID = '';
        var setTimeoutfunction;
        var TotalTimeTakeninsec = 0.0;
        //var icon = new H.map.Icon('assets/img/Car.png');
        //var parisMarker = new H.map.Marker({ lat: 48.8567, lng: 2.3508 }, { icon: icon });

        var parisMarker = new H.map.Marker({ lat: 48.8567, lng: 2.3508 });
        var objImg = document.createElement('img');
        objImg.src = "{{asset('playback/assets/img/Car.png')}}";
        var outerElement = document.createElement('div')
        //outerElement.style.userSelect = 'none';
        //outerElement.style.webkitUserSelect = 'none';
        //outerElement.style.msUserSelect = 'none';
        //outerElement.style.mozUserSelect = 'none';
        //outerElement.style.cursor = 'default';
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
        //app_id_cors = "BTp1kLd1IpptcQe2Ir3h",
        //app_code_cors = "zMDPaKTAFR2g3wF3h4ok7w",
        //api_key = "FdX8ng49KKL5M4Dail77oRCl0AbLF2sFo8fkrWMpLPk";

        var mapContainer = document.getElementById('markers');
        //var platform = new H.service.Platform({ app_code: app_code, app_id: app_id, useCIT: true, useHTTPS: secure });
        var platform = new H.service.Platform({ app_code: app_code, app_id: app_id, useHTTPS: secure });
        var maptypes = platform.createDefaultLayers(hidpi ? 512 : 256, hidpi ? 320 : null);
        var map = new H.Map(mapContainer, maptypes.normal.map, { center: new H.geo.Point(52.11, 0.68), zoom: 5 });
        var zoomToResult = true;
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
        var MarkerStartEnd = new H.map.Group();
        var secure = (location.protocol === 'https:') ? true : false;
        $(document).ready(function () {
            //$("#btn10KM").trigger("click");
            if ($('#exampleFormControlFile1').get(0).files.length === 0) {
                //alert("Kindly select the File to simulate the Route");
                $("#btnPlay").attr("disabled", true);
                $("#btnPause").attr("disabled", true);
                return;
            }
        });
        var strFileName = '';
        var JsonData = ''
        $('#exampleFormControlFile1').on('change', function () {
            if ($('#exampleFormControlFile1').get(0).files.length === 0) {
                return;
            }
            //$('#lblKMRouteCalculation').val('0');
            //Reset();
            //$('#exampleFormControlFile1').val('0');
//            $('#exampleFormControlFile1').val('');
            var fileReader = new FileReader();
            fileReader.onload = function () {
               
                var data = fileReader.result;  // data <-- in this var you have the file data in Base64 format
                if (strFileName == 'gpx') { LoadRMEAPI(data); }
                else if (strFileName == 'json') {
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
            tmpstring = tmpstring + '<?php echo '<?xml version="1.0" ?>' ?>'
            tmpstring = tmpstring + '<gpx xmlns="http://www.topografix.com/GPX/1/1" xmlns:gpxx="http://www.garmin.com/xmlschemas/GpxExtensions/v3" xmlns:gpxtpx="http://www.garmin.com/xmlschemas/TrackPointExtension/v1" creator="mapstogpx.com" version="1.1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd http://www.garmin.com/xmlschemas/GpxExtensions/v3 http://www.garmin.com/xmlschemas/GpxExtensionsv3.xsd http://www.garmin.com/xmlschemas/TrackPointExtension/v1 http://www.garmin.com/xmlschemas/TrackPointExtensionv1.xsd">'
            tmpstring = tmpstring + '<metadata>'
            tmpstring = tmpstring + '<link href="http://www.mapstogpx.com">'
            tmpstring = tmpstring + '<text>Sverrir Sigmundarson</text>'
            tmpstring = tmpstring + '</link>'
            tmpstring = tmpstring + '<!--desc>Map data copyright 2019 Google</desc-->'
            tmpstring = tmpstring + '<!--copyright author="Google Inc">'
            tmpstring = tmpstring + '<year>2019</year>'
            tmpstring = tmpstring + '<license>https://developers.google.com/maps/terms</license>'
            tmpstring = tmpstring + '</copyright-->'
            tmpstring = tmpstring + '<!--url>https://www.google.co.uk/maps/dir/Madurai, Tamil Nadu/Trichy, Tamil Nadu/@10.3578364,77.7444067,9z/data=!3m1!4b1!4m13!4m12!1m5!1m1!1s0x3b00c582b1189633:0xdc955b7264f63933!2m2!1d78.1197754!2d9.9252007!1m5!1m1!1s0x3baaf50ff2aecdad:0x6de02c3bedbbaea6!2m2!1d78.7046725!2d10.7904833?hl=en-GB&hl=en</url-->'
            tmpstring = tmpstring + '<time>2019-08-21T15:23:25Z</time>'
            tmpstring = tmpstring + '</metadata>'
            tmpstring = tmpstring + '<trk>'
            tmpstring = tmpstring + '<name>Madurai to Trichy</name>'
            tmpstring = tmpstring + '<number>1</number>'
            tmpstring = tmpstring + '<trkseg>'
            var strLatitude = '';
            var strLongitude = '';
            var FlagLatitude = false;
            var FlagLongitude = false;
            for (var i = 0; i < data.split(',').length - 1; i++) {
                if (data.split(',')[i].indexOf('latitude') >= 0) {
                    strLatitude = data.split(',')[i].substring(data.split(',')[i].indexOf('latitude'), data.split(',')[i].length).split(':')[1]
                    FlagLatitude = true;
                }
                if (data.split(',')[i].indexOf('longitude') >= 0) {
                    strLongitude = data.split(',')[i].substring(data.split(',')[i].indexOf('longitude'), data.split(',')[i].length).split(':')[1].substring(0, 12)
                    FlagLongitude = true;
                }
                if ((FlagLatitude == true) && (FlagLongitude == true)) {
                    tmpstring = tmpstring + '<trkpt lat=' + strLatitude + ' lon=' + strLongitude + '>'
                    tmpstring = tmpstring + '<name>TP' + i + '</name>';
                    tmpstring = tmpstring + '<time>2019-08-21T15:23:25Z</time>';
                    tmpstring = tmpstring + '</trkpt>';
                    FlagLatitude = false;
                    FlagLongitude = false;
                }
            }
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
                getJSONP(url, gotRouteMatchResponse);
            }
        }
        var gotRouteMatchResponse = function (respJsonObj) {
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

                for (var l = 0; l < tracePoints.length; l++) {
                    var p = tracePoints[l];
                    inputTracePointGroup.addObject(new H.map.Marker(new H.geo.Point(p.originalPosition.latitude, p.originalPosition.longitude), { icon: icons["#000000" + l] }));
                    matchedTracePointGroup.addObject(new H.map.Marker(new H.geo.Point(p.mappedPosition.latitude, p.mappedPosition.longitude), { icon: icons["#00FF00" + l] }));
                }
            } else { // old routematch response
                addLinkPointsToObjectContainer(routeLinks, false);
                // draw the original and the matched trace points
                tracePoints = respJsonObj.TracePoints;
                for (var l = 0; l < tracePoints.length; l++) {
                    var p = tracePoints[l];
                    //debugger;
                    inputTracePointGroup.addObject(new H.map.Marker(new H.geo.Point(p.lat, p.lon), { icon: icons["#000000" + l] }));
                    matchedTracePointGroup.addObject(new H.map.Marker(new H.geo.Point(p.latMatched, p.lonMatched), { icon: icons["#00FF00" + l] }));
                }
            }
            if (originalTraceStrip !== null) {
                objContainer.addObject(new H.map.Polyline(originalTraceStrip, { zIndex: 4, style: DEFAULT_TRACE_STYLE }));
            }
            map.addObject(objContainer);
            if (zoomToResult) map.setViewBounds(objContainer.getBounds());
            zoomToResult = true;
            // should display the warnings … warnings = respJsonObj.Warnings;  if (warnings.length > 0) …
            mapVersion = respJsonObj.mapVersion; // RME's map version. Use it to cross reference with PDE.
        };
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

                    coords1 = getCoordsWithOffset(coords1, distance, l, routeLinks.length);
                }

                totalDistance = totalDistance + routeLinks[l]['linkLength'];
                arrLinkGroup.push({ 'linkid': routeLinks[l].linkId, 'segments': (coords1.length / 2) });

                if (routeLinks[l].linkId != lLinkId) {
                    for (var c = 0; c < coords1.length; c += 2) {
                        coords2.pushLatLngAlt(coords1[c], coords1[c + 1], null); //if it is not offset link, just add new point
                        full_geometry.push(new H.geo.Point(coords1[c], coords1[c + 1]));
                        var objLatLan = new H.geo.Point(coords1[c], coords1[c + 1]);

                        full_geometry_additional.push({
                            'attributes': objLatLan,
                            'linkid': routeLinks[l].linkId, 'mSecToReachLinkFromStart': routeLinks[l].mSecToReachLinkFromStart,
                            'linkLength': routeLinks[l].linkLength
                        });
                    }


                    //arrLinkGroup.push({ 'linkid': routeLinks[l].linkId, 'segments': (coords1.length / 2) });
                    lLinkId = Math.abs(routeLinks[l].linkId);

                    var lineStyle = makeConfidenceAwareStyle(routeLinks[l].confidence);
                    var linkPolyline;
                    var speed;
                    var lineStyle1;
                    speed = ((routeLinks[l].linkLength / 1000) / ((routeLinks[l].mSecToReachLinkFromStart / 1000) / 3600));
                    if (routeLinks[l].mSecToReachLinkFromStart == 0) { // Start Position
                        lineStyle1 = { lineJoin: "round", lineWidth: 8, strokeColor: "blue" };
                    }
                    else if (speed > 80) {
                        lineStyle1 = { lineJoin: "round", lineWidth: 8, strokeColor: "red" };
                    }
                    else if ((speed > 50) && (speed < 80)) {
                        lineStyle1 = { lineJoin: "round", lineWidth: 8, strokeColor: "#FFBF00" }; //"Amber"
                    }
                    else {
                        lineStyle1 = { lineJoin: "round", lineWidth: 8, strokeColor: "blue" };
                    }
                    linkPolyline = new H.map.Polyline(coords2, { zIndex: 3, style: lineStyle1 });
                    linkPolyline.setData(routeLinks[l]);
                    linkPolyline.addEventListener('tap', createTapLinkHandler(linkPolyline));
                    objContainer.addObject(linkPolyline);
                }
            }

            //debugger;
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

        $('#btnPlay').click(function () {
            //debugger;
           // bearsMarker = null;
            if ($('#exampleFormControlFile1').get(0).files.length === 0) {
                alert("Kindly select the File to simulate the Route");
                $("#btnPlay").attr("disabled", false);
                return;
            }

            $('#lblSpeedValue').val('');
            $('#lblKMValue').val('');
            CurrentLinkID = '';
            PreviousLinkID = '';
            TotalTimeTakeninsec = 0;
            TotalKM = 0;

            $("#btnPlay").attr("disabled", true);
            $("#btnPause").attr("disabled", false);
            $("#btnReset").attr("disabled", false);

            PauseFlage = false;
            $("#btnPause").html('Pause');

            MarkerStartEnd.addObject(new H.map.Marker(new H.geo.Point(full_geometry[0]['lat'], full_geometry[0]['lng']), { icon: icons["#000000"] }));
            MarkerStartEnd.addObject(new H.map.Marker(new H.geo.Point(full_geometry[full_geometry.length - 1]['lat'], full_geometry[full_geometry.length - 1]['lng']), { icon: icons["#000000"] }));
            map.addObject(MarkerStartEnd);
            arrayCount = Pausecontinue('', inpUserSpeed);
        });

        function Pausecontinue(j, inpUserSpeed) {

            var items = full_geometry;
            var i;
            if ((j == undefined) || (j == '')) { i = 0 }
            else { i = j }
            var lblSpeedValue = document.getElementById('lblSpeedValue');
            setTimeoutfunction = (function loopIt(i) {
                setTimeout(function () {
                    var tmp = 0.000;
                    var tmpspeed = (3600 / inpUserSpeed) * (full_geometry_additional[i]['linkLength'] / 1000);

                    //if (arrLinkGroup.find(o => o.linkid === full_geometry_additional[i]['linkid'])['segments'] == 0) {
                    //    debugger;
                    //}
                    debugger;
                    traceSpeed = (tmpspeed / arrLinkGroup.find(o => o.linkid === full_geometry_additional[i]['linkid'])['segments']);
                    traceSpeed = traceSpeed * 1000; // secods to Milliseconds
                    CurrentLinkID = full_geometry_additional[i]['linkid'];
                    TotalTimeTakeninsec = TotalTimeTakeninsec + ((traceSpeed / 1000) / 60);
                    //debugger;
                    //TotalTimeTakeninsec = TotalTimeTakeninsec / 60;
                    $('#lblSpeedValue').val(TotalTimeTakeninsec.toFixed(2));
                    if (CurrentLinkID != PreviousLinkID) {
                        //TotalTimeTakeninsec = TotalTimeTakeninsec + (traceSpeed / 1000);
                        //$('#lblSpeedValue').val(TotalTimeTakeninsec.toFixed(2));
                        TotalKM = TotalKM + (full_geometry_additional[i]['linkLength'] / 1000);
                        $('#lblKMValue').val(TotalKM.toFixed(2))

                    }
                    //debugger;
                    if (i < full_geometry_additional.length - 1) {
                        if (full_geometry_additional[i]['attributes']['lat'] != full_geometry_additional[i + 1]['attributes']['lat']) {
                            var RotateDegree;
                            RotateDegree = getDegree(full_geometry_additional[i]['attributes']['lat'], full_geometry_additional[i]['attributes']['lng'], full_geometry_additional[i + 1]['attributes']['lat'], full_geometry_additional[i + 1]['attributes']['lng']);
                            updateMarkerDirection(parisMarker, RotateDegree, full_geometry_additional[i].attributes["lat"], full_geometry_additional[i].attributes["lng"], true);
                        }

                    }
                    else {
                        var RotateDegree;
                        debugger;
                        RotateDegree = getDegree(full_geometry_additional[i]['attributes']['lat'], full_geometry_additional[i]['attributes']['lng'], full_geometry_additional[full_geometry_additional.length - 1]['attributes']['lat'], full_geometry_additional[full_geometry_additional.length - 1]['attributes']['lng']);
                        updateMarkerDirection(parisMarker, RotateDegree, full_geometry_additional[i].attributes["lat"], full_geometry_additional[i].attributes["lng"], true);

                    }


                    //if (full_geometry_additional[i]['attributes']['lat'] == full_geometry_additional[full_geometry_additional.length - 1]['attributes']['lat']) {
                    //    debugger;
                    //    var RotateDegree;
                    //    RotateDegree = getDegree(full_geometry_additional[i]['attributes']['lat'], full_geometry_additional[i]['attributes']['lng'], full_geometry_additional[i + 1]['attributes']['lat'], full_geometry_additional[i + 1]['attributes']['lng']);
                    //    updateMarkerDirection(parisMarker, RotateDegree, full_geometry_additional[i].attributes["lat"], full_geometry_additional[i].attributes["lng"], true);
                    //    //console.log(RotateDegree);
                    //    //console.log(CurrentLinkID);
                    //    //console.log(PreviousLinkID);
                    //}

                    if (PauseFlage == true) {
                        arrayCount = i;
                        return i;
                    }
                    //parisMarker.setPosition({ lat: full_geometry_additional[i].attributes["lat"], lng: full_geometry_additional[i].attributes["lng"] });
                    //map.addObject(parisMarker);
                    PreviousLinkID = full_geometry_additional[i]['linkid'];
                    if (i < items.length - 1) loopIt(i + 1)
                }, traceSpeed);
            })(i)
        }



        $('#btnPause').click(function () {
            $("#btnPlay").attr("disabled", true);
            $("#btnPause").attr("disabled", false);
            $("#btnReset").attr("disabled", false);

            var tmp = arrayCount;
            if (PauseFlage == undefined) {
                PauseFlage = false;
                tmp = Pausecontinue(arrayCount, inpUserSpeed);
                $("#btnPause").html('Pause');
            }
            else if (PauseFlage == true) {
                PauseFlage = false;
                tmp = Pausecontinue(arrayCount, inpUserSpeed);
                $("#btnPause").html('Pause');
            }
            else if (PauseFlage == false) {
                PauseFlage = true;
                $("#btnPause").html('Continue');
            }

        });

        function Reset() {
            full_geometry_additional = new Array();
            full_geometry = new Array();
            arrLinkGroup = new Array();
            FirstLoop = false;
            $('#lblSpeedValue').val('0');
            $('#lblKMValue').val('');
            $('#lblKMRouteCalculation').val('0');
            $('#exampleFormControlFile1').val('');
            $('#cmbSelect').prop('selectedIndex', 0);
            //if ((bearsMarker != null) && (FirstLoop == true)) {
            //    map.removeObject(bearsMarker);
            //    bearsMarker = null;
            //}
            if (bearsMarker != null)  {
                map.removeObject(bearsMarker);
                bearsMarker = null;
            }
            inpUserSpeed = 10; // default Speed
            PauseFlage = true;
            $("#btnPause").html('Pause');
            TotalTimeTakeninsec = 0;
            TotalKM = 0;
            CurrentLinkID = '';
            PreviousLinkID = '';
            MarkerStartEnd.removeAll();
            objContainer.removeAll();
            traceSpeed = 0
            
            //map.removeObject(parisMarker);
            clearTimeout(setTimeoutfunction);
            //debugger;

            //map.removeAll();
            //if (map.has(bearsMarker)) {
            //    debugger;
            //}

           
            
        }

        $('#btnReset').click(function () {
            debugger;
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
                //debugger;
                return;
            }
            var outerElement = document.createElement('div')
            //outerElement.style.userSelect = 'none';
            //outerElement.style.webkitUserSelect = 'none';
            //outerElement.style.msUserSelect = 'none';
            //outerElement.style.mozUserSelect = 'none';
            //outerElement.style.cursor = 'default';
            

            var objImg = document.createElement('img');
            objImg.src = '{{asset("playback/assets/img/Car.png")}}';
            el = objImg;
            var carDirection = RotateDegree;
            console.log(RotateDegree);
            if (el.style.transform.includes("rotate")) {
                el.style.transform = el.style.transform.replace(/rotate(.*)/, "rotate(" + carDirection + "deg)");
            } else {
                el.style.transform = el.style.transform + "rotate(" + carDirection + "deg)";
            }
            outerElement.appendChild(el);

            //outerElement.style.height = '20px';
            //outerElement.style.width = '20px';

            if (FirstLoop == true) {
                //debugger;
                //bearsMarker = null;
                map.removeObject(bearsMarker);
            }
            debugger;
            var domIcon = new H.map.DomIcon(outerElement, { anchor: { x: 20, y: 40 } });
            //domIcon.setCenter(); 
            //domIcon.setCenter();
            bearsMarker = new H.map.DomMarker({ lat: Hlat, lng: Hlng }, {
                icon: domIcon
            });
            map.addObject(bearsMarker);
            if (FirstLoop == false) {
                map.setZoom(16, true);
            }
            map.setCenter({ lat: Hlat, lng: Hlng }, true);

            FirstLoop = true;
        }
        function getDegree(lat1, long1, lat2, long2) {
            var dLon = (long2 - long1);
            var y = Math.sin(dLon) * Math.cos(lat2);
            var x = Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1)
                * Math.cos(lat2) * Math.cos(dLon);
            var brng = Math.atan2(y, x);
            brng = radianstoDegree(brng);
            brng = (brng + 360) % 360;
            // brng = 360 - brng; // count degrees counter-clockwise - remove to make clockwise
            return brng;
        }

        function radianstoDegree(x) {
            return x * 180.0 / Math.PI;
        }

        //$('#exampleFormControlFile1').click(function () {
        //    Reset();
        //});

    </script>
</body>
</html>