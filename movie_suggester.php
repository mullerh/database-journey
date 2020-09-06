<?php
	$host = "localhost";
	$db_name = "movie_database";
	$username = "root";
	$password = "";

	$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

	//select all movies to display them to the user
	$sql = "SELECT * FROM movies";
	$result = $con->prepare($sql);
	$result->execute();

	echo "Pick movies to base suggestion on:<br><br>";
	echo '<form action="finding_suggestions.php" method="post">';
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		echo "Title: " . $row['name'] . ", Rating: " . $row['rating'] . ", Genre: " . $row['genre'];
		echo "<input type='checkbox' value='" . $row['movie_id'] . "' name='movie_id[]'><br>";
	}
	echo "<br>";

	echo '<input type="submit" value="Suggest Movies"/></form>';
?>