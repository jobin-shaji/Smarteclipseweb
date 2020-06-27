var auto_refresh_console    = false;
var refresh_interval_id     = null;
var vehicle_id              = '';
var user_id                 = '';
var filterData              = new FormData();

function getVehicleDetailsBasedOnGps()
{
    var gps_id = document.getElementById('gps_id').value;
    var data = { 'gps_id':gps_id };
    var url = '/device-detailed-report/vehicle-details';
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            var vehicle_name                = '-NA-';
            var vehicle_registration_number = '-NA-';
            var vehicle_category            = '-NA-';
            var engine_number               = '-NA-';
            var chassis_number              = '-NA-';
            var vehicle_model               = '-NA-';
            var vehicle_make                = '-NA-';
            var vehicle_theft_mode          = '-NA-';
            var vehicle_towing_mode         = '-NA-';
            var vehicle_created_on          = '-NA-';
            var driver_name                 = '-NA-';
            var driver_address              = '-NA-';
            var driver_mobile               = '-NA-';
            var driver_score                = '-NA-';
            if(res.vehicle_details != null)
            {
                (res.vehicle_details.vehicle) ? vehicle_name = res.vehicle_details.vehicle.name : vehicle_name = "-NA-";
            (res.vehicle_details.vehicle) ? vehicle_registration_number = res.vehicle_details.vehicle.register_number : vehicle_registration_number = "-NA-";
            (res.vehicle_details.vehicle) ? vehicle_category = res.vehicle_details.vehicle.vehicle_type.name : vehicle_category = "-NA-";
            (res.vehicle_details.vehicle) ? engine_number = res.vehicle_details.vehicle.engine_number : engine_number = "-NA-";
            (res.vehicle_details.vehicle) ? chassis_number = res.vehicle_details.vehicle.chassis_number : chassis_number = "-NA-";
            (res.vehicle_details.vehicle.vehicle_models_with_trashed) ? vehicle_model = res.vehicle_details.vehicle.vehicle_models_with_trashed.name : vehicle_model = "-NA-";
            (res.vehicle_details.vehicle.vehicle_models_with_trashed.vehicle_make_with_trashed) ? vehicle_make = res.vehicle_details.vehicle.vehicle_models_with_trashed.vehicle_make_with_trashed.name : vehicle_make = "-NA-";
            (res.vehicle_details.vehicle) ? vehicle_theft_mode = res.vehicle_details.vehicle.theft_mode : vehicle_theft_mode = "-NA-";
            (res.vehicle_details.vehicle) ? vehicle_towing_mode = res.vehicle_details.vehicle.towing : vehicle_towing_mode = "-NA-";
            (res.vehicle_details.vehicle) ? vehicle_created_on = res.vehicle_details.vehicle.created_at : vehicle_created_on = "-NA-";
            (res.driver_details.name) ? driver_name = res.driver_details.name : driver_name = "-NA-";
            (res.driver_details.address) ? driver_address = res.driver_details.address : driver_address = "-NA-";
            (res.driver_details.mobile) ? driver_mobile = res.driver_details.mobile : driver_mobile = "-NA-";
            (res.driver_details.points != 'null') ? driver_score = res.driver_details.points : driver_score = "-NA-";
            }
            document.getElementById("vehicle_name").innerHTML = vehicle_name;
            document.getElementById("vehicle_registration_number").innerHTML = vehicle_registration_number;
            document.getElementById("vehicle_category").innerHTML = vehicle_category;
            document.getElementById("engine_number").innerHTML = engine_number;
            document.getElementById("chassis_number").innerHTML = chassis_number;
            document.getElementById("vehicle_model").innerHTML = vehicle_model;
            document.getElementById("vehicle_make").innerHTML = vehicle_make;
            document.getElementById("vehicle_theft_mode").innerHTML = vehicle_theft_mode;
            document.getElementById("vehicle_towing_mode").innerHTML = vehicle_towing_mode;
            document.getElementById("vehicle_created_on").innerHTML = vehicle_created_on;
            document.getElementById("driver_name").innerHTML = driver_name;
            document.getElementById("driver_address").innerHTML = driver_address;
            document.getElementById("driver_mobile").innerHTML = driver_mobile;
            document.getElementById("driver_score").innerHTML = driver_score;
        }
    });
}

