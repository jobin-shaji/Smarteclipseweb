$(document).ready(function () {
 
});
 
function plan(id){
 // $("#myModal").reset();
  $('#myModal').modal('show');
  $('#plan_id').val(id);
    // alert(id);

    var url = 'get-gps-data-hlm';
    var data = {
       id:id
    };   
    backgroundPostData(url,data,'gpsDataHlm',{alert:false});           
  }
// 

//   function gpsDataHlm(res)
// {
// console.log(res.gpsData.header);
//     $("#allHLMDataTable tr").remove();
//     var gps=' <tr><td>Header</td><td>'+res.gpsData.header+'</td></tr>'+
//             '<tr><td>Imei</td><td >'+res.gpsData.imei+'</td></tr>'+
//             '<tr><td>Vendor Id</td><td>'+res.gpsData.vendor_id+'</td></tr>'+
//             '<tr><td>Firmware Version</td><td>'+res.gpsData.firmware_version+'</td></tr>'+
//             '<tr><td>Device Date</td><td>'+res.gpsData.device_time+'</td></tr>'+
//             '<tr><td>Update ignition rate on</td><td>'+res.gpsData.update_rate_ignition_on+'</td></tr>'+
//             '<tr><td> Update ignition rate off</td><td>'+res.gpsData.update_rate_ignition_off+'</td></tr>'+
//             '<tr><td>Battery percentage</td><td>'+res.gpsData.battery_percentage+'</td></tr>'+
//             '<tr><td> Low battery Threshold value</td><td>'+res.gpsData.low_battery_threshold_value+'</td></tr>'+
//             '<tr><td>Memory Percentage </td><td>'+res.gpsData.memory_percentage+'</td></tr>'+
//             '<tr><td>Digital IO Status Mode</td><td>'+res.gpsData.digital_io_status+'</td></tr>'+
//             '<tr><td>Analog IO Status Mode</td><td>'+res.gpsData.analog_io_status+'</td></tr>'+
//             '<tr><td>Date</td><td>'+res.gpsData.date+'</td></tr>'+
//             '<tr><td>Time</td><td>'+res.gpsData.time+'</td></tr>';  
//         $("#allHLMDataTable").append(gps);
//     // console.log(res);
//     $('#gpsHLMDataModal').modal('show');
// }
