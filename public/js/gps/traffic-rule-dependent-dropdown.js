$(document).ready(function() {
  $('#country_id').on('change', function() {
    var countryID = $(this).val();
    var data={ countryID : countryID };
    if(countryID) {
      $.ajax({
        type:'POST',
        url: '/traffic-rule/get-state-list',
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