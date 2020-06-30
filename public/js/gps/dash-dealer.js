// -------------------------------------------------------------
$(document).ready(function () { 
     var url = 'dealer-gps-sale';
     var data = {
   
     };
    backgroundPostData(url,data,'dealerGpsSale',{alert:true});
    var url = 'dealer-gps-client-sale';
    var data = {  
    };
    backgroundPostData(url,data,'dealerGpsClientSale',{alert:true});
    var url = 'dealer-gps-user';
     var data = {   
     };
      backgroundPostData(url,data,'dealerGpsUser',{alert:true});
     
});
function dealerGpsSale(res)
{
  // console.log(res);
  // $(document).ready(function () {
var ctx = document.getElementById("rootChart").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
     labels: res.gps_month,
      datasets: [{
        label: "GPS Transfer",
        data:res.gps_count,
        backgroundColor:'rgba(245, 186, 110)',
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
function dealerGpsUser(res){
  var ctx = document.getElementById("rootChartUser").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ["Active Dealers","Active Sub Dealers","Active Clients"],
      datasets: [{
        label: '#:',
       data:[res.sub_dealer,res.trader,res.client],
         backgroundColor: [
                'rgba(246, 156, 53, 1)',
                'rgba( 109, 193, 241, 1)',
                'rgba(241, 62, 38 , 1)'
            ],
            borderColor: [
                'rgba(246, 156, 53, 2)',
                'rgba( 109, 193, 241, 1)',
                'rgba(241, 62, 38 , 2)'
            ],
        borderWidth: 1
      }]
    },
    options: {
    title: {
      display: true,
      text: 'GPS User'
    },
      scales: {
        // yAxes: [{
        //   ticks: {
        //     beginAtZero: true
        //   }
        // }]
      }
    }
  });
}
  // });
function dealerGpsClientSale(res){
  console.log(res);
var ctx = document.getElementById("rootGpsSaleChart").getContext('2d');
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


// ----------------------------------------------------