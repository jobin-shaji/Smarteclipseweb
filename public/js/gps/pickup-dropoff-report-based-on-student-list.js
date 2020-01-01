$(document).ready(function () {
    callBackDataTable();
});
function check(){
    var from_date = document.getElementById('fromDate').value;
    var to_date = document.getElementById('toDate').value;
    var data = {'from_date':from_date , 'to_date':to_date};
    callBackDataTable(data);       
}
function callBackDataTable(data=null){   
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
            {data: '', name: '',searchable: false},           
            {data: '', name: '',orderable: false},
            {data: '', name: '',searchable: false,orderable: false},
            {data: '', name: '',searchable: false,orderable: false},
            {data: '', name: '',searchable: false,orderable: false},          
            
        ],        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}
