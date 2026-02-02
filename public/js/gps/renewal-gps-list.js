$(document).ready(function () {
   callBackDataTable();
 });

function callBackDataTable()
{
    
    var  data = {'manufactured':1};
    $("#dataTable").DataTable({
        bStateSave: true,
        responsive: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        //order: [[1, 'desc']],
        ajax: {
            url: 'gps-renewal-list',
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
            if ( data['is_returned'] == 1 ) {
                $('td', row).css('background-color', 'rgb(243, 217, 185)');
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'gps.imei', name: 'gps.imei', orderable: false},
            {data: 'order_id', name: 'order_id', orderable: false},
            {data: 'total_amount', name: 'total_amount', orderable: false},
            {data: 'customer_name', name: 'customer_name', orderable: false},
            {data: 'dealer_name', name: 'dealer_name', orderable: false},
            {data: 'gps.validity', name: 'gps.validity', orderable: false},
            {data: 'gps.pay_date', name: 'gps.pay_date', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[10, 50, 50, -1], [10, 50, 50, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
}



