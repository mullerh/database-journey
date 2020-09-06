<?php
	session_start();
	$host = "localhost";
	$db_name = "movie_database";
	$username = "root";
	$password = "";

	$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

	if(isset($_POST['movie_id']) and isset($_SESSION['user_id'])) {
		
		$movie_ids = $_POST['movie_id'];
	

		$user_id = $_SESSION['user_id'];
		
		foreach($movie_ids as $id) {
			$data = [
				'user_id' => $user_id,
				'movie_id' => $id
			];

			$sql = "SELECT pref_id FROM user_pref WHERE user_id = :user_id AND movie_id = :movie_id";
			$result = $con->prepare($sql);
			$result->execute($data);

			$pref_row = $result->fetch(PDO::FETCH_ASSOC);

			if($pref_row == NULL) {
				$sql = "INSERT INTO user_pref (user_id, movie_id) VALUES (:user_id, :movie_id)";
				$result = $con->prepare($sql);
				$result->execute($data);

			}
		}

		echo "<script>window.location = 'watched_movies.php'</script>";

	} elseif(! isset($_SESSION['user_id'])) {

		echo "You need to be logged in for movie suggestions.";
		echo '<form action="website.php" method="post"><input type="submit" value="Home Page"/></form>';

	} else {

		echo "<script>window.location = 'watched_movies.php'</script>";

	}
?>