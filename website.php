<?php
	session_start();

	//database credentials
	$host = "localhost";
	$db_name = "movie_database";
	$username = "root";
	$password = "";

	$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

	//select all movies to display them to the user
	$sql = "SELECT * FROM movies";
	$result = $con->prepare($sql);
	$result->execute();

	//checks if the user is logged in (if so allow them to logout and add favourite movies)
	if(isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
		echo '<form action="logout.php" method="post"><input type="submit" value="Log Out"/></form>';
		echo '<form action="watched_movies.php" method="post"><input type="submit" value="Favourite Movies"/></form>';
	//otherwise let them login/signin
	} else {
		echo '<form action="signin.php" method="post"><input type="submit" value="Sign in"/></form>';
		echo '<form action="register.php" method="post"><input type="submit" value="Register"/></form>';
	}

	echo "Movies:<br><br>";
	echo '<form action="adding_watched_movies.php" method="post">';
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		echo "Title: " . $row['name'] . ", Rating: " . $row['rating'] . ", Genre: " . $row['genre'];
		echo "<input type='checkbox' value='" . $row['movie_id'] . "' name='movie_id[]'><br>";
	}
	echo "<br>";

	echo '<input type="submit" value="Add to watched"/></form>';

	echo '<form action="movie_adder.php" method="post"><input type="submit" value="Add Movie"/></form>';

	echo '<form action="movie_searcher.php" method="post"><input type="submit" value="Search For Movies"/></form>';

	echo '<form action="movie_suggester.php" method="post"><input type="submit" value="Suggest Movies"/></form>';

?>