
$('.GpsData').on('change', function() {
    var gpsId=this.value;
    // alert(gpsId);
    var purl = getUrl() + '/'+'gps-create-root-dropdown' ;

    var data = { gps_id : gpsId };
    console.log(data);
    $.ajax({
        type:'POST',
        url: purl,
        data:data ,
        async: true,
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            // console.log(res.imei);
            var imei=res.imei;
            var model_name=res.model_name;
            var icc_id=res.icc_id;
            var imsi=res.imsi;
            var batch_number=res.batch_number;
            var employee_code=res.employee_code;
            var brand=res.brand;
            var version=res.version;
            $("#imei").val(imei);
            $("#model_name").val(model_name);
            $("#icc_id").val(icc_id);
            $("#imsi").val(imsi);
            $("#batch_number").val(batch_number);
            $("#employee_code").val(employee_code);
            
            $("#version").val(version); 
        }
    });
  });