function getTransferDetailsBasedOnGps()
{
    var gps_id = document.getElementById('gps_id').value;
    var data = { 'gps_id':gps_id };
    var url = '/device-detailed-report/transfer-details';
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            var manufacturer;
            var dealer;
            var subdealer;
            var trader;
            var client;
            (res.root != null) ? manufacturer = res.root.name : manufacturer = "-NA-";
            (res.dealer != null) ? dealer = res.dealer.name : dealer = "-NA-";
            (res.subdealer != null) ? subdealer = res.subdealer.name : subdealer = "-NA-";
            (res.trader != null) ? trader = res.trader.name : trader = "-NA-";
            (res.client != null) ? client = res.client.name : client = "-NA-";
            document.getElementById("manufacturer").innerHTML = manufacturer;
            document.getElementById("dealer").innerHTML = dealer;
            document.getElementById("subdealer").innerHTML = subdealer;
            document.getElementById("trader").innerHTML = trader;
            document.getElementById("client").innerHTML = client;
        }
    });
    getTransferHistoryBasedOnGps();
}

function getTransferHistoryBasedOnGps()
{
    var gps_id = document.getElementById('gps_id').value;
    var data = { 'gps_id':gps_id };
    var url = '/device-detailed-report/transfer-history-details';
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
      
            var transfer_table      = $("#transfer_history").find('tbody');
            var tbody               = "";
            transfer_table.html("");

            $.each(res,function(key , item){ 
                var transfer_log = item.gps_transfer_detail;
                $.each(transfer_log,function(item_key , item_value){ 
                     
                    tbody += (item_value.deleted_at) ?  "<tr style='background:#d98b8b'>" : "<tr style='background:#f5f5f5'>" + 
                                "<td>"+item_value.from_user.username+"</td>"+
                                "<td>"+item_value.to_user.username+"</td>"+
                                "<td>"+item_value.dispatched_on+"</td>"+
                                "<td>"+item_value.accepted_on+"</td>"+
                            "</tr>";
                });     
            });           
            if(res.length == 0)
            {
                tbody = '<td colspan ="4"> No data available</td>';
            }
            transfer_table.html(tbody);
        }
    });
}

function getOwnerDetailsBasedOnGps()
{
    var gps_id = document.getElementById('gps_id').value;
    var data = { 'gps_id':gps_id };
    var url = '/device-detailed-report/end-user-details';
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            var owner_name      = '-NA-';
            var owner_address   = '-NA-';
            var owner_mobile    = '-NA-';
            var owner_email     = '-NA-';
            var owner_country   = '-NA-';
            var owner_state     = '-NA-';
            var owner_city      = '-NA-';
            var owner_package   = '-NA-';
            if(res)
            {
                (res.name) ? owner_name = res.name : owner_name = "-NA-";
                (res.address) ? owner_address = res.address : owner_address = "-NA-";
                (res.user) ? owner_mobile = res.user.mobile : owner_mobile = "-NA-";
                (res.user) ? owner_email = res.user.email : owner_email = "-NA-";
                (res.country) ? owner_country = res.country.name : owner_country = "-NA-";
                (res.state) ? owner_state = res.state.name : owner_state = "-NA-";
                (res.city) ? owner_city = res.city.name : owner_city = "-NA-";
                (res.user) ? owner_package = res.user.role : owner_package = "-NA-";
            }
            document.getElementById("owner_name").innerHTML = owner_name;
            document.getElementById("owner_address").innerHTML = owner_address;
            document.getElementById("owner_mobile").innerHTML = owner_mobile;
            document.getElementById("owner_email").innerHTML = owner_email;
            document.getElementById("owner_country").innerHTML = owner_country;
            document.getElementById("owner_state").innerHTML = owner_state;
            document.getElementById("owner_city").innerHTML = owner_city;
            document.getElementById("owner_package").innerHTML = owner_package;
        }
    });
}

