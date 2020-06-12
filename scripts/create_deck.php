<?php

require 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
	echo "login";
	die();
}



$create = $DBH->prepare( 'INSERT INTO deck VALUES(null, :user_id, :name)' );
$create->bindParam( 'user_id', $_SESSION['user_id'] );
$create->bindParam( 'name', $_POST[ 'deck' ] );
$create->execute();


echo "success";

?>