<?php
require 'scripts/database.php';
session_start();
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Flash Quiz | Cards</title>

	<link rel="icon" href="img/favicon.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="styles/main.css">
	<script src="js/jquery-3.2.1.min.js"></script>
</head>

<body>

	<header id="title-header">
		<a href="index.php"><img src="img/logo.svg" id="logo"></a>
		<?php if (isset($_SESSION['user_id'])) { ?><div id="share-id">Share ID: <?php print $user_id?></div><?php } ?>
			<div onclick="toggleMenu()" id="menu-button"></div>
	</header>

	<header id="buttons-header">
	</header>
	
	<table id="deck-table">
	<tr>
		
		
	

	<?php 
		$sql = "SELECT * FROM deck WHERE user_id = '$user_id'";
		$result = $con->query($sql);
		$colors = array("#FF3333"," #FF8F33","#1F9999","#29CC29");
		$count = 1;
		while($row = $result->fetch_assoc()) {
			
		$color = $colors[rand(0,3)];
		
		if ($count == 4) {
	?>
		</tr>
		<tr>
	<?php
		}
	?>
		
		<td>
		<div class="deck-card" style="background-color: <?php print $color ?> " onclick="selectCard(<?php print $row['id']?>)"><?php print $row["name"]?></div>
		</td>
	<?php
		if ($count == 4) {
			$count = 1;
		} else {
			$count++;
		}
	}
		
		$sql = "SELECT * FROM share WHERE user_id = '$user_id'";
		$result = $con->query($sql);
		while($row = $result->fetch_assoc()) {
		$deck_id = $row['deck_id'];
			$sql2 = "SELECT * FROM deck WHERE id = '$deck_id'";
			$result2 = $con->query($sql2);
			while($row2 = $result2->fetch_assoc()) {
				$color = $colors[rand(0,3)];
		
		if ($count == 4) {
	?>
		</tr>
		<tr>
	<?php
		}
	?>
		
		<td>
		<div class="deck-card" style="background-color: <?php print $color ?> " onclick="selectCard(<?php print $row2['id']?>)"><?php print $row2["name"]?><div class="corner-ribbon top-right sticky yellow">Shared</div></div>
		</td>
	<?php
		if ($count == 4) {
			$count = 1;
		} else {
			$count++;
		}
			}
		}
		
	?>
		
	</tr>
	
	</table>
	

	<div id="tr-menu">
		<div class="arrow-up"></div>
		<div class="menu-button" id="login-btn" onclick="selectMenu('login')">Login</div>
		<div class="menu-button" id="register-btn" onclick="selectMenu('register')">Register</div>
		<div class="menu-button" id="welcome-back">Welcome Back<?php if (isset($_SESSION['user_id'])) {
	$uid = $_SESSION['user_id'];
	$sql = "SELECT first_name FROM user WHERE id = '$uid'";
		$result = $con->query($sql);
		while($row = $result->fetch_assoc()) {
			print " ".$row['first_name'];
		}
}
	?>!</div>
		<div class="menu-button" id="logout-btn" onclick="selectMenu('logout')">Logout</div>
		<div class="menu-button" onclick="selectMenu('contact')">Contact</div>

		<div class="login tr-menu-option">
			<img onclick="hideMenu('login')" src="img/arrow.svg">
			<div class="menu-option-title">Login</div>

			<form class="menu-form" method="post" id="login-form" action="scripts/login_handler.php" style="width:300px;">
				<input type="text" name="username" id="username" placeholder="Username" required max="20" min="5">
				<input type="password" name="password" id="password" placeholder="Password" required>
				<input type="submit" value="Login" id="submit">


			</form>

			<div id="login-success" class="login-overlay">You are logged in!</div>
			<div id="login-fail" class="login-overlay">Login failed, please try again.</div>

		</div>

		<div class="register tr-menu-option">
			<img onclick="hideMenu('register')" src="img/arrow.svg">
			<div class="menu-option-title">Register</div>

			<form class="menu-form" id="register-form" action="scripts/register_handler.php" method="post">
				<input type="text" name="first_name" id="first_name" required placeholder="First Name">
				<input type="text" placeholder="Last Name" name="last_name" id="last_name" required>
				<input type="email" placeholder="Email Address" name="email" id="email" required>
				<input type="text" name="username" id="username" required pattern=".{4,12}" placeholder="Username">
				<input type="password" name="password" id="password" pattern=".{8,}" title="Please use at least 8 characters." required placeholder="Password">
				<input type="password" name="confirm_password" id="confirm_password" required placeholder="Confirm Password">
				<input type="submit" value="Create Account" id="submit">
			</form>

			<div id="register-success" class="register-overlay">You are logged in!</div>
			<div id="register-fail" class="register-overlay">Registration failed, please try again.</div>
			<div id="register-email" class="register-overlay">Sorry, that email is already registered.</div>
			<div id="register-username" class="register-overlay">Sorry, that username already exists.</div>
		</div>

		<div class="logout tr-menu-option">
			<img onclick="hideMenu('logout')" src="img/arrow.svg">
			<div class="menu-option-title">Logout</div>
			<form class="menu-form" id="logout-form" action="scripts/logout_handler.php" method="post">
				<input type="submit" value="Logout" id="submit">
		</div>

		<div class="contact tr-menu-option">
			<img onclick="hideMenu('contact')" src="img/arrow.svg">

		</div>
	</div>
