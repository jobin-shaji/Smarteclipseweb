$(document).ready(function () {
     var url = 'dash-count';
     var data = { 
     
     };

    window.setInterval(function(){
    	 backgroundPostData(url,data,'dbcount',{alert:false});  
	}, 5000);
});

function dbcount(res){
	   $('#gps').text(res.gps);
      $('#dealer').text(res.dealers);
      $('#sub_dealer').text(res.subdealers);
      $('#client').text(res.clients);
}