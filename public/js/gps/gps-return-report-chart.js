$(document).ready(function () { 
    var url         =   'root-gps-return-chart';
    var from_date   =   document.getElementById("from_date").value;
    var to_date     =   document.getElementById("to_date").value;
    var data        =   { 'from_date':from_date,'to_date':to_date};
    backgroundPostData(url,data,'returnedGpsManufacturedChart',{alert:true});
});

function returnedGpsManufacturedChart(res){
    var ctx = document.getElementById("deviceChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: res.manufacturing_date,
            datasets: [{
                label: '#:',
                data:res.device_count,
                backgroundColor: [
                    "#f38b4a",
                    "#56d798",
                    "#ff8397",
                    "#6970d5",
                    "#CD5C5C",
                    "#FFFF00",
                    "#808000",
                    "#800000",
                    "#00FF00",
                    "#008000",
                    "#00FFFF",
                    "#008080",
                    "#0000FF",
                    "#FF00FF",
                    "#8080ff",
                    "#ff751a",
                    "#ff4d4d",
                    "#d27979",
                    "#ff7733",
                    "#ffad33",
                    "#ffff1a",
                    "#ace600",
                    "#ff3385",
                    "#ff4dff",
                    "#4d4d00",
                    "#cccc00",
                    "#66ccff",
                    "#6666ff",
                    "#666699",
                    "#ccccff"
                    ],
                borderWidth: 1
            }]
        }
    });
}