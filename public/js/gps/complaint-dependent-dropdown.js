$(document).ready(function() {
        $('#complaint_category').on('change', function() {
            var categoryID = $(this).val();
            var data={ categoryID : categoryID };
            if(categoryID) {
                $.ajax({
                    type:'POST',
                    url: '/complaint/complaintType',
                    data:data ,
                    async: true,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data) {
                        //console.log(data);
                      if(data){
                        $('#complaint_type_id').empty();
                        $('#complaint_type_id').focus;
                        $('#complaint_type_id').append('<option value="">--Select Reason--</option>'); 
                        $.each(data, function(key, value){
                        $('select[name="complaint_type_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
                    });
                  }else{
                    $('#complaint_type_id').empty();
                  }
                  }
                });
            }else{
              $('#complaint_type_id').empty();
            }
        });
    });