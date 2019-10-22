<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php
          $url=url()->current();
          $rayfleet_key="rayfleet";
          $eclipse_key="eclipse";
          if (strpos($url, $rayfleet_key) == true) {  ?>
              <title>RAYFLEET</title> 
          <?php } 
          else if (strpos($url, $eclipse_key) == true) { ?>
              <title>SMART ECLIPSE</title>
          <?php }
          else { ?>
              <title>SMART ECLIPSE</title> 
        <?php } ?>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            <?php
              $url=url()->current();
              $rayfleet_key="rayfleet";
              $eclipse_key="eclipse";
              if (strpos($url, $rayfleet_key) == true) {  ?>
                  html, body {
                    background-color: #151515;
                    color: white;
                    font-family: 'Nunito', sans-serif;
                    font-weight: 200;
                    height: 100vh;
                    margin: 0;
                    background-image: url({{asset('Ray-Fleet-Home.jpg')}});
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: contain;
            }
              <?php } 
              else if (strpos($url, $eclipse_key) == true) { ?>
                  html, body {
                    background-color: #151515;
                    color: white;
                    font-family: 'Nunito', sans-serif;
                    font-weight: 200;
                    height: 100vh;
                    margin: 0;
                    background-image: url({{asset('images/Smart-Eclipse-Home.jpg')}});
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: contain;
            }
              <?php }
              else { ?>
                  html, body {
                    background-color: #151515;
                    color: white;
                    font-family: 'Nunito', sans-serif;
                    font-weight: 200;
                    height: 100vh;
                    margin: 0;
                    background-image: url({{asset('images/Smart-Eclipse-Home.jpg')}});
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: contain;
            }
            <?php } ?> 

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            <?php
                $url=url()->current();
                $rayfleet_key="rayfleet";
                $eclipse_key="eclipse";
                if (strpos($url, $rayfleet_key) == true) {  ?>
                    .links > a {
                        color: #ec1515;
                        padding: 0 25px;
                        font-size: 18px;
                        font-weight: 600;
                        letter-spacing: .1rem;
                        text-decoration: none;
                        text-transform: uppercase;
                    }
                <?php } 
                else if (strpos($url, $eclipse_key) == true) { ?>
                    .links > a {
                        color: #FEB950;
                        padding: 0 25px;
                        font-size: 18px;
                        font-weight: 600;
                        letter-spacing: .1rem;
                        text-decoration: none;
                        text-transform: uppercase;
                    }
                <?php }
                else { ?>
                    .links > a {
                        color: #FEB950;
                        padding: 0 25px;
                        font-size: 18px;
                        font-weight: 600;
                        letter-spacing: .1rem;
                        text-decoration: none;
                        text-transform: uppercase;
                    } 
            <?php } ?> 

            .m-b-md {
                margin-bottom: 30px;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <!-- <div class="title m-b-md">
                    SMART ECLIPSE
                </div>


                <div class="links">Developed by <a href="http://vstmobility.com">VST Mobility Solutions</a> -->

                </div>
            </div>
        </div>
    </body>
</html>
