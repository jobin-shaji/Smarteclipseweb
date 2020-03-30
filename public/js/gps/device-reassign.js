$(document).ready(function () {
  $('#count_data').hide();
});

function searchData()
{   
  if(document.getElementById('return_to').value == '')
  {
    alert('please select any user to reassign');
  }
  else
  {
    var reassign_type_id = document.getElementById('return_to').value;
    var imei = document.getElementById('imei').value;

    // alert(imei);
    var gps = document.getElementById('gps_id').value;
    var url = '/get-gps-count';
    var data = {
      'reassign_type_id':reassign_type_id,
      'imei':imei,
      'gps':gps

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
}

function reassigndevice()
{
  if(confirm('Are you sure you wnt to reassign?')){
    var reassign_type_id = document.getElementById('return_to').value;
    var imei = document.getElementById('imei').value;
    var gps = document.getElementById('gps_id').value;
    var url = '/reassign-device';
    var data = {
      'reassign_type_id':reassign_type_id,
      'imei':imei,
      'gps':gps

    };
    backgroundPostData(url,data,'deviceReasssign',{alert:true}); 
} }