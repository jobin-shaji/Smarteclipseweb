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
var ctx = document.getElementById("rootChart").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: res.gps_month,
      datasets: [{
        label: 'Gps Sale',
        data:res.gps_count,
        backgroundColor:'rgba(242,156,18, 0.2)',
        borderColor:'rgba(242,156,18,1)',
        borderWidth: 1
      }]
    },
    options: {
    title: {
      display: true,
      text: 'GPS SALE'
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
  // console.log(res);
  var ctx = document.getElementById("rootChartUser").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ["Dealers","Sub-dealers","Client"],
      datasets: [{
        label: '#:',
        data:[res.dealer,res.sub_dealer,res.client],
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

 