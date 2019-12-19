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
  "#f38b4a",
          "#56d798",
          "#ff8397",
          "#6970d5"
  ],
  hoverBackgroundColor: [],
  borderColor: []
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



