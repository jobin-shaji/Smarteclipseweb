window.onload = function()
{
    document.getElementById('transfer_type').value = "";
    document.getElementById('from_id').value = "";
    document.getElementById('to_id').value = "";
}
function getDeviceTransferList()
{
    if(document.getElementById('transfer_type').value == ''){
        alert('Please select transfer type');
    }else if(document.getElementById('from_id').value == ''){
        alert('Please select From user');
    }
    else if(document.getElementById('to_id').value == ''){
        alert('Please select To user');
    }else{
        var transfer_type = document.getElementById('transfer_type').value;
        var from_id = document.getElementById('from_id').value;
        var to_id = document.getElementById('to_id').value;
        var data = {'transfer_type':transfer_type , 'from_id':from_id , 'to_id':to_id};
        callBackDataTable(data);
        countSection(data);
    }
       
}

function countSection(data)
{
    $('#stock_section').hide();
    $('#transferred_section').hide();
    var url = 'gps-transferred-count-root';
    var purl = getUrl() + '/' + url;
    $.ajax({
        type: 'POST',
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            if(res.instock_gps_count != undefined)
            {
                $('#stock_section').show();
                $('#stock_count').html(res.instock_gps_count);
                $('#stock_message').html(res.stock_string);
            }
            $('#transferred_section').show();
            $('#transferred_count').html(res.transferred_gps_count);
            $('#transferred_message').html(res.transferred_string);
        },
    });
}


function callBackDataTable(data){
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'gps-transfer-list-root',
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
                $('td', row).css('background-color', 'rgb(178, 178, 178)');
            }
            else if ( data['accepted_on'] ) {
                $('td', row).css('background-color', 'rgb(210, 239, 203)');
            }

        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'from_user.username', name: 'from_user.username'},
            {data: 'to_user.username', name: 'to_user.username'},
            {data: 'dispatched_on', name: 'dispatched_on'},
            {data: 'count', name: 'count'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

function cancelRootGpsTransfer(gps_transfer_id){
    if(confirm('Are you sure to cancel this?')){
        var url = 'gps-transfer-root/cancel';
        var data = {
            id : gps_transfer_id
        };
        backgroundPostData(url,data,'getDeviceTransferList',{alert:true}); 
    } 
}

$('#transfer_type').on('change', function() {
    var transfer_type = $(this).val();
    if(transfer_type == 1)
    {
        $('#from_label').text("Manufacturer");
        $('#to_label').text("Distributor");
    }
    else if(transfer_type == 2)
    {
        $('#from_label').text("Distributor");
        $('#to_label').text("Dealer");
    }
    else if(transfer_type == 4)
    {
        $('#from_label').text("Dealer");
        $('#to_label').text("Sub Dealer");
    }
    else if(transfer_type == 5)
    {
        $('#from_label').text("Sub Dealer");
        $('#to_label').text("End User");
    }
    else
    {
        $('#from_label').text("Dealer");
        $('#to_label').text("End User");
    }
    
    var data={ transfer_type : transfer_type };
    if(transfer_type) {
      $.ajax({
        type:'POST',
        url: '/gps-transferred-root/get-from-list',
        data:data ,
        async: true,
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(data) {
        if(data){
          $('#from_id').empty();
          $('#from_id').focus;
          $('#from_id').append('<option value="" selected disabled>  Select From User </option>'); 
          if(transfer_type != 1)
          {
            $('#from_id').append('<option value="0">  All </option>'); 
          }
          $.each(data, function(key, value){
            $('select[name="from_id"]').append('<option value="'+ value.user_id +'">' + value.name+ '</option>');
          });
        }else{
          $('#from_id').empty();
        }
        }
      });
    }else{
      $('#from_id').empty();
    }
});

$('#from_id').on('change', function() {
    var from_id = $('#from_id').val();
    var transfer_type = $('#transfer_type').val();
    var data={ from_id : from_id,transfer_type : transfer_type };
    if(from_id) {
      $.ajax({
        type:'POST',
        url: '/gps-transferred-root/get-to-list',
        data:data ,
        async: true,
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(data) {
        if(data){
          $('#to_id').empty();
          $('#to_id').focus;
          $('#to_id').append('<option value="" selected disabled>  Select To User </option>'); 
          $('#to_id').append('<option value="0">  All </option>'); 
          $.each(data, function(key, value){
            $('select[name="to_id"]').append('<option value="'+ value.user_id +'">' + value.name+ '</option>');
          });
        }else{
          $('#to_id').empty();
        }
        }
      });
    }else{
      $('#to_id').empty();
    }
});