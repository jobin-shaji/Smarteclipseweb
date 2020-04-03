var filterData = [];
var user_id    = $("#user_id").val();

function getMsMainbatteryDisconnectAlerts()
{
    getFilterData();
    var url = url_ms_alerts + "/alert-report";
    ajaxRequestMs(url,filterData,'POST',successMainBatteryDisconnectAlertFilter,failedMainBatteryDisconnectAlertFilter)
}

function successMainBatteryDisconnectAlertFilter(response) 
{
    var table       = $(".mainbattery-disconnect-report-table").find('tbody');
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
                        "<td>"+alert.device_time+"</td>"+
                        "<td> <a href='/alert/report/"+alert._id+"/map_view' class='btn btn-xs btn-info'><i class='glyphicon glyphicon-map-marker'></i> Map view </a></td>"+        
                    "</tr>";
    });
    if(alertData.length == 0)
    {
        tbody = '<td colspan ="6"> No data available</td>';
        hideDownloadBtn()
    }
    if(response.data.total_pages > 1)
    {
        $('body').find('#mainbattery-disconnect-report-pagination').html(response.data.link);
    }else{
        $('body').find('#mainbattery-disconnect-report-pagination').html("");
    }
    
    table.html(tbody);
}

function failedMainBatteryDisconnectAlertFilter(error) 
{
    $(".loader-1").hide();
}

function showTable() 
{
    $(".mainbattery-disconnect-report-table").show();    
    $(".download-btn").show();
}

function hideDownloadBtn() 
{
    $(".download-btn").hide();
}

function pagination(url)
{
    getFilterData();
    ajaxRequestMs(url,filterData,'POST',successMainBatteryDisconnectAlertFilter,failedMainBatteryDisconnectAlertFilter)
}

function getFilterData() 
{
    var form = $("#form-mainbattery-disconnect-report")[0];
    filterData = new FormData(form);
    filterData.append("user_id",user_id); 
    filterData.append("alert_type","23"); 
}

function downloadAlertMsReport() 
{
    var url = 'main-battery-disconnect-report/export';
    var data = {
            user_id     : user_id,
            vehicle_id  : $('#vehicle_id').val(),
            start_date  : $('#fromDate').val(),
            end_date    : $('#toDate').val(),
    };
    downloadFile(url,data);
}

$(function(){
   
    $("#form-mainbattery-disconnect-report").submit(function(event){
        event.preventDefault();
        $(".loader-1").show();
        getMsMainbatteryDisconnectAlerts();
    })

    $('body').find("#mainbattery-disconnect-report-pagination").on("click","a.page-link",function(event){
        event.preventDefault();
        $(".loader-1").show();
        pagination($(this).attr("href"))

    })

});
