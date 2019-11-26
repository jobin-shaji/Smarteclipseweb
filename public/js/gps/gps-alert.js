$(document).ready(function () {
   
     var url = 'gps-alert-list';
     var data={

     }
      backgroundPostData(url,data,'gpsAlert',{alert:true});
});
function  gpsAlert(res) 
{
	// console.log(res.alerts.data);
	for(var i=0;i<10;i++){
		var j=i+1;
	    $('.inner').prepend('<tr>'+
	    '<td>'+j+'</td>'+
    	'<td>'+res.alerts.data[i].alert_type.description+'</td>'+
    	'<td>'+res.alerts.data[i].gps.vehicle.name+'</td>'+
    	'<td>'+res.alerts.data[i].gps.vehicle.register_number+'</td>'+
    	'<td>'+res.alerts.data[i].device_time+'</td>'+
    	'</tr>');
	}
	$("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);
	var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();
	$('#chatBox').scroll(function(){
	    if ($('#chatBox').scrollTop() == 0){
	        // Display AJAX loader animation
	         $('#loader').show();  
	        setTimeout(function(){
	        // Simulate retrieving 4 messages
	        for(var i=0;i<1;i++){
	        $('.inner').prepend('<div class="messages">Newly Loaded messages<br/><span class="date">'+Date()+'</span> </div>');
	            }
	            // Hide loader on success
	            $('#loader').hide();
	            $('#chatBox').scrollTop(30);
	        },780); 
	    }
	});

	}
	

