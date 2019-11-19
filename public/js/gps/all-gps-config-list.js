function getallData(value) {
  var  data = {
    gps_id : value    
  };
  var url = 'all-gpsconfig-list';
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
          console.log(res);

           // $('#pu').text(res.gps);
          document.getElementById("pu").innerHTML = res.PU;
          document.getElementById("mo").innerHTML = res.MO;
          document.getElementById("eo").innerHTML = res.EO;
          document.getElementById("ed").innerHTML = res.ED;
          document.getElementById("st").innerHTML = res.ST;
          document.getElementById("ht").innerHTML = res.HT;
          document.getElementById("sl").innerHTML = res.SL;
          document.getElementById("hbt").innerHTML = res.HBT;
          document.getElementById("hat").innerHTML = res.HAT;
          document.getElementById("rtt").innerHTML = res.RTT;
          document.getElementById("lbt").innerHTML = res.LBT;
          document.getElementById("ta").innerHTML = res.TA;
          document.getElementById("vn").innerHTML = res.VN;
          document.getElementById("ur").innerHTML = res.UR;
          document.getElementById("urt").innerHTML = res.URT;
          document.getElementById("urs").innerHTML = res.URS;
          document.getElementById("ure").innerHTML = res.URE;
          document.getElementById("urf").innerHTML = res.URF;
          document.getElementById("urh").innerHTML = res.URH;
          document.getElementById("vid").innerHTML = res.VID;
          document.getElementById("fv").innerHTML = res.FV;
          document.getElementById("dsl").innerHTML = res.DSL;
          document.getElementById("m1").innerHTML = res.M1;
          document.getElementById("m2").innerHTML = res.M2;
          document.getElementById("om").innerHTML = res.OM;
          document.getElementById("ou").innerHTML = res.OU;
          document.getElementById("puv").innerHTML = res.PUV;
          document.getElementById("apn").innerHTML = res.APN;
          document.getElementById("pwd").innerHTML = res.PWD;
          document.getElementById("rs").innerHTML = res.RS;
          document.getElementById("est").innerHTML = res.EST;
          document.getElementById("ftp").innerHTML = res.FTP;
          document.getElementById("fip").innerHTML = res.FIP;
          document.getElementById("tm").innerHTML = res.TM;
          document.getElementById("tem").innerHTML = res.TEM;
          document.getElementById("btp").innerHTML = res.BTP;
          document.getElementById("fue").innerHTML = res.FUE;
          document.getElementById("spd").innerHTML = res.SPD;
          document.getElementById("ign").innerHTML = res.IGN;
          document.getElementById("flc").innerHTML = res.FLC;
          document.getElementById("imo").innerHTML = res.IMO;
          document.getElementById("fmt").innerHTML = res.FMT;
          document.getElementById("nod").innerHTML = res.NOD;
          document.getElementById("gp1").innerHTML = res.GP1;
          document.getElementById("gp2").innerHTML = res.GP2;
          document.getElementById("gps").innerHTML = res.GPS;
          document.getElementById("dc2").innerHTML = res.DC2;
          document.getElementById("aof").innerHTML = res.AOF;
          document.getElementById("fus").innerHTML = res.FUS;
          document.getElementById("fpd").innerHTML = res.FPD;
          document.getElementById("tdu").innerHTML = res.TDU;
          document.getElementById("cdc").innerHTML = res.CDC;         
        },
    });
}





