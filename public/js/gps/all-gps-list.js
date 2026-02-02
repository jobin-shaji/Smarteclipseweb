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
            {data: 'icc_id1', name: 'icc_id1', orderable: false},
            {data: 'imsi', name: 'imsi', orderable: false},
            {data: 'provider1', name: 'provider1', orderable: false},
            {data: 'e_sim_number', name: 'e_sim_number', orderable: false},
            {data: 'provider2', name: 'provider2', orderable: false},
            {data: 'e_sim_number1', name: 'e_sim_number1', orderable: false},
            {data: 'validity', name: 'validity', orderable: false},
            {data: 'pay_date', name: 'pay_date', orderable: false},
            {data: 'vehicle_number', name: 'vehicle_no', orderable: false},
            {data: 'mob_app', name: 'mob_app', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[10, 50, 50, -1], [10, 50, 50, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
}



