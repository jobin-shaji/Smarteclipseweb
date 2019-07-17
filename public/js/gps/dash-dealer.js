// -------------------------------------------------------------
$(document).ready(function () { 
     var url = 'dealer-gps-sale';
     var data = {
   
     };
      backgroundPostData(url,data,'dealerGpsSale',{alert:false});
      
    var url = 'dealer-gps-user';
     var data = {   
     };
      backgroundPostData(url,data,'dealerGpsUser',{alert:false});
     
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
        label: "Gps Sale",
        data:res.gps_count,
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
function dealerGpsUser(res){
  var ctx = document.getElementById("rootChartUser").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ["Sub-dealers","Client"],
      datasets: [{
        label: '#:',
       data:[res.sub_dealer,res.client],
        backgroundColor:'rgba(242,156,18, 0.2)',
        borderColor:'rgba(242,156,18,1)',
        borderWidth: 1
      }]
    },
    options: {
    title: {
      display: true,
      text: 'GPS User'
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