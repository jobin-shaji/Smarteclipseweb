function getFuelGraphDetails()
{
    var gps_id = document.getElementById("vehicle").value;
    var date = document.getElementById("date").value;
    if(date == '')
    {
        alert('Please select date from calendar');
    }else if(gps_id == '')
    {
        alert('Please select vehicle');
    }else{
        callBackDataTable(gps_id,date);
        var url = 'fuel-graph';
        var data = {
            gps_id:gps_id,date:date
        };
        backgroundPostData(url, data, 'fuelGraph', {alert: false});
    }

}
function callBackDataTable(gps_id,date)
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
                'gps_id': gps_id,'date': date
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
    if(res.status == 1)
    {
        // res.fuel_km.km
       var fuel_km= '<div class="col-lg-3 col-xs-6 gps_dashboard_grid km_grid">'+
        '<div class="small-box bg-green bxs">'+
          '<div class="inner">'+
            '<h3 >KM : '+res.fuel_km.km+
            '</h3>'+
          '</div>'+
        '</div>'+
      '</div>';
        $('#fuel_km').append(fuel_km);
        $('#fuel_graph').show();
        //line graph
        var fuel_chart_container = document.getElementById("fuel_graph").getContext('2d');
        new Chart(fuel_chart_container, {
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
        $('#fuel_km').text('');
        $('#fuel_graph').hide();
    }

}
