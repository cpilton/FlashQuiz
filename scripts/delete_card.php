<?php

require 'database.php';
session_start();

$card_id = $_GET['card'];


$sql = "DELETE FROM card WHERE id='$card_id'";

if ($con->query($sql) === TRUE) {
    echo "success";
} else {
    echo "fail";
}

die();


?>