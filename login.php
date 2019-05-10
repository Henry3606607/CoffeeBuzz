<?php
	session_start();
?>

<html>
	<body>
		<?php
			$entered_username = $_POST['username'];
			$entered_password = $_POST['password'];
			$exist = 0;
			
			foreach(file('../CoffeeBuzz/database/users.txt') as $line) {
				list($a, $b) = explode(",",$line);
				if($a == $entered_username) {
					if($b == $entered_password . "\n") {
						$exist = 1;
						break;
					}
				}
			}

			if($exist == 1) {
				$_SESSION['login'] = "YES";
				$_SESSION['username'] = $entered_username;
				header('Location: ../CoffeeBuzz/content.php');
			}else {
				echo 'failed';
				//header('Location: ../CoffeeBuzz/store.html');
			}
		?>
		
	</body>
</html>