<footer><a href="https://callumpilton.co.uk" target="_blank">Callum Pilton</a></footer>
</body>
</html>


<script>
	var translate = 0;

	<?php 
		if(isset($_SESSION['user_id'])) {
	?>
	$( "#login-success" ).show();
	$( "#register-success" ).show();
	logoutBtn();
	<?php
		} 
	?>

	function logoutBtn() {
		$( "#logout-btn" ).show();
		$( "#register-btn" ).hide();
		$( "#login-btn" ).hide();
		$( "#welcome-back" ).show();
	}

	function loginBtn() {
		$( "#logout-btn" ).hide();
		$( "#register-btn" ).show();
		$( "#login-btn" ).show();
		$( "#welcome-back" ).hide();
	}

	function toggleMenu() {
		if ( translate == 0 ) {
			translate = 1;

			$( "#menu-button" ).css( "transform", "rotate(-90deg)" );
			$( "#menu-button" ).css( "background-image", "url('img/arrow.svg')" );
			$( "#tr-menu" ).css( "transform", "scale(1.1,1.1)" );
			setTimeout( function () {
				$( "#tr-menu" ).css( "transform", "scale(1,1)" );
			}, 200 );

		} else {
			translate = 0;
			var logo = "/img/menu.svg";

			$( "#menu-button" ).css( "transform", "rotate(0deg)" );
			$( "#menu-button" ).css( "background-image", "url('img/menu.svg')" );
			$( "#tr-menu" ).css( "transform", "scale(0,0)" );
		}
	}

	function selectMenu( menu ) {

		if ( menu == "register" ) {
			$( "#tr-menu" ).css( "height", "575px" );
		} else if ( menu == "login" ) {
			$( "#tr-menu" ).css( "height", "275px" );
		}

		$( ".menu-button" ).css( "transform", "scale(0,0)" );
		setTimeout( function () {
			$( "." + menu ).css( "transform", "scale(1,1)" );
		}, 200 );
	}

	function hideMenu( menu ) {

		$( "#tr-menu" ).css( "height", "125px" );

		$( "." + menu ).css( "transform", "scale(0,0)" );
		setTimeout( function () {
			$( ".menu-button" ).css( "transform", "scale(1,1)" );
		}, 200 );

	}

	$( "#login-form" ).submit( function ( event ) {
		event.preventDefault();

		var request_method = $( this ).attr( "method" );
		var form_data = $( this ).serialize();
		var post_url = $( this ).attr( "action" );

		$.ajax( {
			type: request_method,
			url: post_url,
			data: form_data,
			success: function ( response ) {
				if ( response == "success" ) {
					loginSuccess();
					logoutBtn();
					location.reload();
				} else if ( response == "fail" ) {
					loginFail();
				}
			}
		} );
	} );

	function loginSuccess() {
		$( "#login-success" ).show();
		$( "#register-success" ).show();
		$( "#tr-menu" ).css( "height", "100px" );
	}

	function loginFail() {
		$( "#login-fail" ).show();
		setTimeout( function () {
			$( "#login-fail" ).hide();
		}, 1500 );
	}

	$( "#register-form" ).submit( function ( event ) {
		event.preventDefault();

		var request_method = $( this ).attr( "method" );
		var form_data = $( this ).serialize();
		var post_url = $( this ).attr( "action" );

		$.ajax( {
			type: request_method,
			url: post_url,
			data: form_data,
			success: function ( response ) {
				if ( response == "success" ) {
					registerSuccess();
					logoutBtn();
					location.reload();
				} else if ( response == "fail" ) {
					registerFail();
				} else if ( response == "username" ) {
					registerUsername();
				} else if ( response == "email" ) {
					registerEmail();
				}
			}
		} );
	} );

	function registerSuccess() {
		$( "#register-success" ).show();
		$( "#login-success" ).show();
		$( "#tr-menu" ).css( "height", "100px" );
	}

	function registerFail() {
		$( "#register-fail" ).show();
		setTimeout( function () {
			$( "#register-fail" ).hide();
		}, 1500 );
	}

	function registerEmail() {
		$( "#register-email" ).show();
		setTimeout( function () {
			$( "#register-email" ).hide();
		}, 1500 );
	}

	function registerUsername() {
		$( "#register-username" ).show();
		setTimeout( function () {
			$( "#register-username" ).hide();
		}, 1500 );
	}

	$( "#logout-form" ).submit( function ( event ) {
		event.preventDefault();

		var request_method = $( this ).attr( "method" );
		var form_data = $( this ).serialize();
		var post_url = $( this ).attr( "action" );

		$.ajax( {
			type: request_method,
			url: post_url,
			data: form_data,
			success: function ( response ) {
				if ( response == "success" ) {
					hideMenu( "logout" );
					$( "#login-success" ).hide();
					$( "#register-success" ).hide();
					loginBtn();
					window.location.href = "index.php";	
				}
			}
		} );
	} );
	
	function selectCard(card) {
		$.ajax( {
			type: "GET",
			url: "scripts/set_deck.php?deck="+card,
			dataType: "html",
			success: function ( response ) {		
			window.location.href = "edit.php";
	}
});
	};
	
</script>