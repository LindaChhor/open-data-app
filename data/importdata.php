<?php

require_once '../includes/db.php';

$places_xml = simplexml_load_file('communityGardens.kml');

$sql = $db->prepare('
	INSERT into open_data_app (name, street_address, longitude, latitude)
	VALUES (:name, :street_address, :longitude, :latitude)
');

foreach ($places_xml->Document->Folder[0]->Placemark as $place) {
	//echo $place->name;
	
	$coords = explode(',',trim($place->Point->coordinates));
	//var_dump($coords);
	$adr = '';
	
	foreach($place->ExtendedData->SchemaData->SimpleData as $civic) {
		if ($civic->attributes()->name == 'LEGAL_ADDR') {
			$adr = $civic;
		}
	}
	
	//echo $adr;
	
	$sql->bindValue(':name', $place->name, PDO::PARAM_STR);
	$sql->bindValue(':street_address', $adr, PDO::PARAM_STR);
	$sql->bindValue(':longitude', $coords[0], PDO::PARAM_STR);
	$sql->bindValue(':latitude', $coords[1], PDO::PARAM_STR);
	$sql->execute();
}

var_dump($sql->errorInfo());

