<?PHP
	session_start();
	session_cache_expire(30);
?>
<!-- page generated by the BowdoinRMH software package -->
<html>
	<head>
		<title>
			View Persons
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<?PHP include('header.php');?>
			<div id="content">
				<!-- your main page data goes here. This is the place to enter content -->
				<p><strong>View Persons in the Database</strong><br />
					To find a specific person, <a href="searchPeople.php">search the database</a>!</p>
					<?PHP
						if($_SESSION['access_level']<1){
							//you can only edit your own entry
							echo('<p>You do not have sufficient permissions to view all persons in the database. You can <a href="searchPeople.php">search</a> or you can ');
							echo('<a href="personEdit.php?id='.$_SESSION['_id'].'">edit</a> your own profile.</p>');
						}
						else{
						//grab stuff from the db
						include_once('database/dbPersons.php');
						include_once('domain/Person.php');
						$allPersons = getall_persons();
						
						//the beginnings of not listing all people at once.
						$i=0;
						$num_results = $_GET['num_results'];
						if(!$num_results) {$num_results = 25; $page_num = 0;}
						else $page_num = $_GET['page_num'];

						$min_num = $num_results*$page_num;
						$max_num = $num_results*($page_num+1);
						if(sizeof($allPersons)<=$max_num) $max_num = sizeof($allPersons);
						echo("Viewing results ".($min_num+1)."-".$max_num.". Showing ");

						if($num_results==25)
								echo('<u>25</u> <a href="view.php?page_num=0&num_results=50">50</a> <a href="view.php?page_num=0&num_results=100">100</a>');
						else if($num_results==50)
								echo('<a href="view.php?page_num=0&num_results=25">25</a> <u>50</u> <a href="view.php?page_num=0&num_results=100">100</a>');
						else if($num_results==100)
								echo('<a href="view.php?page_num=0&num_results=25">25</a> <a href="view.php?page_num=0&num_results=50">50</a> <u>100</u>');
						else
								echo('<a href="view.php?page_num=0&num_results=25">25</a> <a href="view.php?page_num=0&num_results=50">50</a> <a href="view.php?page_num=0&num_results=100">100</a>');
						echo(" people per page.</p>");
						echo('<hr size="1" width="30%" align="left">');
						echo('<p><table class="searchResults">');
						foreach($allPersons as $onePerson){
							echo("<tr>");
							if($i>=$min_num && $i<=$max_num){
								echo('<td class="searchResults" style="padding-right:30px;">'.$onePerson->get_last_name().", ".$onePerson->get_first_name().'</td>');
								echo('<td class="searchResults"><a href="viewPerson.php?id='.$onePerson->get_id().'">view</a></td>');
								echo('<td class="searchResults"><a href="personEdit.php?id='.$onePerson->get_id().'">edit</a></td>');
								if (in_array("guest",$onePerson->get_type()))
								    echo('<td class="searchResults"><a href="referralForm.php?id='.$onePerson->get_id().'">create referral form</a></td>');
							}
							echo("</tr>");
							echo("\n");
							$i++;
						}
						echo("</table></p>");
						echo('<hr size="1" width="30%" align="left">');
						if($page_num>0) echo("<a href='view.php?page_num=".($page_num-1)."&num_results=".$num_results."'>&lt;&lt; previous ".$num_results."</a> ");
			//			echo(" ... ");
						if($max_num < $i) echo("<a href='view.php?page_num=".($page_num+1)."&num_results=".$num_results."'>next ".$num_results."&gt&gt</a>");
						}
					?>
				<!-- below is the footer that we're using currently-->
				<?PHP include('footer.inc');?>
			</div>
		</div>
	</body>
</html>