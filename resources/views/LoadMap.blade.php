<!DOCTYPE HTML>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Map View of Smart Eclipse</title>


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
  <style>
    .map {
      border: 1px solid #ccc;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
      border-radius: 5px;
      height:80vh;
    }
    .vehicleList{
      border: 1px solid #ccc;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
      height:80vh;
    }
    @media (max-width: 767px) {
      .custom-height {
        height: auto; /* Auto height for smaller screens (up to 767px width) */
      }
    }
    li{
      margin-left:10px;
    }
  </style>
</head>

<body>
  <header>
    <div class="home-header">
      <nav>
        <div class="container-home-nav">
          <div class="logo">
            <a href="#home"><img src="images/logohome.png" /></a>
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
              <li><a href="/#home">Home.</a></li>
              <li><a href="/#about">About</a></li>
              <li><a href="/#products">Products</a></li>
              <li><a href="/#service">Authorized Service Center</a></li>
              <li><a href="/#appscreen">App Screens</a></li>
              <li><a href="/#contact">Contact</a></li>

              <li><a href="/login" class="login-button button-color">Login</a></li>
            </ul>
          </div>
        </div>
      </nav>

    </div>
  </header>
  <section id="home" class="display">
    <div class="banner">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2 col-sm-12 p-md-2 p-sm-1">
            <div class="vehicleList custom-height">
            <ul style="display: grid;">
    <li>Item 1</li>
    <li>Item 2</li>
    <li>Item 3</li>
</ul>
            </div>
          </div>
          <div class="col-md-10 col-sm-12 p-md-2 p-sm-1">
          
            <div id="map" class="map">Map loading....</div>
          
          </div>
        </div>
      </div>


      <div style="width: 100%;text-align:center;margin-top:2px;color:#999;">
        Copyright © 2020 VST Mobility Solutions Pvt Ltd. All Right Reserved.
      </div>
    </div>

  </section>

  <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js'></script>
  <script src="js/slick.js" type="text/javascript" charset="utf-8"></script>
  <script src="js/animation-script.js" type="text/javascript" charset="utf-8"></script>
  <script src="js/script-menu.js"></script>

  <script src="js/accordion.js"></script>
  <script src="js/video-icon.js"></script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfYT6_j5xH9JjIyTym0aqnIQsjbyE3zBd&libraries=geometry&v=3.26"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      initMap();
    });

    function initMap() {
      var mapOptions = {
        center: {
          lat: 8.49,
          lng: 76.95
        },
        zoom: 10 // Zoom level (0 = Earth, 21 = building)
      };

      // Create the map object
      map = new google.maps.Map(document.getElementById('map'), mapOptions);
    }
  </script>

</body>

</html>