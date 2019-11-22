$(document).ready(function () { 
     $("#loader-1").hide();
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
        var vehicle_id=$('#vehicle').val(); 
        var report_type=$('#report').val(); 
        var client=$('meta[name = "client"]').attr('content');
        var url = '/track-report-list';
       
        var data = {
            'vehicle':vehicle_id,
            'client':client, 
            'type':report_type 
        };
       $("#loader-1").show();
       backgroundPostData(url,data,'vehicleTrackReport',{alert:true});           
    }

   
}
function vehicleTrackReport(res){
  $("#loader-1").hide();
  $('#sl').text("1");
  $('#sleep').text(res.sleep);
  $('#motion').text(res.motion);
  $('#halt').text(res.halt); 
}

