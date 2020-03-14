$(document).ready(function() {    
    $('#city_id').on('change', function() {
        
        var cityID = $(this).val();
        console.log(cityID);
        var data={ cityID : cityID };
        if(cityID) {
            $.ajax({
            type:'POST',
            url: '/city-lat-lng',
            data:data ,
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data) {
            // console.log(data);
            // if(data){
            //     $('#state_id').empty();
            //     $('#state_id').focus;
            //     $('#state_id').append('<option value="">  Select State </option>'); 
            //     $.each(data, function(key, value){
            //     $('select[name="state_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
            //     });
            // }else{
            //     $('#state_id').empty();
            // }
            }
            });
        }else{
            // $('#state_id').empty();
        }
    });
  });