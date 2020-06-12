<?php
require 'database.php';
session_start();

$password = sha1($_POST['password']);

$login = $DBH->prepare('SELECT * FROM user WHERE username=:username LIMIT 0,1;');
$login->bindParam('username', $_POST['username']);
$login->execute();

$user = $login->fetch();

if ($user['password'] == $password) {
	$_SESSION['user_id'] = $user['id'];
	$_SESSION['username'] = $user['username'];
	$_SESSION['first_name'] = $user['first_name'];
	
	echo "success";
} else {
    echo "fail";
}
