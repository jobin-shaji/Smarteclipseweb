$(function(){
    $('#searchclick').click(function() {
        if(document.getElementById('gps_id').value == ''){
            alert('Please select GPS');
        }else if(document.getElementById('date').value == ''){
            alert('Please choose date');
        }else{
            var gps_id = document.getElementById('gps_id').value;
            var date = document.getElementById('date').value;
        }
        if(gps_id){
            var data = { gps_id : gps_id,date : date };
            $.ajax({
                type:'POST',
                url: "gps-records-list",
                data:data ,
                async: true,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    $('#tabledata').empty();
                    for (var i = 0; i < res.length; i++) {
                        var j=i+1;
                        var tablerow = '<tr><td>'+j+'</td>'+
                        '<td>'+res[i].imei+'</td>'+
                        '<td>'+res[i].vlt_data+'</td>'+
                        '<td>'+res[i].device_time+'</td>'+ 
                        '<td>'+res[i].created_at+'</td>'+       
                        '</tr>';
                        $("#tabledata").append(tablerow);
                    }
                }
            });
          
        }
    });
});