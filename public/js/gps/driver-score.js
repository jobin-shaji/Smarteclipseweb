$(document).ready(function() {
  check();
});

function check(){
  var driver=$('#driver').val();  
    driverBehaviour(driver); 
    score(driver);
}
function score(driver){
  $("#loader-1").show();
    var url = 'driver-score';
    var data = {
      driver:driver
    };    
    backgroundPostData(url, data, 'driverScore', {alert: false});

}
 if (myPolarChart) myPolarChart.destroy();

function driverScore(res) {
// console.log(res.drive_score);
  var ctxPA = document.getElementById("driver-behaviour").getContext('2d');
  $("#loader-1").show();
  var myPolarChart = new Chart(ctxPA, {
  type: 'polarArea',
  data: {
  labels: res.drive_data,
  datasets: [{
  data: res.drive_score,
  backgroundColor: [
    'rgba(255, 99, 132, 0.2)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(255, 159, 64, 0.2)',
    'rgba(255, 99, 132, 0.2)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(255, 159, 64, 0.2)'
    ],
  hoverBackgroundColor: [
    'rgba(255,99,132,1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)',
    'rgba(255,99,132,1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)'
    ],
  borderColor: [
    'rgba(255,99,132,1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)',
    'rgba(255,99,132,1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)'
    ]
  }],
  borderWidth : 2
  },
  options: {
  responsive: true
  }
  });
}
function driverBehaviour(driver){
    var url = 'driver-score-alerts';
    var data = {
      driver:driver
    };
    backgroundPostData(url, data, 'driverScoreAlerts', {alert: false});
  }


function driverScoreAlerts(res) {
  var ctxL = document.getElementById("driver-behaviour-alerts").getContext('2d');
  var myLineChart = new Chart(ctxL, {
  type: 'line',
  data: {
  labels: ["Harsh break", "Overspeed", "Tilt", "Impact", "OS+GF Entry", "OS+GF Exit"],
  datasets: res
  },
  options: {
  responsive: true,
  scales: {
    xAxes: [{
      scaleLabel: {
        display: true,
        labelString: 'Alert Type'
      }
    }],
    yAxes: [{
      scaleLabel: {
        display: true,
        labelString: 'Count'
      }
    }]
  } 
  }
  });
}



