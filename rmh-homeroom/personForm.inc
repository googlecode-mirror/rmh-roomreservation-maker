<?PHP
/*
 * Copyright 2008 by Oliver Radwan, Maxwell Palmer, Nolan McNair,
 * Taylor Talmage, and Allen Tucker.  This program is part of RMH Homebase.
 * RMH Homebase is free software.  It comes with absolutely no warranty.
 * You can redistribute it and/or modify it under the terms of the GNU
 * General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
*/
/*
 *	personForm.inc
 *  shows a form for a person to be added or edited in the database
 *	@author Oliver Radwan and Allen Tucker
 *	@version 9/1/2008
 */

if($_SESSION['access_level']<2) {  
        echo("<p id=\"error\">You do not have sufficient permissions to add a person to the database.</p>");
	    ('footer.inc');
		echo('</div></div></body></html>');
		die();
	}
if ($id=='new') {
	  echo('<strong>New Person Input Form</strong><br />');
	  echo('Here you can add a new person to the database.</p>');
}
else {
	   echo('<strong>Person Edit Form</strong><br />');
	   echo('Here you can edit, delete, or change the password for a person in the database.</p><p>');
}

?>
<form method="POST">
	<input type="hidden" name="old_id" value=<?PHP echo("\"".$id."\"");?>>
	<input type="hidden" name="old_pass" value=<?PHP echo("\"".$person->get_password()."\"");?>>
	<input type="hidden" name="_form_submit" value="1">
<p><span style="font-size:x-small;color:FF0000">*</span> denotes required fields
	<span class="bigTable">
	<table>
		<tr><td>First Name<span style="font-size:x-small;color:FF0000">*</span>:</td><td> <input type="text" name="first_name" tabindex=1 value="<?PHP echo($person->get_first_name())?>"></td></tr>
		<tr><td>Last Name<span style="font-size:x-small;color:FF0000">*</span>:</td><td> <input type="text" name="last_name" tabindex=2 value="<?PHP echo($person->get_last_name())?>"></td></tr>
		<tr><td>Address<span style="font-size:x-small;color:FF0000">*</span>:</td><td> <input type="text" name="address" tabindex=3 value="<?PHP echo($person->get_address())?>"></td></tr>
		<tr><td>City<span style="font-size:x-small;color:FF0000">*</span>:</td><td> <input type="text" name="city" tabindex=4 value="<?PHP echo($person->get_city())?>"></td></tr>
		<tr><td>State, Zip:</td>
		<td><select name="state" tabindex=5>
		<?PHP

			$states = array("AL","AK","AZ","AR","CA","CO","CT","DE","DC","FL","GA","HI","ID","IL","IN","IA",
					        "KS","KY","LA","ME","MD","MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM",
					        "NY","NC","ND","OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VT","VA","WA",
					        "WV","WI","WY", "other");
			foreach ($states as $st) {
				echo "<option value='" . $st . "' ";
                if($person->get_state() == $st ) echo("SELECTED");
                else if ($id == "new" && $st =="ME") echo("SELECTED");
                echo ">" . $st . "</option>";
			}
			
		?>
		</select>,
		<input type="text" name="zip" size="5" tabindex=6 value=<?PHP echo $person->get_zip()?>>
		</td></tr>
		<?php if ($id!="new" && $person->get_state()=="ME") {
		    echo "<tr><td>Maine County:</td><td>";
			echo $person->get_county().'</td></tr>';
		}
		?>
		
		
		<tr><td>Primary Phone<span style="font-size:x-small;color:FF0000">*</span>:</td><td> <input type="text" name="phone1" MAXLENGTH=12 tabindex=7 value="<?PHP echo($person->get_phone1())?>"></td></tr>
		<tr><td>Alternate Phone:</td><td><input type="text" name="phone2" MAXLENGTH=12 tabindex=8 value="<?PHP echo($person->get_phone2())?>"></td></tr>
		<tr><td>Email:</td><td><input type="text" name="email" tabindex=9 value="<?PHP echo($person->get_email())?>"></td></tr>
       
	</table>
	</span>
