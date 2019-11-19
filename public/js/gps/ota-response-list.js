$(document).ready(function () {
    callBackDataTable();
});

function check(){          
        callBackDataTable();       
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
            url: 'alldata-list',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }

         },             
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'imei', name: 'imei', orderable: false},
            {data: 'count', name: 'count',orderable: false, searchable: false},
            {data: 'device_time', name: 'device_time'},
            {data: 'forhuman', name: 'forhuman',orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'servertime', name: 'servertime',orderable: false, searchable: false},
            {data: 'vlt_data', name: 'vlt_data',orderable: false, searchable: false},
           {data: 'action', name: 'action',orderable: false, searchable: false
          },
        ],
        
        aLengthMenu: [[25, 50, 100,1000, -1], [25, 50, 100,1000, 'All']]
    });
}




