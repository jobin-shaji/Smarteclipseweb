$(document).ready(function () {
     var url = 'dash-count';
     var data = { 
      depot : $('meta[name = "depot"]').attr('content')
     };

 //    window.setInterval(function(){
 //    	 backgroundPostData(url,data,'dbcount',{alert:false});  
	// }, 5000);
});

function dbcount(res){
	  console.log(res.stages)
      $('#stages').text(res.stages);
      $('#routes').text(res.routes);
      $('#trips').text(res.trips);
      $('#tickets').text(res.tickets);
      $('#vehicles').text(res.vehicles);
      $('#employees').text(res.employees);
      $('#collection').text(res.collections);
      $('#depots').text(res.depots);
      $('#etms').text(res.etms);
      $('#expense').text(res.expense);

}