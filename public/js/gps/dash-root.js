// -------------------------------------------------------------

$(document).ready(function () { 
  var hasTransfer = document.getElementById("rootChart");
  var hasSale = document.getElementById("rootGpsSaleChart");
  var hasUsers = document.getElementById("rootChartUser");

  if (hasTransfer) {
    backgroundPostData('root-gps-sale', {}, 'rootGpsSale', {alert:true});
  }

  if (hasSale) {
    backgroundPostData('root-gps-client-sale', {}, 'rootGpsClientSale', {alert:true});
  }

  if (hasUsers) {
    backgroundPostData('root-gps-user', {}, 'rootGpsUser', {alert:true});
  }
});
// rootGpsSale
function rootGpsSale(res){
var canvas = document.getElementById("rootChart");
if(!canvas){
  return;
}
var ctx = canvas.getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: res.gps_month,
      datasets: [{
        label: 'GPS Transfer',
        data:res.gps_count,
        backgroundColor:'rgba(245, 186, 110 )',
        borderColor:'rgba(242, 143, 16)',
        borderWidth: 1
      }]
    },
    options: {
    title: {
      display: true,
      text: 'GPS TRANSFER'
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
  var canvas = document.getElementById("rootChartUser");
  if(!canvas){
    return;
  }
  var ctx = canvas.getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ["Active Distributors","Active Dealers","Active Clients"],
      datasets: [{
        label: '#:',
        data:[res.dealer,res.sub_dealer,res.client],

        backgroundColor: [
                'rgba( 109, 193, 241, 1)',
                'rgba( 246, 156, 53, 1)',
                'rgba( 241, 62, 38 , 1)'

                
            ],
            borderColor: [
                'rgba(109, 193, 241, 2)',
                'rgba(246, 156, 53, 2)',
                'rgba(241, 62, 38, 2)'
               
            ],
        borderWidth: 1
      }]
    },
    options: {
    title: {
      display: true,
      text: 'GPS USERS'
    },
      scales: {
        // yAxes: [{
        //   ticks: {
        //     // beginAtZero: true,
        //     display: false
        //   }
        // }],
        // xAxes: [{
        //     gridLines: {
        //      display: false
        //     },
        // }]
      }
    }
  });
}

 function rootGpsClientSale(res){
  console.log(res);
  var canvas = document.getElementById("rootGpsSaleChart");
  if(!canvas){
    return;
  }
  var ctx = canvas.getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: res.gps_month,
      datasets: [{
        label: 'GPS Sale',
        data:res.gps_count,
        backgroundColor:'rgba(245, 186, 110 )',
        borderColor:'rgba(242, 143, 16)',
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
