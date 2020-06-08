function getUrl(){
  return $('meta[name = "domain"]').attr('content');
}

$(document).ready(function () {
  $('#count_data').hide();
  $('#loader').show();
});

function searchData()
{   
  if(document.getElementById('return_to').value == '')
  {
    alert('Please select any user to reassign');
  }
  else
  {
    var reassign_type_id = document.getElementById('return_to').value;
    var imei = document.getElementById('imei').value;
    var gps = document.getElementById('gps_id').value;
    var vehicle = document.getElementById('vehicle_id').value;
    var url = '/get-gps-count';
    var data = {
      'reassign_type_id':reassign_type_id,
      'imei':imei,
      'gps':gps,
      'vehicle':vehicle
    };
      backgroundPostData(url,data,'reassign_count',{alert:true});
    // count(imei);
  }
}
function reassign_count(res){
  $('#count_data').show();
  $('#gps_data_count').html(res.gps_data);
  $('#vlt_data_count').html(res.vlt_data);
  $('#alert_count').html(res.alert);
  $('#dailykm_count').html(res.daily_km);
  $('#vehicle_daily_updates_count').html(res.vehicle_daily_updates);
  $('#complaints_count').html(res.complaints);
  $('#vehicle_driver_logs_count').html(res.vehicle_driver_logs);
  $('#vehicle_geofence_count').html(res.vehicle_geofence);
}

function reassigndevice()
{
  if(confirm('Are you sure you want to reassign?')){
    var gps = document.getElementById('gps_id').value;
    if(gps) {
      var data = {
          gps_id : gps
      };
      $.ajax({
        type:'POST',
        url: '/devicereassign-gps-validation',
        data:data ,
        async: true,
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(res) {
          if(res.code ==  1)
          {
              var reassign_type_id = document.getElementById('return_to').value;
              var imei = document.getElementById('imei').value;
              var vehicle = document.getElementById('vehicle_id').value;
              var dealer = document.getElementById('dealer').value;
              var subdealer = document.getElementById('subdealer').value;
              var trader = document.getElementById('trader').value;
              var client = document.getElementById('client').value;
              var url = '/reassign-device';
              var data = {
                'reassign_type_id':reassign_type_id,
                'imei':imei,
                'gps':gps,
                'dealer':dealer,
                'subdealer':subdealer,
                'trader':trader,
                'client':client,
                'vehicle':vehicle
              };
              $('#loader').show();
              backgroundPostData(url,data,'deviceReassign',{alert:true});
              Reassignredirect();
          }
          else
          {
              alert(res.message);
              window.location.href = getUrl() + '/'+'devicereassign/create' ;
          }
        }
      });
    }
    
  }
  // location.reload();
}
function Reassignredirect()
{
  
  // window.location = "/devicereassign/create";
  $('#preview_table').hide();
  $('#preview').hide();
  $('#count_data').hide();
  $('#dropdown_menu').hide();
  // $('#loader').hide();
}
