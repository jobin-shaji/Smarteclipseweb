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
            }
            body{
                margin: :0px;
                padding: :0px;
            }
            -->
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

        <div>
            <p style="text-align: center;font-size: 20px;font-weight: 900px;color: black;margin-bottom: 50px!important;margin-top:-5px "><b>Installation Certificate</b>
            </p>

        </div>
        <br>
        <?php
        $job_complete_date = $servicer_job->job_complete_date;
        $date = new DateTime($job_complete_date);

        $date = $date->format('d/m/Y');
        ?>
        <div style="position:fixed;margin:1%;overflow:auto">

            <div style="position:absolute;left:70px;top:60px" class="cls_002">
                <span class="cls_002 lineheight">
                    {{$servicer_job->sub_dealer->name}}
                    <br>
                    {{$servicer_job->sub_dealer->address}}
                    <br>
                    {{$servicer_job->user->email}}
                    <br>
                    {{$servicer_job->user->mobile}}
                </span>
            </div>

            <div style="position:absolute;left:500px;top:38.72px" class="cls_003">
                <img src="assets/images/smart_eclipse_logo.png" alt="Logo" height="30px" width="150px">
            </div>

            <div style="position:absolute;left:70px;top:187.32px; line-height: 21px;" class="cls_002">
                <span class="cls_002">This is to certify that, this vehicle is equipped with the AIS 140 compliant device, approved by <b>CDAC</b> and <b>ARAI</b>.</span>
            </div>

            <p style="margin-top: 24%;margin-left: 70px"><b>Details of AIS 140 Device</b></p>
            <table border="1" cellspacing="0" cellpadding="5px" style="margin-left: 53px;width:100%;">
                 <tr>
                    <td class="cls_002 yellow">Device IMEI</td>
                    <td>{{$vehicle->gps->imei}}</td>
                </tr>
                <tr>
                    <td class="cls_002 grey">Model</td>
                    <td>VST0507C</td>
                </tr>
                <tr>
                    <td class="cls_002 yellow">Manufacturer</td>
                    <td>
                        B2,Kerala Technology Innovation Zone <br>Kinfra Hi Tech Park, Kalamassery <br>Ernakulam 
                    </td>
                </tr>
                <tr>
                    <td class="cls_002 grey" style="width: 30%">CDAC Certification No</td>
                    <td>CDAC-CR045</td>
                </tr>
            </table>
            <p style="margin-left: 70px"><b>Details of the Vehicle</b></p>
            <table border="1" cellspacing="0" cellpadding="5px" style="margin-left: 53px;width: 100%">
                <tr>
                    <td class="cls_002 yellow">Registration Number</td>
                    <td>{{$vehicle->register_number}}</td>
                </tr>
                <tr>
                    <td class="cls_002 grey">Chassis Number</td>
                    <td>{{$vehicle->chassis_number}}</td>
                </tr>
                <tr>
                    <td class="cls_002 yellow">Registered Owner Name</td>
                    <td>{{$client->name}}</td>
                </tr>
                <tr>
                    <td class="cls_002 grey" style="width: 30%">Registered Owner Address</td>
                    <td>{{$client->address}}</td>
                </tr>
                <tr>
                    <td class="cls_002 yellow">Engine Number</td>
                    <td>{{$vehicle->engine_number}}</td>
                </tr>
                <tr>
                    <td class="cls_002 grey">Date of Installation</td>
                    <td>{{$date}}</td>
                </tr>
            </table>
           
            
            <div style="position:absolute;left:70px;top:770px;line-height: 21px" class="cls_002">
                <span class="cls_002">This letter has been issued on <b>{{$date}}</b> upon the specific request from the customer as a proof of installation</span>
            </div>
            <div style="position:absolute;left:70px;top:830px" class="cls_002">
                <span class="cls_002">Yours Sincerly,</span>
            </div>
             <div style="position:absolute;left:70px;top:870px" class="cls_002">
                <span class="cls_002">{{$servicer_job->sub_dealer->name}}</span>
            </div>
            <div style="position:absolute;left:70px;top:930px" class="cls_002">
                <span class="cls_002">Authorised Signatory</span>
            </div>
        </div>
        
    </body>
</html>