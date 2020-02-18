function Notification(){
   
    this.user_id                = $("#user_id").val();
    this.notify_count           = 0;
    this.notification_count     = $('body').find('#bell_notification_count');
    this.alert_notification     = $('body').find('#alert_notification');
}

Notification.prototype.getNotificationCount = function(){
    firebase.database().ref(notify.user_id+'/notifications/')
    .orderByChild('created_at')
    .on('value', function(notifications) {
        var notification_count  = 0;
        notifications.forEach(function(childNotification) {
            var item = childNotification.val();
            if(item.is_read == 0)
            {
                notification_count++;
            }
        });
        notify.notification_count.html(notification_count)
   });
}

Notification.prototype.getNotifications = function(){
    firebase.database().ref(notify.user_id+'/notifications/')
    .orderByChild('created_at').limitToLast(5)
    .on('value', function(notifications) {
          var notify_array = [];
          notifications.forEach(function(childNotification) {
              var item = childNotification.val();
              if(item.is_read == 0)
              {
                  item.key = childNotification.key;
                  notify_array.push(item);
              }
          });
          notify.displayNotifications(notify_array.reverse());
   });
}

Notification.prototype.displayNotifications= function(notifications){
    notify.alert_notification.html("")


    if(notifications.length > 0){
        $.each(notifications, function( index, value ) {
            var theDate = new Date(value.created_at * 1000);
            dateString  = theDate.toGMTString();
            //  $("#alert_notification").append('<div class="dropdown-item psudo-link"  data-toggle="modal"  data-target="#myModal3" onclick="gpsAlertUpdate('+res.alert[i].id+')">'+res.alert[i].alert_type.description+'<br>('+res.alert[i].vehicle.register_number+')</div>');       

            notify.alert_notification.append('<div class="dropdown-item psudo-link notification-item" data-toggle="modal" data-target="#myModal3" data-id= "'+value.id+'" data-key= "'+value.key+'" >'+value.type+'<br>('+value.vehicle_registration_number+' )</div>')
        });
    }else{
        notify.alert_notification.append('<div class="dropdown-item" >No alerts found</div>');
    }


    
 }


Notification.prototype.markFirebaseNotificationAsRead = function(alert_id)
{
    var key = $("[data-id*='"+alert_id+"']").data("key");
    firebase.database().ref(notify.user_id+'/notifications/'+key).update({"is_read": "1"})
}

Notification.prototype.markDatabaseNotificationAsRead = function(alert_id)
{
    $("#load2").css("display", "block");
    var url     = 'gps-alert-update';
    var data    = {  id:alert_id }
    notify.ajaxCall(url,data,notify.successMethodAsRead,notify.errorMethod);
}

Notification.prototype.successMethodAsRead = function(response)
{
    $("#load-2").css("display", "none");
    $('#alert_'+response.alertmap.id).removeClass('alert');
    var alert_content = response.alert_icon.description+' on vehicle '+response.get_vehicle.name+'('+response.get_vehicle.register_number+') at '+response.alertmap.device_time;
    $('#alert_content').text(alert_content);
    $('#alert_address').text(response.address);

}

Notification.prototype.errorMethod = function(error)
{
    console.log(error)
}


Notification.prototype.ajaxCall = function(url,data,successCallBack,errorCallBack)
{
    var purl = getUrl() + '/'+url ;
    var defaults = {
        type: 'POST',
        alert: false
    };
    $.ajax({
        type: defaults.type,
        url:  purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            return successCallBack(response)
        },
        error: function (error) {
            return errorCallBack(error)
        }
    })


}

Notification.prototype.notificationItemClicked= function(alert_id)
{
    notify.markDatabaseNotificationAsRead(alert_id);
    notify.markFirebaseNotificationAsRead(alert_id);
}


 var notify = new Notification();


$(function(){
    firebase.initializeApp(firebaseConfig);
    notify.getNotificationCount();
    notify.getNotifications();

    $('body').on("click",".notification-item",function(){
        var alert_id = $(this).data("id");
        notify.notificationItemClicked(alert_id);
    })
});

