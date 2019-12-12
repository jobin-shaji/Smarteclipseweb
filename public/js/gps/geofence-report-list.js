$(document).ready(function () {

    callBackDataTable();
});
 
function check(){
     if(document.getElementById('vehicle').value == ''){
        alert('please select Vehicle');
    }
    else if(document.getElementById('fromDate').value == ''){
        alert('please select From date');
    }else if(document.getElementById('toDate').value == ''){
        alert('please select To date');
    }
    else{
        calculate();   
         var client=$('meta[name = "client"]').attr('content');
        var from_date = document.getElementById('fromDate').value;
        var to_date = document.getElementById('toDate').value;
        var vehicle = document.getElementById('vehicle').value;
        var data = {'client':client,'vehicle':vehicle, 'from_date':from_date , 'to_date':to_date};
        callBackDataTable(data);       
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

function callBackDataTable(data=null){
    

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'geofence-report-list',
            type: 'POST',
            data:data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {
            

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: true, searchable: false},
            {data: 'gps.vehicle.name', name: 'gps.vehicle.name', orderable: false},
            {data: 'gps.vehicle.register_number', name: 'gps.vehicle.register_number', orderable: false},
            {data: 'alert_type.description', name: 'alert_type.description', orderable: false},
            {data: 'device_time', name: 'device_time', orderable: false},

        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

var disabledDates = ["2019-11-02"];






