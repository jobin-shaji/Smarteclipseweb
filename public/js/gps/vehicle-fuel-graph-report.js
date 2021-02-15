
function getDriverFuelDetails()
{
    var vehicle_id      =   $("#vehicle").val();
    var hasError        = false;
     if(vehicle_id.length == 0)
    {
        $("#vehicle").siblings('.error').remove();
        // $("#vehicle").after("<span class='error text-danger'>Please Select Vehicle</span>")
        $("#vehicle_span").text("Please Select Vehicle");
        hasError        =   true;
    }
    else
    {
        $("#vehicle").siblings('.error').remove();
        $("#vehicle_span").text("");
    } 
   
    
    var date        =   $("#date").val(); 
    if(date == '')
    {
        $("#date").siblings('.error').remove();
        $("#date").after("<span class='error text-danger'>Please Select Date From Calendar</span>")
        hasError    =   true;
    }
    else
    {
        $("#date").siblings('.error').remove();
    } 
    
    if(hasError == false)
    {
        $('.show_selected_date').show();
        $('.cover_div_search').hide();
        $('.cover_date_select').css('display','none');
        $('.show_selected_date').append('<div class="col-sm-4 col-date-outer fule-cal"><span class="datetime_searched"> Fuel Report : '+date+ '</span><span onclick="resetDate()" class="close-span-rt ful-close"><i class="fa fa-times"></i></span></div>');
        // callBackDataTable(drier_id,date,report_type)
        var url = 'vehicle-fuel-graph';
        var data = {
            date:date,vehicle_id:vehicle_id
        };
        backgroundPostData(url, data, 'fuelGraph', {alert: false});
    }
    else
    {
        return false;
    }   
}
function resetDate(){
    location.reload(true);
  }



function fuelGraph(res)
{
    $('#fuel_km').empty();
    $('#fuel_graph').empty();
    if(res.status   ==   1)
    {
       
        $('#fuel_graph').show();
        //line graph

        var fuel_chart_container    =   document.getElementById("fuel_graph").getContext('2d');
        myChart                     =   new Chart(fuel_chart_container, {
            type        :   'line',
            data        :   {
                                labels: res.vehicle_km,
                                datasets: [{
                                label: 'Fuel range',
                                data: res.percentage,
                                backgroundColor: [
                                    'rgba(55, 59, 66, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(55, 59, 66, 0.7)'
                                ],
                                borderWidth: 2
                                }
                                ]
                            },
            options     :   {
                                responsive: true,
                                scales: {
                                xAxes: [{
                                    scaleLabel: {
                                    display: true,
                                    labelString: 'km'
                                    }
                                }],
                                yAxes: [{
                                    scaleLabel: {
                                    display: true,
                                    labelString: 'Percentage'
                                    }
                                }]
                                }
                            }
        });
    }
    else
    {
        $('#fuel_km').hide();
        $('#fuel_graph').hide();
    }


}
$(document).ready(function() 
{
    $('.show_selected_date').hide();
});


