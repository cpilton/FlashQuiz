<?php

require 'database.php';
session_start();

$share_id = $_POST['user_id'];
$deck_id = $_SESSION['deck'];

$create = $DBH->prepare( 'INSERT INTO share VALUES(null, :user_id, :deck_id)' );
$create->bindParam( 'user_id', $share_id );
$create->bindParam( 'deck_id', $deck_id);
$create->execute();

echo "success";

?>