
//updated all aaaaa

// function trackMode()
// {  
//      if(document.getElementById('vehicle').value == ''){
//         alert('please enter vehicle');
//     }
//      if(document.getElementById('report').value == ''){
//         alert('please enter report');
//     }
//     else{       
//         var vehicle_id=$('#vehicle').val(); 
//         var report_type=$('#report').val(); 
//         var client=$('meta[name = "client"]').attr('content');
       
        
//         var data = {'vehicle':vehicle_id,'client':client, 'from_date':from_date , 'to_date':to_date};
//         var url = '/track-report-list';
//         var data = {
//             'vehicle':vehicle_id,
//             'client':client, 
//             'from_date':from_date , 
//             'to_date':to_date
//         };
//         backgroundPostData(url,data,'vehicleTrackReport',{alert:true});
           
//     }

   
// }

function trackMode()
{  
     if(document.getElementById('vehicle').value == ''){
        alert('please enter vehicle');
    }
     if(document.getElementById('report').value == ''){
        alert('please enter report');
    }
    else{       
        var vehicle_id=$('#vehicle').val(); 
        var report_type=$('#report').val(); 
        var client=$('meta[name = "client"]').attr('content');
          var url = '/track-report-list';
       if(report_type==5)
       {    
             var from_date = document.getElementById('fromDate').value;
            var to_date = document.getElementById('toDate').value;
            var data = {'vehicle':vehicle_id,'client':client, 'type':report_type,'from_date':from_date , 'to_date':to_date};
       }
       else
       {
             var data = {
                'vehicle':vehicle_id,
                'client':client, 
                'type':report_type 
            };
       }
       backgroundPostData(url,data,'vehicleTrackReport',{alert:true});           
    }

   
}
function vehicleTrackReport(res){
    
    $('#sl').text("1");
      
      $('#sleep').text(res.sleep);
        $('#motion').text(res.motion);
          $('#halt').text(res.halt);
     
        
  }