<?PHP
    $st = implode(',',$person->get_type());
    $newpersontypes = array('guest'=>'Guest');
    $types = array('guest'=>'Guest', 'volunteer'=>'Volunteer', 'socialworker'=>'Social Worker', 'manager'=>'Manager' );
    if ($_SESSION['access_level']==0) {
	     echo('<p>Please check "guest" if you are requesting a room at the House:');
	     $ts = $newpersontypes;
    }
	else {
		 echo('<p>Role(s) for this person:');
		 $ts = $types;
	}
	echo('<span style="font-size:x-small;color:FF0000">*</span><br>');
    
	//$i = 0;
    foreach ($ts as $key=>$value) {
    	echo ('<input type="checkbox" name="type[]" value=' . $key);
    	if (strpos($st,$key)!==false) echo(' CHECKED');
    	echo ('>' . $value . '<br />');
    //	$i++;
    }
?>
    <p><span class="bigTable">
    <table>
<?PHP
    if ($id == 'new' || strpos(implode(',',$person->get_type()),'guest') !== false) {
	    echo '<tr><td>Patient\'s Name</td><td> <input type="text" name="patient_name" tabindex=1 value="'.$person->get_patient_name().'"></td></tr>';
?>	   
		<tr><td>Patient's birth date (mm/dd/yy)</td><td>
    <select name = "DateOfBirth_Month">
    <?php 
      echo("<option> </option>");
      for ($i = 1 ; $i <= 9 ; $i ++){
          if (substr($person->get_patient_birthdate(),4,1)==="$i")
             echo ("<option value='0".$i."'selected = 'yes'>".$i."</option>");
          else
             echo ("<option value='0".$i."'>".$i."</option>");
      }
      for ($i = 10 ; $i <= 12 ; $i ++){
          if (substr($person->get_patient_birthdate(),3,2)==="$i")
             echo ("<option selected = 'yes'>".$i."</option>");
          else
             echo ("<option>".$i."</option>");
      }
    ?>
    </select>
    /
    <select name = "DateOfBirth_Day">
    <?php 
      echo("<option>  </option>");
      for ($i = 1; $i <= 9 ; $i ++){
          if(substr($person->get_patient_birthdate(),7,1)==="$i")
             echo ("<option value='0".$i."' selected = 'yes'>".$i."</option>");
          else
             echo ("<option value='0".$i."'>".$i."</option>");
      }
      for ($i = 10; $i <= 31 ; $i ++){
          if(substr($person->get_patient_birthdate(),6,2)==="$i")
             echo ("<option selected = 'yes'>".$i."</option>");
          else
             echo ("<option>".$i."</option>");
      }
    ?>
    </select>
    /
    <input type="text" size = "1" maxLength = "2" name="DateOfBirth_Year" value= "<?php echo(substr($person->get_patient_birthdate(),0,2))?>"/><br />
		

        </td></tr> 
   <?PHP echo '<tr><td>Person\'s relation to patient</td><td> <input type="text" name="patient_relation" tabindex=1 value="'.$person->get_patient_relation().'"></td></tr>';	        
   ?>         
	    </table></span>
<?PHP
    }

    if ($id == 'new' || strpos(implode(',',$person->get_type()),'guest') !== false) {
		if($_SESSION['access_level']<2)
	  	    echo(' disabled="true"');
	  	
	  	if ($id !== 'new') {
	  	    echo('<p>Prior Bookings:<br />');
	  	    foreach ($person->get_prior_bookings() as $prior_booking_id) {
	  	    	 $date = substr($prior_booking_id,0,8);
	  	    	 if ($date!="")
	  	         	echo '<a href="viewBookings.php?id=closed&bookingid='.$prior_booking_id.'">'.date_string($date).'</a> <br>';
	  	    }
	  	}
	  	echo('<p>Manager\'s Notes:<br />');
	  	echo('<textarea name="mgr_notes" rows="3" cols="60"');
	  	echo('>'. $person->get_mgr_notes() . '</textarea>');
	  	
    }

		echo('<input type="hidden" name="password" value="'.$person->get_password().'">');
		echo('<input type="hidden" name="prior_bookings" value="'.implode(',',$person->get_prior_bookings()).'">');
	    echo('<input type="hidden" name="_submit_check" value="1"><p>');
		echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to submit these edits.<br /><br />');
		if ($id != 'new' && $_SESSION['access_level']==3) {
			echo '<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
				'<input type="submit" value="Delete" name="Delete Entry"> to delete this entry. <br />';
			if (!in_array('guest',$person->get_type()))
			    echo '<input type="checkbox" name="reset_pass" value="RESET"> Check this box and then hit ' .
					'<input type="submit" value="Reset Password" name="Reset Password"> to reset this user\'s password.</p>';
		}
		?>
</form>
