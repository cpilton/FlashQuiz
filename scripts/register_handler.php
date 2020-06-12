<?php

require 'database.php';
session_start();

$password = sha1( $_POST[ 'password' ] );
$username = $_POST[ 'username' ];
$email = $_POST[ 'email' ];

$results = mysqli_query( $ajax_con, "SELECT id FROM user WHERE username='$username'" );
$num_rows = mysqli_num_rows( $results );

if ( $num_rows != 0 ) {
	echo "username";
	die();
}

$results = mysqli_query( $ajax_con, "SELECT id FROM user WHERE email='$email'" );
$num_rows = mysqli_num_rows( $results );

if ( $num_rows != 0 ) {
	echo "email";
	die();
}

$register = $DBH->prepare( 'INSERT INTO user VALUES(null, :first_name, :last_name, :email, :username, :password)' );
$register->bindParam( 'first_name', $_POST[ 'first_name' ] );
$register->bindParam( 'last_name', $_POST[ 'last_name' ] );
$register->bindParam( 'email', $_POST[ 'email' ] );
$register->bindParam( 'username', $_POST[ 'username' ] );
$register->bindParam( 'password', $password );
$register->execute();

$login = $DBH->prepare( 'SELECT * FROM user WHERE username=:username LIMIT 0,1;' );
$login->bindParam( 'username', $_POST[ 'username' ] );
$login->execute();
$user = $login->fetch();

if ( $user[ 'password' ] == $password ) {
	$_SESSION[ 'user_id' ] = $user[ 'id' ];
	$_SESSION[ 'username' ] = $user[ 'username' ];
	$_SESSION[ 'first_name' ] = $user[ 'first_name' ];

	echo "success";
} else {
	echo "fail";
}

?>