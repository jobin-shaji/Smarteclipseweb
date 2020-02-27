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
                success: function (data) {
                    $('#tabledata').empty();
                    for (var i = 0; i < data.links.data.length; i++) {
                        var vlt_data_packet = (data.links.data[i].vlt_data != null) ? data.links.data[i].vlt_data.vltdata : '';
                        var j=i+1;
                        var tablerow = '<tr><td>'+j+'</td>'+
                        '<td>'+data.links.data[i].imei+'</td>'+
                        '<td>'+vlt_data_packet+'</td>'+
                        '<td>'+data.links.data[i].device_time+'</td>'+
                        '<td>'+data.links.data[i].created_at+'</td>'+
                        '</tr>';
                        $("#tabledata").append(tablerow);
                    }

                }

            });

        }
    });
});