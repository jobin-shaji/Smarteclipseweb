
$(function(){
    $('#searchclick').click(function() {
        var content = $('#packetvalue').val();
        if(content){
            var data = { content : content };
            $.ajax({
                type:'POST',
                url: "all-batch-list",
                data:data ,
                async: true,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    $('#batchtabledata').empty();
                    for (var i = 0; i < res.length; i++) {
                        var batchrow = '<tr><td>'+res[i]+'</td>'+
                        '</tr>';
                        $("#batchtabledata").append(batchrow);
                    }
                }
            });
          
        }
    });
});

