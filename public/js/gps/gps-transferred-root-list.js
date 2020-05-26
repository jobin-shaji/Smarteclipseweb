function getUrl(){
  return $('meta[name = "domain"]').attr('content');
}
window.onload = function()
{
    document.getElementById('transfer_type').value    =   "";
    document.getElementById('from_id').value          =   "";
    document.getElementById('to_id').value            =   "";
    document.getElementById('from_date').value        =   "";
    document.getElementById('to_date').value          =   "";
  $('#dataTable').DataTable().search( this.value ).draw();

}

$('#clear-filter').click(function() {
  // $('#dataTable').DataTable().search( this.value ).draw();
});
function getDeviceTransferList()
{
    if(document.getElementById('transfer_type').value == ''){
        alert('Please select transfer type');
    }else if(document.getElementById('from_id').value == ''){
        alert('Please select From user');
    }
    else if(document.getElementById('to_id').value == ''){
        alert('Please select To user');
    }
    else if(document.getElementById('from_date').value == ''){
      alert('Please select From date');
    }
    else if(document.getElementById('to_date').value == ''){
      alert('Please select To date');
    }else{
        var transfer_type   =   document.getElementById('transfer_type').value;
        var from_id         =   document.getElementById('from_id').value;
        var to_id           =   document.getElementById('to_id').value;
        var from_date       =   document.getElementById('from_date').value;
        var to_date         =   document.getElementById('to_date').value;
        var from_d          =   new Date(from_date.split("-").reverse().join("-"));
        var from_day        =   from_d.getDate();
        var from_month      =   from_d.getMonth()+1;
        var from_year       =   from_d.getFullYear();
        //var search_from_date=   from_year+""+from_month+""+from_day;
        var to_d            =   new Date(to_date.split("-").reverse().join("-"));
        var to_day          =   to_d.getDate();
        var to_month        =   to_d.getMonth()+1;
        var to_year         =   to_d.getFullYear();
        //var search_to_date  =   to_year+""+to_month+""+to_day;
        var search_from_date=   new Date(from_year, from_month, from_day); //Year, Month, Date    
        var search_to_date  =   new Date(to_year, to_month, to_day); //Year, Month, Date
        if(search_from_date > search_to_date)
        {
            document.getElementById('transfer_type').value  =   "";
            document.getElementById('from_id').value        =   "";
            document.getElementById('to_id').value          =   "";
            document.getElementById('from_date').value      =   "";
            document.getElementById('to_date').value        =   "";
            alert('From date should be less than To date');
            window.location.href = getUrl() + '/'+'gps-transferred-root' ;
        }
        else
        {
          var data = {'transfer_type':transfer_type , 'from_id':from_id , 'to_id':to_id, 'from_date':from_date, 'to_date':to_date};
          callBackDataTable(data);
          countSection(data);
        }
    }
       
}

function countSection(data)
{
    $('#stock_section').hide();
    $('#transferred_section').hide();
    $('#awaiting_confirmation_section').hide();
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
            if(res.awaiting_confirmation_gps_count != undefined)
            {
              $('#awaiting_confirmation_section').show();
              $('#awaiting_confirmation_count').html(res.awaiting_confirmation_gps_count);
              $('#awaiting_confirmation_message').html(res.awaiting_confirmation_string);
            }
            $('#transferred_section').show();
            $('#transferred_count').html(res.transferred_gps_count);
            $('#transferred_message').html(res.transferred_string);
        },
    });
}


function callBackDataTable(data){
  // $('#dataTable').DataTable().search( this.value ).draw();
     // $('#filter-input').val('');
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        // order: [[1, 'desc']],
        ajax: {
            url: 'gps-transfer-list-root',
            type: 'POST',
            data: {'data': data},
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
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'from_user.username', name: 'from_user.username', orderable: false},
            {data: 'to_user.username', name: 'to_user.username', orderable: false},
            {data: 'dispatched_on', name: 'dispatched_on', orderable: false},
            {data: 'count', name: 'count', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
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