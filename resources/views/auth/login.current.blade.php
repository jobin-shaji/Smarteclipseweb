<!DOCTYPE HTML>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>SMART ECLIPSE</title>


  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

</html>
