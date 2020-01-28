$(document).ready(function() {
        $('#document_type_id').on('change', function() {
            var docTypeID = $(this).val();
            var purl = getUrl() + '/'+'vehicles/findDateFieldWithDocTypeID' ;
            var data={ docTypeID : docTypeID };
            if(docTypeID) {
                $.ajax({
                    type:'POST',
                    url: purl,
                    data:data ,
                    async: true,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(res) {
                        if(res){
                            if (res == '1' || res == '6' || res == '7' || res == '8') {
                                $("#expiry_heading").hide();
                                $("#expiry_date").hide();
                            }else {
                                $("#expiry_heading").show();
                                $("#expiry_date").show();
                            }
                        
                        }else{
                            $("#expiry_heading").empty();
                            $("#expiry_date").empty();
                        }
                    }
                });
            }else{
                $("#expiry_heading").empty();
                $("#expiry_date").empty();
            }
        });
    });

$("#choose_image").change(function() {
    displaySelectedImage(this);
  });
function displaySelectedImage(input) {
if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
    $('.selected_image').show();
    $('.selected_image').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
}
}
