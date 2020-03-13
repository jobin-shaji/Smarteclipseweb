$(document).ready(function () { 
     $("#loader-1").hide();
});

function trackMode()
{  

    var vehicle_id      = $("#vehicle").val();
    var report_type     = $("#report").val();
    var hasError        = false;
    if(vehicle_id.length == 0){
        $("#vehicle").siblings('.error').remove();
        $("#vehicle").after("<span class='error text-danger'>Please Select Vehicle</span>")
        hasError = true;
    }else{
        $("#vehicle").siblings('.error').remove();
    } 
    if(report_type.length == 0){
        $("#report").siblings('.error').remove();
        $("#report").after("<span class='error text-danger'>Please Select  Report Type </span>")
        hasError = true;
    }else{
        $("#report").siblings('.error').remove();
    } 
    if(hasError == false)
    {  
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
    else
    {
        return false;
    }

}
function vehicleTrackReport(res){
  $("#loader-1").hide();
  $('#sl').text("1");
  $('#sleep').text(res.sleep);
  $('#motion').text(res.motion);
  $('#halt').text(res.halt); 
}

