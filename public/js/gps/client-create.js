
$(document).ready(function() {
  $("#message").hide();
  $('#country_id').on('change', function() {
    var countryID = $(this).val();
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
        console.log(data);
        if(data){
          $('#state_id').empty();
          $('#state_id').focus;
          $('#state_id').append('<option value="">  Select State </option>'); 
          $.each(data, function(key, value){
            $('select[name="state_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
          });
        }else{
          $('#state_id').empty();
        }
        }
      });
    }else{
      $('#state_id').empty();
    }
  });
});
$(document).ready(function() {
  $("#message").hide();
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
        console.log(data);
        if(data){
          $('#city_id').empty();
          $('#city_id').focus;
          $('#city_id').append('<option value="">  Select City </option>'); 
          $.each(data, function(key, value){
            $('select[name="city_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
          });
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
     var keyCode = e.which;
     if (keyCode >= 48 && keyCode <= 57) 
     {
       $("#message").show();
        e.preventDefault();
    }
     
    });


