 // // Initialize the platform object:
 //    var platform = new H.service.Platform({
 //    'app_id': '{QViYMVb62ejfVgcqHW2l}',
 //    'app_code': '{Em2ekKlXM2Mt38Cz9VCLUHA}'
 //    });

 //    // Obtain the default map types from the platform object
 //    var maptypes = platform.createDefaultLayers();

 //    // Instantiate (and display) a map object:
 //    var map = new H.Map(
 //    document.getElementById('mapContainer'),
 //    maptypes.normal.map,
 //    {
 //      zoom: 10,
 //      center: { lng: 13.4, lat: 52.51 }
 //    });
var overlays = [];
var allPolly = [];
var selectedShape;
var polygon;
var drawingManager;
var map;
var place_name="";
var vertices;

function initMap(){

  //  var url = '/client-location';
  //  var data = { };
  //  backgroundPostData(url,data,'loadMap',{alert:false});

  // }
  var latMap = parseFloat(document.getElementById('lat').value);
  var lngMap = parseFloat(document.getElementById('lng').value);
  // var latMap=25.402282;
  // var lngMap=51.189165;

  //    function loadMap(res) {
  // console.log(res);
  //     // console.log(res);
  //         latMap = res.latitude;
  //         lngMap = res.longitude;
  map = new google.maps.Map(document.getElementById('map'),
   {
    center: {lat: latMap, lng: lngMap},//qatar-25.354826 , 51.183884 kerala- 9.931233 , 76.267303
    zoom: 12
  });
  map.setOptions({ minZoom:5, maxZoom: 17 });

  var input1 = document.getElementById('search_place'); 
  autocomplete1 = new google.maps.places.Autocomplete(input1);
  var searchBox1 = new google.maps.places.SearchBox(autocomplete1);
  var drawingManager = new google.maps.drawing.DrawingManager({
    drawingMode: google.maps.drawing.OverlayType.POLYGON,
    // drawingMode: google.maps.drawing.OverlayType,


    drawingControl: true,
    drawingControlOptions: {
      position: google.maps.ControlPosition.TOP_CENTER,
      drawingModes: [ 'polygon']
    },

    markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
    circleOptions: {
      fillColor: '#CD1C40',
      fillOpacity: 1,
      strokeWeight: 5,
      clickable: false,
      editable: true,
      zIndex: 1
    }
  });
  // console.log(drawingManager);
  drawingManager.setMap(map);
  google.maps.event.addDomListener(drawingManager, 'polygoncomplete', function(polygon) {
    var vertices = polygon.getPath();
    var len = vertices.getLength();
    // overlays.push(polygon);
    if(len>=10)
    {
      alert("Only 10 points allowed");
      polygon.setMap(null);
    }
    else
    {
      addArrays(polygon);
      drawingManager.setDrawingMode(null);
      //   drawingManager.setOptions({
      //   drawingControl: false
      // });
    }
  });


  google.maps.event.addDomListener(savebutton, 'click', function() {
    var name= document.getElementById('name').value;
    if(name !== "")
    {
      var url = 'save/fence';
      var data = {
      polygons : allPolly,
      name : name
    };
    backgroundPostData(url,data,'none',{alert:true});  
    // console.log(allPolly);
    }
    else
    {
      alert("Plese Enter Name");
    }
  });

  // setSelection(newShape);
  google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
    drawingManager.setDrawingMode(null);
    // Add an event listener on this new shape, and make clickable
    //Click = selected
    var newShape = e.overlay;
    newShape.type = e.type;
    setSelection(newShape);
  });
}

function deleteSelectedShape() {
  selectedShape.setMap(null);
  selectedShape.setOptions({
  // drawingControl: false
});

}
function clearSelection() {
  if (selectedShape) {
  selectedShape.setEditable(false);
  selectedShape = null;
  }
}
//set selection to a shape
function setSelection(shape) {
  clearSelection();
  selectedShape = shape;
  shape.setEditable(true);
}

function removeLineSegment() {
  allPolly =[];
  deleteSelectedShape();
}

function addArrays(polygon) {
  var vertices = polygon.getPath();
  var contentString = "";
  poly = [];
  for (var i =0; i < vertices.getLength(); i++) {
  var xy = vertices.getAt(i);
  // contentString += '<br>' + 'Coordinate ' + i + ':<br>' + xy.lat() + ',' +
  // xy.lng();
  cord = [ xy.lat(),xy.lng()];
  poly.push(cord);
  }
  // overlays.push(event);
  allPolly.push(poly);
}
function locationSearch(){

  place_name=$('#search_place').val();
  var geocoder =  new google.maps.Geocoder();
  geocoder.geocode( { 'address':place_name}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      var lat=results[0].geometry.location.lat();
      var lng=results[0].geometry.location.lng();
      map.panTo(new google.maps.LatLng(lat,lng));
      map.setOptions({Zoom: 17});
    } else {
      alert("Something got wrong " + status);
    }
  });
  return false;
}





     
