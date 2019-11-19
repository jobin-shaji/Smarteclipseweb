// $(document).ready(function () {
//     callBackDataTable();
// });

// function check(){          
//         callBackDataTable();       
// }
function callBackDataTable(value){
  // if(value==null)
  // {
  //   gps=document.getElementById('gps_id').value;
    
  // }
  // else{
    gps=value;
  // }
    // console.log(gps);
    var  data = {
        gps : gps
    };
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'ota-response-list',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }

         },             
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'response', name: 'response', orderable: false},
            
        ],
        
        aLengthMenu: [[25, 50, 100,1000, -1], [25, 50, 100,1000, 'All']]
    });
}




