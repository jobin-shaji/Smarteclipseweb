var filterData = [];
var user_id    = $("#user_id").val();

function getMsGeofenceAlerts()
{
    getFilterData();
    var url = url_ms_alerts + "/alert-report";
    ajaxRequestMs(url,filterData,'POST',successGeofenceAlertFilter,failedGeofenceAlertFilter)
}

function successGeofenceAlertFilter(response) 
{
    var table       = $(".geo-fence-report-table").find('tbody');
    var tbody       = "";
    var alertData   = response.data.alerts;
    var page        = parseInt(response.data.page);
    table.html("");
    $(".loader-1").hide();
    $.each(alertData,function(key , alert){    
        tbody += "<tr>"+
                        "<td>"+page+"</td>"+
                        "<td>"+alert.gps.connected_vehicle_name+"</td>"+
                        "<td>"+alert.address+"</td>"+
                        "<td>"+alert.gps.connected_vehicle_registration_number+"</td>"+
                        "<td>"+alert.alert_type.description+"</td>"+
                        "<td>"+alert.device_time+"</td>"+                        
                        "<td> <a href='/alert/report/"+alert._id+"/map_view' class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a></td>"+        
                    "</tr>";
        page =  page + 1;
        showTable();
    });
    if(alertData.length == 0)
    {
        tbody = '<td colspan ="7"> No data available</td>';
        hideDownloadBtn()
    }
    if(response.data.total_pages > 1)
    {
        $('body').find('#giofence-report-pagination').html(response.data.link);
    }else{
        $('body').find('#giofence-report-pagination').html("");
    }
    
    table.html(tbody);
}

function failedGeofenceAlertFilter(error) 
{
    $(".loader-1").hide();
}

function showTable() 
{
    $(".geo-fence-report-table").show();    
    $(".download-btn").show();
}

function hideDownloadBtn() 
{
    $(".download-btn").hide();
}

function pagination(url)
{
    getFilterData();
    ajaxRequestMs(url,filterData,'POST',successGeofenceAlertFilter,failedGeofenceAlertFilter)
}

function getFilterData() 
{
    var form = $("#form-giofence-report")[0];
    filterData = new FormData(form);
    filterData.append("user_id",user_id); 
    filterData.append("alert_type[]",18); 
    filterData.append("alert_type[]",19); 
}

function downloadAlertMsReport() 
{
    var url = 'geofence-report/export';
    var data = {
            user_id     : user_id,
            vehicle_id  : $('#vehicle_id').val(),
            start_date  : $('#fromDate').val(),
            end_date    : $('#toDate').val(),
    };
    downloadFile(url,data);
}

$(function(){
   
    $("#form-giofence-report").submit(function(event){
        event.preventDefault();
        $(".loader-1").show();
        getMsGeofenceAlerts();
    })

    $('body').find("#giofence-report-pagination").on("click","a.page-link",function(event){
        event.preventDefault();
        $(".loader-1").show();
        pagination($(this).attr("href"))

    })

});
