<?php 
/*
 * Copyright 2011 by Alex Lucyk, Jesus Navarro, and Allen Tucker.
 * This program is part of RMH Homeroom, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
?>

<!-- Begin printing out the data of the room as a form -->
<?php
// Grab the booking id and retrieve the booking object
$bookingID = $currentRoom->get_booking_id();
$booking = retrieve_dbBookings($bookingID);

echo ("<h3>Viewing Room ");
echo ($roomID."</h3>");
// echo '<p> (Please change only the information you want to update.)</p>';
if ($booking)
    echo '<p>To view more guest or patient information for this booking, please go <a href="viewBookings.php?id=update&bookingid='.$bookingID.'">here.</a></p>'		
?>
<fieldset>
<form method="POST">

<!--  input fields for everything in the room -->
Beds: <input type="text" name="beds" value="<?php echo($currentRoom->get_beds());?>"/><br />
Room Capacity: <input type="text" name="capacity" value="<?php echo($currentRoom->get_capacity());?>"/><br />
Bath: <select name="bath">
	<?php 
	// fill in the selection for the bath
	if($currentRoom->get_bath() == "y"){
		echo ("<option selected='yes'>Yes</option>");
		echo ("<option>No</option>");
	}else{
		echo ("<option>Yes</option>");
		echo ("<option selected='yes'>No</option>");
	}
	?>
</select><br />
<?php
// Only allow changing the status if it isnt booked
if($currentRoom->get_status() != "booked"){
	echo ("Status: <select name=\"status\">"); 
	$statusArray = array("clean","dirty","off-line");
	foreach($statusArray as $status){
		if($currentRoom->get_status() == $status){
			echo ("<option selected='yes'>".$status."</option>");
		}else{
			echo ("<option>".$status."</option>");
		}
	}
	echo ("</select><br />");
}else{
	$_POST['status'] = "booked";
}
?>

Room Notes: <input type="text" size="50" name="room_notes" value="<?php echo($currentRoom->get_room_notes());?>"/><br />

<?php 

// Take care of a booking. The display changes depending on whether
// or not we have a booking

// If successful, display the guests and add options to add or remove them.
if($booking){
	// Print booking information
	print_booking_info($booking);
	echo "</fieldset>";
	// Add an option to checkout the family
	echo ("<br />");
	if ($_SESSION['access_level']!=2) {
	    echo ("Checkout Family?: <select name='assign_booking'>");
	    echo ("<option selected='yes'>No</option>");
	    echo ("<option>Yes</option>");
	    echo ("</select><br />");
	    echo ("<br />");
	}
}else if ($_SESSION['access_level']!=2) {
	echo "</fieldset><br>";
	// add options to assign a booking
	echo ("Assign a Booking: <select name='assign_booking'>");
	// First option is to leave the room alone
	echo ("<option selected='yes'>Leave Room Unassigned</option>");
	// Grab a list of all pending bookings
	$pendingBookings = retrieve_all_pending_dbBookings(date("y-m-d"));
	if($pendingBookings){
		// Make each booking id a menu item
		foreach($pendingBookings as $booking){
			echo ("<option value='" . $booking->get_id() . "'>");
			$person = retrieve_dbPersons(substr($booking->get_id(), 8));
			if ($person)
				echo ($person->get_first_name() . " " . $person->get_last_name() . " (" .date_string(substr($booking->get_id(),0,8)).")");
			else echo($booking->get_id());
			echo ("</option>");
		}
	}
	echo("</select><br />");
}
else echo "</fieldset><br>";
if ($_SESSION['access_level']!=2) {
    echo "Hit Submit to save these changes: "; 
    echo '<input type="submit" value = "Submit" name = "submit"/>';
}
?>
</form>

<!-- Useful funtions -->
<?php 

// Function to display information about the booking
function print_booking_info($booking){
	echo "<br>";
	echo ("<tr><b>Guests:</b></tr>");
	$guests = $booking->get_occupants();
	// Print each occupant
	foreach($guests as $currentGuest){
		echo ("<br>".$currentGuest);
	}
	// Print the patient associated with the booking
	$patient = $booking->get_patient();
	echo ("<br><br><b>Patient: </b><br>". $patient."<br>");
	
	// print the loaners associated with the booking
//	$loaners = $booking->get_loaners();
//	echo ("Loaners: ");
//	foreach($loaners as $loaner){
//		echo ($loaner.",");
//	}

}
?>