function getInstallationDetailsBasedOnGps()
{
    var gps_id = document.getElementById('gps_id').value;
    var data = { 'gps_id':gps_id };
    var url = '/device-detailed-report/installation-details';
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            var servicer_name       = '-NA-';
            var servicer_address    = '-NA-';
            var servicer_mobile     = '-NA-';
            var servicer_email      = '-NA-';
            var job_date            = '-NA-';
            var job_status          = '-NA-';
            var job_complete_date   = '-NA-';
            var location            = '-NA-';
            var description         = '-NA-';
            var comments            = '-NA-';
            if(Object.keys(res).length != 0)
            {
                (res.servicer) ? servicer_name = res.servicer.name : servicer_name = "-NA-";
                (res.servicer) ? servicer_address = res.servicer.address : servicer_address = "-NA-";
                (res.servicer.user) ? servicer_mobile = res.servicer.user.mobile : servicer_mobile = "-NA-";
                (res.servicer.user) ? servicer_email = res.servicer.user.email : servicer_email = "-NA-";
                (res.job_date) ? job_date = res.job_date : job_date = "-NA-";
                (res.status) ? job_status = res.status : job_status = "-NA-";
                (res.job_complete_date) ? job_complete_date = res.job_complete_date : job_complete_date = "-NA-";
                (res.location) ? location = res.location : location = "-NA-";
                (res.description) ? description = res.description : description = "-NA-";
                (res.comments) ? comments = res.comments : comments = "-NA-";
            }
            document.getElementById("servicer_name").innerHTML = servicer_name;
            document.getElementById("servicer_address").innerHTML = servicer_address;
            document.getElementById("servicer_mobile").innerHTML = servicer_mobile;
            document.getElementById("servicer_email").innerHTML = servicer_email;
            document.getElementById("job_date").innerHTML = job_date;
            document.getElementById("job_status").innerHTML = job_status;
            document.getElementById("job_complete_date").innerHTML = job_complete_date;
            document.getElementById("location").innerHTML = location;
            document.getElementById("description").innerHTML = description;
            document.getElementById("comments").innerHTML = comments;
        }
    });
}

function getServiceDetailsBasedOnGps()
{
    var gps_id = document.getElementById('gps_id').value;
    var data = { 'gps_id':gps_id };
    var url = '/device-detailed-report/services-details';
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            
            var table       = $("#service_details").find('tbody');
            var tbody       = "";
            table.html("");
            var comments;
            $.each(res,function(key , each_data){ 
            if(each_data.status == 1 )
            {
                var status  = 'Pending';
            }
            else if(each_data.status == 2 )
            {
                var status  = 'In Progress';
            }
            else if(each_data.status == 3 )
            {
                var status  =  'Completed';
            }
            else{
                var status  =  '-NA-';
            }
            var servicer_name=(each_data.servicer) ? each_data.servicer.name : "-NA-";
            var servicer_address=(each_data.servicer) ? each_data.servicer.address : "-NA-";
            var servicer_mobile=(each_data.servicer.user) ? each_data.servicer.user.mobile : "-NA-";
            var servicer_email=(each_data.servicer.user) ? each_data.servicer.user.email : "-NA-";
            var job_date=(each_data.job_date) ? each_data.job_date : "-NA-";
            var job_complete_date=(each_data.job_complete_date) ? each_data.job_complete_date : "-NA-";
            var location=(each_data.location) ? each_data.location : "-NA-";
            var description=(each_data.description) ?  each_data.description : "-NA-";
            var comment=(each_data.comments) ? each_data.comments : "-NA-";                
            tbody += "<tr>"+
                            "<td>"+servicer_name+"</td>"+
                            "<td>"+servicer_address +"</td>"+
                            "<td>"+servicer_mobile +"</td>"+
                            "<td>"+servicer_email+"</td>"+
                            "<td>"+job_date +"</td>"+
                            "<td>"+status+"</td>"+
                            "<td>"+job_complete_date+"</td>"+
                            "<td>"+location+"</td>"+
                            "<td>"+description+"</td>"+
                            "<td>"+comment+"</td>"+
                        "</tr>";
            });           
            if(res.length == 0)
            {
                tbody = '<td colspan ="10"> No data available</td>';
            }
            table.html(tbody);
        }
    });
}

