{{-- <!DOCTYPE HTML>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>SMART ECLIPSE</title>


  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.6.3/css/all.css'>

  <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>

  <script src="js/slick.js" type="text/javascript" charset="utf-8"></script>
  <link rel="stylesheet" type="text/css" href="css/homestyle.css">
  <link rel="stylesheet" type="text/css" href="css/home-resposive.css" />
  <link rel="stylesheet" type="text/css" href="css/slick.css">
  <link rel="stylesheet" type="text/css" href="css/slick-theme.css">
  <link rel="stylesheet" type="text/css" href="css/animation.css">

</head>

<body>
  <header>

    <div class="home-header">




      <nav>
        <div class="container-home-nav">
          <div class="logo">
            <a href="#home"><img src="assets/images/logo-v.png" /></a>
          </div>
          <div id="menu" class="nav-bar-rt">
            <div id="menu-toggle">
              <div id="menu-icon">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
              </div>
            </div>
            <ul>
              <li><a href="/">Home</a></li>
              <li><a href="/#about">About</a></li>
              <li><a href="/#products">Products</a></li>
              <li><a href="/#service">Authorized Service Center</a></li>
              <li><a href="/#appscreen">App Screens</a></li>
              <li><a href="/#contact">Contact</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <section id="home" class="display">
    <div class="banner">
      <div class="container-home-nav">
        <div class="login-banner-left">
          <img src="assets/images/login-banner.png" class="animatable moveUp" />
        </div>
        <div class="login-banner-right" style="padding-top: 4em;">
          <div class="login-top-head animatable fadeInUp">
            <div class="login-head-icon ">
              <img src="assets/images/login-top-icon.png" />
            </div>
            <div class="login-text">Login</div>
          </div>
          <div class="login-form">
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="input-warpper animatable fadeInUp">
                <span><img src="assets/images/login-user-icon.png" /></span>
                <input type="text" name="login" class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}" id="login" placeholder="login" value="{{ old('login') }}" required autofocus>



                
                @if ($errors->has('login'))
                <div class="invalid-feedback" role="alert" style="margin-bottom: 10%">
                  <strong style="color: red;font-weight :700">{{ $errors->first('login') }}</strong>
                </div>
                @endif



              </div>
              <div class="input-warpper animatable fadeInUp">
                <input type="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                @if ($errors->has('password'))
                <div class="invalid-feedback" role="alert" style="margin-bottom: 10%">
                  <strong>{{ $errors->first('password') }}</strong>
                </div>
                @endif
                <span class="pass"><img src="assets/images/login-password-icon.png" /></span>
              </div>



              <div class="input-wrapper animatable fadeInUp">
                <div class="forgot-outer">
                  <div class="squaredThree animatable fadeInUp">
                    <input type="checkbox" value="None" id="squaredThree" name="check" unchecked="">
                    <label for="squaredThree"><span>Remember me</span></label>
                  </div>
                  <div class="forgot-r animatable fadeInUp">
                    <a href="">Forgot Password?</a>
                  </div>
                </div>
              </div>


              <input type="submit" value="Login" class="animatable fadeInUp">

              <div class="forgot-r" style="color:grey;float:left;font-size:small;margin-left:1em;margin-top:5px;">
                <a href="register" style="color:lightblue !important;">New Registration</a>
                </div>
              


            </form>

          </div>
        </div>



      </div>


    </div>



  </section>




  <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js'></script>

  <script src="js/slick.js" type="text/javascript" charset="utf-8"></script>

  <script src="assets/js/animation-script.js" type="text/javascript" charset="utf-8"></script>
  <script src="assets/js/script-menu.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.1.135/jspdf.min.js"></script>






  <script src="assets/js/accordion.js"></script>
  <script src="assets/js/video-icon.js"></script>

  <script type="text/javascript">
    $(document).on('ready', function() {

      $(".regular").slick({
        dots: true,
        arrows: false,
        infinite: true,
        slidesToShow: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        slidesToScroll: 1,


        responsive: [


          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]

      });

      $(".app-slide").slick({
        dots: true,
        arrows: false,
        infinite: true,
        slidesToShow: 4,
        autoplay: true,
        autoplaySpeed: 2000,
        slidesToScroll: 4,

        responsive: [

          {
            breakpoint: 768,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
      });

      $(".our-certification-slide").slick({
        dots: false,
        arrows: false,
        infinite: true,
        slidesToShow: 8,
        autoplay: true,
        autoplaySpeed: 2000,
        slidesToScroll: 1,

        responsive: [

          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 6,
              slidesToScroll: 1
            }
          },

          {
            breakpoint: 800,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
      });




    });


    $(function() {

      var specialElementHandlers = {
        '#editor': function(element, renderer) {
          return true;
        }
      };
      $('#cmd').click(function() {
        var doc = new jsPDF();
        doc.fromHTML($('#target').html(), 15, 15, {
          'width': 170,
          'elementHandlers': specialElementHandlers
        });
        doc.save('pdf/gps-brochure.pdf');
      });

      $('#cmd1').click(function() {
        var doc = new jsPDF();
        doc.fromHTML($('#target').html(), 15, 15, {
          'width': 170,
          'elementHandlers': specialElementHandlers
        });
        doc.save('pdf/gps-brochure.pdf');
      });
    });

    $(document).ready(function() {
      $("#myModal").on("hidden.bs.modal", function() {
        $("#iframeYoutube").attr("src", "#");
      })
    })

    function changeVideo(vId) {
      var iframe = document.getElementById("iframeYoutube");
      iframe.src = "https://www.youtube.com/embed/" + vId;

      $("#myModal").modal("show");
    }
  </script>


</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VFLEET</title>
    <!-- Google-icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Custom Css -->
    <link href="{{ asset('css/style2.css') }}" rel="stylesheet">
    <!-- Bootstrap core CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</head>

<body>
    <section class="login-pg">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="login-lft-sec">
                        <img class="white-logo" src="{{ url('white-logo.png') }}" class="" alt="">
                        <div class="login-img-txt">
                            <h3>Welcome to Your <br>Mobility Hub!</h3>
                            <p>Track, analyze, and manage vehicle data with ease.<br>
                                Stay informed with real-time insights for smarter decisions.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <div class="login-form">
                                    <div class="top-login"> <img class="login-logo" src="{{ url('logo.png') }}"></div>
                                    <div class="mt-4">

                                        <h1>Welcome </h1>
                                        <p>Sign in to continue </p>

                                        <form class="my-4" method="POST" action="{{ route('login') }}">
                                          @csrf
                                            <div class="form-floating mb-3">
                                                <input name="username"
                                                    class="form-control{{ $errors->has('login') ? ' is-invalid' : '' }}"
                                                    type="text" class="form-control" id="login"
                                                    placeholder="JohnDoe">
                                                <label for="login">Username</label>
                                                @if ($errors->has('login'))
                                                    <div class="invalid-feedback" role="alert"
                                                        style="margin-bottom: 10%">
                                                        <strong
                                                            style="color: red;font-weight :700">{{ $errors->first('login') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-floating">
                                                <input type="password" name="password" class="form-control" id="floatingPassword"
                                                    placeholder="Password">
                                                <label for="floatingPassword">Password</label>
                                                @if ($errors->has('password'))
                                                    <div class="invalid-feedback" role="alert"
                                                        style="margin-bottom: 10%">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between my-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <small> Remember Me</small>
                                                    </label>
                                                </div>
                                                <a href="forgot-password.html" class="link"><small>Forgot
                                                        Password?</small></a>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100 mt-3">Sign In</button>
                                            <div class="mt-3 text-center"><small>Don’t have an account? <a
                                                        href="signup.html" class="link">Sign up</a></small></div>
                                        </form>
                                    </div>
                                    <div class="copy-rt-sec">
                                        <p>© VFleet2025. All rights reserved</p>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Custom scripts for all pages-->
    <script src="js/layout.js"></script>


    <!-- graph -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.0/morris.min.js'></script>
    <script src="js/script.js"></script>

</body>

</html>
