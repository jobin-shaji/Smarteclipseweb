var timeFactor = 5; //number of minutes in real life to a second in the viz
$('.timeFactor').html(timeFactor); //Displays the timeFactor in the UI.
var tweenToggle = 0;

var APP_ID = '2VzgdTUB2EW9ez9B2DZa';
var APP_CODE = 'Xd_baX0mFI4IEdKBG-8x8g';
var tUrl = 'https://1.base.maps.api.here.com/maptile/2.1/maptile/newest/normal.day.grey/{z}/{x}/{y}/256/png8?app_id=' + APP_ID + '&token=' + APP_CODE + '&lg=/eng';
var tUrlOld = 'http://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png';
var tiles = L.tileLayer(tUrl, {
    attribution: '&copy;'
});

var topLeft, bottomRight;

var time = moment();
var map = L.map('map', { zoomControl: false })
    .addLayer(tiles)
    .setView([22.631529243663, 88.453499721363], 14);


var running = {
    "fare": 0,
    "surcharge": 0,
    "mtatax": 0,
    "tolls": 0,
    "tip": 0,
    "total": 0,
    "passengers": 0
};



var svg = d3.select(map.getPanes().overlayPane).append("svg"),
    g = svg.append("g").attr("class", "leaflet-zoom-hide");


//area chart
var margin = { top: 30, right: 20, bottom: 20, left: 40 },
    areaChartWidth = $(window).width() - margin.left - margin.right - 40,
    areaChartHeight = 140 - margin.top - margin.bottom;

var parseDate = d3.time.format("%d-%b-%y").parse;

var x = d3.scale.linear()
    .range([0, areaChartWidth]);

