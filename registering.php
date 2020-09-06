<?php
	session_start();
	$host = "localhost";
	$db_name = "movie_database";
	$username = "root";
	$password = "";

	$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

	$user_username = $_POST['username'];
	$user_password = $_POST['password'];

	$sql = "SELECT username FROM users WHERE username = '" . $user_username . "'";
	$result = $con->prepare($sql);
	$result->execute();

	$user_row = $result->fetch(PDO::FETCH_ASSOC);

	if($user_username == '' or $user_password == '') {
		echo "Cannot have blank entries, try again:<br>";
		echo '<form action="register.php" method="post"><input type="submit" value="Try Again"/></form>';
	} elseif($user_row == NULL) {
		$data = [
			'username' => $user_username,
			'password' => $user_password
		];

		$sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
		$result = $con->prepare($sql);
		$result->execute($data);

		$sql = "SELECT user_id FROM users WHERE username = :username AND password = :password";
		$result = $con->prepare($sql);
		$result->execute($data);

		$user_row = $result->fetch(PDO::FETCH_ASSOC);

		$_SESSION['user_id'] = $user_row['user_id'];
		
		echo "<script>window.location = 'website.php'</script>";
	} else {
		echo "Username taken, try again:<br>";
		echo '<form action="register.php" method="post"><input type="submit" value="Try Again"/></form>';
	}

	//Have passwords be relaxed and not let user put in actual passwords.