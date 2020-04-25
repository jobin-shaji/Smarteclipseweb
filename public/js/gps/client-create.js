$(document).ready(function() {
var user_id= $('#user_id').val();

  // intializing form elements
  $("#message").hide();
  $("#user_message").hide();
  
    var countryID = $('#default_id').val();
    var data={ countryID : countryID };
    if(countryID) {
      $.ajax({
        type:'POST',
        url: '/client-create/get-state-list',
        data:data ,
        async: true,
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(data) {
      
        if(data){
          $('#state_id').empty();
          $('#state_id').focus;
          $('#state_id').append('<option value="">  Select State </option>'); 
          $.each(data, function(key, value){
            $('select[name="state_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
          });

          $("#state_id").select2().val(localStorage.getItem(user_id+'.autofill.enduser.state').toString()).trigger("change");
        }else{
          $('#state_id').empty();
        }
        }
      });
    }else{
      $('#state_id').empty();
    }
    //for store item in local storage

   $("#state_id").change(function(){
   localStorage.setItem(user_id+'.autofill.enduser.state',$(this).val());
   });
   $("#city_id").change(function(){
    localStorage.setItem(user_id+'.autofill.enduser.city',$(this).val());
  });
   $("#client_category").change(function(){
    localStorage.setItem(user_id+'.autofill.enduser.client_category',$(this).val());
  });
 $("#client_category").val(localStorage.getItem(user_id+'.autofill.enduser.client_category')).trigger("change");
});







$(document).ready(function() {
  var user_id= $('#user_id').val();
  $("#message").hide();
  $("#user_message").hide();
  $('#state_id').on('change', function() {
    var stateID = $(this).val();
    var data={ stateID : stateID };
    if(stateID) {
      $.ajax({
        type:'POST',
        url: '/client-create/get-city-list',
        data:data ,
        async: true,
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(data) {
       
        if(data){
          $('#city_id').empty();
          $('#city_id').focus;
          $('#city_id').append('<option value="">  Select City </option>'); 
          $.each(data, function(key, value){
            $('select[name="city_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
          });
           $("#city_id").select2().val(localStorage.getItem(user_id+'.autofill.enduser.city').toString()).trigger("change");
        }else{
          $('#city_id').empty();
        }
        }
      });
    }else{
      $('#city_id').empty();
    }
  });
});


$('#name').keypress(function (e) {
       $("#message").hide();
       $("#user_message").hide();
       var keyCode = e.which;
     if (keyCode >= 48 && keyCode <= 57) 
     {
        $("#message").show();
        e.preventDefault();
    }
     
    });
// CODE FOR USERNAME SPACE NOT ALLOWED
$('#trader_username').keypress(function (e) {
       $("#user_message").hide();
      
      if(e.which === 32) 
      {
        $("#user_message").show();
        e.preventDefault();
      }
     
    });