function closeConsole()
{
    // workaround to handle padding issue in body tag
    removePaddingFromBody();
    //stop refreshing of console window
    auto_refresh_console = false;
    window.clearInterval(refresh_interval_id);
}

function openConsole(imei)
{
    auto_refresh_console = true;
    //first load of console window
    getRealTimePackets(imei);
    // auto refresh of console window
    refresh_interval_id = setInterval(getRealTimePackets.bind(null, imei), 5000);
}

function getRealTimePackets(imei)
{
    if( auto_refresh_console )
    {
        $("#loading-indicator").removeClass('hide-loading-indicator').addClass('show-loading-indicator');
        var data = { 'imei':imei };
        var url = '/device-detailed-report/get-console';
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                var packets_in_console  = $("#packets_in_console").find('.each_packets');
                var each_packets        = '';
                packets_in_console.html("");
                $.each(res,function(item_key , item_value){ 
                    each_packets +=  '<div class="row"><div class="time">'+item_value.created_at+'</div><div class="col-lg-10">'+item_value.vltdata+'</div></div>';
                });              
                if(res.length == 0)
                {
                    each_packets += 'No data available';
                }
                $(".each_packets").html(each_packets);
                $("#loading-indicator").addClass('hide-loading-indicator').removeClass('show-loading-indicator');
            }
        });
    }
}

function getAlertDetailsBasedOnGps()
{
    var gps_id = document.getElementById('gps_id').value;
    var data = { 'gps_id':gps_id };
    var url = "/device-detailed-report/get-vehicle-id"
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            var alerts_table    = $("#alert_details").find('tbody');
            var tbody           = '';
            alerts_table.html("");
            if(res.length == 0)
            {
                tbody = '<td colspan ="4"> No data available</td>';
            }
            else
            {
                ( res.vehicle ) ? vehicle_id = res.vehicle.id : tbody = '<td colspan ="4"> No data available</td>';
                if(vehicle_id)
                {
                    ( res.vehicle.client_with_trashed ) ? user_id = res.vehicle.client_with_trashed.user_id : tbody = '<td colspan ="4"> No data available</td>';
                    if(user_id)
                    {
                        getMsAlertList();
                        $('body').find("#alert-list-pagination").on("click","a.page-link",function(event){
                            event.preventDefault();
                            $(".loader-1").show();
                            pagination($(this).attr("href"))
                        })
                    }
                }
            }
            alerts_table.html(tbody);
        }
    });
}

function getMsAlertList()
{
    $(".loader-1").show();
    getFilterData();
    var url = url_ms_alerts + "/alert-report";
    ajaxRequestMs(url,filterData,'POST',successAlertList,failedAlertList)
}

function successAlertList(response) 
{
    var table       = $("#alert_details").find('tbody');
    var tbody       = "";
    var alertData   = response.data.alerts;
    var page        = parseInt(response.data.page);
    table.html("");
    $(".loader-1").hide();
    var per_page    = parseInt(response.data.per_page);
    page            = (per_page * page) - per_page;
    $.each(alertData,function(key , alert){    
        page =  page + 1;
        tbody += "<tr>"+
                        "<td>"+page+"</td>"+
                        "<td>"+alert.alert_type.description+"</td>"+
                        "<td>"+alert.device_time+"</td>"+
                        "<td>"+alert.address+"</td>"+       
                    "</tr>";
    });
    if(alertData.length == 0)
    {
        tbody = '<td colspan ="7"> No data available</td>';
    }
    console.log(response.data.total_pages);
    if(response.data.total_pages > 1)
    {
        $('body').find('#alert-list-pagination').html(response.data.link);
    }else{
        $('body').find('#alert-list-pagination').html("");
    }
    
    table.html(tbody);
}

function failedAlertList(error) 
{
    $(".loader-1").hide();
}

function pagination(url)
{
    getFilterData();
    ajaxRequestMs(url,filterData,'POST',successAlertList,failedAlertList)
}

function getFilterData()
{
    filterData.append('user_id',user_id);
    filterData.append('vehicle_id',vehicle_id);
}

function removePaddingFromBody()
{
    setTimeout(function(){
        $('body').removeAttr('style');
    }, 500);      
}