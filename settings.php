<?php
	session_start();
	if(!isset($_SESSION['login'])){  //Makes sure only logged in user can access this page
		header('Location: ../CoffeeBuzz/login.html');
	}

  if($_SESSION['username'] !== 'admin'){  //Makes sure only admin can access this page
    header('Location: ../CoffeeBuzz/content.php');
  }

  if (isset($_POST['newUser'])) { //PHP for adding new user to users.txt

    $enteredNewUsername = $_POST['newUsername'];
    $enteredNewPassword = $_POST['newPassword'];
    $exist = 0;

    foreach(file('../CoffeeBuzz/database/users.txt') as $line) {
      list($a, $b) = explode(",",$line);
      if($a == $enteredNewUsername) {
        $exist = 1;
        break;
      }
    }

    if($exist == 1) {
      echo "This user already exists!";
    }else{
      $file = fopen("../CoffeeBuzz/database/users.txt", "a");
      fwrite($file, $enteredNewUsername . "," . $enteredNewPassword . "\n");
      fclose($file);
      ?> <div class="alert alert-success" style="font-family: Verdana,sans-serif; 15px; line-height: 1.5;"><strong>Success!</strong> User has been added</div> <?php
    }
  }

  if (isset($_POST['removeUser'])) { //PHP for removing a user from users.txt

    $enteredRemoveUser = $_POST['removeUser'];

    $out = array();

    foreach(file('../CoffeeBuzz/database/users.txt') as $line) {
      if(trim($line) == trim($enteredRemoveUser)) {
        list($a, $b) = explode(",",$line);
        if($a == 'admin') {
          ?> <div class="alert alert-danger" style="font-family: Verdana,sans-serif; 15px; line-height: 1.5;"><strong>Error!</strong> You cannot delete the admin</div> <?php
          break;
        }else{
          foreach(file('../CoffeeBuzz/database/users.txt') as $line2) {
            if(trim($line2) != trim($enteredRemoveUser)) {
              $out[] = $line2;
            }
          }
          $fp = fopen('../CoffeeBuzz/database/users.txt', 'w+');
          flock($fp, LOCK_EX);
          foreach($out as $line2) {
           fwrite($fp, $line2);
          }
          flock($fp, LOCK_UN);
          fclose($fp);
          ?> <div class="alert alert-success" style="font-family: Verdana,sans-serif; 15px; line-height: 1.5;"><strong>Success!</strong> User has been removed</div> <?php
        }
      }
    }
  }

  if (isset($_POST['updateUser'])) { //PHP for updating a user from users.txt part 1

    $enteredUpdatePassword = $_POST['newPassword'];
    $oldline = $_POST['updateUser'];

    list($a, $b) = explode(",",$oldline);
    $newline = $a . "," . $enteredUpdatePassword . "\n";

    foreach(file('../CoffeeBuzz/database/users.txt') as $line) {
      if(trim($line) != trim($oldline)) {
        $out[] = $line;
      }else {
        $out[] = $newline;
      }
    }

    $fp = fopen('../CoffeeBuzz/database/users.txt', 'w+');
    flock($fp, LOCK_EX);
    foreach($out as $line) {
     fwrite($fp, $line);
    }
    flock($fp, LOCK_UN);
    fclose($fp);
    ?> <div class="alert alert-success" style="font-family: Verdana,sans-serif; 15px; line-height: 1.5;"><strong>Success!</strong> Password has been changed</div> <?php
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
              <li class="nav-item px-lg-4">
              <a class="nav-link text-uppercase text-expanded" href="content.php">Back to tickets</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="page-section cta">
      <div class="container-fluid">
       <h1>Admin Settings</h1><br>
        <div class="row">
          <div class="col-sm-5" style="margin-left: 20px; background: #000; border: 3px groove #ccc; color: #ccc; display: block; padding: 5px; width: 300px;">
            <h2 class="section-heading mb-1">
              <span class="section-heading-upper">List of Users</span>
            </h2>
            <?php
              echo "<table class='table' style='width: 100%; font-family: Raleway; color: #ccc;'>";
              echo "<tr>";
              echo "<th>Username</th>";
              echo "<th>Password</th>";
              echo "<th>Change Password</th>";
              echo "<th>Remove User</th>";
              echo "</tr>";
              foreach(file('../CoffeeBuzz/database/users.txt') as $line) {
                list($a, $b) = explode(",",$line);
                echo "<tr>";
                echo "<td>$a</td>";
                echo "<td>$b</td>";
                //echo "<td> <button type='button' class='btn-light' data-toggle='modal' data-target='#myModal'>Update</button>";
                echo "<td><form action='$_SERVER[PHP_SELF]' method='post'> <input type='text' name='newPassword'> <button type='submit' value='$line' name='updateUser' class='btn-light'>Update</button> </form></td>";
                echo "<td><form action='$_SERVER[PHP_SELF]' method='post'> <button type='submit' value='$line' name='removeUser' class='btn-light'>Remove</button> </form></td>";
                echo "</tr>";
              }
              echo "</table>";
            ?>
          </div>
          <div class="col-sm-5" style="margin-left: 20px;">
            <h2 class="section-heading mb-1">
              <span class="section-heading-upper">Add new user</span>
            </h2>
            <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post"> <!-- form posts back to this page which allows the php code at the top to execute -->
              <h5>Username:<span class="label label-default"></span></h5>
              <input type="text" name="newUsername" required><br><br>
              <h5>Password:<span class="label label-default"></span></h5>
              <input type="password" name="newPassword" required><br><br>
              <button type="submit" name="newUser" class="btn btn-danger">Add user</button> 
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
</html>