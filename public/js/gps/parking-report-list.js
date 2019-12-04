function trackMode()
{  
     if(document.getElementById('vehicle').value == ''){
        alert('Please enter vehicle');
    } 
    else{   
     calculate();    
        var vehicle_id=$('#vehicle').val();       
        var client=$('meta[name = "client"]').attr('content');
        var from_date = document.getElementById('fromDate').value;
        var to_date = document.getElementById('toDate').value;
        var data = {'vehicle':vehicle_id,'client':client, 'from_date':from_date , 'to_date':to_date};
        var url = '/parking-report-list';
        var data = {
            'vehicle':vehicle_id,
            'client':client, 
            'from_date':from_date , 
            'to_date':to_date
        };
        backgroundPostData(url,data,'vehicleParkingReport',{alert:true});
           
    }

   
}
function calculate() {
    var d1 = $('#fromDate').data("DateTimePicker").date();
    var d2 = $('#toDate').data("DateTimePicker").date();
    var timeDiff = 0
    if(d2) {
        timeDiff = (d2 - d1) / 1000;
    }
    var DateDiff = Math.floor(timeDiff / (60 * 60 * 24));
    if(DateDiff>15)
    {
        var fromDate=$('#fromDate').val();
        document.getElementById("toDate").value = "";
        alert("Please select date upto 15 days ");
    }
}

function vehicleParkingReport(res){
    
    $('#sl').text("1");      
    $('#vehicle_name').text(res.vehicle_name);
    $('#register_number').text(res.register_number);
    $('#sleep').text(res.sleep);
     
        
  }