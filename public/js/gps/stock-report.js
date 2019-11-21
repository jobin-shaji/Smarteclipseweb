
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
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: true, searchable: false},
            {data: 'gps.imei', name: 'gps.imei', orderable: false},                   
            {data: 'gps.serial_no', name: 'gps.serial_no', searchable: false},
            {data: 'gps.e_sim_number', name: 'gps.e_sim_number', orderable: false},
            {data: 'gps.manufacturing_date', name: 'gps.manufacturing_date', orderable: false},
             {data: 'created_at', name: 'created_at', orderable: false, searchable: false}
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
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



