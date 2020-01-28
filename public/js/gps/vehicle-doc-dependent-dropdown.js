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
$('#delete_button').click(function () {
    alert('Are you sure to delete this document?');
});
$('#upload_form').on('submit', function(event){
      event.preventDefault();
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
            console.log(res);
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
            // alert("Successfully Created"); 
            location.reload(true); 
       }
  })
}