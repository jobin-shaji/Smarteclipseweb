$(document).ready(function () { 
     $("#loader-1").hide();
});

function check()
{  
    if(document.getElementById('vehicle').value == ''){
        alert('Please Select Vehicle');
    }
    else if(document.getElementById('date').value == ''){
        alert('Please Select Report Type');
    }
    else{
        // callBackDataTable();
        var url = 'duration-report-list';
        var vehicle =document.getElementById('vehicle').value;
        var date =document.getElementById('date').value;
        var  data = {
            vehicle : vehicle,
            date : date          
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

