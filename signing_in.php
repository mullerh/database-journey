<?php
	session_start();
	$host = "localhost";
	$db_name = "movie_database";
	$username = "root";
	$password = "";

	$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

	$user_username = $_POST['username'];
	$user_password = $_POST['password'];

	$sql = "SELECT user_id FROM users WHERE username = '" . $user_username . "' AND password = '" . $user_password . "'";
	$result = $con->prepare($sql);
	$result->execute();

	$user_row = $result->fetch(PDO::FETCH_ASSOC);

	if($user_row == NULL) {
		echo "Sorry, wrong username or password, try again:<br>";
		echo '<form action="signin.php" method="post"><input type="submit" value="Try Again"/></form>';
	} else {
		$_SESSION['user_id'] = $user_row['user_id'];
		echo "<script>window.location = 'website.php'</script>";
	}
?>