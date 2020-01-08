$(document).ready(function() {
  $(".search").keyup(function () {
    var search_key  =   $(".search").val();
    var driver   =   $("#driver_id").val();
    var fromDate   =   $("#from_date").val();
    var toDate     =   $("#to_date").val();
    var data        =   { 'search_key' : search_key,'driver' : driver,'fromDate' : fromDate,'toDate' : toDate };
    if(search_key.length > 3)
    {
      $.ajax({
        type: 'POST',
        url: 'performance-score-history-search-list',
        data: data,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            
        },
      });
    }
    });
});