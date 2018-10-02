<?php
session_start();
header('Content-Type: application/json');
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

if( isset($_POST['id']) && trim($_POST['id']) ) {
	$id = $_POST['id'];
}
else {
	$res = array('status' => 'Error.sessions_deleting.1');
	echo json_encode( $res );
	exit();
}

/*
 Index
*/
$ampm = array('AM' => '上午', 'PM' => '下午');

/*
 Connect to DB
*/
try {
  $dbh = new PDO($DB_connection_array['job']['driver_name'].':host='.$DB_connection_array['job']['host'].';dbname='.$DB_connection_array['job']['db_name'], $DB_connection_array['job']['user_name'], $DB_connection_array['job']['password']);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
  $res = array('status' => 'Error.sessions_deleting.2');
  echo json_encode( $res );
  exit();
}

/*
 Delete one job and the subjos of it.
 Delete one subjob.
*/
$delete_session = $dbh->prepare('DELETE FROM `sessions` WHERE `session_id`=? and `user_id`=?;'); 
$delete_session->execute( array( $id, $_SESSION['userid'] ) );

$res = array('status' => 'success');
echo json_encode( $res );

?>