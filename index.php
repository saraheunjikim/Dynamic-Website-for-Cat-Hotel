<!DOCTYPE html>
<html lang="en">
<head>
<title>Welcome to MeowTel!</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/index.css">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
include("header.php");
?>
<main>
    <section>
        <div id="videoContainer">
        <video controls autoplay muted id="welcomeVideo">
          <source src="videos/meowtel_welcome.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
        </div>
        <div id="mainContainer">
        <div id="leftPanel">
          <h1>Welcome to MeowTel</h1>
          <p> MeowTel is the place where you can relax with our lovely cats. <br><br>
              We have a 24-hour reception desk that you can call in case you need anything.
              Our staff will be more than willing to assist you with your needs. <br><br>
              Here at MeowTel, your comfort and convenience are always our topmost priority. <br><br>

              Also, we make sure all our cats are safe and happy.</p>
          <a href="reservation.php">
          <button class="button buttonReservation">Make a Reservation</button>
          </a>
        </div>
        <div id="rightPanel">
          <img class="welcomeCat" src="images/home/cat1.jpg" alt="cat1" >
          <img class="welcomeCat" src="images/home/cat2.jpg" alt="cat2">
          <img class="welcomeCat" src="images/home/cat3.jpg" alt="cat3">
        </div>
        </div>
    </section>
</main>
<?php
include("footer.php");
?>
</body>
</html>