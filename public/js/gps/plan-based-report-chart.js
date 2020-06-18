$(document).ready(function () {
    
    var url         =   'plan-based-report-chart';
    var plan_type   =   document.getElementById("plan").value;
    var data        =   { 'plan_type':plan_type};
    backgroundPostData(url,data,'planBasedChart',{alert:true});
});

function planBasedChart(res){
    var ctxP = document.getElementById("pieChart").getContext('2d');
    var myChart = new Chart(ctxP, {
        type: 'pie',
        data: {
            labels: res.plan_name,
            datasets: [{
                label: '#:',
                data:res.client_count,
                backgroundColor: [
                    "#f38b4a",
                    "#56d798",
                    "#ff8397",
                    "#6970d5"
                    ],
                borderWidth: 1
            }]
        }
    });
}