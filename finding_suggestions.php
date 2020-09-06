<?php

	$host = "localhost";
	$db_name = "movie_database";
	$username = "root";
	$password = "";

	$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

	$movie_ids = $_POST['movie_id'];

	//foreach ($movie_ids as $movie_id) {
	//	echo $movie_id . "<br>";
	//}


	//WHERE clause for user id search sql
	function movie_id_search_string($movies) {
		$search_string = "";

		foreach ($movies as $movie) {
			$search_string = $search_string . "movie_id=" . $movie . " OR ";
		}

		return $search_string = rtrim($search_string, " OR ");
	}

	//WHERE clause for movie id search sql
	function user_id_search_string($users, $movies) {
		$search_string = "(";

		foreach ($users as $user) {
			$search_string = $search_string . "user_id=" . $user . " OR ";
		}

		$search_string = rtrim($search_string, " OR ");

		$search_string = $search_string . ") AND NOT (";

		foreach ($movies as $movie) {
			$search_string = $search_string . "movie_id=" . $movie . " OR ";
		}

		return $search_string = rtrim($search_string, " OR ") . ")";
	}

	//set up and execute user search sql

	$sql = "
	SELECT user_id
    FROM (SELECT user_id 
          FROM user_pref 
          WHERE " . movie_id_search_string($movie_ids) . ") AS A 
    GROUP BY user_id 
    HAVING COUNT(user_id) = " . count($movie_ids);

	$result = $con->prepare($sql);
	$result->execute();

	$searched_user_ids = [];

	while ($user_ids_result = $result->fetch(PDO::FETCH_ASSOC)) {
		array_push($searched_user_ids, $user_ids_result['user_id']);
	}

	//set up and execute user search sql

	$sql = "
	SELECT movie_id
    FROM (SELECT * 
          FROM user_pref
          WHERE " . user_id_search_string($searched_user_ids, $movie_ids) . ") AS A
    GROUP BY movie_id
    ORDER BY COUNT(movie_id) DESC
    LIMIT 5";


	$result = $con->prepare($sql);
	$result->execute();

	$searched_movie_ids = [];

	while ($movie_ids_search = $result->fetch(PDO::FETCH_ASSOC)) {
		array_push($searched_movie_ids, $movie_ids_search['movie_id']);
	}

	$sql = "SELECT * FROM movies WHERE " . movie_id_search_string($searched_movie_ids);

	$result = $con->prepare($sql);
	$result->execute();

	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		echo "Title: " . $row['name'] . ", Rating: " . $row['rating'] . ", Genre: " . $row['genre'] . "<br>";
	}

	echo '<br><form action="website.php" method="post"><input type="submit" value="Home Page"/></form>';

/*
(things with ## around them are the variable elements)

FINDING USERS WITH MATCHING MOVIES 

SELECT user_id, COUNT(user_id) AS occurance 
    FROM (SELECT user_id 
          FROM user_pref 
          WHERE movie_id = #1# OR movie_id = #2#) AS A 
    GROUP BY user_id 
    HAVING occurance = #2#


FINDING MOST COMMON MOVIES IN USER LISTS

SELECT movie_id, COUNT(movie_id) AS occurance 
     FROM (SELECT * 
           FROM user_pref
           WHERE user_id = 1 OR user_id = 9) AS A
     GROUP BY movie_id
     ORDER BY occurance DESC
     LIMIT 5

*/


?>