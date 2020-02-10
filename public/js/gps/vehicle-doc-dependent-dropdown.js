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


$('#upload_form').on('submit', function(event){
   
       event.preventDefault();
       $("#load4").removeAttr("style");
       $("#load-4").removeAttr("style");
        
      var data_val=new FormData(this);
      $.ajax({
           url:'/document-upload',
           method:"POST",
           data:new FormData(this),
           dataType:'JSON',
           contentType: false,
           cache: false,
           processData: false,
           success:function(res)
           {
              
                if(typeof res.error != 'undefined')
                {
                    Object.keys(res.error).forEach(key => {
                        $('.error_'+key).text(res.error[key]);
                    });
                    return false;
                }
                if(res.count==3){
                    if (confirm('Maximum number of documents with same expiry date is reached. Do you want to replace all existing documents with the current one ?')){            
                        deleteDocuments(data_val);
                    }else{
                        alert("Please delete the document manually");
                        location.reload(true);            
                    } 
                }
                else if(res.count==4){
                     if (confirm('A document with a different expiry date is already in the database. Do you want to replace this ?')){            
                        deleteDocuments(data_val);
                    }
                }
                else{
                    alert("Document successfully uploaded"); 
                    location.reload(true); 
                }
           }
      })
 });
function deleteDocuments(data_val){
   $.ajax({
        url:'/delete-already-existing',
        method:"POST",
        data:data_val,
        dataType:'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success:function(data)
        {
            location.reload(true); 
        }
  })
}


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

