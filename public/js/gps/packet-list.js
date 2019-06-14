$(document).ready(function () {
});

function PacketSubmit(){
var imei = document.getElementById('gps_id').value;
var lat = document.getElementById('lat').value;
var lng = document.getElementById('lng').value;
var speed = document.getElementById('speed').value;
var header = document.getElementById('header').value;
var from_date = document.getElementById('fromDate').value;
var formattedDate = moment(from_date).format('DDMMYYHms');
var data="NRM"+imei+"01L0"+formattedDate+"0"+lat+"N0"+lng+"E4040464e4c00000271b000.00000.0017991800H";
     $.ajax({
           url     :"https://api.gpsvst.vehiclest.com/api/v1/gps-data",
           method  :"Post",
           async   :true,
           context :this,
           data    :{vltdata:data},
           success : function (Result) {
            // alert(Result);
           }
       }); 
     
}





