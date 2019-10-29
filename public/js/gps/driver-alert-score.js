$(document).ready(function() {
 var url = 'driver-score-alerts';
 var data = {

 };
 backgroundPostData(url, data, 'driverScoreAlerts', {alert: false});
});


function driverScoreAlerts(res) {
  //console.log(res);
  var ctxL = document.getElementById("driver-behaviour-alerts").getContext('2d');
  var myLineChart = new Chart(ctxL, {
  type: 'line',
  data: {
  labels: ["Harsh breaking", "Over speed", "Tilt", "Impact", "Overspeed+GF Entry", "Overspeed+GF Exit"],
  datasets: res
  },
  options: {
  responsive: true
  }
  });
}


//line
// var ctxL = document.getElementById("lineChart").getContext('2d');
// var myLineChart = new Chart(ctxL, {
// type: 'line',
// data: {
// labels: ["January", "February", "March", "April", "May", "June", "July"],
// datasets: [{
// label: "My First dataset",
// data: [65, 59, 80, 81, 56, 55, 40],
// backgroundColor: [
// 'rgba(105, 0, 132, .2)',
// ],
// borderColor: [
// 'rgba(200, 99, 132, .7)',
// ],
// borderWidth: 2
// }
// ]
// },
// options: {
// responsive: true
// }
// });



