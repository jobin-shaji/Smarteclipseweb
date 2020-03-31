function check()
{
    if(document.getElementById('vehicle').value == '')
    {
        alert('Please select vehicle');
    }
    else if(document.getElementById('fromDate').value == '')
    {
        alert('Please enter date');
    }
    else{
        var  data = {
            client      :   $('meta[name = "client"]').attr('content'),
            date        :   document.getElementById('fromDate').value,
            vehicle     :   document.getElementById('vehicle').value,
        };
        callBackDataTable(data);
    }
}

function callBackDataTable(data=null)
{
    if(data != null)
    {
        $('#daily_km_report_download').show();
        $('#dataTable').show();
    }
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'dailykm-report-list',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        fnDrawCallback: function (oSettings, json) {
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false},
            {data: 'vehicle_gps.vehicle.name', name: 'vehicle_gps.vehicle.name', orderable: false, searchable: false},
            {data: 'vehicle_gps.vehicle.register_number', name: 'vehicle_gps.vehicle.register_number', orderable: false},
            {data: 'totalkm', name: 'totalkm', orderable: false},
            {data: 'date', name: 'date', orderable: false},
        ],
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



