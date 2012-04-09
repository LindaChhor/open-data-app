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
	 
	require_once 'includes/db.php';
	
	$results = $db->query('
	SELECT id, name, longitude, latitude
	FROM splashpool
	ORDER BY id ASC
	');
	
	include 'includes/theme-top.php';

?>


<ol class="pools">
<?php foreach ($results as $pools) : ?>
	<li itemscope itemtype="http://schema.org/TouristAttraction">
		<a href="single.php?id=<?php echo $pools['id']; ?>" itemprop="name"><?php echo $pools['name']; ?></a>
		<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
			<meta itemprop="latitude" content="<?php echo $pools['latitude']; ?>">
			<meta itemprop="longitude" content="<?php echo $pools['longitude']; ?>">
		</span>
	</li>
<?php endforeach; ?>
</ol>

<div id="map"></div>



<?php
	
	include 'includes/theme-bottom.php';

?>