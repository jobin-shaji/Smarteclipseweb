

 $(document).ready(function(){
        $('.branch_check_box input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
               var batch=this.value;
			    var data={ batch : batch };
			    if(batch) {
			      $.ajax({
			        type:'POST',
			        url: '/student/get-studen-from-batch',
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





               var selectedValues = [1, 2,3];
               $("#students_data").val(selectedValues).trigger('change'); 
            }else if($(this).prop("checked") == false){
                var unchecked_branch=this.value;
                var selectedValues = [1, 2,3];
               $("#students_data").val('').trigger("change");
            }
        });
    });