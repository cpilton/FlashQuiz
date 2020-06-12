<?php

require 'database.php';
session_start();

if (isset($_POST[ 'pin' ])) {
	$pin = $_POST[ 'pin' ];
	$_SESSION['pin'] = $pin;
	unset($_SESSION['used']);
} else {
	$pin = $_SESSION['pin'];
}




$limit = $_GET['limit'];

if (strpos($pin, '/') !== false) {
	
	$arr = explode("/", $pin, 2);
	$first = $arr[0];
	$second = $arr[1];
	

	$result = $con->query("SELECT * FROM card WHERE deck_id = '$first' AND topic_id = '$second'");
	$row_cnt = $result->num_rows;
    $result->close();
    
      if (!isset($_SESSION['used'])) {
    for ($i = 0 ; $i < $row_cnt ; $i++ ) {
    $_SESSION['used'][$i] = $i;
}
}

$array_size = sizeof($_SESSION['used']);
    
   $num = rand(0,sizeof($_SESSION['used'])-1);
    $selected = $_SESSION['used'][$num];

    unset($_SESSION['used'][$num]);
    $temp = array_values($_SESSION['used']);
    $_SESSION['used'] = $temp;
  


	$sql = "SELECT * FROM card WHERE deck_id = '$first' AND topic_id = '$second' LIMIT $selected,1";
	
} else {
    
	$result = $con->query("SELECT * FROM card WHERE deck_id = '$pin'");
	$row_cnt = $result->num_rows;
    $result->close();
    
    if (!isset($_SESSION['used'])) {
for ($i = 0 ; $i < $row_cnt ; $i++ ) {
    $_SESSION['used'][$i] = $i;
}
}

    $array_size = sizeof($_SESSION['used']);

    $num = rand(0,sizeof($_SESSION['used'])-1);
    $selected = $_SESSION['used'][$num];

    unset($_SESSION['used'][$num]);
    $temp = array_values($_SESSION['used']);
    $_SESSION['used'] = $temp;
  


$sql = "SELECT * FROM card WHERE deck_id = '$pin' LIMIT $selected,1";


}



if ($array_size > 0) {
$result = $con->query( $sql );
$count = 0;
while ( $row = $result->fetch_assoc() ) {
	$count++;
	
	$sql2 = "SELECT name FROM deck WHERE id = '$pin'";
	$result2 = $con->query( $sql2 );
	while ( $row2 = $result2->fetch_assoc() ) {
		$deck_name = $row2['name'];
	}
	
	$topic_id = $row['topic_id'];
	
	$sql3 = "SELECT name FROM topic WHERE id = '$topic_id'";
	$result3 = $con->query( $sql3 );
	while ( $row3 = $result3->fetch_assoc() ) {
		$topic_name = $row3['name'];
	}
	
	
	echo '<div id="category">'.$deck_name.' | '.$topic_name.'</div>';
	echo '<div id="question">'.nl2br($row['question'], true).'</div>';
	echo '<div id="show-answer" onclick="showAnswer()">Show Answer</div>';
	echo '<div id="answer" class="resize">'.nl2br($row['answer'], true).'</div>';
	echo '<div id="next-question" onclick="nextQuestion('.($limit+1).')">Continue</div>';
	
	echo '<div id="left-progress">'.($limit+1).'</div><div id="myProgress"><div id="myBar"></div></div><div id="right-progress">'.$row_cnt.'</div>';
}

?>
<script>
$( "#myBar" ).css( "transform", "scale(<?php print (($limit)/$row_cnt)?>,1)" );
		setTimeout( function () {
  $( "#myBar" ).css( "transform", "scale(<?php print (($limit+1)/$row_cnt)?>,1)" );
}, 400 );

	
</script>

<?php

} else {
    unset($_SESSION['used']);
	echo '<div id="game-over">You have finished this quiz!</div><form class="form" style="transform:scale(0,0); transition-duration: .2s; transform-origin: center;" method="post" id="get-game-form" action="scripts/get-game.php?limit=0" style="width:375px;"><input type="text" name="pin" id="pin" placeholder="Enter Game PIN" required><input type="submit" value="Play" id="play"></form>';
	
	?>
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
	</script>
	<?php
}



die();
?>