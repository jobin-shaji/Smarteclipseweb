$(document).ready(function () {
    callBackDataTable();
});
function check(){
   
    if(document.getElementById('gps_id').value == ''){
        alert('please Select Gps');
    }   
    else{      
        var gps_id=$('#gps_id').val();
         // alert(gps_id);
         var client=$('meta[name = "client"]').attr('content');
        var from_date = document.getElementById('fromDate').value;
        var to_date = document.getElementById('toDate').value;
        var data = {'gps_id':gps_id,'client':client, 'from_date':from_date , 'to_date':to_date};
        callBackDataTable(data);
        //      var  data = {
        //     client : $('meta[name = "client"]').attr('content'),
        //     from_date : document.getElementById('fromDate').value,
        //     to_date : document.getElementById('toDate').value,
        // };      
            // callBackDataTable(data);
    }
}
function callBackDataTable(data=null){
    // var  data = {
    
    // }; 

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: '/data-usage-list',
            type: 'POST',
            data:data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'gps.name', name: 'gps.name'},
            {data: 'gps.imei', name: 'gps.imei'},
            {data: 'gps.manufacturing_date', name: 'gps.manufacturing_date'},
             {data: 'date_time', name: 'date_time'},
            {data: 'data_size', name: 'data_size'}          
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}







