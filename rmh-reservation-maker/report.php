<?php
/*
* Copyright 2011 by Kayla Haynes and Bonnie MacKellar.
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
 
/*
* Reporting module for RMH-RoomReservationMaker. 
* Displays form for data entry and report after data is entered
* @author Kayla Haynes
* @version May 01, 2012
*/
session_start();
session_cache_expire(30);

$title = "Report Generation";
$helpPage = "PatientReport.php";

include ('header.php');
include_once (ROOT_DIR.'/domain/Reservation.php');
include_once (ROOT_DIR.'/domain/Family.php');
include_once (ROOT_DIR.'/domain/UserProfile.php');
include_once (ROOT_DIR.'/database/dbReservation.php');
include_once (ROOT_DIR.'/database/dbFamilyProfile.php');
include_once (ROOT_DIR.'/database/dbUserProfile.php');


$showForm = false;
$showResult = false;
$beginDateError = false;
$endDateError = false;


/**
 *Determines whether to display form or report 
 */
//Token is good
if(isset($_POST['form_token']) && validateTokenField($_POST))
{
    //startDate is not set
   if ((empty($_POST['beginYear'])) || (empty($_POST['beginMonth'])) || (empty($_POST['beginDay'])))
   {
       $message = "Please select a beginning date.";
       $beginDateError = true;
       $showForm = true;
   }
   //endDate is not set
   else if ((empty($_POST['endYear'])) || (empty($_POST['endMonth'])) || (empty($_POST['endDay'])))
   {
       $message = "Please select an ending date.";
       $endDateError = true;
       $showForm = true;
   }
   //All data is set
   else
   {
       //check if dates are valid
       $beginDateMins = ($_POST['beginYear']*365*24*60)+($_POST['beginMonth']*30*24*60)+($_POST['beginDay']*24*60);
       $endDateMins = ($_POST['endYear']*365*24*60)+($_POST['endMonth']*30*24*60)+($_POST['endDay']*24*60);
       if(($endDateMins - $beginDateMins) <= 0)
       {
           $message = "End date must be after begin date.";
           $beginDateError = true;
           $endDateError = true;
           $showForm = true;
       }
       else
       {
           $showResult = true;
       }
   }
}
//Token is not good
else if(isset($_POST['form_token']) && !validateTokenField($_POST))
{
    $_POST['beginYear'] = "";
    $_POST['beginMonth'] = "";
    $_POST['beginDay'] = "";
    $_POST['endYear'] = "";
    $_POST['endMonth'] = "";
    $_POST['endDay'] = "";
    $_POST['hospital'] = "";
    $message = "";
    $showForm = true;
}
//No POST data
else
{
    $_POST['beginYear'] = "";
    $_POST['beginMonth'] = "";
    $_POST['beginDay'] = "";
    $_POST['endYear'] = "";
    $_POST['endMonth'] = "";
    $_POST['endDay'] = "";
    $_POST['hospital'] = "";
    $message = "";
    $showForm = true;
}

echo '<section class="content">';
        echo '<div>';

