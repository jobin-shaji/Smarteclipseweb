$(document).ready(function () {
    callBackDataTable();
});

function callBackDataTable(){
    var  data = {
    }; 

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        //order: [[1, 'desc']],
        ajax: {
            url: 'esim-activation-details-list',
            type: 'POST',
            data: {
                'data': data
            },
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
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'imei', name: 'imei' , orderable: false},
            {data: 'msisdn', name: 'msisdn' , orderable: false},
            {data: 'iccid', name: 'iccid', orderable: false},
            {data: 'imsi', name: 'imsi', orderable: false, searchable: false},
            {data: 'puk', name: 'puk', orderable: false},
            {data: 'product_type', name: 'product_type', orderable: false},
            {data: 'activated_on', name: 'activated_on', orderable: false},
            {data: 'expire_on', name: 'expire_on', orderable: false},     
            {data: 'business_unit_name', name: 'business_unit_name', orderable: false},     
            {data: 'product_status', name: 'product_status', orderable: false}     
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();

}






