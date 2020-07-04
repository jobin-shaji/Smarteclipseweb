$(document).ready(function () {
    var  data = {
    
    }; 
    callBackDataTable(data);
});

function getDeviceTransferList()
{
    if(document.getElementById('from_date').value == '')
    {
        alert('Please select From date');
    }
    else if(document.getElementById('to_date').value == '')
    {
        alert('Please select To date');
    }
    else
    {
        var from_date       = document.getElementById('from_date').value;
        var to_date         = document.getElementById('to_date').value;
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
            window.location.href = getUrl() + '/'+'gps-transfers-subdealer' ;
        }
        else
        {
            var data = {'from_date':from_date , 'to_date':to_date};
            callBackDataTable(data);
        }
    }
}

function callBackDataTable(data){
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'gps-transfer-list-subdealer',
            type: 'POST',
            data:data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        createdRow: function ( row, data, index ) {
            if ( data['deleted_at'] ) {
                $('td', row).css('background-color', 'rgb(178, 178, 178)');
            }
            else if ( data['accepted_on'] ) {
                $('td', row).css('background-color', 'rgb(210, 239, 203)');
            }

        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'from_user', name: 'from_user', orderable: false},
            {data: 'to_user', name: 'to_user', orderable: false},
            {data: 'dispatched_on', name: 'dispatched_on', orderable: false},
            {data: 'count', name: 'count'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
    var table = $('#dataTable').DataTable();
    table.search('').draw();
}
