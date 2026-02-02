$(document).ready(function () {
    $("#loader-1").hide();
});

function trackMode()
{  
    if(document.getElementById('vehicle').value == '')
    {
        alert('Please enter vehicle');
    } 
    else if(document.getElementById('fromDate').value == '')
    {
        alert('Please select From date');
    }
    else if(document.getElementById('toDate').value == '')
    {
        alert('Please select To date');
    }
    else
    {   
        var vehicle_id      =   $('#vehicle').val();       
        var client          =   $('meta[name = "client"]').attr('content');
        var from_date       =   document.getElementById('fromDate').value;
        var to_date         =   document.getElementById('toDate').value;
        var data            =   {'vehicle':vehicle_id,'client':client, 'from_date':from_date , 'to_date':to_date};
        var url             =   'parking-report-list';
        var data            =   {
                                    'vehicle':vehicle_id,
                                    'client':client, 
                                    'from_date':from_date , 
                                    'to_date':to_date
                                };
        $("#loader-1").show();
        backgroundPostData(url,data,'vehicleParkingReport',{alert:true});  
    }
}
function vehicleParkingReport(res)
{
    $("#loader-1").hide();
    $('#sl').text("1");      
    $('#vehicle_name').text(res.vehicle_name);
    $('#register_number').text(res.register_number);
    $('#sleep').text(res.sleep);   
}