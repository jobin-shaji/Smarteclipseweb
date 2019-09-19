// -------------------------------------------------------------
// $(document).ready(function () {

  $(document).ready(function () { 
     var url = 'sub-dealer-gps-sale';
     var data = {
   
     };
      backgroundPostData(url,data,'subDealerGpsSale',{alert:true});
       var url = 'sub-dealer-gps-user';
     var data = {   
     };
      backgroundPostData(url,data,'subDealerGpsUser',{alert:true});
     
});
function subDealerGpsSale(res)
{
  
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
function subDealerGpsUser(res)
{ 
  // console.log(res);
  var ctx = document.getElementById("rootChartUser").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: res.client,
      datasets: [{
        label: '#:',
       data:res.gps_count,
        backgroundColor:'rgba(242,156,18, 0.2)',
        borderColor:'rgba(242,156,18,1)',
        borderWidth: 1
      }]
    },
    options: {
    title: {
      display: true,
      text: ' Users Vehicle'
    },
      scales: {
      //   yAxes: [{
      //     ticks: {
      //       beginAtZero: true
      //     }
      //   }]
      }
    }
  });
}
  // });


// ----------------------------------------------------