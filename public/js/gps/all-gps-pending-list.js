$(document).ready(function () {
   callBackDataTable();
 });

function callBackDataTable()
{   var clients="";
    var client =  $("#client").val();;
    if(client!="")
        {
            clients =   client;
        }
    var  data = {'client':clients}
    $("#dataTable").DataTable({
        bStateSave: true,
        responsive: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        //order: [[1, 'desc']],
        ajax: {
            url: 'esim-pending-list',
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
            {data: 'vehicle_no', name: 'vehicle_no', orderable: false},
            {data: 'imei', name: 'imei', orderable: false},
            {data: 'serial_no', name: 'serial_no', orderable: false},
            {data: 'icc_id', name: 'icc_id', orderable: false},
            {data: 'icc_id1', name: 'icc_id1', orderable: false},
            {data: 'provider1', name: 'provider1', orderable: false},
            {data: 'e_sim_number', name: 'e_sim_number', orderable: false},
            {data: 'installation_date_new', name: 'installation_date_new', orderable: false},
            {data: 'validity_date', name: 'validity_date', orderable: false},
          
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[10, 50, 50, -1], [10, 50, 50, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
}

// Handle assign button click
$(document).on('click', '.assign-btn', function(e) {
    e.preventDefault();
    console.log('Assign button was clicked!');
    var gpsId = $(this).data('gps-id');
    console.log('GPS ID from button:', gpsId);
    $('#assign_gps_id').val(gpsId);
    $('#callcenter_id').val('');
    console.log('Opening modal...');
    $('#assignModal').modal('show');
    console.log('Modal opened');
});

// Handle confirm assign
$(document).on('click', '#confirmAssign', function() {
    var gpsId = $('#assign_gps_id').val();
    var callcenterId = $('#callcenter_id').val();
    
    console.log('=== ASSIGN DEVICE START ===');
    console.log('GPS ID:', gpsId);
    console.log('Call Center ID:', callcenterId);
    
    if(!callcenterId) {
        console.warn('No call center selected');
        toastr.warning('Please select a call center executive');
        return;
    }
    
    var requestData = {
        gps_id: gpsId,
        callcenter_id: callcenterId,
        _token: $('meta[name="csrf-token"]').attr('content')
    };
    
    console.log('Request data:', requestData);
    
    $.ajax({
        url: '/assign-single-device',
        type: 'POST',
        data: requestData,
        success: function(response) {
            console.log('=== ASSIGN SUCCESS ===');
            console.log('Response:', response);
            $('#assignModal').modal('hide');
            toastr.success(response.message);
            $('#dataTable').DataTable().ajax.reload();
        },
        error: function(xhr) {
            console.error('=== ASSIGN ERROR ===');
            console.error('Status:', xhr.status);
            console.error('Status Text:', xhr.statusText);
            console.error('Response Text:', xhr.responseText);
            console.error('Response JSON:', xhr.responseJSON);
            
            var errorMsg = 'Error assigning device. Please try again.';
            if(xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            
            console.error('Error message:', errorMsg);
            toastr.error(errorMsg);
        }
    });
});



