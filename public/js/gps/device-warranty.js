$(document).ready(function() {
    $('.content').hide();
    setInterval(function() {
        $("#session_message").hide();
    }, 3000);
});

/**
 * @author SSK
 * 
 * 
 */
function addWarranty()
{
    var device    = document.getElementById('device').value;
    if( device == 0)
    {
        alert('Please select device');
    }
    else
    {
        $.ajax({
            type:'POST',
            url: "get-active-warranty",
            data: {gps_id: device },
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) 
            {
                if(res.active_warranty)
                {
                    document.getElementById('imei').innerHTML = res.active_warranty.gps.imei;
                    document.getElementById('period_from').innerHTML = res.active_warranty.period_from;
                    document.getElementById('period_to').innerHTML = res.active_warranty.period_to;
                    document.getElementById('expired_on').innerHTML = ( res.active_warranty.expired_on ) ? res.active_warranty.expired_on : "Not Expired";
                    document.getElementById('reason').innerHTML = ( res.active_warranty.expired_reason ) ? res.active_warranty.expired_reason : "Warranty Active";
                }
                else if(res.gps)
                {
                    document.getElementById('imei').innerHTML = res.gps.imei;
                    document.getElementById('period_from').innerHTML = "No warranty for this device";
                    document.getElementById('period_to').innerHTML = "No warranty for this device";
                    document.getElementById('expired_on').innerHTML = "No warranty for this device";
                    document.getElementById('reason').innerHTML = "No warranty for this device";
                }
                $('.warranty-content').hide();
                document.getElementById('gps_id').value = device;
                $('.content').show();
            
            }

        });
    }
}

/**
 * @author SSK
 * 
 * 
 */
function cancel()
{
    window.location = "device-warranty";
}

function setToDate()
{
    alert("hii");
}