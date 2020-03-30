$(document).ready(function () {
  $('#count_data').hide();
});

function searchData()
{   
  if(document.getElementById('return_to').value == '')
  {
    alert('please select any user to reassign');
  }
  else
  {
    imei = document.getElementById('return_to').value;
    count(imei);
  }
}

function count(imei){   
       
  $.ajax({
    type: 'POST',
    url: '/get-gps-count',
    data: {'imei':imei},
    async: true,
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(res) {
        $('#count_data').show();
        $('#gps_data_count').html(res);
    },
  });
  $.ajax({
    type: 'POST',
    url: '/get-vlt-count',
    data: {'imei':imei},
    async: true,
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(res) {
        $('#vlt_data_count').html(res);
    },
  });
}

