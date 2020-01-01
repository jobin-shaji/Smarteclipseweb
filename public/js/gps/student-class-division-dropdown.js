$(document).ready(function() {
  $('#class_id').on('change', function() {
    var classID = $(this).val();
    var data={ classID : classID };
    if(classID) {
      $.ajax({
        type:'POST',
        url: '/student/class-division-dropdown',
        data:data ,
        async: true,
        headers: {
          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(data) {
        console.log(data);
        if(data){
          $('#division_id').empty();
          $('#division_id').focus;
          $('#division_id').append('<option value="">  Select Division </option>'); 
          $.each(data, function(key, value){
            $('select[name="division_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
          });
        }else{
          $('#division_id').empty();
        }
        }
      });
    }else{
      $('#division_id').empty();
    }
  });
});

$('.route_batch').on('change', function() {
    var routeBatchID=this.value;
    var route_area = [];
    var data = { routeBatchID : routeBatchID };
    $.ajax({
        type:'POST',
        url: '/student/route-batch',
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
          route_area.push(res.route_area);
          $('[name=route_area]').val(JSON.stringify(route_area)); 
        } 
    });
});

