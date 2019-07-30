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
                            if (res == '1') {
                                $("#expiry_heading").hide();
                                $("#expiry_date").hide();
                            }else if (res == '6') {
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