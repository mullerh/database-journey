<?php
	//database credentials
	$host = "localhost";
	$db_name = "movie_database";
	$username = "root";
	$password = "";

	$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

	$name = $_POST['name'];
	$rating = $_POST['rating'];
	$genre = $_POST['genre'];

	$data = [
		'name' => $name,
		'rating' => $rating,
		'genre' => $genre
	];

	$sql = "INSERT INTO movies (name, rating, genre) VALUES (:name, :rating, :genre)";
	$result = $con->prepare($sql);
	$result->execute($data);

	echo "<script>window.location = 'website.php'</script>";

?>