function check()
{
    if(document.getElementById('vehicle').value == '')
    {
        alert('please select vehicle');
    }
    else if(document.getElementById('fromDate').value == '')
    {
        alert('Please select From date');
    }
    else if(document.getElementById('toDate').value == '')
    {
        alert('Please select To date');
    }
    else
    {
        calculate();
        var  data = {
            client      :   $('meta[name = "client"]').attr('content'),
            from_date   :   document.getElementById('fromDate').value,
            to_date     :   document.getElementById('toDate').value,
            vehicle     :   document.getElementById('vehicle').value,
        };
        if(document.getElementById('toDate').value == '')
        {
            $("#sudden_acceleration_report_download").hide(); 
            $('#dataTable tbody').empty();
        }
        else{
            callBackDataTable(data);
        }      
    }
}
function calculate() 
{
    var d1              =   $('#fromDate').data("DateTimePicker").date();
    var d2              =   $('#toDate').data("DateTimePicker").date();
    var timeDiff        =   0
    if(d2) 
    {
        timeDiff        =   (d2 - d1) / 1000;
    }
    var DateDiff        =   Math.floor(timeDiff / (60 * 60 * 24));
    if(DateDiff > 15)
    {
        var fromDate    =   $('#fromDate').val();
        document.getElementById("toDate").value = "";
        alert("Please select date upto 15 days ");
    }
}
 
function callBackDataTable(data=null)
{
    if(data != null)
    {
        $('#sudden_acceleration_report_download').show();
        $('#dataTable').show();
    }
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        // order: [[1, 'desc']],
        ajax: {
            url: 'sudden-acceleration-report-list',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'gps.vehicle.register_number', name: 'gps.vehicle.register_number', orderable: false},
            {data: 'alert_type.description', name: 'alert_type.description', orderable: false, searchable: false},
            {data: 'device_time', name: 'device_time', orderable: false},
            // {data: 'action', name: 'action', orderable: false, searchable: false}
           
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



