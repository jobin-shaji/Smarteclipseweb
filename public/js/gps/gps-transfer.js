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
        order: [[1, 'desc']],
        ajax: {
            url: 'gps-transfer-list',
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

function cancelGpsTransfer(gps_transfer_id){
    if(confirm('Are you sure want to cancel this?')){
        var url = 'gps-transfer/cancel';
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







