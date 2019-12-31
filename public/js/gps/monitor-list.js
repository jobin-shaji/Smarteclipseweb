function single_vehicle_details(vehicle_id) 
{
    var vehicle_tab_elements = [
        {'id' : 'tvc_vehicle_name', 'key' : 'name'},
        {'id' : 'tvc_vehicle_registration_number', 'key' : 'register_number'}
    ];

    if(vehicle_id)
    {
        var data = { vehicle_id :vehicle_id};
        $.ajax({
            type    :'POST',
            url     : 'allvehicle-list',
            data    : data ,
            async   : true,
            headers : {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res){
                if(res.success)
                {
                    vehicle_tab_elements.forEach(function(each_element){
                        if(typeof res.data[each_element.key])
                        {
                            $('#'+each_element.id).text(res.data[each_element.key]); 
                        }
                    });
                    // display vehicle tab
                    setActiveTab('vehicle');
                }
            }
        });
    }
}

function setActiveTab(active_tab_id)
{
    $('#monitoring_details_tab_contents').find('.tab-pane').each(function(){
        $(this).removeClass('active show in');
        if( $(this).attr('id') == 'tab_content_'+active_tab_id )
        {
            $(this).addClass('active show in');
        }
    });
}



