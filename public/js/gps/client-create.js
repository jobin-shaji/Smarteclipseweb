var name;
$(document).ready(function() {
    var user_id = $('#user_id').val();
    //for username  and mobile value same

    $("#mobile_number").keyup(function() {
        $("#Username").val(this.value);
        name = $('#name').val();
        var password_generated = (name.length > 2) ? nameLessTwoChar() : withoutName();
        $('#password').val(password_generated);
        $('#confirm_password').val(password_generated);
    });

    // Function for ternary operator password_generated

    function nameLessTwoChar() {
        return name.substr(name.length - 2).toLowerCase() + getRandomSpecialCharacter() + $('#mobile_number').val().slice(-4) + getRandomSpecialCharacter() + getRandomString().toUpperCase() + getRandomSpecialCharacter() + Math.floor(Math.random() * 10);
    }

    // Functions for ternary operator password_generated 

    function withoutName() {
        return getRandomString().toLowerCase() + getRandomSpecialCharacter() + $('#mobile_number').val().slice(-4) + getRandomSpecialCharacter() + getRandomString().toUpperCase() + getRandomSpecialCharacter() + Math.floor(Math.random() * 10);
    }

    // Function to generate random special char

    function getRandomSpecialCharacter() {

        var allowed_characters = ["@", "#", "$", "%", "&"];
        return allowed_characters[Math.floor(Math.random() * allowed_characters.length)];
    }

    //Function to generate random string.
    
    function getRandomString() {

        return Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 2);
    }


    // intializing form elements
    var previously_selected_distributer_id = localStorage.getItem($('#user_id').val() + '.autofill.rootenduser.distributor');
    if (previously_selected_distributer_id != null) {
        $("#dealer").select2().val(previously_selected_distributer_id.toString()).trigger("change");
    }


    $("#message").hide();
    $("#user_message").hide();
    var countryID = $('#default_id').val();
    var data = {
        countryID: countryID
    };
    if (countryID) {
        $.ajax({
            type: 'POST',
            url: '/client-create/get-state-list',
            data: data,
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                if (data) {
                    $('#state_id').empty();
                    $('#state_id').focus;
                    $('#state_id').append('<option value="">  Select State </option>');
                    $.each(data, function(key, value) {
                        $('select[name="state_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                    $("#state_id").select2().val(localStorage.getItem(user_id + '.autofill.enduser.state').toString()).trigger("change");
                } else {
                    $('#state_id').empty();
                }
            }
        });
    } else {
        $('#state_id').empty();
    }
    //for store item in local storage

    $("#state_id").change(function() {
        localStorage.setItem(user_id + '.autofill.enduser.state', $(this).val());
    });
    $("#city_id").change(function() {
        localStorage.setItem(user_id + '.autofill.enduser.city', $(this).val());
    });
    $("#client_category").change(function() {
        localStorage.setItem(user_id + '.autofill.enduser.client_category', $(this).val());
    });
    $("#client_category").val(localStorage.getItem(user_id + '.autofill.enduser.client_category')).trigger("change");
});

$(document).ready(function() {
    $("#message").hide();
    $("#user_message").hide();
    var user_id = $('#user_id').val();
    $('#state_id').on('change', function() {
        var stateID = $(this).val();
        var data = {
            stateID: stateID
        };
        if (stateID) {
            $.ajax({
                type: 'POST',
                url: '/client-create/get-city-list',
                data: data,
                async: true,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data) {
                        $('#city_id').empty();
                        $('#city_id').focus;
                        $('#city_id').append('<option value="">  Select City </option>');
                        $.each(data, function(key, value) {
                            $('select[name="city_id"]').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        $("#city_id").select2().val(localStorage.getItem(user_id + '.autofill.enduser.city').toString()).trigger("change");
                    } else {
                        $('#city_id').empty();
                    }
                }
            });
        } else {
            $('#city_id').empty();
        }
    });
});


$('#name').keypress(function(e) {
    $("#message").hide();
    $("#user_message").hide();
    var keyCode = e.which;
    if (keyCode >= 48 && keyCode <= 57) {
        $("#message").show();
        e.preventDefault();
    }
});
// CODE FOR USERNAME SPACE NOT ALLOWED
$('#trader_username').keypress(function(e) {
    $("#user_message").hide();

    if (e.which === 32) {
        $("#user_message").show();
        e.preventDefault();
    }

});
// for selecting dealer from distributor
function selectDealer(dealer) {
    localStorage.setItem($('#user_id').val() + '.autofill.rootenduser.distributor', dealer);
    var url = 'select/subdealer';
    var data = {
        dealer: dealer
    };
    backgroundPostData(url, data, 'rootSubdealer', {
        alert: true
    });
}

function rootSubdealer(res) {

    $("#sub_dealer").empty();
    var length = res.sub_dealers.length
    sub_dealer_text = '<option value="">Choose Dealer from the list</option>';
    for (var i = 0; i < length; i++) {
        sub_dealer += '<option value="' + res.sub_dealers[i].id + '"  >' + res.sub_dealers[i].name + '</option>';
    }
    $("#sub_dealer").append(sub_dealer_text + sub_dealer);

    var previously_selected_dealerid = localStorage.getItem($('#user_id').val() + '.autofill.rootenduser.dealer');
    if (previously_selected_dealerid != null) {
        $("#sub_dealer").select2().val(previously_selected_dealerid.toString()).trigger("change");
    }

}


//  for selecting subdealer fro dealer

function selectTrader(dealer_id) {
    localStorage.setItem($('#user_id').val() + '.autofill.rootenduser.dealer', dealer_id);
    var url = 'select/trader';
    var data = {
        dealer_id: dealer_id
    };
    backgroundPostData(url, data, 'rootTrader', {
        alert: true
    });
}

function rootTrader(res) {
    $("#trader").empty();
    var length = res.traders.length
    trader_text = '<option value="">Choose Sub Dealer from the list</option>';
    if (length == 0) {
        trader = '<option value="">No Sub Dealer</option>';
        $("#trader").append(trader);
    } else {
        for (var i = 0; i < length; i++) {
            trader += '  <option value="' + res.traders[i].id + '"  >' + res.traders[i].name + '</option>';
        }
        $("#trader").append(trader_text + trader);
        var previously_selected_trader_id = localStorage.getItem($('#user_id').val() + '.autofill.rootenduser.trader');
        if (previously_selected_trader_id != null) {
            $("#trader").select2().val(previously_selected_trader_id).trigger("change");
        }
    }
}

function traderChanged(trader_id) {
    localStorage.setItem($('#user_id').val() + '.autofill.rootenduser.trader', trader_id);
}