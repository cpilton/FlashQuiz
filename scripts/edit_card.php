<?php

require 'database.php';
session_start();

$question = $_POST['question'];
$answer = $_POST['answer'];
$card_id = $_GET['card'];


$sql = "UPDATE card SET question='$question', answer='$answer' WHERE id='$card_id'";

if ($con->query($sql) === TRUE) {
    echo "success";
} else {
    echo "fail";
}

die();


?>