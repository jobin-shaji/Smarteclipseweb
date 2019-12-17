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
            span.cls_006{font-family:Times,serif;font-size:25px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
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
        </style>

        <script type="text/javascript" src="wz_jsgraphics.js"></script>

    </head>
    <body >
        <?php
        $job_complete_date = $servicer_job->job_complete_date;
        $date = new DateTime($job_complete_date);

        $date = $date->format('d/m/Y');
        ?>
        <div style="position:fixed;margin:1%;overflow:hidden">
            <div style="position:absolute;left:50px;top:41.80px" class="cls_002">
                <span class="cls_002 lineheight"> <b>{{$servicer_job->sub_dealer->name}}</b></span>
            </div>

            <div style="position:absolute;left:50px;top:56.44px" class="cls_002">
                <span class="cls_002 lineheight">
                    {{$servicer_job->sub_dealer->address}}
                    <br>
                    {{$servicer_job->user->email}}
                    <br>
                    {{$servicer_job->user->mobile}}
                </span>
            </div>

            <div style="position:absolute;left:409.44px;top:36.72px" class="cls_003">
                <img src="assets/images/smart_eclipse_logo.png" alt="Logo" height="30px" width="150px">
            </div>

            <div style="position:absolute;left:50px;top:185.32px" class="cls_002">
                <span class="cls_002">This is to certify that , this vehicle is equiped with the AIS 140 compliant device,</span>
            </div>

            <div style="position:absolute;left:50px;top:201.16px" class="cls_002">
                <span class="cls_002" style="letter-spacing: 1px">approved by </span>
                <span class="cls_005" >CDAC </span>
                <span class="cls_002">and </span>
                <span class="cls_005">ARAI.</span>
            </div>
            <div style= "width: 510px;margin-top: 25%;margin-left: 50px">

                <div style="width: 100%; float: left;display: block; margin-top: 10px;font-size: 16px; border: 1px solid #000; border-bottom: 0px;     margin-top: 40px;">
                    <div class="cls_006" style="  width: 50%; float: left;">
                        <span style="width: 38%; float: left; border-right: 1px solid #000;border-left: 1px solid #000; padding: 10px 0; padding-left: 5px; min-height: 27px;     background: #f5bb14;">Issue Date
                        </span>
                        <span style="width: 50%; float: left;min-height: 30px; border-right: 1px solid #000; padding: 10px 0; padding-left: 5px;margin-left: 55%" >{{$date}}
                        </span>
                    </div>
                   <div class="cls_006" style="width: 50%; float: left; margin-left: 53.8%;">
                        <span  style="width: 42%; float: left; border-right: 1px solid #000; padding: 10px 0; padding-left: 5px; min-height: 27px;     background: #f5bb14;">VLT Model No
                        </span>
                        <span style="width: 37.5%; float: left;min-height: 30px; border-right: 1px solid #000; padding: 10px 0;margin-left:54.8%" >&nbsp;
                        </span>
                    </div>
                </div>

                <div style="width: 100%; display: block; font-size: 16px; border: 1px solid #000;margin-top: 36px;">
                    <div class="cls_006" style="  width: 50%; float: left;">
                        <span style="width: 38%; float: left; border-right: 1px solid #000;border-left: 1px solid #000; padding: 10px 0; padding-left: 5px; min-height: 27px;     background: #f5bb14;">Issue Date
                        </span>
                        <span style="width: 50%; float: left;min-height: 30px; border-right: 1px solid #000; padding: 10px 0; padding-left: 5px;margin-left: 55%" >{{$date}}
                        </span>
                    </div>
                   <div class="cls_006" style="width: 50%; float: left; margin-left: -66.6%;">
                        <span  style="width: 42%; float: left; border-right: 1px solid #000; padding: 10px 0; padding-left: 5px; min-height: 27px;     background: #f5bb14;">VLT Model No
                        </span>
                        <span style="width: 37.7%; float: left;min-height: 30px; border-right: 1px solid #000; padding: 10px 0;margin-left:54.8%" >&nbsp;
                        </span>
                    </div>
                </div>
            </div>
            
            <div style="position:absolute;left:90px;top:570px" class="cls_006">
                <span class="cls_006">Issued By<b style="margin-left: 9.9%">:</b> {{$servicer_job->sub_dealer->name}}</span>
            </div>

            <div style="position:absolute;left:350px;top:570px" class="cls_006">
                <span class="cls_006">Inspected and Approved By:</span>
            </div>

            <div style="position:absolute;left:90px;top:650px" class="cls_006">
                <span class="cls_006">Franchisee Name <b style="margin-left: 2%">:</b> </span>
            </div>

            <div style="position:absolute;left:350px;top:650px" class="cls_006">
                <span class="cls_006">Name & Signature</span>
            </div>

            <div style="position:absolute;left:400px;top:740px" class="cls_006">
                <span class="cls_006">Official Seal</span>
            </div>

            <div style="position:absolute;left:462.96px;top:794.60px" class="cls_007">
                <span class="cls_007">VST Mobility Solutions</span>
            </div>
        </div>
    </body>
</html>