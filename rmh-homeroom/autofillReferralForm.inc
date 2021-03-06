<form method="POST">
<?php 
if ($_SESSION['access_level']==0)
    echo "<b> To request a room at the Ronald McDonald House, please fill out the following form:</b>";
else if ($id=='update') {
    echo "<b> Updating a pending or active booking " ;
	echo ("</b> (All fields are required unless noted as <i>Optional</i>):<br><br>");
}
else {
	echo "<b> Creating a new referral " ;
	echo ("</b> (All fields are required unless noted as <i>Optional</i>):<br><br>");
}
?>
<div align="left">
<fieldset>
<legend>Booking Information:</legend>
Patient's Name <input type="text" name="patient_name" value= "<?php echo($guest->get_patient_name())?>"/>

Patient's birth date:  
    <select name = "patient_birth_month">
    <?php 
      $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
	  echo("<option> </option>");
      for ($i = 1 ; $i <= 9 ; $i ++){
          if('0'.$i == substr($patient_DOB,3,2))
             echo ("<option value='0".$i."' selected = 'yes'>".$months[$i-1]."</option>");
          else
             echo ("<option value='0".$i."'>".$months[$i-1]."</option>");
      }
      for ($i = 10 ; $i <= 12 ; $i ++){
          if($i == substr($patient_DOB,3,2))
             echo ("<option value=".$i." selected = 'yes' >".$months[$i-1]."</option>");
          else
             echo ("<option value=".$i.">".$months[$i-1]."</option>");
      }
    ?>
    </select>
    /
    <select name = "patient_birth_day">
    <?php 
      echo("<option>  </option>");
      for ($i = 1; $i <= 9 ; $i ++){
          if($i == substr($patient_DOB,6,2))
             echo ("<option value='0".$i."' selected = 'yes'>".$i."</option>");
          else
             echo ("<option value='0".$i."'>".$i."</option>");
      }
      for ($i = 10; $i <= 31 ; $i ++){
          if($i == substr($patient_DOB,6,2))
             echo ("<option selected = 'yes'>".$i."</option>");
          else
             echo ("<option>".$i."</option>");
      }
    ?>
    </select>
    /
    <input type="text" size = "1" maxLength = "2" name="patient_birth_year" value= "<?php echo(substr($patient_DOB,0,2))?>"/><br />
					
Hospital <select name="hospital">
			<?php 
$hospitals = array("Maine Medical Center", "Mercy Hospital", "Spring Harbor Hospital", "Specialist", "other");	
			foreach($hospitals as $hospital){
				echo ("<option value='");
				echo ($hospital. "' ");
				if ($tempBooking->get_hospital() == $hospital || $id == "new" && $hospital == "Maine Medical Center")
				    echo "SELECTED";
				echo (">".$hospital."</option>");
			}
			?>
</select>
Department of Treatment  
<select name="dept">
			<?php 
$departments = array("", "NICU", "PICU", "SCU", "BBCH", "Pediatrics", "NEEDS Program", "Prenatal", "MCCP", "Other");			
			foreach($departments as $department){
				echo ("<option value='");
				echo ($department. "' ");
				if ($tempBooking->get_department() == $department)
				    echo "SELECTED";
				echo (">".$department."</option>");
			}
			?>
</select><br>

Referred by: <input type="text" size="35" name="referred_by" value="
<?php 
if ($tempBooking->get_referred_by()!="")
	echo($tempBooking->get_referred_by());
else 
	echo($user_name." (".substr($user_phone,0,3)."-".substr($user_phone,3,3)."-".substr($user_phone,6).")");
?>"/>
Date Submitted: <?php echo date_string($tempBooking->get_date_submitted())?><br />
 <br/>