//if $showForm = true, display form to enter data
if($showForm == true)
{
    if ($message =="")
    {
        echo "Please select the data for your report";
    }
    else
    {
        echo '<div class="notice">'.$message.'</div>';   
    }
    
    //FORM
    ?>
<form class="generic" name="reportForm" action="report.php" method="POST">
    <?php echo generateTokenField(); 
    
    //TODO use a better validation
    if ($beginDateError==true)
    {
        echo '<div class="formRow"';
    }
 else 
    {
       echo '<div class="formRow">'; 
    }
    
    ?>
    <label for="beginMonth">Start Date</label>
        <input name="begindate" type="date" min="2008-01-01" >
        <br><br>
        <label for="endDate">End Date:</label>
        <input name="enddate" type="date" min="2008-01-01" >
 <!--       <select name="beginMonth" id="beginMonth">
            <option value="">Month</option>
            <option value="01" <?php if($_POST['beginMonth']=='01') echo "selected='selected'";?> >January</option>
            <option value="02" <?php if($_POST['beginMonth']=='02') echo "selected='selected'";?> > February</option>
            <option value="03" <?php if($_POST['beginMonth']=='03') echo "selected='selected'";?> >March</option>
            <option value="04" <?php if($_POST['beginMonth']=='04') echo "selected='selected'";?> >April</option>
            <option value="05" <?php if($_POST['beginMonth']=='05') echo "selected='selected'";?>>May</option>
            <option value="06" <?php if($_POST['beginMonth']=='06') echo "selected='selected'";?> >June</option>
            <option value="07" <?php if($_POST['beginMonth']=='07') echo "selected='selected'";?> >July</option>
            <option value="08" <?php if($_POST['beginMonth']=='08') echo "selected='selected'";?> >August</option>
            <option value="09" <?php if($_POST['beginMonth']=='09') echo "selected='selected'";?> >September</option>
            <option value="10" <?php if($_POST['beginMonth']=='10') echo "selected='selected'";?> >October</option>
            <option value="11" <?php if($_POST['beginMonth']=='11') echo "selected='selected'";?> >November</option>
            <option value="12" <?php if($_POST['beginMonth']=='12') echo "selected='selected'";?> >December</option>
        </select>
        <select name="beginDay">
            <option value="">Day</option>
            <option value="01" <?php if($_POST['beginDay']=='01') echo "selected='selected'";?> >01</option>
            <option value="02" <?php if($_POST['beginDay']=='02') echo "selected='selected'";?> >02</option>
            <option value="03" <?php if($_POST['beginDay']=='03') echo "selected='selected'";?> >03</option>
            <option value="04" <?php if($_POST['beginDay']=='04') echo "selected='selected'";?> >04</option>
            <option value="05" <?php if($_POST['beginDay']=='05') echo "selected='selected'";?> >05</option>
            <option value="06" <?php if($_POST['beginDay']=='06') echo "selected='selected'";?> >06</option>
            <option value="07" <?php if($_POST['beginDay']=='07') echo "selected='selected'";?> >07</option>
            <option value="08" <?php if($_POST['beginDay']=='08') echo "selected='selected'";?> >08</option>
            <option value="09" <?php if($_POST['beginDay']=='09') echo "selected='selected'";?> >09</option>
            <option value="10" <?php if($_POST['beginDay']=='10') echo "selected='selected'";?> >10</option>
            <option value="11" <?php if($_POST['beginDay']=='11') echo "selected='selected'";?> >11</option>
            <option value="12" <?php if($_POST['beginDay']=='12') echo "selected='selected'";?> >12</option>
            <option value="13" <?php if($_POST['beginDay']=='13') echo "selected='selected'";?> >13</option>
            <option value="14" <?php if($_POST['beginDay']=='14') echo "selected='selected'";?> >14</option>
            <option value="15" <?php if($_POST['beginDay']=='15') echo "selected='selected'";?> >15</option>
            <option value="16" <?php if($_POST['beginDay']=='16') echo "selected='selected'";?> >16</option>
            <option value="17" <?php if($_POST['beginDay']=='17') echo "selected='selected'";?> >17</option>
            <option value="18" <?php if($_POST['beginDay']=='18') echo "selected='selected'";?> >18</option>
            <option value="19" <?php if($_POST['beginDay']=='19') echo "selected='selected'";?> >19</option>
            <option value="20" <?php if($_POST['beginDay']=='20') echo "selected='selected'";?> >20</option>
            <option value="21" <?php if($_POST['beginDay']=='21') echo "selected='selected'";?> >21</option>
            <option value="22" <?php if($_POST['beginDay']=='22') echo "selected='selected'";?> >22</option>
            <option value="23" <?php if($_POST['beginDay']=='23') echo "selected='selected'";?> >23</option>
            <option value="24" <?php if($_POST['beginDay']=='24') echo "selected='selected'";?> >24</option>
            <option value="25" <?php if($_POST['beginDay']=='25') echo "selected='selected'";?> >25</option>
            <option value="26" <?php if($_POST['beginDay']=='26') echo "selected='selected'";?> >26</option>
            <option value="27" <?php if($_POST['beginDay']=='27') echo "selected='selected'";?> >27</option>
            <option value="28" <?php if($_POST['beginDay']=='28') echo "selected='selected'";?> >28</option>
            <option value="29" <?php if($_POST['beginDay']=='29') echo "selected='selected'";?> >29</option>
            <option value="30" <?php if($_POST['beginDay']=='30') echo "selected='selected'";?> >30</option>
            <option value="31" <?php if($_POST['beginDay']=='31') echo "selected='selected'";?> >31</option>
        </select>
        <select name="beginYear">
            <option value="">Year</option>
            <option value="2000" <?php if($_POST['beginYear']=='2000') echo "selected='selected'";?> >2000</option>
            <option value="2001" <?php if($_POST['beginYear']=='2001') echo "selected='selected'";?> >2001</option>
            <option value="2002" <?php if($_POST['beginYear']=='2002') echo "selected='selected'";?> >2002</option>
            <option value="2003" <?php if($_POST['beginYear']=='2003') echo "selected='selected'";?> >2003</option>
            <option value="2004" <?php if($_POST['beginYear']=='2004') echo "selected='selected'";?> >2004</option>
            <option value="2005" <?php if($_POST['beginYear']=='2005') echo "selected='selected'";?> >2005</option>
            <option value="2006" <?php if($_POST['beginYear']=='2006') echo "selected='selected'";?> >2006</option>
            <option value="2007" <?php if($_POST['beginYear']=='2007') echo "selected='selected'";?> >2007</option>
            <option value="2008" <?php if($_POST['beginYear']=='2008') echo "selected='selected'";?> >2008</option>
            <option value="2009" <?php if($_POST['beginYear']=='2009') echo "selected='selected'";?> >2009</option>
            <option value="2010" <?php if($_POST['beginYear']=='2010') echo "selected='selected'";?> >2010</option>
            <option value="2011" <?php if($_POST['beginYear']=='2011') echo "selected='selected'";?> >2011</option>
            <option value="2012" <?php if($_POST['beginYear']=='2012') echo "selected='selected'";?> >2012</option>
            <option value="2013" <?php if($_POST['beginYear']=='2013') echo "selected='selected'";?> >2013</option>
	    </select> -->
    </div>
    
    <?php
    if ($endDateError==true)
    {
        echo '<div class="formRow" style="background:rgba(255, 255, 122, .7); padding-top:7px; color: red; border-top:thin solid red;">';
    }
    else 
    {
       echo '<div class="formRow" style="background:#FFF; padding-top:7px;">'; 
    }
    ?>
       
    <label for="endDate">End Date</label>
        <select name="endMonth">
            <option value="">Month</option>
            <option value="01" <?php if($_POST['endMonth']=='01') echo "selected='selected'";?> >January</option>
            <option value="02" <?php if($_POST['endMonth']=='02') echo "selected='selected'";?> > February</option>
            <option value="03" <?php if($_POST['endMonth']=='03') echo "selected='selected'";?> >March</option>
            <option value="04" <?php if($_POST['endMonth']=='04') echo "selected='selected'";?> >April</option>
            <option value="05" <?php if($_POST['endMonth']=='05') echo "selected='selected'";?>>May</option>
            <option value="06" <?php if($_POST['endMonth']=='06') echo "selected='selected'";?> >June</option>
            <option value="07" <?php if($_POST['endMonth']=='07') echo "selected='selected'";?> >July</option>
            <option value="08" <?php if($_POST['endMonth']=='08') echo "selected='selected'";?> >August</option>
            <option value="09" <?php if($_POST['endMonth']=='09') echo "selected='selected'";?> >September</option>
            <option value="10" <?php if($_POST['endMonth']=='10') echo "selected='selected'";?> >October</option>
            <option value="11" <?php if($_POST['endMonth']=='11') echo "selected='selected'";?> >November</option>
            <option value="12" <?php if($_POST['endMonth']=='12') echo "selected='selected'";?> >December</option>
        </select>
        <select name="endDay">
            <option value="">Day</option>
            <option value="01" <?php if($_POST['endDay']=='01') echo "selected='selected'";?> >01</option>
            <option value="02" <?php if($_POST['endDay']=='02') echo "selected='selected'";?> >02</option>
            <option value="03" <?php if($_POST['endDay']=='03') echo "selected='selected'";?> >03</option>
            <option value="04" <?php if($_POST['endDay']=='04') echo "selected='selected'";?> >04</option>
            <option value="05" <?php if($_POST['endDay']=='05') echo "selected='selected'";?> >05</option>
            <option value="06" <?php if($_POST['endDay']=='06') echo "selected='selected'";?> >06</option>
            <option value="07" <?php if($_POST['endDay']=='07') echo "selected='selected'";?> >07</option>
            <option value="08" <?php if($_POST['endDay']=='08') echo "selected='selected'";?> >08</option>
            <option value="09" <?php if($_POST['endDay']=='09') echo "selected='selected'";?> >09</option>
            <option value="10" <?php if($_POST['endDay']=='10') echo "selected='selected'";?> >10</option>
            <option value="11" <?php if($_POST['endDay']=='11') echo "selected='selected'";?> >11</option>
            <option value="12" <?php if($_POST['endDay']=='12') echo "selected='selected'";?> >12</option>
            <option value="13" <?php if($_POST['endDay']=='13') echo "selected='selected'";?> >13</option>
            <option value="14" <?php if($_POST['endDay']=='14') echo "selected='selected'";?> >14</option>
            <option value="15" <?php if($_POST['endDay']=='15') echo "selected='selected'";?> >15</option>
            <option value="16" <?php if($_POST['endDay']=='16') echo "selected='selected'";?> >16</option>
            <option value="17" <?php if($_POST['endDay']=='17') echo "selected='selected'";?> >17</option>
            <option value="18" <?php if($_POST['endDay']=='18') echo "selected='selected'";?> >18</option>
            <option value="19" <?php if($_POST['endDay']=='19') echo "selected='selected'";?> >19</option>
            <option value="20" <?php if($_POST['endDay']=='20') echo "selected='selected'";?> >20</option>
            <option value="21" <?php if($_POST['endDay']=='21') echo "selected='selected'";?> >21</option>
            <option value="22" <?php if($_POST['endDay']=='22') echo "selected='selected'";?> >22</option>
            <option value="23" <?php if($_POST['endDay']=='23') echo "selected='selected'";?> >23</option>
            <option value="24" <?php if($_POST['endDay']=='24') echo "selected='selected'";?> >24</option>
            <option value="25" <?php if($_POST['endDay']=='25') echo "selected='selected'";?> >25</option>
            <option value="26" <?php if($_POST['endDay']=='26') echo "selected='selected'";?> >26</option>
            <option value="27" <?php if($_POST['endDay']=='27') echo "selected='selected'";?> >27</option>
            <option value="28" <?php if($_POST['endDay']=='28') echo "selected='selected'";?> >28</option>
            <option value="29" <?php if($_POST['endDay']=='29') echo "selected='selected'";?> >29</option>
            <option value="30" <?php if($_POST['endDay']=='30') echo "selected='selected'";?> >30</option>
            <option value="31" <?php if($_POST['endDay']=='31') echo "selected='selected'";?> >31</option>
        </select>
        <select name="endYear">
            <option value="">Year</option>
            <option value="2000" <?php if($_POST['endYear']=='2000') echo "selected='selected'";?> >2000</option>
            <option value="2001" <?php if($_POST['endYear']=='2001') echo "selected='selected'";?> >2001</option>
            <option value="2002" <?php if($_POST['endYear']=='2002') echo "selected='selected'";?> >2002</option>
            <option value="2003" <?php if($_POST['endYear']=='2003') echo "selected='selected'";?> >2003</option>
            <option value="2004" <?php if($_POST['endYear']=='2004') echo "selected='selected'";?> >2004</option>
            <option value="2005" <?php if($_POST['endYear']=='2005') echo "selected='selected'";?> >2005</option>
            <option value="2006" <?php if($_POST['endYear']=='2006') echo "selected='selected'";?> >2006</option>
            <option value="2007" <?php if($_POST['endYear']=='2007') echo "selected='selected'";?> >2007</option>
            <option value="2008" <?php if($_POST['endYear']=='2008') echo "selected='selected'";?> >2008</option>
            <option value="2009" <?php if($_POST['endYear']=='2009') echo "selected='selected'";?> >2009</option>
            <option value="2010" <?php if($_POST['endYear']=='2010') echo "selected='selected'";?> >2010</option>
            <option value="2011" <?php if($_POST['endYear']=='2011') echo "selected='selected'";?> >2011</option>
            <option value="2012" <?php if($_POST['endYear']=='2012') echo "selected='selected'";?> >2012</option>
            <option value="2013" <?php if($_POST['endYear']=='2013') echo "selected='selected'";?> >2013</option>
	</select>
	</div>
	<div class="formRow">
    <label for="hospital">Hospital (optional)</label>
            <input id="hospital" type="text" name="hospital" />
   	</div>
   	<div class="formRow">
            <input class="btn" type="submit" value="Submit" name="submit" />
    </div>        
</form>
<?php
}
//if $showReport = true, display report
else if($showResult == true)
{
    //Initialize form data
    $userId = sanitize(getCurrentUser());
    $beginDate = sanitize($_POST['beginYear']."-".$_POST['beginMonth']."-".$_POST['beginDay']);
    $endDate = sanitize($_POST['endYear']."-".$_POST['endMonth']."-".$_POST['endDay']);
    $numReservations = 0;
    
//if hospital is default, set to ""
    if($_POST['hospital']=="Hospital")
    {
        $hospital = "";
    }
    else if ($_POST['hospital']=="MSKCC")
    {
        $hospital = "Memorial Sloan-Kettering Cancer Center";
    }
    else
    {
        $hospital = sanitize($_POST['hospital']); 
    }

    //REPORT
    echo "Report Requested by: ".$userId."<br>";
    echo "Beginning Date: ".date('m/d/Y', strtotime($beginDate))."<br>";
    echo "Ending Date: ".date('m/d/Y', strtotime($endDate))."<br>";
    
    //report for all hospitals
    if(empty($hospital))
    {
        //Retrieve array of data
        $theReservations = retrieve_all_RoomReservationActivity_byDate ($beginDate, $endDate);
        
    //report for selected hospital, $hospital
    }
    else
    {
        echo "Hospital: ".$hospital."<br>";
        
        //Retrieve array of data
        $theReservations = retrieve_all_RoomReservationActivity_byHospitalAndDate($hospital, $beginDate, $endDate);
    }
    
    if(empty($theReservations))
    {
        echo '<br><div class="notice">No data matches your selections.</div><br>';
        echo '<a href="report.php"><div class="goback"></div></a>';
    }
    else
    {
        //TABLE
        echo '<br><br>
            <table border = "2" cellspacing = "10" cellpadding = "10">';       
        echo '<thead>
            <tr>
            <th>#</th>
            <th>Begin Date</th>
            <th>End Date</th>
            <th>Parent Name</th>
            <th>Patient Name</th>
            <th>Social Worker</th>
            <th>Status</th>
            </thead>
            <tbody>';

        foreach ($theReservations as $reservation)
        {
            $beginDate = date('m/d/Y', strtotime($reservation->get_beginDate()));
            $endDate = date('m/d/Y', strtotime($reservation->get_endDate()));
            $parentName = $reservation->get_parentLastName().", ".$reservation->get_parentFirstName();
            $familyId = $reservation->get_familyProfileId();
            $family = retrieve_FamilyProfile($familyId);
            $patientName = $family->get_patientlname().", ".$family->get_patientfname();
            $swName = $reservation->get_swLastName().", ".$reservation->get_swFirstName();
            $status = $reservation->get_status();
            $numReservations++;
            
            echo '<tr>';
            echo '<td align="center"><b>'.$numReservations.'</b></font></td>
                  <td align="center">'.$beginDate.'</td>
                  <td align="center">'.$endDate. '</td>
                  <td align="center">'.$parentName. '</td>
                  <td align="center">'.$patientName.'</td>
                  <td align="center">'.$swName. '</td>
                  <td align="center">'.$status.'</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        
        echo "<br><br>Total Requests: ".$numReservations;
}
}

        echo '</div>';
echo '</section>';

function readAndValidateDates(&$formattedBeginDate, &$formattedEndDate,&$message)
{
    $bdate = new DateTime();
    $edate = new DateTime();
    $hasError = false;
        //startDate is not set
    if ((empty($_POST['begindate']))) {
        $message['BeginningDate'] = '<p><font color="red">You must select a beginning date!</font></p>';
        error_log('missing begin date');
        $hasError = true;
    }
    //endDate is not set
    if ((empty($_POST['enddate']))) {
        $message['EndDate'] = '<p><font color="red">You must select an end date!</font></p>';
        error_log('missing end date');
        $hasError = true;
    }
    else {
        //check if dates are valid
        $currentdate = date("Ymd");
        $bdate = new DateTime($_POST['begindate']);
        $edate = new DateTime($_POST['enddate']);
        $formatbdate = $bdate->format('Ymd');
        $formatedate = $edate->format('Ymd');
        //end date before begin date
        if (($formatedate - $formatbdate) <= 0) {
            $message['EndAfterBeginDate'] = '<p><font color="red">End date must be after begin date!</font></p>';
            error_log('end date after begin date');
            $hasError = true;
        }
        //request dates are in the past
        if ($currentdate - $formatedate >= 0 || $currentdate - $formatbdate > 0) {
            $message['DatesInThePast'] = '<p><font color="red">Dates cannot be in the past!</font></p>';
            error_log('request dates are in the past');
            $hasError = true;
        } 
      
    }
    if ($hasError)
      return false;
 
    // no problems with the dates
      $formattedBeginDate = $bdate->format('Y-m-d');

     $formattedEndDate = $edate->format('Y-m-d');
     return true;
   
} // end readAndValidateDates

include ('footer.php');

?>
