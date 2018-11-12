<?php
session_start();
header('Content-Type:text/html; charset=utf-8');
require "../../../../config_conn.inc.php";
//require "/successdev/config_conn.inc.php"; // Bug

/*
 Convert html tag
*/
foreach( $_POST as $index => $arg ) {
	if( is_array( $_POST[$index] ) ) {
		foreach( $_POST[$index] as $index2 => $arg2 ) {
			$_POST[$index][$index2] = htmlspecialchars( $_POST[$index][$index2] );
		}
	}
	else {
		$_POST[$index] = htmlspecialchars( $_POST[$index] );
	}
}

/*
 Get the Main Job
*/
if( isset($_POST['main_job_title']) && trim($_POST['main_job_title']) ) {
	$main_job_title = $_POST['main_job_title'];
	if( !$_POST['main_job_sdate'] && !$_POST['main_job_edate'] ) {
		$main_job_sdate = $main_job_edate = date('Y-m-d');
	}
	else {
		$main_job_sdate = $_POST['main_job_sdate']; 
		$main_job_edate = $_POST['main_job_edate'];
	}
}
else {
	error_callback( "Error.jobs_saving.1" );
}

/*
 Connect to DB
*/
try {
  $dbh = new PDO($DB_connection_array['job']['driver_name'].':host='.$DB_connection_array['job']['host'].';dbname='.$DB_connection_array['job']['db_name'], $DB_connection_array['job']['user_name'], $DB_connection_array['job']['password']);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
  error_callback( "Error.jobs_saving.2" );
  exit();
}

/*
 Get Sub Jobs datas
*/
$sub_job_titles = $_POST['sub_job_titles'];
$sub_job_sdates = $_POST['sub_job_sdates'];
$sub_job_edates = $_POST['sub_job_edates'];

/*
 Let subjobs during cover the parent job during
*/
foreach( $sub_job_titles as $index => $sub_job_title ) {
	if( !trim( $sub_job_title ) ) {
		continue;
	}
	if( !$sub_job_sdates[ $index ] || !$sub_job_edates[ $index ] ) {
			$sub_job_sdates[ $index ] = $main_job_sdate;
			$sub_job_edates[ $index ] = $main_job_edate;
	}
	else {
		if( sprintf("%d", str_replace('/', '', $sub_job_sdates[ $index ]) ) < sprintf("%d", str_replace('/', '', $main_job_sdate) ) ) {
			$main_job_sdate = $sub_job_sdates[ $index ];
		}
		if( sprintf("%d", str_replace('/', '', $sub_job_edates[ $index ]) ) > sprintf("%d", str_replace('/', '', $main_job_edate) ) ) {
			$main_job_edate = $sub_job_edates[ $index ];
		}
	}
}

/*
 Insert New jobs and subjobs
*/
$add_main_job = $dbh->prepare('INSERT INTO `jobs`(`user_id`, `job_title`, `job_start_date`, `job_end_date`, `created_datetime`) VALUES(?, ?, ?, ?, ?);');
$add_main_job->execute( array( $_SESSION['userid'], $main_job_title, $main_job_sdate, $main_job_edate, date('Y-m-d H:i:s') ) );
$main_job_id = $dbh->lastInsertId();

if( $main_job_id ) {
	$add_sub_job = $dbh->prepare('INSERT INTO `subjobs`(`user_id`, `parent_job_id`, `subjob_title`, `subjob_start_date`, `subjob_end_date`, `created_datetime`) VALUES(?, ?, ?, ?, ?, ?);');
	
	/*
	 Insert subjob
	*/
	foreach($sub_job_titles as $index => $sub_job_title) {
		if( !trim( $sub_job_title ) ) {
			continue;
		}
		$add_sub_job->execute( array( $_SESSION['userid'], $main_job_id, $sub_job_title, $sub_job_sdates[ $index ], $sub_job_edates[ $index ], date('Y-m-d H:i:s') ) );
	}
}

/*
 Back to planning
*/
header("HTTP/1.1 301 Moved Permanently");
header("Location: ".$_SERVER['HTTP_REFERER']);
?>

<h1>TEST</h1>
<p>
<h3>Main Job</h3>
<?php
echo $_POST['main_job_title'];
echo "<br>";
echo $main_job_sdate ." ~ ". $main_job_edate;
?>
</p>
<p>
<h3>Sub Jobs</h3>
<?php
$sub_job_titles = $_POST['sub_job_titles'];
$sub_job_sdates = $_POST['sub_job_sdates'];
$sub_job_edates = $_POST['sub_job_edates'];
foreach($sub_job_titles as $index => $sub_job_title) {
	if( !trim( $sub_job_title ) ) {
		continue;
	}
?>
	<p>
<?php
	echo $sub_job_title;
	echo "<br>";
	echo $sub_job_sdates[ $index ] ." ~ ". $sub_job_edates[ $index ];
?>
	</p>
<?php
}
?>
</p>

<?php
/*
 Back to previous page and show error message
*/
function error_callback( $error_msg ) {
	$_SESSION['Error_msg'] = $error_msg;
	header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$_SERVER['HTTP_REFERER']);
}
?>