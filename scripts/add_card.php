<?php

require 'database.php';
session_start();

if ($_POST['topic'] != 0) {
	$topic = $_POST['topic'];
} else {
	$topic = $_POST['new-topic'];
	
	$create = $DBH->prepare( 'INSERT INTO topic VALUES(null, :deck_id, :name)' );
	$create->bindParam( 'deck_id', $_SESSION['deck'] );
	$create->bindParam( 'name', $topic );
	$create->execute();
	$pin = $_SESSION['deck'];
$sql = "SELECT * FROM topic WHERE deck_id = '$pin' AND name = '$topic' LIMIT 1";
$result = $con->query( $sql );
while ( $row = $result->fetch_assoc() ) {
	$topic = $row['id'];
	
} 

}






$create = $DBH->prepare( 'INSERT INTO card VALUES(null, :deck_id, :question, :answer, :topic)' );
$create->bindParam( 'deck_id', $_SESSION['deck'] );
$create->bindParam( 'question', $_POST[ "question" ] );
$create->bindParam( 'answer', $_POST[ "answer" ] );
$create->bindParam( 'topic', $topic );
$create->execute();

echo "success";

?>