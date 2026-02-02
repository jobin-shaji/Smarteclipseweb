
$(document).ready(function () {
    callBackDataTable();
});
function checkDate(value){  
 
        callBackDataTable();
}
function callBackDataTable(){
      var  data = {
         from_date : document.getElementById('fromDate').value,
        to_date : document.getElementById('toDate').value
    }; 
    console.log(data);
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'stock-report-list',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false},
            {data: 'imei', name: 'imei'},                   
            {data: 'serial_no', name: 'serial_no'},
            {data: 'provider1', name: 'provider1'},
            {data: 'e_sim_number', name: 'e_sim_number', orderable: false, searchable: false},
            {data: 'provider2', name: 'provider2'},
            {data: 'e_sim_number1', name: 'e_sim_number1', orderable: false, searchable: false},
            {data: 'icc_id', name: 'icc_id',  orderable: true},
            {data: 'icc_id1', name: 'icc_id1',  orderable: true},
            {data: 'validity', name: 'validity',  orderable: true},
            {data: 'imsi', name: 'imsi',  orderable: true},
            {data: 'manufacturing_date', name: 'manufacturing_date', orderable: false, searchable: false},
            {data: 'gps_stock.user.username', name: 'gps_stock.user.username', orderable: false, searchable: false},
             // {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
}



function refresh(){
    if(document.getElementById('fromDate').value == '' || document.getElementById('toDate').value == ''){
        callBackDataTable();
    }
    else{                      
    var from_date = document.getElementById('fromDate').value;
    var to_date = document.getElementById('toDate').value;
    var data = { 'agent':agent,'depot':depot, 'from_date':from_date , 'to_date':to_date};
    callBackDataTable(data);
    }   
}



