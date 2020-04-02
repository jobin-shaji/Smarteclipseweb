
function stopActivated()
{
    var servicer_jobid =$('#servicer_jobid').val();
     var stage="stop";


    if(servicer_jobid)
    {
        var data = { servicer_jobid :servicer_jobid,stage:stage};
        $.ajax({
            type    :'POST',
            url     : '/servicer/alltest-stop',
            data    : data ,
            async   : true,
            headers : {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res){
               console.log(res.message);
                if(res.success)
                {
                    $('#modalValue').text(res.message);
                    $('#stopModal').show();
                }
            }
        });
    }
}
$(document).ready(function() {
$("#close").click(function() {
   $("#stopModal").hide();
    location.reload(true);
});
});

function resetActivated()
{
    var servicer_jobid =$('#servicer_jobid').val();
     var stage="reset";


    if(servicer_jobid)
    {
        var data = { servicer_jobid :servicer_jobid,stage:stage};
        $.ajax({
            type    :'POST',
            url     : '/servicer/devicetestbutton-reset',
            data    : data ,
            async   : true,
            headers : {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res){
              
               
                     $('#resetValue').text(res.message);
                     $('#resetModal').show();

               
            }
        });
    }
}

$(document).ready(function() {
$("#resetclose").click(function() {
   $("#resetModal").hide();
      location.reload(true);
});
});
//reload after 5 seconds on page load
 $(document).ready(function () 
 {
     setTimeout(function(){
     location.reload(true);
     }, 15000);       
 });