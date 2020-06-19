$(document).ready(function () {
    
    var url         =   'plan-based-report-chart';
    var plan_type   =   document.getElementById("plan").value;
    var data        =   { 'plan_type':plan_type};
    backgroundPostData(url,data,'planBasedChart',{alert:true});
});

function planBasedChart(res){
    var ctxP = document.getElementById("pieChart").getContext('2d');
    var myChart = new Chart(ctxP, {
        type: 'doughnut',
        data: {
            labels: res.plan_name,
            datasets: [{
                label: '#:',
                data:res.client_count,
                
                backgroundColor: [
                    "rgb(255, 99, 132)", 
                    "rgb(255, 205, 86)",
                    "rgb(75, 192, 192)", 
                    "rgb(54, 162, 235)"
                ],
                borderWidth: 1
            }]
        },
        options : {
            legend: {
                display: true,
                position: 'right',
                labels: {
                    fontSize: 25,
                    padding: 20
                }
            },
        }
    });
}