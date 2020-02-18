function AlertNotification()
{
    this.user_id                    =   notify.user_id;
    this.alert_notification_wrapper =   $('body').find('#notification');
    this.selected_key               = '';
}

AlertNotification.prototype.getAllAlertNotifications = function(){
    firebase.database().ref(alert_notify.user_id+'/notifications/')
    .orderByChild('created_at')
    .on('value' , function(notifications){
        var alert_array =   [];
        notifications.forEach(function (childNotification)
        {
            var item    =   childNotification.val();
            item.key    = childNotification.key;
            alert_array.push(item);
        });
        alert_notify.displayAllAlertNotifications(alert_array.reverse());
    });
}

AlertNotification.prototype.displayAllAlertNotifications = function(notifications)
{
    alert_notify.alert_notification_wrapper.html("")
    if(notifications.length > 0){
        $.each(notifications, function( index, value ) {
            var register_number = value.vehicle_registration_number;
            var vehicle_name    = value.vehicle_name;
            var alert           = value.type;
            var device_time     = value.device_time;
            var id              = value.id;
            var key             = value.key;
            var is_read             = value.is_read;

            if(value.is_read == 1) // verified alerts
            {
                var alert_content=' <div class="item active-read psudo-link verify_alert_notification" id="alert" data-toggle="modal" data-key ="'+key+'" data-id ="'+id+'" data-is_read ="'+is_read+'"  data-target="#clickedModelInDetailPage">'+  
                                    '<div class="not-icon-bg">'+
                                    '<img src="images/bell.svg"/>'+
                                    '</div>'+
                                    '<div class="deatils-bx-rt">'+
                                    '<div class="vech-no-out">'+
                                    '<div class="vech-no">'+
                                    vehicle_name+'<span>('+register_number+')</span>'+
                                    '</div>'+
                                    '<div class="ash-time">'+alert+'</div>'+
                                    '</div>'+
                                    '<div class="run-date">'+device_time+'</div>'+
                                    '</div>'+
                                    '</div>  ';   
            }
            if(value.is_read == 0) // not verified alerts
            {
                var alert_content=' <div class="item active-read alert psudo-link verify_alert_notification" data-toggle="modal" data-key ="'+key+'" data-id ="'+id+'" data-is_read ="'+is_read+'"  data-target="#clickedModelInDetailPage"  >'+  
                                    '<div class="not-icon-bg" >'+
                                    '<img src="/images/bell.svg"/>'+
                                    '</div>'+
                                    '<div class="deatils-bx-rt">'+
                                    '<div class="vech-no">'+
                                    '<div class="vech">'+
                                    vehicle_name+'<span>('+register_number+')</span>'+
                                    '</div>'+
                                    '<div class="ash-time">'+alert+'</div>'+
                                    '</div>'+
                                    '<div class="run-date">'+device_time+'</div>'+
                                    '</div>'+
                                    '</div>';    
            }
            
            alert_notify.alert_notification_wrapper.append(alert_content)
        });
    }else{
        var alert_content = ' <div class="item active-read psudo-link"  data-toggle="modal">No alerts found'+'</div>';
        alert_notify.alert_notification_wrapper.append(alert_content)
    }
}

AlertNotification.prototype.markDatabaseNotificationAsRead = function(alert_id)
{
    var url = 'gps-alert-tracker';
    var data={
      id:alert_id   
    }
    notify.ajaxCall(url,data,alert_notify.successMethodAsRead,alert_notify.errorMethod);

}

AlertNotification.prototype.successMethodAsRead = function(response)
{
    $('.model_label').empty();
    if(response.status  ==  1)
    {
        var latitude;
        var longitude;
        var key =   alert_notify.selected_key;
        firebase.database().ref(alert_notify.user_id+'/notifications/'+key)
        .orderByChild('created_at').on('value' , function(single_notifications){
            latitude    =   parseFloat(single_notifications.val().latitude);
            longitude   =   parseFloat(single_notifications.val().longitude);
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 17,
                center: {lat: latitude, lng: longitude},
                mapTypeId: 'terrain'
            });
            $.ajax({
                url     :'https://maps.googleapis.com/maps/api/geocode/json?latlng='+latitude+','+longitude+'&sensor=false&key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap',
                method  :"get",
                async   :true,
                context :this,
                success : function (Result) {
                    alert_notify.displayAlertDetailsInModel(single_notifications,response.address);
                }
            });     
            var alertMap = {
                alerttype: {
                    center: {lat: latitude, lng: longitude},               
                }
            };
            for (var alert in alertMap) {
                var cityCircle = new google.maps.Circle({
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#FF0000',
                    fillOpacity: 0.35,
                    map: map,
                    center: alertMap[alert].center
                });
            }
            var marker = new google.maps.Marker({
                position:  alertMap[alert].center,
                map: map
            });
        });
    }
    alert_notify.selected_key   =   '';
}

AlertNotification.prototype.displayAlertDetailsInModel = function(response,address)
{
    $('#address').text(address);
    $('#vehicle_name').text(response.val().vehicle_name);
    $('#register_number').text(response.val().vehicle_registration_number);
    $('#description').text(response.val().type);
    $('#device_time').text(response.val().device_time);
}

AlertNotification.prototype.errorMethod = function(response){
    console.log(error)
}

//to create object for function calling
var alert_notify = new AlertNotification();

$(function(){
    alert_notify.getAllAlertNotifications();

    $('body').on('click','.verify_alert_notification',function(){
        var alert_id = $(this).data("id");
        var key = $(this).data("key");
        var is_read = $(this).data("is_read");
        if(is_read == 0){
            notify.markFirebaseNotificationAsRead(alert_id);
        }
        alert_notify.selected_key = key;
        alert_notify.markDatabaseNotificationAsRead(alert_id);
    });
  
});

var latitude= parseFloat(document.getElementById('lat').value);
var longitude= parseFloat(document.getElementById('lng').value); 
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 17,
        fullscreenControl: false,
        center: {lat: latitude, lng: longitude},
        mapTypeId: 'terrain'
    });
}
