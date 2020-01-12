<?php
  require("vendor/autoload.php");
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();
  $GOOGLE_MAPS_GEOLOCATION_API_KEY = getenv("GOOGLE_MAPS_GEOLOCATION_API_KEY");
  $partialAddress =

  $url = "https://maps.googleapis.com/maps/api/geocode/json?address="./*1600+Amphitheatre+Parkway,+Mountain+View,.+CA*/"&key=".$GOOGLE_MAPS_GEOLOCATION_API_KEY."";
  /*
  $url_headers = @get_headers($url);

  if (!$url_headers || $url_headers[0] == 'HTTP/1.1 404 Not Found') {
    echo "URL not found";
  } else {
      $urlContents = file_get_contents($url);
      $contentsArray = json_decode($urlContents, true);
      print_r($contentsArray);
  }
  */

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Geocoding an Address</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <script src="assets/js/popper.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap-jquery.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.js" type="text/javascript"></script>
    <script src="assets/js/jquery-non-slim.js" type="text/javascript"></script>
    <style>

      html {
        background: no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }

      #searchButton {
        margin-top: 2em;
      }

      h1 {
        margin-top: 1em;
      }

    </style>
  </head>
  <body>
    <div class="container">
      <h1>Postcode Finder</h1>
      <div id="result"></div>
      <!--<p>Enter a partial address to get the postcode</p>-->
      <label for="partialAddress">Enter a partial address</label>
      <input type="text" name="partialAddress" id="partialAddress" class="form-control">
      <button id="searchButton" class="btn btn-primary">Search</button>
    </div>
  </body>
  <script>
    $(document).ready(function() {
      $('#searchButton').click(function(e) {
        e.preventDefault();
        $.ajax({
          url : "https://maps.googleapis.com/maps/api/geocode/json?address=" + encodeURIComponent($('#partialAddress').val()) + "&key=<?php echo $GOOGLE_MAPS_GEOLOCATION_API_KEY; ?>",
          type : "GET",
          success : function( data ) {
            //console.log(data["status"]);
            if ( data["status"] == "OK" ) {
              $.each(data["results"][0]["address_components"], function (key, value) {
                //console.log(key);
                if (value["types"][0] == "postal_code") {
                  //alert(value["long_name"]);
                  $('#result').html( '<div class="alert alert-success">' + value["long_name"].toString() + '</div>');
                }
              });
            } else {
                $('#result').html('<div class="alert alert-danger">Postcode Not Found</div>');
              }
            },
          error : function () {
            //console.log("AJAX ERROR");
            $('#result').html('<div class="alert alert-danger">Postcode Not Found</div>');
          }
        });
      });
    });
  </script>
</html>
