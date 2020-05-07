$('.dealerData').on('change', function() {
    var dealerUserID = this.value;
    var purl = getUrl() + '/' + 'gps-transfer-root-dropdown';
    var data = {
        dealer_user_id: dealerUserID
    };
    $.ajax({
        type: 'POST',
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            var dealer_name = res.dealer_name;
            var dealer_address = res.dealer_address;
            var dealer_mobile = res.dealer_mobile;
            $("#dealer_name").val(dealer_name);
            $("#address").val(dealer_address);
            $("#mobile").val(dealer_mobile);
        }
    });
});

$(document).ready(function() {
    user_id = $('#logged_distributor_id').val();
    $('.selectedCheckBox').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
    });
    //for checking logged in is a distributor or dealer
    if (user_id) {
        
        var previously_selected_dealer_id = localStorage.getItem($('#logged_distributor_id').val() + '.autofill.transfer.dealer');
        if (previously_selected_dealer_id != null) {
            $("#dealer").select2().val(previously_selected_dealer_id).trigger("change");
        }
        var previously_selected_address_stored = localStorage.getItem($('#logged_distributor_id').val() + '.autofill.transfer.address');
        if (previously_selected_address_stored) {
            $("#address").val(previously_selected_address_stored).trigger("change");
        }
        var previously_selected_mobile_stored = localStorage.getItem($('#logged_distributor_id').val() + '.autofill.transfer.mobile');
        if (previously_selected_mobile_stored) {
            $("#mobile").val(previously_selected_mobile_stored).trigger("change");
        }

    } else {

        var previously_selected_dealer_id = localStorage.getItem($('#logged_subdealer_id').val() + '.autofill.transfer.dealer');
        if (previously_selected_dealer_id != null) {
            $("#dealer").select2().val(previously_selected_dealer_id).trigger("change");
        }
        var previously_selected_address_stored = localStorage.getItem($('#logged_subdealer_id').val() + '.autofill.transfer.address');
        if (previously_selected_address_stored) {
            $("#address").val(previously_selected_address_stored).trigger("change");
        }
        var previously_selected_mobile_stored = localStorage.getItem($('#logged_subdealer_id').val() + '.autofill.transfer.mobile');
        if (previously_selected_mobile_stored) {
            $("#mobile").val(previously_selected_mobile_stored).trigger("change");
        }
    }

    $('#empcode').keyup(function() {
     localStorage.setItem($('#logged_distributor_id').val() + '.autofill.enduser.empcode', $(this).val());
    });
    $("#empcode").val(localStorage.getItem($('#logged_distributor_id').val() + '.autofill.enduser.empcode')).trigger("change");
     //for employeecode in subdealer login to trader
     $('#subdealer_empcode').keyup(function() {
     localStorage.setItem($('#logged_subdealer_id').val()+'.autofill.enduser.subdealer_empcode',$(this).val());
    });
    $("#subdealer_empcode").val(localStorage.getItem($('#logged_subdealer_id').val()+'.autofill.enduser.subdealer_empcode')).trigger("change");
     //for employeecode in subdealer login to end user
    $('#scan_code').keyup(function() {
     localStorage.setItem($('#logged_subdealer_transfer_user').val()+'.autofill.enduser.subdealer_enduser_empcode',$(this).val());
    });
    $("#scan_code").val(localStorage.getItem($('#logged_subdealer_transfer_user').val()+'.autofill.enduser.subdealer_enduser_empcode')).trigger("change");
     //for employeecode in trader login to end user
     $('#trader_empcode').keyup(function() {
     localStorage.setItem($('#logged_trader_id').val()+'.autofill.enduser.trader_empcode',$(this).val());
    });
    $("#trader_empcode").val(localStorage.getItem($('#logged_trader_id').val()+'.autofill.enduser.trader_empcode')).trigger("change");
    });

   
     


