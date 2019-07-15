// -------------------------------------------------------------

$(document).ready(function () { 
     var url = 'root-gps-sale';
     var data = {
   
     };
      backgroundPostData(url,data,'rootGpsSale',{alert:false});

      var url = 'root-gps-user';
     var data = {
   
     };
      backgroundPostData(url,data,'rootGpsUser',{alert:false});
});
// rootGpsSale
function rootGpsSale(res){
  // console.log(res.gps_month);
// $(document).ready(function () {
var ctx = document.getElementById("rootChart").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: res.gps_month,
      datasets: [{
        label: '#:',
        data:[10,50,50,90,70],
        backgroundColor:'rgba(242,156,18, 0.2)',
        borderColor:'rgba(242,156,18,1)',
        borderWidth: 1
      }]
    },
    options: {
    title: {
      display: true,
      text: 'GPS Sale'
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

function rootGpsUser(res){
  console.log(res);
  var ctx = document.getElementById("rootChartUser").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ["Dealers","Sub-dealers","Client"],
      datasets: [{
        label: '#:',
        data:[40,80,50],
        backgroundColor:'rgba(242,156,18, 0.2)',
        borderColor:'rgba(242,156,18,1)',
        borderWidth: 1
      }]
    },
    options: {
    title: {
      display: true,
      text: 'GPS USERS'
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

  // });


// ----------------------------------------------------