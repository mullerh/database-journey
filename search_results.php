<?php

	$host = "localhost";
	$db_name = "movie_database";
	$username = "root";
	$password = "";

	$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

	if(isset($_POST['genre'])) {
		$genres = $_POST['genre'];

		foreach($genres as $genre) {
			$data = [
				'genre' => $genre
			];
			$sql = "SELECT name, rating, genre FROM movies WHERE genre = :genre";
			$result = $con->prepare($sql);
			$result->execute($data);

			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				echo "Title: " . $row['name'] . ", Rating: " . $row['rating'] . ", Genre: " . $row['genre'] . "<br>";
			}
		}
	} else {
		echo "No search fields added";
	}

	echo '<form action="website.php" method="post"><input type="submit" value="Home Page"/></form>';

?>