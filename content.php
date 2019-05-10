<?php
	session_start();
	if(!isset($_SESSION['login'])){
		header('Location: ../CoffeeBuzz/client/login.html');
	}
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Jordan Tori">

    <title>CoffeeBuzz | Staff Login</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/business-casual.min.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
      <div class="container">
          <ul class="navbar-nav mx-2">
            <li class="nav-item px-lg-4">
              <a class="nav-link text-uppercase text-expanded" href="index.html">Logout</a>
            </li>
            <?php if($_SESSION['username'] == 'admin') : ?> <!-- checks if you are logged in as an admin or not -->
              <li class="nav-item px-lg-4">
             	<a class="nav-link text-uppercase text-expanded" href="settings.php">Admin settings</a>
           	  </li>
        	<?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <section class="page-section cta">
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <div class="cta-inner text-center rounded">
              <h2 class="section-heading mb-2">
                <span class="section-heading-upper">STAFF ORDERING SYSTEM GOES HERE</span>
                <span class="section-heading-lower">STAFF ORDERING SYSTEM GOES HERE</span>
              </h2>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
</html>