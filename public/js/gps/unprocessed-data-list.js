function searchButtonClicked()
{
    var status  = false;       
    var imei    = document.getElementById('imei').value;        
    var header  = document.getElementById('header').value; 
    if( imei == '')
    {
        alert('Please select GPS');
    }
    else if( header == '')
    {
        alert('Please select header');
    }  
    else
    {
        status = true;
    }
    return status;
}

function sendCommandToDevice(imei)
{
    var url = 'get-gps-id-from-imei';
    var data = {
        imei:imei
    };   
    $.ajax({
        type:'POST',
        url: url,
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            
        },
        success: function (res) 
        {
            if(res.status == 1)
            {
                $("#set_ota_gps_id").val(res.gps_id);
            }
        }

    });
}

function setOta(gps_id) {
    if(document.getElementById('command').value == ''){
        alert('Please enter your command');
    }
    else{
        var command = document.getElementById('command').value;
        var data = {'gps_id':gps_id, 'command':command};
    }
    var url = 'console-set-ota';
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            if(res.status==1)
            {
                $('#command').val('');
                toastr.success(res.message);
            }
            else{
                toastr.error(res.message);
            }
        }
    });
}