<?php
 
/*  Direct access of include files needs to prevented. In order to do that, the following constant defines PARENT.
    Any include page that has header included before, will have this constant defined. If the page is directly accessed,
    PARENT will not be defined. So we can perform this check on the include pages.
 */
    define('PARENT','rmhresmaker');

    include('core/config.php');
    include('core/globalFunctions.php');
    include('core/sessionManagement.php');
    
    checkSession();
  /**
		 * Set our permission array for families, social workers, room reservation managers, and 
                 * administrators. If a page is not specified in the permission array, anyone logged into 
                 * the system can view it. If someone logged into the system attempts to access a page above their
		 * permission level, they will be sent back to the home page.
		 */
  
                 //Everyone = -1
                 //Family member = 0
                 //Social Worker = 1
                 //Room Reservation Manager = 2
                 //Admin = 3
                 
                 //Access Level (Should match UserCategory in DB):
                   $accessLevel = array(
                                        'Family'=>0,
                                        'Social Worker'=>1,
                                        'RMH Staff Approver'=>2,
                                        'RMH Administrator'=>3
                                        );
  
                $permission_array = array();
		//pages families can view
		$permission_array['index.php']=0;
                
                $permission_array['login.php']=-1; //login page is viewable by everyone
              
		//additional pages social workers can view
                
		$permission_array['referralForm.php']=1;
                $permission_array['profileChangeForm.php']=1;
                $permission_array['profileChange.php']=1;
                $permission_array['SearchReservations.php']=1;
                $permission_array['profileDetail.php']=1;
		//more pages
                
                //admin pages
                $permission_array['listUsers.php'] = 3;
                           
                //additional pages room reservation managers can view
		$permission_array['roomLog.php']=2;
		//more pages
         
		//additional pages administrators can view
		$permission_array['log.php']=3;
		//more pages
                
                //password reset page (available to everyone)
                $permission_array['reset.php']=-1;
                
                //logout page
		$permission_array['logout.php']=-1;
                
                //reporting
                $permission_array['report.php']=1;
                
                $permission_array['SearchReservations.php']=1;
                
                $permission_array['activity.php'] = 2;
                $permission_array['activityHandler.php'] = 2;

		//Check if they're at a valid page for their access level.
		$current_page = getCurrentPage();
  
	//Log-in security
	//If they aren't logged in, display our log-in form.
	if(!isset($_SESSION['logged_in']) && $permission_array[$current_page] != -1){
           //Redirect to the login page only if the current page is NOT viewable by the world AND the logged in session variable is not set
            header('Location: '.BASE_DIR.DS.'login.php'); 
            exit();
	}
        else if(isset($_SESSION['logged_in']) && ($current_page == 'login.php' || $current_page == 'reset.php'))
        {
            //if the current page is login.php || reset.php && the user is logged in, then redirect to the index.php page
            header('Location: '.BASE_DIR.DS.'index.php');
            exit();
        }
	else if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
             //if user is logged in start the permission check
		if(!isset($permission_array[$current_page]) || $permission_array[$current_page]>$_SESSION['access_level']){
			//in this case, the user doesn't have permission to view this page.
			//we redirect them to the index page.
                        header('Location: '.BASE_DIR.DS.'index.php');
			//echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
			//note: if javascript is disabled for a user's browser, it would still show the page.
			//so we die().
			die();
		}
	}
        

?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo (isset($title) ? $title : 'Welcome') . ' | RMH Room Reservation Maker'; ?> </title>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="<?php echo CSS_DIR;?>/style.css"/>
        <script src="<?php echo JS_DIR;?>/libs/jquery-1.7.2.min.js"></script>
        <script src="<?php echo JS_DIR;?>/form.js"></script>
        <link rel="javascript" href="<?php echo JS_DIR;?>/libs/jquery.simplemodal.1.4.2.min.js"/>
        <link rel="javascript" href="<?php echo JS_DIR;?>/libs/jquery-1.6.2.min.js"/>
    </head>
<body class="<?php // $_ENV['/**browser **/'] ?>">

<div id="header">
    <h1><?php echo $title; ?></h1>
</div>
<?php if(isset($_SESSION['logged_in'])) include_once (ROOT_DIR.'/navigation.php'); ?>