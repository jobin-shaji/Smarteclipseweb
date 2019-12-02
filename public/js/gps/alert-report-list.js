

function check()
{  
     if(document.getElementById('vehicle').value == ''){
        alert('please enter vehicle');
    }
  
    else{    
        var vehicle_id=$('#vehicle').val();       
        var client=$('meta[name = "client"]').attr('content');
        var from_date = document.getElementById('fromDate').value;
        var to_date = document.getElementById('toDate').value;
        var alert_id=$('#alert').val(); 
        var data = {'vehicle':vehicle_id,'client':client, 'from_date':from_date , 'to_date':to_date,'alert_id':alert_id};
        var url = '/alert-report-list';
        var data = {
            'vehicle_id':vehicle_id,
            'client':client, 
            'from_date':from_date , 
            'to_date':to_date,
            'alertID':alert_id
        };
        backgroundPostData(url,data,'alertsReport',{alert:true});           
    }   
}
function alertsReport(res){
    $('#alerttabledata').empty();
    for (var i = 0; i < res.length; i++) {
        var j=i+1;
        var alertdatas = '<tr><td>'+j+'</td>'+
        '<td>'+res[i].gps.vehicle.name+'</td>'+
        '<td>'+res[i].alert_type.description+'</td>'+
        '<td>'+res[i].device_time+'</td>'+       
        '</tr>';
        $("#alerttabledata").append(alertdatas);
    }
}






