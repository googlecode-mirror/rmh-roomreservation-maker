<?php
/*
* Copyright 2011 by Paul Kubler and Bonnie MacKellar.
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
 
/*
* Approve New Request Display Page module for RMH-RoomReservationMaker. 
* This handles getting the data based on the specific case of the title
* @author Paul Kubler
* @version 5/1/12
*/
//start the session and set cache expiry
session_start();
session_cache_expire(30);

$title = "Approve New Room Request"; //This should be the title for the page, included in the <title></title>

include('..\header.php'); //including this will further include (globalFunctions.php and config.php)
include_once(ROOT_DIR .'domain/UserProfile.php');
include_once(ROOT_DIR .'domain/ProfileChange.php');
include_once("../domain/Reservation.php");
include_once(ROOT_DIR .'database/dbProfileActivity.php');
include_once(ROOT_DIR .'database/dbUserProfile.php');
/*
 * If your page includes a form, please follow the instructions below.
 * If not, this code block can be deleted
 * 
 * If the page checks for $_POST data then it is important to validate the token that is attached with the form.
 * Attaching token to a form is described below in the HTML section.
 * Include the following check:
 */
    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        //the security validation was successful, perform required operation here below.
        //*** NOTE *** The validateTokenField DOES NOT filter/sanitize/clean the data fields.
        //A separate function sanitize() should be called to clean the data so that it is html/db safe
    }
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
        //if the security validation failed. display/store the error:
        //'The request could not be completed: security check failed!'

    }
    else
    {
        //there was no POST DATA
    }
  
    //DISPLAY THE ENTIRE FAMILY PROFILE TO SW
?>

<div id="container">

    <div id="content">
        
        <!-- ALL YOUR HTML CONTENT GOES HERE -->
        
        <!-- If your page has a form please follow the coding guideline:
        Once you have your form setup, add the following php code after the form declaration:
        generateTokenField() 
        
        IMPORTANT: Make sure that generateTokenField() is always after validateTokenField in your code sequence
        
        EXAMPLE code block below (can be deleted if not using form) -->
       
       <form name ="approverequestnew" method="post">
            <?php echo generateTokenField(); ?>
                                    
           <h1> Approve Room Requested Modification Form </h1> <br><br>
           <?php
           '<title>$title</title>';

                //gets the family profileID and retrieves the fields into an array to validate the input changes
                //and to display in the html form
                if(isset($_GET['family']) ){
                $familyID = sanitize($_GET['family']);
                $Request = array();
                $modifyRequest = retrieve_dbFamilyProfile($familyID);
                $Request['RequestID']=$reservation->get_roomReservationRequestID();
                $Request['FProfileID']=$reservation->get_familyProfileId();
                $Request['SWProfileID']=$reservation->get_socialWorkerProfileId();
                $Request['DateSubmitted']=$reservation->get_swDateStatusSubmitted();
                $Request['activity']=$reservation->get_activityType();
                $Request['begindate']= $reservation->get_beginDate();
                $Request['enddate']=$reservation->get_endDate();
                $Request['diagnosis']=$reservation->get_patientDiagnosis();
                $Request['roomnote']=$reservation->get_roomnote();
            }
           'New Room Request</br>
           Request ID:'.$Request['RequestID'].'</br>
           Family Profile ID:   '.$Request['FProfileID'].'</br>
           Social Worker Profile ID: '.$Request['SWProfileID'].'</br>
           Date Submitted:      '.$Request['DateSubmitted'].'</br>
           Activity:            '.$Request['activity'].'</br>
           Begin Date:          '.$Request['begindate'].'</br>
           End Date:            '.$Request['enddate'].'</br>
           Diagnosis:           '.$Request['diagnosis'].'</br>
           Room Notes:          '.$Request['roomnote'].'</br>';
           ?>
            <input type="submit" name="Approve" value="Approve" action="ApproveRequestNew.php"/>
            <input type="submit" name="Deny" value="Deny" action="DenyRequestNew.php"/>
       </form>

    </div>
</div>

<?php 
include ('footer.php'); 
//include the footer file, this contains the proper </body> and </html> ending tag.
?>
