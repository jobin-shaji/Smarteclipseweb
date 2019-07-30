
<table border="1" cellpadding="0" style="margin:0 auto;width:720px">
  <tbody>
    <tr style="width:700px;border:solid 1px #222;border-width:0 0 1px 0; position:absolute;">
      <td style="margin:12px 0 0 12px;border:none;width:150px">
        <img src="./images/vst-logo-New.png" width="120">
      </td>

      <td style="margin:12px 0 0 30px;width:120px;border:none;">
        <img src="./images/eclipse.png" width="130" >
      </td>

      <td style="margin:30px 0 0 ;width:120px;border:none">
       <img src="./images/make-in-india.png" width="88" height="48">
      </td>

      <td style="border:solid 1px #222;border-width:0 0 0 1px;width:100px;">

        <?php 

        $qr=$gps->imei;
        
        ?>
        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($qr)) !!}" />
      </td>

      </tr>

      <tr style=" width:710px; border:solid 1px #222;border-width:0 0 1px 0;position:absolute;">
        <td style="padding:12px 0;width:250px;margin:0 0 0 12px;font-family:’Helvetica Bold’,Helvetica,’Arial Bold’,Arial,sans-serif;font-size:20px;font-weight:bolder;border:none;padding:0 0 0 12px">Date of Manufacturing:10/10/2019
        </td>
         <td style="border:solid 1px #222;border-width:0 0 0 1px;width:250px;font-family:’Helvetica Bold’,Helvetica,’Arial Bold’,Arial,sans-serif;font-size:20px;font-weight:bolder;padding:12px 0 12px 12px">Manufacturing Address:<br><span style="font-size:13px">VST Mobility Solutions Pvt. Ltd. Kerala Technology Innovation Zone,<br>
        Kinfra Hi-Tech Park, HMT Colony, North Kalamassery,<br>
        Ernakulam, Kerala, India 683503</span>
       </td>
       
    </tr>
    <tr style="width:710px;border:solid 1px #222;border-width:0 0 1px 0;position:absolute;">

    <td style="margin:0 0 0 12px;width:250px;font-family:’Helvetica Bold’,Helvetica,’Arial Bold’,Arial,sans-serif;font-size:20px;font-weight:bolder;padding:12px 0 12px 12px;border:none;">Quantity:1</td>
    <td style="margin:0 0 0 12px;width:250px;font-family:’Helvetica Bold’,Helvetica,’Arial Bold’,Arial,sans-serif;font-size:20px;font-weight:bolder;padding:12px 0 12px 12px;border:solid 1px #222;border-width:0 0 0 1px;">Batch:121561651</td>
    </tr>

     <tr style="width:710px;border:solid 1px #222;border-width:0 0 1px 0;position:absolute;">

    <td style="margin:0 0 0 12px;width:250px;font-family:’Helvetica Bold’,Helvetica,’Arial Bold’,Arial,sans-serif;font-size:20px;font-weight:bolder;padding:12px 0 12px 12px;border:none;">IMEI No:{{$gps->imei}}</td>
    <td style="margin:0 0 0 12px;width:250px;font-family:’Helvetica Bold’,Helvetica,’Arial Bold’,Arial,sans-serif;font-size:20px;font-weight:bolder;padding:12px 0 12px 12px;border:solid 1px #222;border-width:0 0 0 1px;">Model No:11111111</td>
    </tr>

    

     <tr style="position:absolute;" >
    <td style="margin:0 0 0 12px;width:250px;font-family:’Helvetica Bold’,Helvetica,’Arial Bold’,Arial,sans-serif;font-size:20px;font-weight:bolder;padding:12px 0 12px 12px;border:none;" >Certifications:<br></td>
    <td style="width:250px;margin:0 0 12px 0;border:none;float:left"> <img src="./images/certifications1.png" width="200" height="40"></td>
    </tr>

   

      
  </tbody>
</table>

