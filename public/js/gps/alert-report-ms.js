var filterData = [];
var user_id    = $("#user_id").val();

function getMsAlerts()
{
    getFilterData();
    var url = url_ms_alerts + "/alert-report";
    ajaxRequestMs(url,filterData,'POST',successAlertFilter,failedAlertFilter)
}

function successAlertFilter(response) 
{
    var table       = $(".alert-report-table").find('tbody');
    var tbody       = "";
    var alertData   = response.data.alerts;
    var page        = parseInt(response.data.page);
    table.html("");
    $(".loader-1").hide();
    var per_page    = parseInt(response.data.per_page);
    page = (per_page *page) - per_page;
    showTable();
    $.each(alertData,function(key , alert){ 
        page =  page + 1; 
        tbody += "<tr>"+
                        "<td>"+page+"</td>"+
                        "<td>"+alert.gps.connected_vehicle_name+"</td>"+
                        "<td>"+alert.address+"</td>"+
                        "<td>"+alert.gps.connected_vehicle_registration_number+"</td>"+
                        "<td>"+alert.alert_type.description+"</td>"+
                        "<td>"+alert.device_time+"</td>"+
                        "<td> <a href='/alert/report/"+alert._id+"/map_view' class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a></td>"+        

                    "</tr>";

    });
    if(alertData.length == 0)
    {
        tbody = '<td colspan ="7"> No data available</td>';
        hideDownloadBtn()

    }
    if(response.data.total_pages > 1)
    {
        $('body').find('#alert-report-pagination').html(response.data.link);
    }else{
        $('body').find('#alert-report-pagination').html("");
    }
    
    table.html(tbody);
}


function failedAlertFilter(error) 
{
    $(".loader-1").hide();
}
function showTable() 
{
    $(".alert-report-table").show();    
    $(".download-btn").show();
}

function hideDownloadBtn() 
{
    $(".download-btn").hide();
}

function pagination(url)
{
    getFilterData();
    ajaxRequestMs(url,filterData,'POST',successAlertFilter,failedAlertFilter)
}

function getFilterData() 
{
    var form = $("#form-alert-report")[0];
    filterData = new FormData(form);
    filterData.append("user_id",user_id); 
}

function getAlertFromMicroService()
{
    var ms_alert_id    = $("#ms_alert_id").val();
    var url = url_ms_alerts + "/get-alert-by-id/"+ms_alert_id;
    ajaxRequestMs(url,{},'POST',displayMap,failedMapLoad)   
}


function failedMapLoad(error) 
{
    console.log(error);
    $(".loader-1").hide();
}

function displayMap(response) 
{
    var latitude            = parseFloat(response.data.latitude);
    var longitude           = parseFloat(response.data.longitude);
    var address             = response.data.address;
    var vehicle_name        = response.data.gps.connected_vehicle_name	;
    var alert_description   = response.data.alert_type.description;
    var alert_icon          = response.data.alert_type.icon;
    var map = new google.maps.Map(document.getElementById('tracker-map'), {
        zoom: 17,
        center: {lat: latitude, lng: longitude},
        mapTypeId: 'terrain'
    });
    var alertMap = {
        alert_type: {
            center: {lat: latitude, lng: longitude},               
        }
    };
    for (var alert in alertMap) 
    {
        var cityCircle = new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: map,
        center: alertMap[alert].center,
        radius: 100
        });
    }
    var marker = new google.maps.Marker({
        position:  alertMap[alert].center,
        map: map
    });
    addMarker()
    
    function addMarker()
    {
        var title ='<div id="content" style="width:150px;">' +
        '<div style="background-color:#FF8C00; color:#fff;font-weight:600"><span style="padding:30px ;">Alert Map</span></div>'+  
        '<div style="padding-top:5px;"><i class="fa fa-car"></i> '+vehicle_name+'</div>'+ 
        '<div style="padding-top:5px;"><i class="fa fa-bell-o"></i> '+alert_description+'</div>'+ 
        '<div style="padding-top:5px;"><i class="fa fa-map-marker"></i> '+address+'</div>'+ 
        '</div>'; 
        var info_window = new google.maps.InfoWindow();
        google.maps.event.addListener(marker, 'mouseover', function() {
            info_window.setContent(title);
            info_window.open(map, this);
        });
    }
}

function downloadAlertMsReport() 
{
    var url = 'alert-report/export';
    var data = {
            user_id     : user_id,
            alert_type  : $('#alert_type').val(),
            vehicle_id  : $('#vehicle_id').val(),
            start_date  : $('#fromDate').val(),
            end_date    : $('#toDate').val(),
    };
    downloadFile(url,data);
}



$(function(){
   
    $("#form-alert-report").submit(function(event){
        event.preventDefault();
        $(".loader-1").show();
        getMsAlerts();
    })

    $('body').find("#alert-report-pagination").on("click","a.page-link",function(event){
        event.preventDefault();
        $(".loader-1").show();
        pagination($(this).attr("href"))

    })

   

    
});
