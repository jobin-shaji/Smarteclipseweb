var items = [];
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
      scanner.addListener('scan', function (content) {
        var imei=content;
        var data = { imei : imei };
        $.ajax({
            type:'POST',
            url: '/gps-scan',
            data:data ,
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
              if(res.status == 1){
                var position = jQuery.inArray(res.gps_id, items);
                  if(position !='-1'){
                       alert("item exists");
                  }else{
                      items.push(res.gps_id);
                      var gps_name=res.gps_name;
                      var gps_imei=res.gps_imei;
                      $("#gps_id").val(items); 
                      var markup = "<tr><td>" + gps_name + "</td><td>" + gps_imei + "</td></tr>";
                      $("table tbody").append(markup);
                      alert("Success");
                  }
              }else{
                alert("Gps device already tranferred");
              }
            }
        });
        
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });