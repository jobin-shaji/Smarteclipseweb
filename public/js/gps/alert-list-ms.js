var user_id    =   $("#user_id").val();
var vehicle_id =   $('#vehicle_id').val();
var filterData = new FormData();
var from_date  = 30; // get last 30 days alert

function getMsAlertList()
{
    $(".loader-1").show();
    getFilterData();
    var url = url_ms_alerts + "/alert-report";
    ajaxRequestMs(url,filterData,'POST',successAlertList,failedAlertList)
}

function successAlertList(response) 
{
    var table       = $(".alert-list-table").find('tbody');
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
    }
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

function getFilterData()
{
    var today = new Date();
    var end_date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    today.setDate(today.getDate() - from_date);
    var start_date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    filterData.append('user_id',user_id);
    filterData.append('vehicle_id',vehicle_id);
    filterData.append('start_date',start_date);
    filterData.append('end_date',end_date);
}


function pagination(url)
{
    getFilterData();
    ajaxRequestMs(url,filterData,'POST',successAlertList,failedAlertList)
}

$(function()
{
    getMsAlertList();
    $('body').find("#alert-list-pagination").on("click","a.page-link",function(event){
        event.preventDefault();
        $(".loader-1").show();
        pagination($(this).attr("href"))

    })
});
