$(document).ready(function() {
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
                    $('#plan').empty();
                    $('#plan').focus;
                    $('#plan').append('<option value="'+ data.plan_type.ID +'">' + data.plan_type.NAME+ '</option>'); 
                }
                else
                {
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
            url: '/end-user-vehicle',
            data:data ,
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data) {
                            
                $('#vehicle_id').empty();
                $('#vehicle_id').focus;
                $('#vehicle_id').append('<option value="" disabled="disabled" selected="selected">Select vehicles</option>'); 
                $.each(data.vehicles, function(key, value){
                    $('select[name="vehicle_id" ]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
                });                
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
