
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
            url: 'gps-report-list',
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
            {data: 'imei', name: 'imei',  orderable: true, searchable: false},                   
            {data: 'serial_no', name: 'serial_no',  orderable: true, searchable: false},
            {data: 'e_sim_number', name: 'e_sim_number',  orderable: true, searchable: false},
            {data: 'icc_id', name: 'icc_id',  orderable: true, searchable: false},
            {data: 'imsi', name: 'imsi',  orderable: true, searchable: false},
            {data: 'manufacturing_date', name: 'manufacturing_date', orderable: true, searchable: false},
            
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



