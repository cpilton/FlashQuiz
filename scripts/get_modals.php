<?php

session_start();
require 'database.php';
$user_id = $_SESSION[ 'user_id' ];
$deck_id = $_SESSION[ 'deck' ];

echo '<div id="add-modal" class="modal-card"><div class="modal-title">Add Card</div> <span class="close-modal" onclick="closeModal()">x</span><form class="modal-form" method="post" id="add-form" action="scripts/add_card.php" style="width:300px;">Question<textarea name="question" form="add-form"></textarea>Answer<textarea name="answer" form="add-form"></textarea><div class="wrapper"><select name="topic" size="1"><option value="0">Add new Topic</option>';
	$sql = "SELECT * FROM topic WHERE deck_id = '$deck_id'";
$result = $con->query( $sql );
while ( $row = $result->fetch_assoc() ) {
  echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
}

echo '<input type="text" pattern=".{1,}" name="new-topic" id="new-topic" placeholder="Topic Name"></input>';
echo '</select></div><input type="submit" value="Add" id="add-btn"></form></div>';

echo '<div id="share-modal" class="modal-card"><div class="modal-title">Share Deck</div> <span class="close-modal" onclick="closeModal()">x</span><form class="modal-form" method="post" id="share-form" action="scripts/share_card.php" style="width:300px;"><input type="text" placeholder="User ID" name="user_id" id="user_id" style="width:220px;" required><input type="submit" value="Add" id="add-btn"></form></div>';


?>


<script>
	
	$('select').on('change', function() {
  		if (this.value == 0) {
			$('#new-topic').removeAttr("disabled");
			$('#new-topic').css("background", "#ffffff");
		} else {
			$('#new-topic').prop("disabled", "disabled");
			$('#new-topic').css("background", "#eeeeee");
			   }
})
	
	
	$( "#add-form" ).submit( function ( event ) {
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
					closeModal();
					getQuestions();
				}
			}
		} );
	} );
</script>

<script>
	$( "#share-form" ).submit( function ( event ) {
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
					closeModal();
					getQuestions();
				}
			}
		} );
	} );
</script>

<?php




$sql = "SELECT * FROM card WHERE deck_id = '$deck_id'";
$result = $con->query( $sql );
$count = 0;
while ( $row = $result->fetch_assoc() ) {


	echo '<div id="edit-modal-' . $row[ 'id' ] . '" class="modal-card edit-modal" style="height:500px"><div class="modal-title">Edit Card</div> <span class="close-modal" onclick="closeModal()">x</span><form class="modal-form" method="post" id="edit-form-' . $row[ 'id' ] . '" action="scripts/edit_card.php?card=' . $row[ 'id' ] . '" style="width:300px;">Question<textarea name="question" form="edit-form-' . $row[ 'id' ] . '">' . $row[ 'question' ] . '</textarea>Answer<textarea name="answer" form="edit-form-' . $row[ 'id' ] . '">' . $row[ 'answer' ] . '</textarea><input type="submit" value="Edit" id="add-btn"></form></div>';

	echo '<div id="delete-modal-' . $row[ 'id' ] . '" class="modal-card delete-modal"><div class="modal-title">Delete Card</div> <span class="close-modal" onclick="closeModal()">x</span><form class="modal-form" method="post" id="delete-form-' . $row[ 'id' ] . '" action="scripts/delete_card.php?card=' . $row[ 'id' ] . '" style="width:300px;">Are you sure you want to delete this card?</br></br><input type="submit" value="Delete" id="add-btn"></form></div>';



	?>
	<script>
		$( '#edit-form-<?php print $row['id']?>' ).submit( function ( event ) {
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
						closeModal();
						getQuestions();
					}
				}
			} );
		} );

		$( '#delete-form-<?php print $row['id']?>' ).submit( function ( event ) {
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
						closeModal();
						getQuestions();
					}
				}
			} );
		} );
	</script>
	
	<?php
}
?>
