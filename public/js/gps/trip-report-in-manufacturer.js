function getUrl(){
    return $('meta[name = "domain"]').attr('content');
}

$(document).ready(function() {
    var hidden_client_id = $('#client_id').val();
    getVehicles(hidden_client_id)
});
$('#client_id').on('change', function() {
    var client_id = $(this).val();
    getVehicles(client_id);
});

function getVehicles(client_id)
{
    var data={ client_id : client_id };
    if(client_id) {
        $.ajax({
            type:'POST',
            url: '/trip-report-vehicle-dropdown-in-manufacturer',
            data:data ,
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(data) {
                if(data.vehicles.length != 0){
                    $('#vehicle_id').empty();
                    $('#vehicle_id').focus;
                    $('#vehicle_id').append('<option value="">  Select Vehicle </option>');
                    $('#vehicle_id').append('<option value="0">  All </option>'); 
                    $.each(data.vehicles, function(key, value){
                    $('select[name="vehicle_id"]').append('<option value="'+ value.id +'">' + value.name+' || '+ value.register_number+ '</option>');
                    });
                    var hidden_vehicle_id = $('#hidden_vehicle_id').val();
                    if(hidden_vehicle_id)
                    {
                        $("#vehicle_id").select2().val(hidden_vehicle_id).trigger("change");
                    }
                }else{
                    $('#vehicle_id').empty();
                    $('#vehicle_id').focus;
                    $('#vehicle_id').append('<option value="">  No Vehicles Found </option>'); 
                }
            }
        });
    }else{
        $('#gps_id').empty();
    }
}


function DateCheck()
{
    var from_date       =   document.getElementById('from_date').value;
    var to_date         =   document.getElementById('to_date').value;
    var from_d          =   new Date(from_date.split("-").reverse().join("-"));
    var from_day        =   from_d.getDate();
    var from_month      =   from_d.getMonth()+1;
    var from_year       =   from_d.getFullYear();
    //from_date           =   from_year+""+from_month+""+from_day;
    var to_d            =   new Date(to_date.split("-").reverse().join("-"));
    var to_day          =   to_d.getDate();
    var to_month        =   to_d.getMonth()+1;
    var to_year         =   to_d.getFullYear();
    // to_date             =   to_year+""+to_month+""+to_day;
    var dateFrom        =   new Date(from_year, from_month, from_day); //Year, Month, Date    
    var dateTo          =   new Date(to_year, to_month, to_day); //Year, Month, Date    
    if(dateFrom > dateTo)
    {
        document.getElementById('from_date').value  =   "";
        document.getElementById('to_date').value    =   "";
        alert('From date should be less than To date');
        window.location.href = getUrl() + '/'+'trip-report-manufacturer' ;
    }
    else
    {
        return true;
    }
}