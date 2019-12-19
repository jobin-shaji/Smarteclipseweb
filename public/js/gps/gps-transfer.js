
function check()
{
    if(document.getElementById('transfer_type').value == ''){
        alert('please select transfer type');
    }else if(document.getElementById('from_id').value == ''){
        alert('please select from user');
    }
    else if(document.getElementById('to_id').value == ''){
        alert('please select to user');
    }else{
        var transfer_type = document.getElementById('transfer_type').value;
        var from_id = document.getElementById('from_id').value;
        var to_id = document.getElementById('to_id').value;
        var data = {'transfer_type':transfer_type , 'from_id':from_id , 'to_id':to_id};
        callBackDataTable(data);
    }
       
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
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
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
        backgroundPostData(url,data,'callBackDataTables',{alert:true}); 
    } 
}

$('.dealerData').on('change', function() {
    var dealerUserID=this.value;
    var purl = getUrl() + '/'+'gps-transfer-root-dropdown' ;
    var data = { dealer_user_id : dealerUserID };
    $.ajax({
        type:'POST',
        url: purl,
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            var dealer_name=res.dealer_name;
            var dealer_address=res.dealer_address;
            var dealer_mobile=res.dealer_mobile;
            $("#dealer_name").val(dealer_name);
            $("#address").val(dealer_address);
            $("#mobile").val(dealer_mobile); 
        }
    });
  });

$(document).ready(function() {
    $('.selectedCheckBox').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
});

$('.subDealerData').on('change', function() {
    var subDealerUserID=this.value;
    var purl = getUrl() + '/'+'gps-transfer-dealer-dropdown' ;
    var data = { sub_dealer_user_id : subDealerUserID };
    $.ajax({
        type:'POST',
        url: purl,
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            var sub_dealer_name=res.sub_dealer_name;
            var sub_dealer_address=res.sub_dealer_address;
            var sub_dealer_mobile=res.sub_dealer_mobile;
            $("#sub_dealer_name").val(sub_dealer_name);
            $("#address").val(sub_dealer_address);
            $("#mobile").val(sub_dealer_mobile); 
        }
    });
});

$('.clientData').on('change', function() {
    var clientUserID=this.value;
    var purl = getUrl() + '/'+'gps-transfer-sub-dealer-dropdown' ;
    var data = { client_user_id : clientUserID };
    $.ajax({
        type:'POST',
        url: purl,
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            var client_name=res.client_name;
            var client_address=res.client_address;
            var client_mobile=res.client_mobile;
            $("#client_name").val(client_name);
            $("#address").val(client_address);
            $("#mobile").val(client_mobile); 
        }
    });
});

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
    else
    {
        $('#from_label').text("Dealer");
        $('#to_label').text("Client");
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
          $('#from_id').append('<option value="">  Select User </option>'); 
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
          $('#to_id').append('<option value="">  Select User </option>'); 
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







