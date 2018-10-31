<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>John Doe - Photography admin panel</title>
  <meta name="description" content="John Doe - Photography book a photoshoot admin panel">
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
    <!-- Login system based on https://www.tutorialrepublic.com/php-tutorial/php-mysql-login-system.php -->
    <?php
    session_start();

    $username = $password = '';
    $usernameErr = $passwordErr = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
      } else {
        $username = test_input($_POST["username"]);
      }

      if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
      } else {
        $password = test_input($_POST["password"]);
      }
    }

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data, ENT_QUOTES);
      return $data;
    }

    if (isset($_POST['login'])) {

      $servername = "localhost";
      $usernamedb = "root";
      $passworddb = "";
      $dbname = "sberk";

      // Create connection
      $conn = new mysqli($servername, $usernamedb, $passworddb, $dbname);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Creates table with users if it doesn't exists
      $query = "CREATE TABLE IF NOT EXISTS users (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
      )";

      $result = $conn->query($query);
      // Adding defualt user
      $adminusername = 'admin';
      $adminpassword = 'sberk';

      if($query = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)")){
        $query->bind_param("ss", $param_username, $param_password);
        $param_username = $adminusername;
        $param_password = password_hash($adminpassword, PASSWORD_DEFAULT);

        $query->execute();
      }

      // Creating table with bookings if it doesn't exists
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

      // Validate credentials
      if(empty($usernameErr) && empty($passwordErr)){
        if($query= $conn->prepare("SELECT username, password FROM users WHERE username = ?")){
          // Bind variables to the prepared statement as parameters
          $query->bind_param("s", $param_username);

          // Set parameters
          $param_username = $username;

          // Attempt to execute the prepared statement
          if($query->execute()){
            // Store result
            $query->store_result();

            // Check if username exists, if yes then verify password
            if($query->num_rows == 1){
              // Bind result variables
              $query->bind_result($username, $hashed_password);
              if($query->fetch()){
                if(password_verify($password, $hashed_password)){
                  $_SESSION['username'] = $username;
                } else{
                  // Display an error message if password is not valid
                  $passwordErr = 'Incorrect username or password.';
                }
              }
            } else{
              // Display an error message if username doesn't exist
              $usernameErr = 'Incorrect username or password.';
            }
          } else {
            echo '<div class="col span_2_of_12"></div><div class="col span_8_of_12 error"><p>Oops! Something went wrong. Please try again later.</p></div>';
          }
        }
      }
      if(empty($usernameErr) && empty($passwordErr)) {
        // Gets all data from table bookings
        $query = "SELECT * FROM bookings";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
          echo '<div class="col span_2_of_12"></div><div class="col span_8_of_12 admin-panel"><p class="title">BOOKINGS</p><table><thead><tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Phone number</th>
          <th>Email</th>
          <th>Date</th>
          <th>Additional information</th>
          </tr>
          </thead>
          <tbody>';
          // output data of each row
          while($row = $result->fetch_assoc()) {
            // Word wraping found here: https://stackoverflow.com/a/25273135
            echo '<tr><td>' . $row['id']. '</td><td>' . preg_replace('/([^\s]{25})(?=[^\s])/', '$1'.'<wbr>', $row['first_name']) . '</td><td>' . preg_replace('/([^\s]{25})(?=[^\s])/', '$1'.'<wbr>', $row['last_name']) . '</td><td>' . $row['number'] . '</td><td>' . preg_replace('/([^\s]{25})(?=[^\s])/', '$1'.'<wbr>', $row['email']) . '</td><td>' . $row['date'] . '</td><td>' . preg_replace('/([^\s]{25})(?=[^\s])/', '$1'.'<wbr>', $row['msg']) . '</td></tr>';
          }
          echo '</tbody></table></div>';
        } else {
            echo '<div class="col span_2_of_12"></div><div class="col span_8_of_12 error"><p class="title">This database is empty</p></div>';
        }
      } else {
        echo '<div class="col span_2_of_12"></div><div class="col span_8_of_12 error">';
        if(!empty($usernameErr)) {
          echo '<p class="title">' . $usernameErr . '</p><br />';
        }

        if(!empty($passwordErr)) {
          echo '<p class="title">' . $passwordErr . '</p><br />';
        }

        echo '</div>';
      }
    }
    if(empty($username) && empty($password)) {
      echo '<div class="col span_2_of_12"></div><div class="col span_8_of_12 error">';
      echo '<p class="title"> You are not logged in! </p>
      <a href="login.html"><p>Come back to login by pressing here</p></a></div>';
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
