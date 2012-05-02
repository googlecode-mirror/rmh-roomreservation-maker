<?php
/*
* Copyright 2011 by Gergana Stoykova and Bonnie MacKellar.
* This program is part of RMH-RoomReservationMaker, which is free software,
* inspired by the RMH Homeroom Project.
* It comes with absolutely no warranty.  You can redistribute and/or
* modify it under the terms of the GNU Public License as published
* by the Free Software Foundation (see <http://www.gnu.org/licenses/).
*/
 
/*
* Reservation Domain Object for RMH-RoomReservationMaker. 
* Specifies attributes needed to create and modify a room request
* @author Gergana Stoykova
* @version 5/2/2012
*/

//include_once(ROOT_DIR .'/domain/UserProfile.php');
//include_once(ROOT_DIR .'/domain/Family.php');
class Reservation  {
   
    private $roomReservationActivityID;
    private $roomReservationRequestID;
    private $familyProfileId;
    private $parentLastName;
    private $parentFirstName;
    private $socialWorkerProfileId;
    private $swLastName;
    private $swFirstName;
    private $rmhStaffProfileId;
    private $rmhStaffLastName;
    private $rmhStaffFirstName;       
    private $swDateStatusSubmitted;
    private $rmhDateStatusSubmitted;
    private $activityType;
    private $status;
    private $beginDate;
    private $endDate;
    private $patientDiagnosis;
    private $roomnote;
    
      
    function __construct($roomReservationActivityID, $roomReservationRequestID, $familyProfileId, $parentLastName, 
                $parentFirstName, $socialWorkerProfileId, $swLastName, $swFirstName, $rmhStaffProfileId, $rmhStaffLastName,
                $rmhStaffFirstName, $swDateStatusSubmitted, $rmhDateStatusSubmitted, $activityType, $status, $beginDate, $endDate,
                $patientDiagnosis, $roomnote){
        
            $this->roomReservationActivityID = $roomReservationActivityID;
            $this->roomReservationRequestID = $roomReservationRequestID;
            $this->familyProfileId = $familyProfileId;
            $this->parentLastName = $parentLastName;
            $this->parentFirstName = $parentFirstName;
            $this->socialWorkerProfileId = $socialWorkerProfileId;
            $this->swLastName = $swLastName;
            $this->swFirstName = $swFirstName;
            $this->rmhStaffProfileId = $rmhStaffProfileId;
            $this->rmhStaffLastName = $rmhStaffLastName;
            $this->rmhStaffFirstName = $rmhStaffFirstName;
            $this->swDateStatusSubmitted = $swDateStatusSubmitted;
            $this->rmhDateStatusSubmitted = $rmhDateStatusSubmitted;
            $this->activityType = $activityType;
            $this->status = $status;
            $this->beginDate = $beginDate;
            $this->endDate = $endDate;
            $this->patientDiagnosis = $patientDiagnosis;
            $this->roomnote = $roomnote;
            }
    
    //getters
    function get_roomReservationActivityID(){
         return $this->roomReservationActivityID;
    }
    
    function get_roomReservationRequestID(){
        return $this->roomReservationRequestID;
    }
    
    function get_familyProfileId(){
        return $this->familyProfileId;
    }
    
    function get_parentLastName(){
        return $this->parentLastName;
    }
    
    function get_parentFirstName(){
        return $this->parentFirstName;
    }
    
    function get_socialWorkerProfileId(){
        return $this->socialWorkerProfileId;
    }
    
    function get_swLastName(){
        return $this->swLastName;
    }
    
    function get_swFirstName(){
        return $this->swFirstName;
    }
    
    function get_rmhStaffProfileId(){
        return $this->rmhStaffProfileId;
    }
    
    function get_rmhStaffLastName(){
        return $this->rmhStaffLastName;
    }
    
    function get_rmhStaffFirstName(){
        return $this->rmhStaffFirstName;
    }
    
    function get_swDateStatusSubmitted(){
        return $this->swDateStatusSubmitted;
    }
    
    function get_rmhDateStatusSubmitted(){
        return $this->rmhDateStatusSubmitted;
    }
    
    function get_activityType(){
        return $this->activityType;
    }
    
    function get_status(){
        return $this->status;
    }
   
    function get_beginDate(){
        return $this->beginDate;
    }
    
    function get_endDate(){
        return $this->endDate;
    }
    
    function get_patientDiagnosis(){
        return $this->patientDiagnosis;
    }
    
    function get_roomnote(){
        return $this->roomnote;
    }
    
    
    //setters
    function set_roomReservationActivityID($roomResId){
         $this->roomReservationActivityID = $roomResId;
    }
    
    function set_roomReservationRequestID($roomRequestId){
        $this->roomReservationRequestID = $roomRequestId;
    }
    
    function set_familyProfileId($famId){
        $this->familyProfileId = $famId;
    }
    
    function set_parentLastName($parLname){
        $this->parentLastName = $parLname;
    }
    
    function set_parentFirstName($parFname){
        $this->parentFirstName = $parFname;
    }
    
    function set_socialWorkerProfileId($sid){
        $this->socialWorkerProfileId = $sid;
    }
    
    function set_swLastName($sLname){
        $this->swLastName = $sLname;
    }
    
    function set_swFirstName($sFname){
        $this->swFirstName = $sFname;
    }
    
    function set_rmhStaffProfileId($rid){
        $this->rmhStaffProfileId = $rid;
    }
    
    function set_rmhStaffLastName($rLname){
        $this->rmhStaffLastName = $rLame;
    }
    
    function set_rmhStaffFirstName($rFname){
        $this->rmhStaffFirstName = $rFname;
    }
    
    function set_swDateStatusSubmitted($swDateSubm){
        $this->swDateStatusSubmitted = $swDateSubm;
    }
    
    function set_rmhDateStatusSubmitted($rmhDateSubm){
        $this->rmhDateStatusSubmitted = $rmhDateSubm;
    }
    
    function set_activityType($actTy){
        $this->activityType = $actTy;
    }
    
    function set_status($stat){
        $this->status = $stat;
    }
   
    function set_beginDate($dateBegin){
        $this->beginDate = $dateBegin;
    }
    
    function set_endDate($dateEnd){
        $this->endDate = $dateEnd;
    }
    
    function set_patientDiagnosis($patDiagnosis){
        $this->patientDiagnosis = $patDiagnosis;
    }
    
    function set_roomnote($rnote){
        $this->roomnote = $rnote;
    }
    
    
  
    //is this cancel request supposed to be in the domain ? (question from Geri)
   // function cancel_request($roomReservationRequestID){ 
    /* A room needs to be canceled. 
    * SW goes to look up the room request that was made for the family.
    * SW states the reason for cancellation in the note.
    * select cancel room reservation. 
    * A new roomreservationactivity record is logged in the DB table 
    * cancellation email is sent to RMH approvers with the cancellation key
    * RMH approvers receives the key and looks up the room request to approve the cancellation. 
    */
        
        //1 - modify room request
        //2 - cancel room request
       /* if (selection == 2){
            $retrieve = retrieve_dbRoomRequest($roomReservationRequestID); // needs retrieve function from database group
            if ($retrieve->status == "apply-confirmed"){
                //email function ? 
                update_roomreservationactivity($this); //needs update_roomreservation function database group to log a record
                                                       //change status to "applied" 
            }
            else 
                return false;
               
        }
   
     
 } //close cancel_request*/
 //
 
        
    }//close class Request
?>
