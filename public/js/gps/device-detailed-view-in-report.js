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
            var vehicle_name;
            var vehicle_registration_number;
            var vehicle_category;
            var engine_number;
            var chassis_number;
            var driver_name;
            var driver_address;
            var driver_mobile;
            (res.vehicle_details.name) ? vehicle_name = res.vehicle_details.name : vehicle_name = "-NA-";
            (res.vehicle_details.register_number) ? vehicle_registration_number = res.vehicle_details.register_number : vehicle_registration_number = "-NA-";
            (res.vehicle_details.vehicle_type) ? vehicle_category = res.vehicle_details.vehicle_type.name : vehicle_category = "-NA-";
            (res.vehicle_details.engine_number) ? engine_number = res.vehicle_details.engine_number : engine_number = "-NA-";
            (res.vehicle_details.chassis_number) ? chassis_number = res.vehicle_details.chassis_number : chassis_number = "-NA-";
            (res.driver_details.name) ? driver_name = res.driver_details.name : driver_name = "-NA-";
            (res.driver_details.address) ? driver_address = res.driver_details.address : driver_address = "-NA-";
            (res.driver_details.mobile) ? driver_mobile = res.driver_details.mobile : driver_mobile = "-NA-";
            document.getElementById("vehicle_name").innerHTML = vehicle_name;
            document.getElementById("vehicle_registration_number").innerHTML = vehicle_registration_number;
            document.getElementById("vehicle_category").innerHTML = vehicle_category;
            document.getElementById("engine_number").innerHTML = engine_number;
            document.getElementById("chassis_number").innerHTML = chassis_number;
            document.getElementById("driver_name").innerHTML = driver_name;
            document.getElementById("driver_address").innerHTML = driver_address;
            document.getElementById("driver_mobile").innerHTML = driver_mobile;
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
            var owner_name;
            var owner_address;
            var owner_mobile;
            var owner_email;
            var owner_country;
            var owner_state;
            var owner_city;
            var owner_package;
            (res.name) ? owner_name = res.name : owner_name = "-NA-";
            (res.address) ? owner_address = res.address : owner_address = "-NA-";
            (res.user) ? owner_mobile = res.user.mobile : owner_mobile = "-NA-";
            (res.user) ? owner_email = res.user.email : owner_email = "-NA-";
            (res.country) ? owner_country = res.country.name : owner_country = "-NA-";
            (res.state) ? owner_state = res.state.name : owner_state = "-NA-";
            (res.city) ? owner_city = res.city.name : owner_city = "-NA-";
            (res.user) ? owner_package = res.user.role : owner_package = "-NA-";
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
            var servicer_name;
            var servicer_address;
            var servicer_mobile;
            var servicer_email;
            var job_date;
            var job_status;
            var job_complete_date;
            var location;
            var description;
            var comments;
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
            console.log(res);
            var table       = $("#service_details").find('tbody');
            var tbody       = "";
            $.each(res,function(key , each_data){ 
                tbody += "<tr>"+
                                "<td>"+(each_data.servicer) ? res.servicer.name : "-NA-"+"</td>"+
                                "<td>"+(each_data.servicer) ? res.servicer.address : "-NA-"+"</td>"+
                                "<td>"+(each_data.servicer.user) ? res.servicer.user.mobile : "-NA-"+"</td>"+
                                "<td>"+(each_data.servicer.user) ? res.servicer.user.email : "-NA-"+"</td>"+
                                "<td>"+(res.job_date) ? res.job_date : "-NA-"+"</td>"+
                                "<td>"+(res.status) ? res.status : "-NA-"+"</td>"+
                                "<td>"+(res.job_complete_date) ? res.job_complete_date : "-NA-"+"</td>"+
                                "<td>"+(res.location) ? res.location : "-NA-"+"</td>"+
                                "<td>"+(res.description) ?  res.description : "-NA-"+"</td>"+
                                "<td>"+(res.comments) ? res.comments : "-NA-"+"</td>"+
                            "</tr>";
            });
            if(res.length == 0)
            {
                tbody = '<td colspan ="10"> No data available</td>';
            }
        }
    });
}