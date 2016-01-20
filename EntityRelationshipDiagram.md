# Introduction #

The purpose of this page is to provide an overview of the current entity relationship diagram.

# Entity Relationship Diagram #

<a href='http://s283.photobucket.com/albums/kk285/lindashek1/?action=view&amp;current=ERD.png'><img src='http://i283.photobucket.com/albums/kk285/lindashek1/ERD.png' alt='Photobucket' border='0'><a />

<h1>Table Details</h1>

Below is an explanation of each entity presented in the entity relationship diagram:<br>
<br>
<ul><li>The <u><b>Activation</b></u> table: Lists all information regarding password reset.<br>
</li><li>The <u><b>UserProfile</b></u> table: Lists all user profiles.<br>
</li><li>The <u><b>SocialWorkerProfile</b></u> table: Lists all Social Worker profiles.<br>
</li><li>The <u><b>RMHStaffProfile</b></u> table: Lists all Ronald McDonald House Staff profiles.<br>
</li><li>The <u><b>FamilyProfile</b></u> table: Lists all family profiles.<br>
</li><li>The <u><b>ProfileActivity</b></u> table: Lists all profile activities.<br>
</li><li>The <u><b>RoomReservationActivity</b></u> table: Lists all room reservation activities.<br>
</li><li>The <u><b>RequestKeyNumber</b></u> table: A look-up table to find the next highest request key number for both 'ProfileActivityRequestID' and 'RoomReservationRequestID'. Works with the store procedure called: <i>GetRequestKeyNumber</i>.</li></ul>

<h1>Table Structures and Descriptions</h1>

Below is an explanation of each field for each entity presented in the entity relationship diagram:<br>
<br>
<h2>Table Name: Activation</h2>
<ul><li><b>ActivationID</b> : Primary key of the Activation table.<br>
</li><li><b>UserProfileID</b> : Points to the UserProfile table.<br>
</li><li><b>ActivationCode</b> : Displays the activation code for password reset.<br>
</li><li><b>ResetTime</b> : Displays the time of the password reset.<br>
</li><li><b>ResetStatus</b> : Displays the status of 'Yes' or 'No' regarding the password reset.</li></ul>

<h2>Table Name: UserProfile</h2>
<ul><li><b>UserProfileID</b> : Primary key of the UserProfile table.<br>
</li><li><b>UsernameID</b> : Displays the username of the user.<br>
</li><li><b>UserEmail</b> : Displays the user's email address.<br>
</li><li><b>Password</b> : Displays the user's hashed password.<br>
</li><li><b>UserCategory</b> : Displays the user's category: 'Social Worker', 'RMH Staff Approver', 'RMH Administrator'.</li></ul>

<h2>Table Name: SocialWorkerProfile</h2>
<ul><li><b>SocialWorkerProfileID</b> : Primary key of the SocialWorkerProfile table.<br>
</li><li><b>UserProfileID</b> : Points to the UserProfile table.<br>
</li><li><b>Title</b> : Displays the title of the Social Worker: 'Ms., Mr., Mrs., etc.'<br>
</li><li><b>FirstName</b> : Displays the first name of the social worker.<br>
</li><li><b>LastName</b> : Displays the last name of the social worker.<br>
</li><li><b>HospitalAffiliation</b> : Displays the hospital the social worker is affiliated with.<br>
</li><li><b>Phone</b> : Displays the phone number of the social worker.<br>
</li><li><b>EmailNotification</b> : Displays whether or not the social worker would like to receive email notifications regarding profile activities and room reservation activities.</li></ul>

<h2>Table Name: RMHStaffProfile</h2>
<ul><li><b>RMHStaffProfileID</b> : Primary key of the RMHStaffProfile table.<br>
</li><li><b>UserProfileID</b> : Points to the UserProfile table.<br>
</li><li><b>Title</b> : Displays the title of the RMH Staff: 'Ms., Mr., Mrs., etc.'<br>
</li><li><b>FirstName</b> : Displays the first name of the RMH Staff.<br>
</li><li><b>LastName</b> : Displays the last name of the RMH Staff.<br>
</li><li><b>Phone</b> : Displays the phone number of the RMH Staff.</li></ul>

<h2>Table Name: FamilyProfile</h2>
<ul><li><b>FamilyProfileID</b> : Primary key of the FamilyProfile table.<br>
</li><li><b>ParentFirstName</b> : Displays the first name of the parent.<br>
</li><li><b>ParentLastName</b> : Displays the last name of the parent.<br>
</li><li><b>Email</b> : Displays the email address of the parent.<br>
</li><li><b>Phone1</b> : Displays the primary phone number of the parent.<br>
</li><li><b>Phone2</b> : Displays the secondary phone number of the parent.<br>
</li><li><b>Address</b> : Displays the parent address.<br>
</li><li><b>City</b> : Displays the parent city.<br>
</li><li><b>State</b> : Displays the parent state.<br>
</li><li><b>ZipCode</b> : Displays the parent zip-code.<br>
</li><li><b>Country</b> : Displays the parent country.<br>
</li><li><b>PatientFirstName</b> : Displays the first name of the patient.<br>
</li><li><b>PatientLastName</b> : Displays the last name of the patient.<br>
</li><li><b>PatientRelation</b> : Displays the patient relation with the parent.<br>
</li><li><b>PatientDateOfBirth</b> : Displays the patient's date of birth.<br>
</li><li><b>FormPDF</b> : Displays the URL of the family form in pdf format.<br>
</li><li><b>Notes</b> : (optional) Notes about the family profile.</li></ul>

