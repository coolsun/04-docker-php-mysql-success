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

/*
 Get type
*/
$types = array(0, 1);
if( in_array( trim( $_POST['type'] ), $types ) ) {
	$type = trim( $_POST['type'] );
}
else {
	$res = array('status' => 'Error.sessions_updating.1');
	echo json_encode( $res );	
	//echo "Error.sessions_saving.1";
	exit();
}

if( isset($_POST['data']) && count( $_POST['data'] ) ) {
	$data = $_POST['data'];
}
else {
	$res = array('status' => 'Error.sessions_updating.2');
	echo json_encode( $res );	
	//echo "Error.sessions_saving.2";
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
  $res = array('status' => 'Error.sessions_updating.3');
  echo json_encode( $res );	
  //echo "Error.sessions_saving.3";
  exit();
}

if( $type == 0 ) {
	$update_session = $dbh->prepare('UPDATE `sessions` SET `session_title`=? WHERE `session_id`=? AND `user_id`=?;');
	$update_session->execute( array( $data['title'], $data['id'], $_SESSION['userid'] ) );
	$res = array('status' => 'success');
	echo json_encode( $res );	
}
else if( $type == 1 ) {
	$time = date( 'H:i:00', strtotime($data['time']) );
	$update_session = $dbh->prepare('UPDATE `sessions` SET `session_title`=?, `session_start_time`=? WHERE `session_id`=? AND `user_id`=?;');
	$update_session->execute( array( $data['title'], $time, $data['id'], $_SESSION['userid'] ) );

	$time = substr($time, 0, 5);
	$amorpm = date('A', strtotime($time) );
	$showtime = date('A h:i', strtotime($time) );
	$showtime = $ampm[ $amorpm ].' '.substr( $showtime, 3);
	$res = array('status' => 'success', 'time' => $showtime);
	echo json_encode( $res );	
}
?>