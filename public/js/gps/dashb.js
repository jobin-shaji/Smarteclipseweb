$(document).ready(function () {
     var url = 'dash-count';
     var data = { 
      dealer : $('meta[name = "dealer"]').attr('content')
     };

    window.setInterval(function(){
    	 backgroundPostData(url,data,'dbcount',{alert:false});  
	}, 5000);
});

function dbcount(res){
	  
      $('#dealer').text(res.dealers);
      $('#sub_dealer').text(res.subdealers);
      $('#client').text(res.clients);
}