 $(document).ready(function () {
    var from_date = document.getElementById('fromDate').value;
    var to_date   = document.getElementById('toDate').value;
    var vehicle   = document.getElementById('vehicle').value;
    var data = {'from_date':from_date,'to_date':to_date,'vehicle':vehicle};
    callBackDataTable(data);
});
            /**
         *  modal show
         */
        function addGeneralRequest()
        {
            $('#myModal').modal('show');
        }

    function check()
    {
        if(document.getElementById('vehicle').value == '')
        {
            alert('Please select vehicle');
        }
        if(document.getElementById('fromDate').value == ''){
            alert('Please select  From date');
        }else if(document.getElementById('toDate').value == ''){
            alert('Please select To date');
        }else{
            var from_date = document.getElementById('fromDate').value;
            var to_date = document.getElementById('toDate').value;
            var vehicle = document.getElementById('vehicle').value;
            var data = {'from_date':from_date , 'to_date':to_date,'vehicle':vehicle};
        callBackDataTable(data);
        }
       
    }

function callBackDataTable(data=null){
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        // order: [[1, 'desc']],
        ajax: {
            url: 'demand-report-details',
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
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'trip_report_date', name: 'trip_report_date', orderable: false},
            {data: 'vehicle.register_number', name: 'vehicle.register_number', orderable: false},
            {data: 'report_type', name:'report_type', orderable: false},
            {data: 'job_submitted_on', name: 'job_submitted_on', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false},         
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}






