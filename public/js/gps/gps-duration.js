function getData(value) {
  var  data = {
    gps_id : value    
  };
  var url = 'vehicle-duration-list';
  var purl = getUrl() + '/' + url;
    $.ajax({
        type: 'POST',
        url: purl,
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
          $('#durationtabledata').empty();
          for (var i = 0; i < res.length; i++) {
              var j=i+1;
              var durationrow = '<tr><td>'+j+'</td>'+
              '<td>'+res[i].km+'</td>'+
              '<td>'+res[i].ignition_on_duration+'</td>'+
              '<td>'+res[i].ignition_off_duration+'</td>'+ 
              '<td>'+res[i].moving_duration+'</td>'+       
              '<td>'+res[i].halt_duration+'</td>'+ 
              '<td>'+res[i].sleep_duration+'</td>'+ 
              '<td>'+res[i].stop_duration+'</td>'+ 
              '<td>'+res[i].ac_on_duration+'</td>'+ 
              '<td>'+res[i].ac_off_duration+'</td>'+ 
              '<td>'+res[i].ac_on_halt_duration+'</td>'+ 
              '<td>'+res[i].date+'</td>'+ 
              '</tr>';
              $("#durationtabledata").append(durationrow);
          }
        },
    });
}