var y = d3.scale.linear()
    .range([areaChartHeight, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .ticks(4);

var area = d3.svg.area()
    .x(function (d) { return x(d.time); })
    .y0(areaChartHeight)
    .y1(function (d) { return y(d.runningFare); });

var dummyData = [];



x.domain([0, 24]);
y.domain([0, 600]);
$('.slower').click(function () {
    if (timeFactor > 1) {
        timeFactor -= 1;
    };

    $('.timeFactor').html(timeFactor);

});

$('.faster').click(function () {
    timeFactor += 1;
    $('.timeFactor').html(timeFactor);

});

$('.asterisks').click(function () {
    $('.asterisksPopup').fadeIn();
});

$('.attribution').click(function () {
    $('.attributionPopup').fadeIn();
});

$('.aboutPopup .panel-heading>.glyphicon').click(function () {
    $('.aboutPopup').fadeOut();
});

$('.asterisksPopup .panel-heading>.glyphicon').click(function () {
    $('.asterisksPopup').fadeOut();
});

$('.attributionPopup .panel-heading>.glyphicon').click(function () {
    $('.attributionPopup').fadeOut();
});

var transform = d3.geo.transform({
    point: projectPoint
}),
    d3path = d3.geo.path().projection(transform);

var timer;

function updateTimer() {
    time.add('minutes', 1);
    //$('.readableTime').text(time.format('h:mm a'));
    // $('.date').text(time.format('dddd, MMMM Do YYYY'));
    timer = setTimeout(function () { updateTimer() }, (1000 / timeFactor));
}
var i = 0;

function startTrip(tripIndex) {
    reset();
    i = tripIndex;
    $('.overlay').fadeOut(250);
    $("#launchInfo").modal('hide');
    $('.box').fadeIn(250);
    setTimeout(function () {
        updateTimer();
        iterate();
    }, 500);
}
function iterate() {

    var chartInterval = 0;

    var emptyData = [];


    var path = svg.select("path.trip" + i)
        .attr("style", "opacity:.7")
        .call(transition);



    function pathStartPoint(path) {
        var d = path.attr('d');

        dsplitted = d.split("L")[0].slice(1).split(",");
        var point = []
        point[0] = parseInt(dsplitted[0]);
        point[1] = parseInt(dsplitted[1]);

        return point;
    }


    var startPoint = pathStartPoint(path);
    marker.attr("transform", "translate(" + startPoint[0] + "," + startPoint[1] + ")");


    path.each(function (d) {

        //add the translation of the map's g element
        startPoint[0] = startPoint[0]; //+ topLeft[0];
        startPoint[1] = startPoint[1]; //+ topLeft[1];
        var newLatLon = coordToLatLon(startPoint);
        pointsArray.push([newLatLon.lng, newLatLon.lat, d.properties.isSolid]);

        points = g.selectAll(".point")
            .data(pointsArray)
            .enter()
            .append('circle')
            .attr("r", 5)
            .attr("class", function (d) {
                if (d[2]) {
                    return "startPoint point";
                } else {
                    return "endPoint point";
                }
            })
            .attr("transform", function (d) {
                return translatePoint(d);
            });

        if (d.properties.isSolid) { //transition marker to show full taxi
            marker
                .transition()
                .duration(500)
                .attr("r", 5)
                .attr('style', 'opacity:1');







        } else { //Transition marker to show empty taxi

            marker
                .transition()
                .duration(500)
                .attr("r", 40)
                .attr('style', 'opacity:.3');

        }
    });




    function transition(path) {

        g.selectAll

        path.transition()
            .duration(function (d) {
                //calculate seconds
                var duration = d.geometry.coordinates.length * 1000 * 60;
                if (d.properties.duration) {
                    duration = d.properties.duration;
                } else if (d.properties.pickuptime) {
                    var start = Date.parse(d.properties.pickuptime),
                        finish = Date.parse(d.properties.dropofftime);
                    duration = finish - start;
                    time = moment(d.properties.pickuptime.toString());
                    $('.readableTime').text(time.format('h:mm a'));
                }
                duration = duration / 60000; //convert to minutes
                duration = duration * (1 / timeFactor) * 1000;
                return (duration);
            })
            .attrTween("stroke-dasharray", tweenDash)
            .each("end", function (d) {

                if (d.properties.isSolid) {
                    running.fare += parseFloat(d.properties.fare);
                    running.surcharge += parseFloat(d.properties.surcharge);
                    running.mtatax += parseFloat(d.properties.mtatax);
                    running.tip += parseFloat(d.properties.tip);
                    running.tolls += parseFloat(d.properties.tolls);
                    running.total += parseFloat(d.properties.total);
                    running.passengers += parseFloat(d.properties.passengers);
                    for (var p = 0; p < d.properties.passengers; p++) {
                        $('.passengerGlyphs').append('<span class="glyphicon glyphicon-user"></span>');
                    }
                    updateRunning();
                };
                i++;

                var nextPath = svg.select("path.trip" + i);
                if (nextPath[0][0] == null) {
                    clearTimeout(timer);
                } else {
                    iterate();
                }
            });
    }

    function tweenDash(d) {

        var l = path.node().getTotalLength();
        var i = d3.interpolateString("0," + l, l + "," + l); // interpolation of stroke-dasharray style attr
        return function (t) {
            var marker = d3.select("#marker");
            var p = path.node().getPointAtLength(t * l);
            marker.attr("transform", "translate(" + p.x + "," + p.y + ")");//move marker


            if (tweenToggle == 0) {
                tweenToggle = 1;
                var newCenter = map.layerPointToLatLng(new L.Point(p.x, p.y));

                map.panTo(newCenter, 14);
            } else {
                tweenToggle = 0;
            }



            return i(t);
        }
    }

}

//get a random number between 0 and 11
var number = Math.floor(Math.random() * 15)
var data = null;
var feature = null;
var marker = null;
var pointsArray = [];


function execCommand(url, method, data, callBack) {
    var headers =  { "Content-Type": "application/json" };
    $.ajax({
        url: url,
        type: method,
        headers: headers,
        data: data,
        contentType: "application/json",
        beforeSend: function (request, settings) {

            start_time = new Date().getTime();

        },
        success: function (data, textStatus, jqXHR) {
            callBack(data, jqXHR.status);
        },
        error: function (jqXHR, textStatus, errorThrown) {


            callBack(jqXHR.responseJSON, jqXHR.status);

        }
    });
}

function getFeature(jsonData,index){

    var feature = {
        "type": "Feature",
        "id": "test1",
        "properties": {
            "key": index,
            "isSolid": true,
            "tip": "0",
            "fare": "0",
            "tolls": "0",
            "total": "0",
            "mtatax": "0",
            "hasfare": true,
            "surcharge": "0.0",
            "passengers": "0",
            "paymenttype": "CSH",
            "nextpickuptime": "5/30/13 1:45",
        },
        "geometry": {
            "type": "LineString",
            "coordinates": []
        }
    }
    jsonData.forEach(element => {
        feature.geometry.coordinates.push([parseFloat(element.longitude), parseFloat(element.latitude)]);
    });

    return feature;
}
function toFC(feature) {
    return {
        type: "FeatureCollection",
        features: [
            feature
        ]
    }
}



function process(dataInput){
    data = toFC(getFeature(dataInput,1));
    console.log("Loaded data for medallion: " + data.features[0].properties.medallion);
    feature = g.selectAll("path")
        .data(data.features)
        .enter().append("path")
        .attr("class", function (d) {
            return "trip" + (d.properties.key) + " " + d.properties.isSolid;
        })
        .attr("style", "opacity:0");
    var points = g.selectAll(".point")
        .data(pointsArray);
    marker = g.append("circle");
    marker.attr("r", 5)
        .attr("id", "marker");
    map.on("viewreset", reset);
    map.on("zoomend", reset);
    reset();
    startTrip(1);
    
}



// Reposition the SVG to cover the features.
function reset() {
    var bounds = d3path.bounds(data);
    topLeft = bounds[0],
        bottomRight = bounds[1];

    svg.attr("width", bottomRight[0] - topLeft[0] + 100)
        .attr("height", bottomRight[1] - topLeft[1] + 100)
        .style("left", topLeft[0] - 50 + "px")
        .style("top", topLeft[1] - 50 + "px");

    g.attr("transform", "translate(" + (-topLeft[0] + 50) + "," + (-topLeft[1] + 50) + ")");

    feature.attr("d", d3path);

    //TODO: Figure out why this doesn't work as points.attr...
    g.selectAll(".point")
        .attr("transform", function (d) {
            return translatePoint(d);
        });


}


// Use Leaflet to implement a D3 geometric transformation.
function projectPoint(x, y) {
    var point = map.latLngToLayerPoint(new L.LatLng(y, x));
    this.stream.point(point.x, point.y);
}

function translatePoint(d) {
    var point = map.latLngToLayerPoint(new L.LatLng(d[1], d[0]));

    return "translate(" + point.x + "," + point.y + ")";
}

function coordToLatLon(coord) {
    var point = map.layerPointToLatLng(new L.Point(coord[0], coord[1]));
    return point;
}

