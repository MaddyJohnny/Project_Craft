<?php
	$mysqli = new mysqli(
				'localhost',
				'root',
				'',
				'CraftDB');


	if($mysqli->connect_error){
		die(' Connect Error ('.$mysqli->connect_errno. ') '.$mysqli->connect_error);
	}
	else echo "<script>console.log('DB connected!');</script>";
?>