$(document).ready(function () {
   callBackDataTable();
 });

function callBackDataTable()
{
    var manufactured_device =   document.getElementById('manufactured_device');
    var refurbished_device  =   document.getElementById('refurbished_device');
    if(manufactured_device.checked == true && refurbished_device.checked == true)
    {
        manufactured_device =   Number(manufactured_device.checked); 
        refurbished_device  =   Number(refurbished_device.checked);
    }
    else if(manufactured_device.checked == true && refurbished_device.checked == false){
        manufactured_device =   Number(manufactured_device.checked); 
        refurbished_device  =   Number(refurbished_device.checked);
    }
    else if(manufactured_device.checked == false && refurbished_device.checked == true){
        manufactured_device =   Number(manufactured_device.checked); 
        refurbished_device  =   Number(refurbished_device.checked);
    }
    else if(manufactured_device.checked == false && refurbished_device.checked == false){
        alert('Please select at least one checkbox');
        location.reload();
    }
    var  data = {'manufactured_device':manufactured_device,'refurbished_device':refurbished_device}
    $("#dataTable").DataTable({
        bStateSave: true,
        responsive: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        //order: [[1, 'desc']],
        ajax: {
            url: 'gps-all-list',
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
            {data: 'imei', name: 'imei', orderable: false},
            {data: 'serial_no', name: 'serial_no', orderable: false},
            {data: 'icc_id', name: 'icc_id', orderable: false},
            {data: 'imsi', name: 'imsi', orderable: false},
            {data: 'e_sim_number', name: 'e_sim_number', orderable: false},
            {data: 'batch_number', name: 'batch_number', orderable: false},
            {data: 'employee_code', name: 'employee_code', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
}



