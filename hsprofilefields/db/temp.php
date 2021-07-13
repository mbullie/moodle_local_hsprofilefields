<?php



	
	//we get the values for fields first
	$fields = array_map('str_getcsv', file(getcwd().'/profilefields.csv'));
	var_dump($fields);exit();
	
?>
 
	