$(document).ready(function () { 
   
        $("#load6").css("display","none");
        $("#load-6").css("display","none");
});

function trackMode()
{  
     if(document.getElementById('vehicle').value == ''){
        alert('Please enter vehicle');
    }
     if(document.getElementById('report').value == ''){
        alert('Please enter report type');
    }
    else{
        $("#load6").css("display","show");
        $("#load-6").css("display","show"); 
        var vehicle_id=$('#vehicle').val(); 
        var report_type=$('#report').val(); 
        var client=$('meta[name = "client"]').attr('content');
        var url = '/track-report-list';
       
        var data = {
            'vehicle':vehicle_id,
            'client':client, 
            'type':report_type 
        };
   
        $("#load6").css("display","show");
        $("#load-6").css("display","show");
       backgroundPostData(url,data,'vehicleTrackReport',{alert:true});           
    }

   
}
function vehicleTrackReport(res){
// //   $("#loader-1").hide();
  $("#load6").css("display","none");
  $("#load-6").css("display","none");
  $('#sl').text("1");
  $('#sleep').text(res.sleep);
  $('#motion').text(res.motion);
  $('#halt').text(res.halt); 
}

