$(document).ready(function () {
    callBackDataTable();
});
function callBackDataTable(){
    var  data = {

    };
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'driver-list',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        createdRow: function ( row, data, index ) {
            if ( data['deleted_at'] ) {
                $('td', row).css('background-color', 'rgb(243, 204, 204)');
            }
        },
        fnDrawCallback: function (oSettings, json) {
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name', orderable: false },
            {data: 'address', name: 'address', orderable: false, searchable: false},
            {data: 'mobile', name: 'mobile', orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},

        ],

        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}
function delDriver(driver){
    if(confirm('The driver will be removed from the assigned vehicle.   Are you sure to deactivate this driver?')){
        var url = 'driver/delete';
        var data = {
            uid : driver
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});
    }
}
function activateDriver(driver){
    if(confirm('Driver should be assigned manually to any vehicle.        Are you sure to activate this driver?')){
        var url = 'driver/activate';
        var data = {
            id : driver
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});
    }
}

function validate_driver(driver_id)
{
    var proceed = false;
    if(typeof driver_id == 'undefined')
    {
        toastr.error( 'Invalid request', 'Error');
        return false;
    }
    $.ajax({
        type: 'POST',
        url: 'driver/validate_driver',
        data: {
            id: driver_id
        },
        async: false,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            if(res.driver_exists == false)
            {
                toastr.error( 'Driver not exists', 'Error');
                reloadPageWithAdelay(1000);
            }
            else
            {
                proceed = true;
            }
        }
    });
    return proceed;
}

function reloadPageWithAdelay(delay)
{
    if(typeof delay != 'undefined')
    {
        setTimeout(function(){
            window.location.reload();
          }, delay);
    }
}
function validate_driver_mobileno()
    {
        var proceed = false;
        var mob=$('#mobile').val();
         $.ajax({
            type: 'POST',
            url: '/validate_mobile_driver',
            data: {
            mobile: mob
            },
            async: false,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                if(res.driver_exists == true)
                {

                    toastr.error( 'Driver with this mobile number already exists', 'Error');
                    reloadPageWithAdelay(2000);
                }
                else
                {
                    proceed = true;
                }
            }
        });
        return proceed;
    }
