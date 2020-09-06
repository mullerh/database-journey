<?php
	session_start();

	$host = "localhost";
	$db_name = "movie_database";
	$username = "root";
	$password = "";

	if(isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
		$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

		$sql = "SELECT movie_id FROM user_pref WHERE user_id = '" . $user_id . "'";
		$id_result = $con->prepare($sql);
		$id_result->execute();

		while($movie_id = $id_result->fetch(PDO::FETCH_ASSOC)) {

			$sql = "SELECT * FROM movies WHERE movie_id = '" . $movie_id['movie_id'] . "'";
			$movie_result = $con->prepare($sql);
			$movie_result->execute();

			$row = $movie_result->fetch(PDO::FETCH_ASSOC);

			echo "Title: " . $row['name'] . ", Rating: " . $row['rating'] . ", Genre: " . $row['genre'];
			echo "<input type='checkbox' value='" . $row['movie_id'] . "' name='movie_id[]'><br>";
		}
	} else {
		echo "Sorry, you're not logged in:<br>";
	}

	echo '<form action="website.php" method="post"><input type="submit" value="Home Page"/></form>';
?>