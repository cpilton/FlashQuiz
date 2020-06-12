<?php
session_start();
if(isset($_SESSION['used'])) {
unset($_SESSION['used']);
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Flash Quiz | Play</title>
	
	<link rel="icon" href="img/favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" type="text/css" href="styles/play.css">
	<script src="js/jquery-3.2.1.min.js"></script>
</head>

<body>
		<a href="index.php"><img src="img/logo.svg" id="logo"></a>

	
	<div id="quiz-contents">
	
			<form class="form" method="post" id="get-game-form" action="scripts/get-game.php?limit=0" style="width:375px;">
				<input type="text" name="pin" id="pin" placeholder="Enter Game PIN" required>

				<input type="submit" value="Play" id="play">
			</form>
	
		</div>
	
	
	
</body>
</html>

<script>
$( "#get-game-form" ).submit( function ( event ) {
		event.preventDefault();

		var request_method = $( this ).attr( "method" );
		var form_data = $( this ).serialize();
		var post_url = $( this ).attr( "action" );

		$.ajax( {
			type: request_method,
			url: post_url,
			data: form_data,
			success: function ( response ) {
						$( "#quiz-contents" ).html( response );
				showNext();
				
			}
		} );
	} );


function showAnswer() {
		$( "#show-answer" ).css( "transform", "scale(0,0)" );
		setTimeout( function () {
			$( "#answer" ).css( "transform", "scale(1,1)" );
		}, 200 );
		setTimeout( function () {
			$( "#next-question" ).css( "transform", "scale(1,1)" );
		}, 400 );
	}
	
	function nextQuestion(id) {
		hideAll();
		
		setTimeout( function () {
		$.ajax( {
			type: "GET",
			url: "scripts/get-game.php?limit="+id,
			dataType: "html",
			success: function ( response ) {
				$( "#quiz-contents" ).html( response );
				
				if (response.search('<div id="game-over">') == -1) {
				showNext()
				} else {
				showEnd();
				}
			},
			error: function () {
			    nextQuestion(id)
			}
		} );
			}, 600 );
	}
	
	function hideAll() {
		$( "#next-question" ).css( "transform", "scale(0,0)" );
		setTimeout( function () {
			$( "#answer" ).css( "transform", "scale(0,0)" );
		}, 200 );
		setTimeout( function () {
			$( "#question" ).css( "transform", "scale(0,0)" );
		}, 400 );
		setTimeout( function () {
			$( "#category" ).css( "transform", "scale(0,0)" );
		}, 400 );
	}
	
	function showNext() {
		setTimeout( function () {
		$( "#question" ).css( "transform", "scale(1,1)" );
			}, 200 );
		setTimeout( function () {
			$( "#show-answer" ).css( "transform", "scale(1,1)" );
		}, 400 );
		setTimeout( function () {
			$( "#category" ).css( "transform", "scale(1,1)" );
		}, 200 );
		
	}
	
	function showEnd() {
		setTimeout( function () {
		$( "#game-over" ).css( "transform", "scale(1,1)" );
			}, 200 );
		setTimeout( function () {
			$( "#game-over" ).css( "transform", "scale(0,0)" );
			}, 1700 );
		setTimeout( function () {
		$( "#get-game-form" ).css( "transform", "scale(1,1)" );
		}, 1900 );
	}
	
</script>