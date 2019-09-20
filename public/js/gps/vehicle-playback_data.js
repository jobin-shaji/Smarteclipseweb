$(document).ready(function () {
    getPlayBackData();
});


function getPlayBackData(){
	
	var vehicle_id=$.urlParam('vehicle_id');
	var start_date=$.urlParam('from_date');
	var end_date=$.urlParam('to_date');
    var data = {
         vehicle_id : vehicle_id,
         start_date : start_date,
         end_date : end_date
         };

     $.ajax({
            type: "GET",
            url: "/vehicle_playback_data",
            dataType: "json",
            data:data,
            success : function(res){
     
                if(res.status=="success"){
                     process(res.locations);
                } else {
                    alert("there is no playback data")
                }
            }
        });




}


$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return decodeURIComponent(results[1] || 0);
    }
}