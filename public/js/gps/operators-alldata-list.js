$(document).ready(function () {
// var value=0;
    callBackDataTable();
});
document.getElementById("geofence").style.visibility = "hidden";
    var checkboxes = document.getElementsByName('checkbox1');
    var checkOff = document.getElementsByName('check_off');
    var checkall = document.getElementsByName('checkall');    
    var gf = document.getElementsByName('check_GF');
    var check_EO = document.getElementsByName('check_EO');
    
function checkAll(e) {
   var checkboxes = document.getElementsByName('checkbox1');
   if (e.checked) {
        for (var i = 0; i < checkboxes.length; i++) { 
           checkboxes[i].checked = true;
           document.getElementById("geofence").style.visibility = "hidden";

        }
    } 
    else {
        for (var i = 0; i < checkboxes.length; i++) {
           checkboxes[i].checked = false;
        }
   }
 }
 function checkEO(e) {
    
    if (e.checked) {
       document.getElementById("geofence").style.visibility = "hidden";

        for (var i = 0; i < checkboxes.length; i++) {  
           checkOff[0].checked = true;
           gf[0].disabled = true;
           checkall[0].checked = false;
            checkall[0].disabled = true;
           checkboxes[i].disabled = true;
           checkboxes[i].checked = false;
           
        }
    } 
    else {
        for (var i = 0; i < checkboxes.length; i++) {
            gf[0].disabled = false;
           checkboxes[i].disabled = false; 
           checkOff[0].checked = false;          
        }
   }
 }
 function checkGF(e) {
  
  var x = document.getElementById("geofence");
  if(e.checked==true)
    {
        for (var i = 0; i < checkboxes.length; i++) 
        {  
           check_EO[0].disabled = true;
           checkOff[0].disabled = true;
           checkall[0].disabled = true;
           checkall[0].checked = false;
           checkboxes[i].disabled = true;
           checkboxes[i].checked = false;
           // checkboxes[i].checked = false;
        }
        x.style.visibility = "visible"; // or x.style.display = "none";
    }
    else
    {
        for (var i = 0; i < checkboxes.length; i++) 
        {   
            check_EO[0].disabled = false;
           checkOff[0].disabled = false;
           checkall[0].disabled = false;
           checkall[0].checked = false;
           checkboxes[i].disabled = false;
           checkboxes[i].checked = false;
        }
        x.style.visibility = "hidden"; //or x.style.display = "block";
    }
}
function check(){
    // if(document.getElementById('header').value == ''){
    //     alert('please select header');
    // }   
    // else{        
        callBackDataTable();       
    // }
}
function callBackDataTable(value){
  if(value==null)
  {
    gps=document.getElementById('gps_id').value;
    
  }
  else{
    gps=value;
  }
    // console.log(gps);
    var  data = {
        gps : gps,        
        header : document.getElementById('header').value
    };
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'operators-alldata-list',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }

         },             
        // fnDrawCallback: function (oSettings, json) {

        // },

        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'imei', name: 'imei', orderable: false},
            {data: 'count', name: 'count',orderable: false, searchable: false},
            {data: 'device_time', name: 'device_time'},
            {data: 'forhuman', name: 'forhuman',orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'servertime', name: 'servertime',orderable: false, searchable: false},
            {data: 'vlt_data', name: 'vlt_data',orderable: false, searchable: false},
           {data: 'action', name: 'action',orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100,1000, -1], [25, 50, 100,1000, 'All']]
    });
}




