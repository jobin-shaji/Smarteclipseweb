function getData(value) {
  var  data = {
    gps_id : value    
  };
  var url = 'gpsconfig-list';
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
          document.getElementById("imei").innerHTML = res.imei;
          document.getElementById("serial_no").innerHTML = res.serial_no;
          document.getElementById("manufacturing_date").innerHTML = res.manufacturing_date;
          document.getElementById("icc_id").innerHTML = res.icc_id;
          document.getElementById("imsi").innerHTML = res.imsi;
          document.getElementById("e_sim_number").innerHTML = res.e_sim_number;
          document.getElementById("batch_number").innerHTML = res.batch_number;
          document.getElementById("model_name").innerHTML = res.model_name;
          document.getElementById("version").innerHTML = res.version;
          document.getElementById("mode").innerHTML = res.mode;
          document.getElementById("lat").innerHTML = res.lat;
          document.getElementById("lat_dir").innerHTML = res.lat_dir;
          document.getElementById("lon").innerHTML = res.lon;
          document.getElementById("lon_dir").innerHTML = res.lon_dir;
          document.getElementById("fuel_status").innerHTML = res.fuel_status;
          document.getElementById("speed").innerHTML = res.speed;
          document.getElementById("odometer").innerHTML = res.odometer;
          document.getElementById("satllite").innerHTML = res.satllite;
          document.getElementById("battery_status").innerHTML = res.battery_status;
          document.getElementById("heading").innerHTML = res.heading;
          document.getElementById("main_power_status").innerHTML = res.main_power_status;
          document.getElementById("ignition").innerHTML = res.ignition;
          document.getElementById("gsm_signal_strength").innerHTML = res.gsm_signal_strength;
          document.getElementById("emergency_status").innerHTML = res.emergency_status;
          document.getElementById("ac_status").innerHTML = res.ac_status;
          document.getElementById("km").innerHTML = res.km;
          document.getElementById("device_time").innerHTML = res.device_time;
        },
    });
}