<fieldset>
  <legend>Primary Guest Information:</legend>
    First Name: <input type="text" size="30" name="first_name_1" value= "<?php echo($guest->get_first_name())?>"/><br />
    Last Name: <input type="text" size="30" name="last_name_1" value= "<?php echo($guest->get_last_name())?>" /><br />
    Relationship to Above Patient: <input type="text" size = "30" name = "patient_relation_1" value= "<?php echo($guest->get_patient_relation())?>"/><br />
    Home Address: <input type="text" size="40" name = "address_1" value= "<?php echo($guest->get_address())?>"/><br />
    City: <input type = "text" size = "15" name = "city_1" value= "<?php echo($guest->get_city())?>"/> 
    State: <select name = "state_1">
  <?php

			$states = array("  ", "AL","AK","AR","AZ","CA","CO","CT","DC","DE","FL","GA","HI","IA","ID","IL","IN",
					        "KS","KY","LA","MA","MD","ME","MI","MN","MO", "MS","MT","NC","ND","NE","NH","NJ","NM",
					        "NV","NY","OH","OK","OR","PA","RI","SC","SD","TN","TX","UT","VA","VT","WA","WI",
					        "WV","WY");
			foreach ($states as $st) {
			    if ($st == $guest->get_state())
			       echo "<option selected='yes'>" . $st ."</option>";
			    else
				   echo "<option>" . $st ."</option>";
			}
		?>
    </select>
    Zip: <input type = "text" size = "5" maxLength = "5" name="zip_1" value= "<?php echo($guest->get_zip())?>"/> <br />
    E-mail <i>(Optional):</i> <input type="text" size="30" name="email_1" value= "<?php echo($guest->get_email())?>"/><br />
  <?php 
    $phone1 = $guest->get_phone1();
    $phone2 = $guest->get_phone2();
   ?>
    Phone #: (<input type = "text" size = "2" maxLength = "3" name="phone1_area_1" value="<?php echo(substr($phone1,0,3))?>"/>) 
              <input type = "text" size = "2" maxLength = "3" name="phone1_middle_1" value="<?php echo(substr($phone1,3,3))?>"/> - 
              <input type = "text" size = "3" maxLength = "4" name="phone1_end_1" value="<?php echo(substr($phone1,6,4))?>"/> 
    Alternate Phone # <i> (Optional): </i>(<input type = "text" size = "2" maxLength = "3" name="phone2_area_1" value="<?php echo(substr($phone2,0,3))?>"/>) 
             <input type = "text" size = "2" maxLength = "3" name="phone2_middle_1" value="<?php echo(substr($phone2,3,3))?>"/> - 
             <input type = "text" size = "3" maxLength = "4" name="phone2_end_1" value="<?php echo(substr($phone2,6,4))?>"/>  <br />

</fieldset>
<br />
<b> Additional Guests </b> <i>(Optional, maximum of 4)</i>:
<br/>
<br />
<?php
  $occupants = $tempBooking->get_occupants();
  for ($counter = 1; $counter <=4; $counter++){
      $occupant_name = substr($occupants[$counter],0,strpos($occupants[$counter],":"));
      $occupant_relation = substr($occupants[$counter],strpos($occupants[$counter],":")+1);
     echo
		'
		Name: <input type="text" size="15" name = "additional_guest_'.$counter.'" value = "'.$occupant_name.'"/>
		Relationship to Patient: <input type="text" size="22" name = "additional_guest_'.$counter.'_relation" value = "'.$occupant_relation.'"/>
		<br />
		';
  }
?>


<br />
<b>Select Payment Arrangement:</b><br />
 <input type="radio" name="payment" value="10 per night" <?php if($tempBooking->get_payment_arrangement() == "10 per night") echo('checked')?>/> $10 per night<br />
 <input type="radio" name="payment" value="other" <?php if($tempBooking->get_payment_arrangement()!= "10 per night" && $tempBooking->get_payment_arrangement()!= ""  ) echo('checked')?>/> Other:  
       <input type="text" name="payment_description" size="20" value = "<?php if($tempBooking->get_payment_arrangement()!= "10 per night") echo($tempBooking->get_payment_arrangement())?>"/> <br />
<br />

<?php 
echo "<b>Status: </b>". $tempBooking->get_status(); 

echo "<br />";
if ($tempBooking->get_status()!="active") {
    ?>
<b>Select one of the following: </b> <br />
 <input type="radio" name="visitOrWC" value="visit" <?php if($tempBooking->get_date_in() != "Will Call") echo('checked')?>/> Will Visit 
    <i>(Date of Initial Visit:  </i>
   
    <select name = "date_in_month">
    <?php
    
    echo("<option> </option>");
      for ($i = 1 ; $i <= 9 ; $i ++){
          if('0'.$i == substr($date_in,3,2) && $tempBooking->get_date_in() != "Will Call")
             echo ("<option value='0".$i."' selected = 'yes'>".$months[$i-1]."</option>");
          else
             echo ("<option value='0".$i."'>".$months[$i-1]."</option>");
      }
      for ($i = 10 ; $i <= 12 ; $i ++){
          if($i == substr($date_in,3,2) && $tempBooking->get_date_in() != "Will Call")
             echo ("<option value=".$i." selected = 'yes'>".$months[$i-1]."</option>");
          else
             echo ("<option value=".$i.">".$months[$i-1]."</option>");
      }
    ?>
    </select>
    /
    
    <select name = "date_in_day">
     <?php 
      echo("<option>  </option>");
      for ($i = 1; $i <= 9 ; $i ++){
          if($i == substr($date_in,6,2) && $tempBooking->get_date_in() != "Will Call")
             echo ("<option value='0".$i."' selected = 'yes'>".$i."</option>");
          else
             echo ("<option value='0".$i."'>".$i."</option>");
      }
      for ($i = 10; $i <= 31 ; $i ++){
          if($i == substr($date_in,6,2) && $tempBooking->get_date_in() != "Will Call")
             echo ("<option selected = 'yes'>".$i."</option>");
          else
             echo ("<option>".$i."</option>");
      }
      ?>
      </select>
      /
    
    <input type="text" size = "1" maxLength = "2" name="date_in_year" value= "<?php if ($tempBooking->get_date_in() != "Will Call") echo (substr($date_in,0,2))?>"/> <i>)</i> <br />
    
    
 <input type="radio" name="visitOrWC" value="Will Call" <?php if($tempBooking->get_date_in()== "Will Call") echo('checked')?>/> Will Call 
 <?php } // active booking
