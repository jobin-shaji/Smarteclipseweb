$(document).ready(function() {
 var url = 'driver-score';
 var data = {

 };
 backgroundPostData(url, data, 'driverScore', {alert: false});
});

function driverScore(res) {
    var ctx = document.getElementById("driver-behaviour").getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: res.drive_data,
      datasets: [{
      label: '# Score',
      data: res.drive_score,
      backgroundColor: 'rgba(242,156,18, 0.2)',
      borderColor: 'rgba(242,156,18,1)',
      borderWidth: 1
     }]
    },
    options: {
     title: {
      display: true,
      text: 'Driver Score'
     },
     scales: {
      yAxes: [{
       ticks: {
        beginAtZero: true
       }
      }]
     }
    }
   });
}


