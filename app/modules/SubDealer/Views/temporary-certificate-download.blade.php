<html>
    <head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">

        <style type="text/css">
            span.cls_002{font-family:Times,serif;font-size:15px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_002{font-family:Times,serif;font-size:15px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
            span.cls_003{font-family:Times,serif;font-size:21.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_003{font-family:Times,serif;font-size:21.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_004{font-family:Times,serif;font-size:30.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_004{font-family:Times,serif;font-size:30.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_005{font-family:Times,serif;font-size:15px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
            div.cls_005{font-family:Times,serif;font-size:11.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
            span.cls_006{font-family:Times,serif;font-size:15px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_006{font-family:Times,serif;font-size:12px!important;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
            span.cls_007{font-family:Times,serif;font-size:10px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
            div.cls_007{font-family:Times,serif;font-size:7.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
            .lineheight {
                line-height: 20px;
                margin-top: 1%!important;
            }
            body{
                margin: :0px;
                padding: :0px;
            }
            div.page
            {
                page-break-after: always;
                page-break-inside: avoid;
            }
            .border{
            width: 570px;
                float: left;
                display: block;
                border: 1px solid #000;
                padding:30px 0 50px;
            }
            .clear{clear:both;
            }
            .same-width{width:100%;
            float:left;
            padding-bottom:10px;
            }
            .top-bg-left{
            width:70%;
            float:left;
            }
            .top-bg-right{
            width:30%;
            float:left;
            }

            .logo{
            width:100%;float:left;display:block;
            }.logo img{
            width:150px;
            float:right;}
            .marg-auto{
            width:540px;margin:30px auto;
            }
            .top-text{
            width:100%;float:left;display:block; margin-top:10px;
            font-size:16px;
            }
            .top-text-left{
            width:50%;float:left;
            }.top-text-right{
            width:50%;float:left;
                margin-left: -1px;
            }

            .top-text span.cls_006 {
                 font-size: 12px;
            }
            .mrg-left-5{margin-left:5px;
            }

            .mrg-top-70{margin-top:60px;
            }.mrg-top-50{margin-top:50px;
            }
            .officeal-txt{
                width: 200px;
                float: right;
                margin-top: 50px;}
            .top-text-left-1 {
                width: 100%;
                float: left;
            }
            .mrg-30{
            margin-top:30px;
            }

            .inner-bg-left{
            width:510px;
            margin:0px auto;
            }
            .inner-border{
            margin: 0;
                border: 1px solid #000;
                border-bottom: 0px solid #000;
            }.boderder-bottom{
            border-bottom:1px solid #000;
            }
            .inner-left{
            width: 42%;
                float: left;
                border-right: 1px solid #000;
                padding: 10px 0;
                padding-left: 5px;
                    min-height: 30px;

            }
            .inner-right{
            width:53%;
            float:left;
            min-height: 30px;
                border-right: 1px solid #000;
            padding:10px 0;
               padding-left: 5px;
            }
            .yellow{
            background:#f5bb14;
            }
            .border-0{
            border:0px;
            }
            .gray{
            background:#bebdbc;
            }
            .br-bt{
            border-bottom:1px solid #000;}
            .mrg-40
            {margin-top:40px;
            }
            .yellow{background: #f5bb14;}
            .grey{background: #bebdbc;}
            .cls_002{font-family:Times,serif;font-size:15px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
            td{
                vertical-align: text-top;
            }
        </style>

        <script type="text/javascript" src="wz_jsgraphics.js"></script>

    </head>
    <body >
        <?php 
            $datas = json_decode($data['details'],true);
        ?>
        <div >
            <div style="position:absolute;left:23px;">
                <img style="position:absolute;left:530px" class="cls_003" src="assets/images/smart_eclipse_logo.png" alt="Logo" height="30px" width="150px">
                <p style="font-size: 20px;font-weight: 900px;color: black;margin-bottom: 50px!important;margin-top:-5px"><b>Temporary Installation Certificate</b>
                </p>
            </div>
            <br>
            <div style="position:fixed;margin:1%;overflow:auto">

                <div style="position:absolute;left:20px;top:10px;width: 65%" class="cls_002">
                    <div class="cls_002 lineheight">
                        <b>Name:</b> {{$datas['client_name']}}
                    </div>
                    <div class="cls_002 lineheight">
                        <b>Address:</b> {{$datas['owner_address']}}
                    </div>
                    <div class="cls_002 lineheight">
                        <b>Registration Number:</b> {{$datas['vehicle_registration_number']}}
                    </div>
                    <div class="cls_002 lineheight">
                        <b>Date of Installation:</b> {{$datas['device_expected_date_of_installation']}}
                    </div>
                </div>
                <?php 
                   $qr ='IMEI: '.$datas['imei'].' MODEL: VST0507C MANUFACTURER: VST Mobility Solutions Private Limited, B2,Kerala Technology Innovation Zone Kinfra Hi Tech Park, Kalamassery';
                ?>
                <div style="position:absolute;left: 560px!important;margin-top: 20px!important">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->generate($qr)) !!} ">
                </div>

                <div style="position:absolute;left:20px;top:170px; line-height: 21px;" class="cls_002">
                    <span class="cls_002">This is to certify that, this vehicle is equipped with the AIS 140 compliant device, approved by <b>CDAC</b> and <b>ARAI</b>.</span>
                </div>
            </div>
        </div>
        
    </body>
</html>