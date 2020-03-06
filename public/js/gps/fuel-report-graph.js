function getFuelGraphDetails()
{

    var report_type = document.getElementById("report_type").value;
    var gps_id = document.getElementById("vehicle").value;
    if(report_type==1)
    {
        var date = document.getElementById("date").value;
        document.getElementById("month").value="";
        if(date == '')
        {
            alert('Please select date from calendar');
        }
    }
    else if(report_type==2)
    {
        var date = document.getElementById("month").value;
        document.getElementById("date").value=""
        if(date == '')
        {
            alert('Please select date from calendar');
        }
    }
    if(gps_id == '')
    {
        alert('Please select vehicle');
    }
    else{
        $('.show_selected_date').show();
        $('.cover_div_search').hide();
        // cover_div_search
        $('.cover_date_select').css('display','none');
        $('.show_selected_date').append('<div class="col-sm-4 col-date-outer fule-cal"><span class="datetime_searched"> Fuel Report : '+date+ '</span><span onclick="resetDate()" class="close-span-rt ful-close"><i class="fa fa-times"></i></span></div>');
        callBackDataTable(gps_id,date,report_type)
            var url = 'fuel-graph';
            var data = {
                gps_id:gps_id,date:date,report_type:report_type
            };
            backgroundPostData(url, data, 'fuelGraph', {alert: false});
        }
}
function resetDate(){
    location.reload(true);
  }

function callBackDataTable(gps_id,date,report_type)
{
    $('#dataTable').show();
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        // order: [[1, 'desc']],
        ajax: {
            url: 'fuel-report-list',
            type: 'POST',
            data: {
                'gps_id': gps_id,'date': date,'report_type':report_type
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        createdRow: function ( row, data, index ) {
        },

        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'vehicle', name: 'vehicle', orderable: false},
            {data: 'register_number', name: 'register_number', orderable: false},
            {data: 'percentage', name: 'percentage', orderable: false},
            {data: 'created_at', name: 'created_at', orderable: false}
        ],

        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

function fuelGraph(res)
{
    $('#fuel_km').empty();
    $('#fuel_graph').empty();
    if(res.status == 1)
    {
        if(res.fuel_km){
           var km=res.fuel_km.km;
        }
        else{
            var km="";
        }
        // res.fuel_km.km
       var fuel_km= '<div class="col-lg-3 col-xs-6 gps_dashboard_grid km_grid">'+
        '<div class="small-box bg-green bxs">'+
          '<div class="inner">'+
            '<h5 >KM : '+km+
            '</h5>'+
          '</div>'+
        '</div>'+
      '</div>';
        $('#fuel_km').append(fuel_km);
        $('#fuel_graph').show();
        //line graph

        var fuel_chart_container = document.getElementById("fuel_graph").getContext('2d');
        myChart= new Chart(fuel_chart_container, {




            type: 'line',
            data: {
                labels: res.date_time,
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
            options: {
                responsive: true,
                scales: {
                xAxes: [{
                    scaleLabel: {
                    display: true,
                    labelString: 'DateTime'
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
$(document).ready(function() {
    $('.show_selected_date').hide();
    show_selected_date
    $('#single_date').hide();
    $('#single_month').hide();

  });
function reportType(value){
    if(value==1){
        $('#single_date').show();
        $('#single_month').hide();
    }
    else if(value==2){
        $('#single_date').hide();
        $('#single_month').show();
    }
}


function monthFuelGraph(res)
{

}
