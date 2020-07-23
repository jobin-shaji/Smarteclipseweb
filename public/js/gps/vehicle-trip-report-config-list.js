$(document).ready(function() {
    $("#plan_section").hide();
    $('#client').on('change', function() {
        var client_id = $(this).val();
        var data={ client_id : client_id };
        $.ajax({
            type:'POST',
            url: '/end-user-plan',
            data:data ,
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data) {
                if(data.client_id != 'all')
                {
                    $("#plan_section").hide();
                    $('#plan').empty();
                    $('#plan').focus;
                    $('#plan').append('<option value="'+ data.plan_type.ID +'">' + data.plan_type.NAME+ '</option>'); 
                }
                else
                {
                    $("#plan_section").show();
                    $('#plan').empty();
                    $('#plan').focus;
                    $('#plan').append('<option value="">ALL</option>'); 
                    $.each(data.plan_type, function(key, value){
                        $('select[name="plan"]').append('<option value="'+ value.ID +'">' + value.NAME+ '</option>');
                    });
                }
            }
        });
        
           
         
    });
/**
 * 
 * fetch client vehicles 
 */
    $('#client_id').on('change', function() {
        var client_id = $(this).val();
        var data={ client_id : client_id };
        $.ajax({
            type:'POST',
            url: '/end-user-plan-count',
            data:data ,
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data) {
              $('#client_role').html('<div class="no-data-class" style="margin-top: 8px;">PLAN:'+data.plan+' , Total Vehicles:'+data.vehicle_count+'</div>');                            
            }
        });
    });
});
/**
 *  modal show
 */
function getVehicleTripReportConfiguration()
{
    $('#myModal').modal('show');
}

function addVehicleSubscription()
{
    $('#vehicle_registration').modal('show');
}
/**
 * for clearing the modal when close
 */
$(".modal").on("hidden.bs.modal", function(){
    $(".modal-body1").html("");
})

// date picker validations
$( ".config_date" ).datetimepicker({
    format: 'DD-MM-YYYY',
    minDate: new Date()
});

