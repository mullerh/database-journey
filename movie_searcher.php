<?php
	$host = "localhost";
	$db_name = "movie_database";
	$username = "root";
	$password = "";

	$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

	$sql = "SELECT DISTINCT genre FROM movies";
	$result = $con->prepare($sql);
	$result->execute();

	echo "Genres:<br><br>";
	echo '<form action="search_results.php" method="post">';

	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		echo $row['genre'];
		echo "<input type='checkbox' value='" . $row['genre'] . "' name='genre[]'><br>";
	}

	echo '<input type="submit" value="Search For Movies"/></form>';

	echo '<form action="website.php" method="post"><input type="submit" value="Home Page"/></form>';
?>