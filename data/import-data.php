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
	 

require_once '../includes/db.php';

$places_xml = simplexml_load_file('2009_splash_pads.kml');

$sql = $db->prepare('
	INSTERT INTO location (name, longitude, latitude)
	VALUE (:name, :longitude, :latitude)
');

//var_dump($places_xml);         -to see if it's working

foreach ($places_xml->Document->Folder[0]->Placemark as $place) {	
	//echo $place->name;
	$coords = explode(',', trim($place->Point->coordinates));
	
	//FOR WHEN YOU HAVE ADDRESS IN KML --------------
	//foreach ($place->ExtendedData->SchemaData->SimpleData as $civic) {
		//if ($civic->attributes()->name == 'LEGAL_ADDR'){
		//	$adr=$civic;
		//}
	//}
	
	$sql->bindValue(':name', $place->name, PDO::PARAM_STR);
	//$sql->bindValue(':street_address', adr, $place->name, PDO::PARAM_STR);
	$sql->bindValue(':longitude', $coords[0], PDO::PARAM_STR);
	$sql->bindValue(':latitude', $coords[1], PDO::PARAM_STR);
	$sql->execute();
	
	
	
}