<?php
	/**
	 * Displays the list and map for the Open Data Set
	 * 
	 * @package Splash Pads finder
	 * @copyright 2012 Linda Chhor
	 * @author Linda Chhor <hey@LindaChhor.ca>
	 * @link https://LindaChhor@github.com/LindaChhor/open-data-app.git
	 * @license New BSD License
	 * @version 1.0.0
	 */
	 

require_once 'includes/filter-wrapper.php';

$errors = array();

$movie_title = filter_input(INPUT_POST, 'movie_title', FILTER_SANITIZE_STRING);
$director = filter_input(INPUT_POST, 'director', FILTER_SANITIZE_STRING);
$release_date = filter_input(INPUT_POST, 'release_date', FILTER_SANITIZE_STRING);

if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if(empty($movie_title)) {
		$errors['movie_title'] = true;
	}
	if (empty($director)) {
		$errors['director'] = true;
	}
	if (empty($release_date)) {
		$errors['release_date'] = true;
	}
	if (empty($errors)) {
		require_once 'includes/db.php';
		
		$sql = $db->prepare('
			INSERT INTO movie_database (movie_title, director, release_date)
			VALUES (:movie_title, :director, :release_date)
		');
		$sql->bindValue(':movie_title', $movie_title, PDO::PARAM_STR);
		$sql->bindValue(':director', $director, PDO::PARAM_STR);
		$sql->bindValue(':release_date', $release_date, PDO::PARAM_STR);
		$sql->execute();
		
		header('Location: index.php');
		exit;
	}
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Add</title>
	<link href="css/general.css" rel="stylesheet">
</head>

<body>

	<form method="post" action="add.php">
    	<div>
        	<label for="movie_title">Movie Name:<?php if (isset($errors['movie_title'])) : ?> <strong>is required</strong><?php endif; ?></label>
            <input id="movie_title" name="movie_title" value="<?php echo $movie_title; ?>" required>
        </div>
        <div>
        	<label for="director">Director<?php if (isset($errors['director'])) : ?> <strong>is required</strong><?php endif; ?></label>
            <input id="director" name="director" value="<?php echo $director; ?>" required>
        </div>
		<div>
        	<label for="release_date">Release Date:<?php if (isset($errors['release_date'])) : ?> <strong>is required</strong><?php endif; ?></label>
            <input id="release_date" name="release_date" value="<?php echo $release_date; ?>" required>
        </div>
        <button type="submit">Add</button>
    </form>

</body>
</html>