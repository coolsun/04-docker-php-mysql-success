<?php
session_start();
header('Content-Type:text/html; charset=utf-8');
require "../../../../config_conn.inc.php";

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
 Job Type and Job ID
*/
$jobTypes = array('job', 'subjob');
if( isset( $_POST['job_type'] ) && trim( $_POST['job_type'] ) && in_array( $_POST['job_type'], $jobTypes ) && isset( $_POST['job_id'] ) ) {

	$job_type = $_POST['job_type'];
	$job_id = $_POST['job_id'];

}
else {
	error_callback( 'Error.job_deleting.1' );
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
 Delete one job and the subjos of it.
 Delete one subjob.
*/
$delete_job = $dbh->prepare('DELETE FROM `'.$job_type.'s` WHERE `'.$job_type.'_id`=? and `user_id`=?;'); 
$delete_job->execute( array( $job_id, $_SESSION['userid'] ) );

echo "success";

/*
 Back to planning
*/
/*header("HTTP/1.1 301 Moved Permanently");
header("Location: ".$_SERVER['HTTP_REFERER']);*/
?>

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