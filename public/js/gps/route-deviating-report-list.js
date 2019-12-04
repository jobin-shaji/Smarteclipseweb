$(document).ready(function () {
    callBackDataTable();
});
function check(){
    if(document.getElementById('vehicle').value == ''){
        alert('please select vehicle');
    }
    else if(document.getElementById('fromDate').value == ''){
        alert('please select From date');
    }else if(document.getElementById('toDate').value == ''){
        alert('please select To date');
    }
    else{
        calculate();
        callBackDataTable();
    }
}
function calculate() {
    var d1 = $('#fromDate').data("DateTimePicker").date();
    var d2 = $('#toDate').data("DateTimePicker").date();
    var timeDiff = 0
    if(d2) {
        timeDiff = (d2 - d1) / 1000;
    }
    var DateDiff = Math.floor(timeDiff / (60 * 60 * 24));
    if(DateDiff>15)
    {
        var fromDate=$('#fromDate').val();
        document.getElementById("toDate").value = "";
        alert("Please select date upto 15 days ");
    }
}

function callBackDataTable(){
    var  data = {
          from_date : document.getElementById('fromDate').value,
          to_date : document.getElementById('toDate').value,
          vehicle : document.getElementById('vehicle').value,
    }; 


    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'route-deviation-report-list',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {
            

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: true, searchable: false},
            {data: 'vehicle.name', name: 'vehicle.name', orderable: false},
            {data: 'vehicle.register_number', name: 'vehicle.register_number', orderable: false},
            {data: 'route.name', name: 'route.name', orderable: false},
            {data: 'location', name: 'location', orderable: false},
            {data: 'deviating_time', name: 'deviating_time', orderable: false},

        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}



