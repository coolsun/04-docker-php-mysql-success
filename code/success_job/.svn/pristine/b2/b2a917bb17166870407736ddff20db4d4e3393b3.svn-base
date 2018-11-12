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

if( isset($_POST['no']) && trim($_POST['no']) ) {
	$no = $_POST['no'];
}
else {
	error_callback( 'Error.opportunity_deleting.1' );
	exit();
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
  error_callback( "Error.opportunity_deleting.2" );
  exit();
}

/*
 Delete one job and the subjos of it.
 Delete one subjob.
*/
$delete_session = $dbh->prepare('DELETE FROM `businesses` WHERE `user_id`=? AND `business_no`=?;'); 
$delete_session->execute( array( $_SESSION['userid'], $no ) );

/*
 Get last no
*/
$getLastBusinessNo = $dbh->prepare('SELECT `business_last_no`, `business_num` FROM `businesses_metadata` WHERE `user_id`=?;');
$getLastBusinessNo->execute( array( $_SESSION['userid'] ) );
$bmeta = $getLastBusinessNo->fetch(PDO::FETCH_ASSOC);

$getLastOpportunity = $dbh->prepare('SELECT MAX(`business_no`) AS `business_no` FROM `businesses` WHERE `user_id`=? ');
$getLastOpportunity->execute( array( $_SESSION['userid'] ) );
$opportunity = $getLastOpportunity->fetch(PDO::FETCH_ASSOC);
//$bmeta['business_last_no'] = $opportunity['business_no'];

/*
 Update meta data
*/
$update_metadata = $dbh->prepare('UPDATE `businesses_metadata` SET `business_last_no`=?, `business_num`=? WHERE `user_id`=?;');
$update_metadata->execute( array( $opportunity['business_no'], $bmeta['business_num']-1, $_SESSION['userid'] ) );

header("HTTP/1.1 301 Moved Permanently");
header("Location: ".$_SERVER['HTTP_REFERER']);
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