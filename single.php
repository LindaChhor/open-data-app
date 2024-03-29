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
	 

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');
	exit;
}

require_once 'includes/db.php';

$sql = $db->prepare('
	SELECT id, name, longitude, latitude
	FROM splashpool
	WHERE id = :id
');

$sql->bindValue(':id', $id, PDO::PARAM_INT);
$sql->execute();
$results = $sql->fetch();

if (empty($results)) {
	header('Location: index.php');
	exit;
}

$title = $results['name'];

include 'includes/theme-top.php';

?>

<h1><?php echo $results['name']; ?></h1>
<dl>
	<dt>Longitude</dt><dd><?php echo $results['longitude']; ?></dd>
	<dt>Latitude</dt><dd><?php echo $results['latitude']; ?></dd>
</dl>

<?php

include 'includes/theme-bottom.php';

?>