<h2>Table Name: ProfileActivity</h2>
<ul><li><b>ProfileActivityID</b> : Primary key of the ProfileActivity table.<br>
</li><li><b>ProfileActivityRequestID</b> : Displays the request key number for the profile activity.<br>
</li><li><b>FamilyProfileID</b> : Points to the FamilyProfile table.<br>
</li><li><b>SocialWorkerProfileID</b> : Points to the SocialWorkerProfile table.<br>
</li><li><b>RMHStaffProfileID</b> : Points to the RMHStaffProfile table.<br>
</li><li><b>SW_DateStatusSubmitted</b> : Displays the timestamp of the profile activity status that was submitted by the social worker.<br>
</li><li><b>RMH_DateStatusSubmitted</b> : Displays the timestamp of the profile activity status that was submitted by the rmh staff.<br>
</li><li><b>ActivityType</b> : Utilized by the social worker for the room request: 'Apply','Modify','Cancel'.<br>
</li><li><b>Status</b> : Utilized by the rmh staff for the room request:    'Unconfirmed','Confirm','Deny'.<br>
</li><li><b>ParentFirstName</b> : Displays the first name of the parent.<br>
</li><li><b>ParentLastName</b> : Displays the last name of the parent.<br>
</li><li><b>Email</b>: Displays the email address of the parent.<br>
</li><li><b>Phone1</b>: Displays the primary phone number of the parent.<br>
</li><li><b>Phone2</b>: Displays the secondary phone number of the parent.<br>
</li><li><b>Address</b>: Displays  the parent address.<br>
</li><li><b>City</b>: Displays the parent city.<br>
</li><li><b>State</b>: Displays the parent state.<br>
</li><li><b>ZipCode</b>: Displays the parent zip-code.<br>
</li><li><b>Country</b>: Displays the parent country.<br>
</li><li><b>PatientFirstName</b>: Displays the first name of the patient.<br>
</li><li><b>PatientLastName</b>: Displays the last name of the patient.<br>
</li><li><b>PatientRelation</b>: Displays the patient relation with the parent.<br>
</li><li><b>PatientDateOfBirth</b>: Displays the patient's date of birth.<br>
</li><li><b>FormPDF</b>: Displays the URL of the family's pdf form.<br>
</li><li><b>FamilyNotes</b>: (optional) Notes from the the RMH Staff and/or Social Worker regarding the family profile.<br>
</li><li><b>ProfileActivityNotes</b>: (optional) Notes from the RMH Staff and/or Social Worker regarding the profile activity.</li></ul>

<h2>Table Name: RoomReservationActivity</h2>
<ul><li><b>RoomReservationActivityID</b>: Primary key of the RoomReservationActivity table.<br>
</li><li><b>RoomReservationRequestID</b>: Displays the request key number for the room reservation activity.<br>
</li><li><b>FamilyProfileID</b>: Points to the FamilyProfile table.<br>
</li><li><b>SocialWorkerProfileID</b>: Points to the SocialWorkerProfile table.<br>
</li><li><b>RMHStaffProfileID</b>: Points to the RMH Staff Profile table.<br>
</li><li><b>SW_DateStatusSubmitted</b>: Displays the timestamp of the room reservation activity status submitted by the social worker.<br>
</li><li><b>RMH_DateStatusSubmitted</b>: Displays the timestamp of the room reservation activity status submitted by the rmh staff.<br>
</li><li><b>ActivityType</b>: Utilized by the social worker for the room request: 'Apply','Modify','Cancel'.<br>
</li><li><b>Status</b>: Utilized by the rmh staff for the room request: 'Unconfirmed','Confirm','Deny'.<br>
</li><li><b>BeginDate</b>: Displays the estimate begin date of the room reservation for the family.<br>
</li><li><b>EndDate</b>: Displays the estimate end date of the room reservation for the family.<br>
</li><li><b>PatientDiagnosis</b>: (optional) Displays comments on patient diagnosis.<br>
</li><li><b>Notes</b>: (optional) Notes from the RMH Staff and/or Social Worker about the room reservation activity.</li></ul>

<h2>Table Name: RequestKeyNumber</h2>
<ul><li><b>RoomReservationRequestID</b> : Displays the next highest room reservation request id, when the store procedure, <i>GetRequestKeyNumber</i> is called.<br>
</li><li><b>ProfileActivityRequestID</b> : Displays the next highest profile activity request id, when the store procedure, <i>GetRequestKeyNumber</i> is called.