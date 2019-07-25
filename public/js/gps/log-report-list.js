$(document).ready(function () {
    callBackDataTable();
    
});


function check(){
        //  var client=$('meta[name = "dealer"]').attr('content');
        var from_date = document.getElementById('fromDate').value;
        var to_date = document.getElementById('toDate').value;
        var data = {'from_date':from_date , 'to_date':to_date};
        callBackDataTable(data);
       
    }


function callBackDataTable(data=null){
    
    // var  data = {
    //      // dealer : $('meta[name = "dealer"]').attr('content'),
    //        // sub_dealer:$('meta[name = "client"]').attr('content')
    //       from_date : document.getElementById('fromDate').value,
    //      to_date : document.getElementById('toDate').value    
    // }; 
    // console.log(data);
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'log-report-list',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        createdRow: function ( row, data, index ) {
            if ( data['deleted_at'] ) {
                $('td', row).css('background-color', 'rgb(243, 204, 204)');
            }
        },       
        fnDrawCallback: function (oSettings, json) {
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},         
            {data: 'gps.imei', name: 'gps.imei',searchable: false},           
            {data: 'status', name: 'status'},
            {data: 'user.username', name: 'user.username',searchable: false},
            {data: 'created_at', name: 'created_at',searchable: false},         
            
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}