else echo " <b>Check-in date:</b> ".date_string($tempBooking->get_date_in());
 ?>
<br />
<br />
<b>Approved Use(s): </b> <br />
 <input type="checkbox" name="overnight" value="yes" <?php if($tempBooking->overnight_use() == "yes") echo('checked')?>/> Overnight<br />
 <input type="checkbox" name="day" value="yes" <?php if($tempBooking->day_use() == "yes") echo('checked')?>/> Day <br />
<br />
<b>Additional Notes</b> <i>(optional):</i><br />
  <textarea rows = "3" cols = "80" name = "notes" ><?php echo $tempBooking->get_mgr_notes()?></textarea>
 <br />
 
</fieldset>

<br>
<fieldset><legend>Ronald McDonald House Health Questionnaire:</legend>
<b>Please answer the following questions for all guests who will be staying at the House.</b><br> (Check any items that apply.)
<br>
<br>Do you currently:
<br><input type="checkbox" name="health[]" value="flu" 
    <?php if($tempBooking->get_health_question(1) != "0") echo(' checked')?>>1.  Have flu-like symptoms?
<br><input type="checkbox" name="health[]" value="shingles" 
    <?php if($tempBooking->get_health_question(2) != "0") echo(' checked')?>>2.  Have active shingles? 
<br><input type="checkbox" name="health[]" value="tb" 
    <?php if($tempBooking->get_health_question(3) != "0") echo(' checked')?>>3.  Have active TB?
<br><input type="checkbox" name="health[]" value="strep"
    <?php if($tempBooking->get_health_question(4) != "0") echo(' checked')?>>4.  Have active conjunctivitis, impetigo, or strep throat?
<br><input type="checkbox" name="health[]" value="lice"
    <?php if($tempBooking->get_health_question(5) != "0") echo(' checked')?>>5.  Have active scabies, head lice, or body lice?
<br><input type="checkbox" name="health[]" value="whoopingcough"
    <?php if($tempBooking->get_health_question(6) != "0") echo(' checked')?>>6. Have whooping cough?
<br><br>Have you:
<br><input type="checkbox" name="health[]" value="measles" 
    <?php if($tempBooking->get_health_question(7) != "0") echo(' checked')?>>7.  Been exposed to measles in the last 18 days?
<br><input type="checkbox" name="health[]" value="nomeaslesshot" 
    <?php if($tempBooking->get_health_question(8) != "0") echo(' checked')?>>8.  Elected not to be immunized against measles?
<br><input type="checkbox" name="health[]" value="chickenpox"
    <?php if($tempBooking->get_health_question(9) != "0") echo(' checked')?>>9.  Had or been exposed to chicken pox in the last 21 days?
<br><input type="checkbox" name="health[]" value="chickenpoxshot"
    <?php if($tempBooking->get_health_question(10) != "0") echo(' checked')?>>10. Been vaccinated against chicken pox in the last 21 days?
<br><br>Do any of the children:
<br><input type="checkbox" name="health[]" value="hepatitisb"
    <?php if($tempBooking->get_health_question(11) != "0") echo(' checked')?>>11. Carry the hepatitis B virus? 
</fieldset>
</div>
<div align ="left">
<br>Hit Submit to complete this form: 
<input type="submit" value = "Submit" name = "submit"/>
<?php 
if ($id == "new") {
    echo '<br>Hit Clear Form to start over: ';
    echo '<input type="submit" value = "Clear Form" name = "submit"/>';
}
?>
</div>
</form>