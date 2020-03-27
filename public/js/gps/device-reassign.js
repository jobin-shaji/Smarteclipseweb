  $(document).ready(function() 
      {
        $("#revert_device").hide();
      });


 function searchData(){
    
     if(imei == ''){
        alert('please enter imei');
    }
    else{    

      var imei = document.getElementById('imei').value;
      var url= '/device-reassign-list';
      var data = {
          'imei':imei
      };
      // backgroundPostData(url,data,'deviceReassign',{alert:true});
      callBackDataTable(data);
    }
  }

  function callBackDataTable(data=null){   
 $("#revert_device").show();
  // console.log(data); 
    var aTable = $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: '/device-reassign-list',
            type: 'POST',
             data:data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {
// document.getElementById('serial').value=json;
        },
// console.log(data);
          columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            // {data: 'return_code', name: 'return_code', orderable: false},
            {data: 'imei', name: 'imei' , orderable: false},
            {data: 'serial_no', name: 'serial_no' , orderable: false},
            {data: 'manufacturer', name: 'manufacturer', orderable: false},
            {data: 'distributor', name: 'distributor', orderable: false},
            {data: 'dealer', name: 'dealer', orderable: false},
            {data: 'sub_dealer', name: 'sub_dealer', orderable: false},
            {data: 'client', name: 'client', orderable: false},

           
        ],
        
        // aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    aTable.on('xhr', function() {
    var ajaxJson = aTable.ajax.json();
    var imei=ajaxJson.data[0]['imei'];
    var manufacturer_id=ajaxJson.data[0]['manufacturer_id'];
    var distributor_id=ajaxJson.data[0]['distributor_id'];
    var dealer_id=ajaxJson.data[0]['dealer_id'];
    var sub_dealer_id=ajaxJson.data[0]['sub_dealer_id'];
    var client_id=ajaxJson.data[0]['client_id'];
     var manufacturer=ajaxJson.data[0]['manufacturer'];
    var distributor=ajaxJson.data[0]['distributor'];
    var dealer=ajaxJson.data[0]['dealer'];
    var sub_dealer=ajaxJson.data[0]['sub_dealer'];
    var client=ajaxJson.data[0]['client'];
details(manufacturer_id,distributor_id,dealer_id,sub_dealer_id,client_id,manufacturer,distributor,dealer,sub_dealer,client);
});
}

function details(manufacturer_id,distributor_id,dealer_id,sub_dealer_id,client_id,manufacturer,distributor,dealer,sub_dealer,client)
{

  // var return_to;
  //  return_to = '<option value="">--Select Reason--</option>';
  // if(manufacturer_id ){
  //    return_to = '<option value="'+manufacturer_id+'">'+manufacturer+'</option>';
  // }
  // else if(manufacturer_id && distributor_id){
  //    return_to = '<option value="'+manufacturer_id+'">'+manufacturer+'</option>'+
  //               '<option value="'+distributor_id+'">distributor/'+distributor+'</option>';
  // }
  // else if(manufacturer_id && distributor_id && dealer_id){
  //    return_to =  '<option value="'+manufacturer_id+'">'+manufacturer+'</option>'+
  //               '<option value="'+distributor_id+'">distributor/'+distributor+'</option>'+
  //               '<option value="'+dealer_id+'">Dealer/'+dealer+'</option>';
  // }
  // else if(manufacturer_id && distributor_id && dealer_id && sub_dealer_id){
  //    return_to = '<option value="'+manufacturer_id+'">'+manufacturer+'</option>'+
  //               '<option value="'+distributor_id+'">distributor/'+distributor+'</option>'+
  //               '<option value="'+dealer_id+'">Dealer/'+dealer+'</option>'+
  //               '<option value="'+sub_dealer_id+'">SubDealer/'+sub_dealer+'</option>';
  // }
  
    var  return_to = '<option value="'+manufacturer_id+'">'+manufacturer+'</option>'+
        '<option value="'+distributor_id+'">distributor/'+distributor+'</option>'+
        '<option value="'+dealer_id+'">Dealer/'+dealer+'</option>'+
        '<option value="'+sub_dealer_id+'">SubDealer/'+sub_dealer+'</option>'+
        
          '<option value="'+client_id+'">Client/'+client+'</option>'
        
        ;

   $('#return_to').append(return_to)
}