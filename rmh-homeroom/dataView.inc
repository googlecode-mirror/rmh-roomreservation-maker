<?php 
/*
 * Copyright 2011 by Alex Lucyk, Jesus Navarro, and Allen Tucker.
 * This program is part of RMH Homeroom, which is free software.
 * It comes with absolutely no warranty.  You can redistribute and/or
 * modify it under the terms of the GNU Public License as published
 * by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/

// THIS SECTION GATHERS AND DISPLAYS ROOM OCCUPANCY DATA FOR THE GIVEN PERIOD
// global variables are $date, $dateEnd, and $od ( = new OccupancyData($date, $dateEnd))

echo ("<h3>");
echo ("Room occupancy data for: ".$formattedDate." to ".$formattedEndDate."</h3>");		
echo ("<table>");
$rc = $od->get_room_counts();
$bc = $od->get_booking_counts();
$gc = $od->get_guest_counts();
$tr = $tb = $tg = 0;
echo "<th>Room #</th> <th>Bookings</th> <th>Nights</th> <th>Guests</th>";
foreach($rc as $room_no => $days){
	echo ("<tr>");
	echo ("<td align='center';>". $room_no . "</td>" . 
	    "<td align='center';>". $bc[$room_no] . "</td>". 
	    "<td align='center';>". $days . "</td>". 
	    "<td align='center';>". $gc[$room_no] . "</td>");
	echo ("</tr>");
	$tb += $bc[$room_no];
	$tr += $days;
	$tg += $gc[$room_no];
}
echo "<tr> <td align='center';><strong>Totals:</strong></td><td align='center';>".
      $tb."</td><td align='center';>".
      $tr."</td><td align='center';>".
      $tg."</td></tr>";
echo ("</table>");

echo ("<table>");
$ac = $od->get_address_counts();
$ag = $od->get_address_guest_counts();
$ta = 0;
$tg = 0;
echo "<br><th>State/County</th> <th>Bookings</th><th>Guests</th>";
foreach($ac as $zip => $bookings){
	echo ("<tr>");
	echo ("<td align='center';>". $zip . "</td>" . 
	    "<td align='center';>". $bookings . "</td>" . 
	    "<td align='center';>". $ag[$zip] . "</td>");
	echo ("</tr>");
	$ta += $bookings;
	$tg += $ag[$zip];
}
echo "<tr> <td align='center';><strong>Total:</strong></td><td align='center';>".$ta."</td>".
		"<td align='center';>".$tg."</td></tr>";
echo ("</table>");

echo ("<table>");
$ac = $od->get_age_counts();
$ag = $od->get_age_guest_counts();
$ta = 0;
$tg = 0;
echo "<br><th>Patient Age</th> <th>Bookings</th><th>Guests</th>";
foreach($ac as $age => $bookings){
	echo ("<tr>");
	echo ("<td align='center';>". $age . "</td>" . 
	    "<td align='center';>". $bookings . "</td>" . 
	    "<td align='center';>". $ag[$age] . "</td>");
	echo ("</tr>");
	$ta += $bookings;
	$tg += $ag[$age];
}
echo "<tr> <td align='center';><strong>Total:</strong></td><td align='center';>".$ta."</td>".
		"<td align='center';>".$tg."</td></tr>";
echo ("</table>");

echo ("<table>");
$ac = $od->get_hospital_counts();
$ag = $od->get_hospital_guest_counts();
$ta = 0;
$tg = 0;
echo "<br><th>Hospital</th> <th>Bookings</th><th>Guests</th>";
foreach($ac as $hospital => $bookings){
	echo ("<tr>");
	echo ("<td align='center';>". $hospital . "</td>" . 
	    "<td align='center';>". $bookings . "</td>" . 
	    "<td align='center';>". $ag[$hospital] . "</td>");
	echo ("</tr>");
	$ta += $bookings;
	$tg += $ag[$hospital];
}
echo "<tr> <td align='center';><strong>Total:</strong></td><td align='center';>".$ta."</td>".
		"<td align='center';>".$tg."</td></tr>";
echo ("</table>");
?>