$('.subDealerData').on('change', function() {
     // if dropdown is not selected clear local storage  value
    var selected_text = $("#dealer").val();
    if (selected_text == "Select Dealer") {
        $("#address").val('').trigger("change");
        localStorage.removeItem(user_id + '.autofill.transfer.address');
        var defaultSelectedSetItem = localStorage.setItem(user_id + '.autofill.transfer.address', '')
        $("#mobile").val('').trigger("change");
        localStorage.removeItem(user_id + '.autofill.transfer.mobile');
        var defaultSelectedSetItem = localStorage.setItem(user_id + '.autofill.transfer.mobile', '')
    }

    var subDealerUserID = this.value;
    localStorage.setItem($('#logged_distributor_id').val() + '.autofill.transfer.dealer', $(this).val());
    var purl = getUrl() + '/' + 'gps-transfer-dealer-dropdown';
    var data = {
        sub_dealer_user_id: subDealerUserID
    };
    $.ajax({
        type: 'POST',
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            var sub_dealer_name = res.sub_dealer_name;
            var sub_dealer_address = res.sub_dealer_address;
            var sub_dealer_mobile = res.sub_dealer_mobile;
            $("#sub_dealer_name").val(sub_dealer_name);
            $("#address").val(sub_dealer_address);
            $("#mobile").val(sub_dealer_mobile);
            var previously_selected_address_value = localStorage.setItem($('#logged_distributor_id').val() + '.autofill.transfer.address', sub_dealer_address);
            var previously_selected_mobile_value = localStorage.setItem($('#logged_distributor_id').val() + '.autofill.transfer.mobile', sub_dealer_mobile);

        }
    });
});

$('.traderData').on('change', function() {
    // if dropdown is not selected clear local storage  value
       var selected_text = $("#dealer").val();
       if (selected_text == "Select Sub Dealer") {
        $("#address").val('').trigger("change");
        localStorage.removeItem($('#logged_subdealer_id').val() + '.autofill.transfer.address');
        var defaultSelectedSetItem = localStorage.setItem($('#logged_subdealer_id').val() + '.autofill.transfer.address', '')
        $("#mobile").val('').trigger("change");
        localStorage.removeItem($('#logged_subdealer_id').val() + '.autofill.transfer.mobile');
        var defaultSelectedSetItem = localStorage.setItem($('#logged_subdealer_id').val() + '.autofill.transfer.mobile', '')
    }
    var traderUserID = this.value;
    localStorage.setItem($('#logged_subdealer_id').val() + '.autofill.transfer.dealer', $(this).val());
    var purl = getUrl() + '/' + 'gps-transfer-sub-dealer-trader-dropdown';
    var data = {
        trader_user_id: traderUserID
    };
    $.ajax({
        type: 'POST',
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            var trader_name = res.trader_name;
            var trader_address = res.trader_address;
            var trader_mobile = res.trader_mobile;
            $("#trader_name").val(trader_name);
            $("#address").val(trader_address);
            $("#mobile").val(trader_mobile);
            var previously_selected_address_value = localStorage.setItem($('#logged_subdealer_id').val() + '.autofill.transfer.address', trader_address);
            var previously_selected_mobile_value = localStorage.setItem($('#logged_subdealer_id').val() + '.autofill.transfer.mobile', trader_mobile);
        }
    });
});

$('.clientData').on('change', function() {
    var clientUserID = this.value;
    var purl = getUrl() + '/' + 'gps-transfer-sub-dealer-dropdown';
    var data = {
        client_user_id: clientUserID
    };
    $.ajax({
        type: 'POST',
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            var client_name = res.client_name;
            var client_address = res.client_address;
            var client_mobile = res.client_mobile;
            $("#client_name").val(client_name);
            $("#address").val(client_address);
            $("#mobile").val(client_mobile);
        }
    });
});

$('.clientDataInTrader').on('change', function() {
    var clientUserID = this.value;
    var purl = getUrl() + '/' + 'gps-transfer-trader-end-user-dropdown';
    var data = {
        client_user_id: clientUserID
    };
    $.ajax({
        type: 'POST',
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            var client_name = res.client_name;
            var client_address = res.client_address;
            var client_mobile = res.client_mobile;
            $("#client_name").val(client_name);
            $("#address").val(client_address);
            $("#mobile").val(client_mobile);
        }
    });
});