$(document).ready(function() {
  check();
});

function check(){
   $("#load3").css("display", "none");
   $("#load-3").css("display", "none");
  
  var driver=$('#driver').val();  
    driverBehaviour(driver); 
    score(driver);
}
function score(driver){
     $("#load3").css("display", "none");
     $("#load-3").css("display", "none");
  
    var url = 'driver-score';
    var data = {
      driver:driver
    };    
    backgroundPostData(url, data, 'driverScore', {alert: false});

}
 if (myPolarChart) myPolarChart.destroy();

function driverScore(res) {
      $("#load3").css("display", "none");
      $("#load-3").css("display", "none");
  var ctxPA = document.getElementById("driver-behaviour").getContext('2d');
  
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



