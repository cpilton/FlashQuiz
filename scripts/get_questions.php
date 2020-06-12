<?php
session_start();
require 'database.php';
$user_id = $_SESSION[ 'user_id' ];
$deck_id = $_SESSION[ 'deck' ];


$topics = array();
$sql = "SELECT DISTINCT topic_id FROM card WHERE deck_id = '$deck_id' ORDER BY topic_id";
	$result = $con->query( $sql );
	while ( $row = $result->fetch_assoc() ) {
		array_push($topics, $row['topic_id']);
	}


$count = 1;
foreach ($topics as $topic) {
$sql = "SELECT * FROM card WHERE deck_id = '$deck_id' AND topic_id = '$topic'";
	
		$topic_id = $row['topic_id'];
	$sql2 = "SELECT * FROM topic WHERE id = '$topic'";
$result2 = $con->query( $sql2 );
while ( $row2 = $result2->fetch_assoc() ) {
	$colors = array("rgba(255, 51, 51, 0.3)","rgba(255, 143, 51, 0.3)","rgba(31, 153, 153, 0.3)","rgba(41, 204, 41, 0.3)");
	$color = $colors[rand(0,3)];
	
	echo '<div class="topic-header" style="background-color:'.$color.'" onclick="toggleTable('.$row2['id'].')">'.$row2['name'].'<span class="right-span">Game ID: '.$deck_id.'/'.$topic.'</span></div>';
	echo '<table class="card-table" id="'.$row2['id'].'"><tr><th></th><th>Question</th><th>Answer</th><th></th><th></th></tr>';
}
	
	
	
	
$result = $con->query( $sql );
while ( $row = $result->fetch_assoc() ) {
	

	

	echo '<tr><td width="50px" style="text-align: center">' . $count . '</td><td width="40%">' . $row[ "question" ] . '</div></td><td width="40%">' . preg_replace("/\n/", "<br />", $row[ "answer" ]) . '</div></td>';
	
	
	echo '<td width="75px" style="text-align: center" class="text-link" onclick="editCard(' . $row[ "id" ] . ')">Edit</td>	<td width="75px" style="text-align: center" class="text-link"';

	$sql2 = "SELECT user_id FROM deck WHERE id = '$deck_id'";
$result2 = $con->query( $sql2 );
while ( $row2 = $result2->fetch_assoc() ) {
    $deck_user = $row2['user_id'];
    }
    if ($deck_user == $user_id) {
    echo 'onclick="deleteCard(' . $row[ "id" ] . ')"';
    }
    
    echo '>Delete</td>';

	$count++;

}
	echo '</tr></table>';
}


?>

<script>
	
	function toggleTable( table ) {
		if ($( "#" + table ).css( "max-height" ) == "0px" ) {
		$( ".card-table" ).css( "max-height", "0px" );
		$( "#" + table ).css( "max-height", "500px" );
		} else {
			$( "#" + table ).css( "max-height", "0px" );
		}
	}
	
	
	
	
</script>
	
	
	

