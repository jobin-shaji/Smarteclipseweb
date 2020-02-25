
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

$('.traderData').on('change', function() {
    var traderUserID=this.value;
    var purl = getUrl() + '/'+'gps-transfer-sub-dealer-trader-dropdown' ;
    var data = { trader_user_id : traderUserID };
    $.ajax({
        type:'POST',
        url: purl,
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            var trader_name=res.trader_name;
            var trader_address=res.trader_address;
            var trader_mobile=res.trader_mobile;
            $("#trader_name").val(trader_name);
            $("#address").val(trader_address);
            $("#mobile").val(trader_mobile); 
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

$('.clientDataInTrader').on('change', function() {
    var clientUserID=this.value;
    var purl = getUrl() + '/'+'gps-transfer-trader-end-user-dropdown' ;
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









