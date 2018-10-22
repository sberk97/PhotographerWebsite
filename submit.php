<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>John Doe - Photography book a photoshoot - submit</title>
  <meta name="description" content="John Doe - Photography book a photoshoot - submit">
  <meta name="author" content="Sebastian Berk">
  <meta name="keywords" content="John, Doe, John Doe, Photography">
  <meta name="robots" content="nofollow">

  <!-- Done by http://www.favicomatic.com -->
  <!-- Icon made by Lucy G (https://www.flaticon.com/authors/lucy-g) from www.flaticon.com  -->
  <link rel="apple-touch-icon-precomposed" sizes="57x57" href="images/favicon/apple-touch-icon-57x57.png" />
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/favicon/apple-touch-icon-114x114.png" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/favicon/apple-touch-icon-72x72.png" />
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/favicon/apple-touch-icon-144x144.png" />
  <link rel="apple-touch-icon-precomposed" sizes="120x120" href="images/favicon/apple-touch-icon-120x120.png" />
  <link rel="apple-touch-icon-precomposed" sizes="152x152" href="images/favicon/apple-touch-icon-152x152.png" />
  <link rel="icon" type="image/png" href="images/favicon/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="images/favicon/favicon-16x16.png" sizes="16x16" />
  <meta name="application-name" content="&nbsp;"/>
  <meta name="msapplication-TileColor" content="#FFFFFF" />
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png" />

  <link rel="stylesheet" type="text/css" href="css/style.css">
  <!-- Grid system from http://www.responsivegridsystem.com -->
  <link rel="stylesheet" type="text/css" href="css/grid.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="js/script.js" async defer></script>
</head>
<!-- Hero, footer based on https://github.com/kevin-powell/How-to-build-a-responsive-website-from-scratch Author: Kevin Powell -->
<!-- Navbar based on https://codepen.io/kevinpowell/pen/PWNwZm Author: Kevin Powell -->
<body>
  <div class="hero hero-s h-half parallax--bg">
    <header>
      <div class="container">
        <!-- Icon made by Lucy G (https://www.flaticon.com/authors/lucy-g) from www.flaticon.com  -->
        <a href="index.html"><img src="images/logo.png" alt="John Doe - Photography Logo" class="logo"></a>
        <nav class="site-nav">
          <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About me</a></li>
            <li><a href="book.html">Book a Photoshoot</a></li>
            <li><a href="gallery.html">Gallery</a></li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
        </nav>
        <!-- Hamburger menu icon from https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_menu_icon_js -->
        <div class="menu-toggle" onclick="hamburger(this);">
          <div class="bar1"></div>
          <div class="bar2"></div>
          <div class="bar3"></div>
        </div>
      </div>
    </header>
  </div>

  <div class="section group">
    <!-- Php based on http://lamp.scim.brad.ac.uk:50710/week10/registration.php -->
    <?php
    session_start();

    $first_name = $last_name = $number = $email = $date = $msg = '';
    $first_nameErr = $last_nameErr = $numberErr = $emailErr = $dateErr = '';
    $error = 0;
    // XSS Attack prevention from https://www.w3schools.com/php/php_form_validation.asp
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (empty($_POST["first_name"])) {
        $first_nameErr = "First name is required";
        $error += 1;
      } else {
        $first_name = test_input($_POST["first_name"]);
        // check if first name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$first_name)) {
          $first_nameErr = "In first name only letters and white space allowed";
          $error += 1;
        }
      }

      if (empty($_POST["last_name"])) {
        $last_nameErr = "Last name is required";
        $error += 1;
      } else {
        $last_name = test_input($_POST["last_name"]);
        // check if last name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$last_name)) {
          $last_nameErr = "In last name only letters and white space allowed";
          $error += 1;
        }
      }

      if (empty($_POST["number"])) {
        $number = "Number is required";
        $error += 1;
      } else {
        $number = test_input($_POST["number"]);
        // check if number is 8 to 11 digits long and starts with 0
        if (!preg_match("/0[0-9]{7,10}/",$number)) {
          $numberErr = "From 8 to 11 digits are allowed starting with 0";
          $error += 1;
        }
      }

      if (empty($_POST["email"])) {
        $email = "None";
      } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid email format";
          $error += 1;
        }
      }

      if (empty($_POST["date"])) {
        $dateErr = "Date is required";
      } else {
        $date = test_input($_POST["date"]);
        $date_arr  = explode('-', $date);
        // check if date address is well-formed
        // Based on https://secure.php.net/manual/en/function.checkdate.php and https://stackoverflow.com/a/12030841
        if (!checkdate($date_arr[1], $date_arr[2], $date_arr[0])) {
          $dateErr = "Invalid date format";
          $error += 1;
        }
      }

      if (empty($_POST["msg"])) {
        $msg = "None";
      } else {
        $msg = test_input($_POST["msg"]);
      }
    }

    // Removes illegal characters
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data, ENT_QUOTES);
      return $data;
    }

    if (isset($_POST['submit']) and $error == 0) {

      $servername = "localhost";
      $username = "sberk";
      $password = "";
      $dbname = "sberk";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Creates table if it doesn't exists
      $query = "CREATE TABLE IF NOT EXISTS bookings (
        id SMALLINT NOT NULL AUTO_INCREMENT,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        number VARCHAR(11) NOT NULL,
        email VARCHAR(100),
        date DATE NOT NULL,
        msg VARCHAR(255),
        PRIMARY KEY (id)
      )";

      $result = $conn->query($query);
      // SQL Injection prevention based on https://www.wikihow.com/Prevent-SQL-Injection-in-PHP and https://secure.php.net/manual/en/mysqli-stmt.bind-param.php
      if ($query = $conn->prepare("INSERT INTO bookings (first_name, last_name, number, email, date, msg) VALUES (?, ?, ?, ?, ?, ?)")) {
        $query->bind_param("ssssss", $first_name, $last_name, $number, $email, $date, $msg);

        $query->execute();

        $query->close();
      }

      $conn->close();

      echo '<div class="col span_2_of_12"></div><div class="col span_8_of_12 success">';
      echo '<p class="title">BOOKED SUCCESSFULLY</p>';
      echo '<p class="img-caption">I have just received your booking. I will contact you soon!</p>';
      // Word wraping found here: https://stackoverflow.com/a/25273135
      echo '<p><strong>Name:</strong> ' . preg_replace('/([^\s]{25})(?=[^\s])/', '$1'.'<wbr>', $first_name) . '<br /><strong>Last name:</strong> ' . preg_replace('/([^\s]{25})(?=[^\s])/', '$1'.'<wbr>', $last_name) . '<br /><strong>Phone number:</strong> ' . $number . '<br /><strong>Email:</strong> ' . preg_replace('/([^\s]{25})(?=[^\s])/', '$1'.'<wbr>', $email) . '<br /><strong>Booked date:</strong> ' . $date . '<br /><strong>Additional message:</strong> ' . preg_replace('/([^\s]{25})(?=[^\s])/', '$1'.'<wbr>', $msg) . '</p></div>';
    } else {
      echo '<div class="col span_2_of_12"></div><div class="col span_8_of_12 error">';
      echo '<p class="title">ERROR OCCURRED</p>';
      // Error output
      if(!empty($first_nameErr)) {
        echo '<p>' . $first_nameErr . '</p><br />';
      }

      if(!empty($last_nameErr)) {
        echo '<p>' . $last_nameErr . '</p><br />';
      }

      if(!empty($numberErr)) {
        echo '<p>' . $numberErr . '</p><br />';
      }

      if(!empty($dateErr)) {
        echo '<p>' . $dateErr . '</p><br />';
      }

      if(!empty($emailErr)) {
        echo '<p>' . $emailErr . '</p><br />';
      }
      echo '<a href="book.html"><p>Come back to fill the form again by pressing here</p></a></div>';
    }
    ?>
    <div class="col span_2_of_12"></div>
  </div>

  <footer>
    <div class="container">
      <!-- Facebook logo taken from https://www.iconfinder.com/icons/194929/facebook_social_media_icon#size=256 Author: Neil Hainsworth-->
      <a href="https://www.facebook.com"><img src="images/fb-logo-s.png" class="footer-logo" alt="Facebook logo" /></a>

      <!-- Instagram logo taken from https://www.iconfinder.com/icons/194923/intsagram_social_media_icon#size=256 Author: Neil Hainsworth -->
      <a href="https://www.instagram.com"><img src="images/insta-logo-s.png" class="footer-logo" alt="Instagram logo" /></a>

      <!-- Twitter logo taken from https://www.iconfinder.com/icons/194909/social_media_twitter_icon#size=256 Author: Neil Hainsworth -->
      <a href="https://www.twitter.com"><img src="images/twit-logo-s.png" class="footer-logo" alt="Twitter logo" /></a>
      <div class="statement">
        <a href="login.html" class="login-link"><p>Admin panel login</p></a>
        <p>This website is entirely original work, and contains no plagiarised material.</p>
        <p>Made by Sebastian Berk UB: </p>
      </div>
    </div>
  </footer>
  <!-- Author of parallax.js Kevin Powell -->
  <script src="js/parallax.js" async defer></script>
</body>
</html>
