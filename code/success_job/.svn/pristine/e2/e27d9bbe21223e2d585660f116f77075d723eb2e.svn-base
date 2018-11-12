<?php
ini_set("display_errors", "On"); // 顯示錯誤是否打開( On=開, Off=關 )
error_reporting(E_ALL & ~E_NOTICE);

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
 Get fist and last job id
*/
if( !( isset($_POST['first']) && isset($_POST['last']) ) && !count($_POST['jobs']) ) {
	$res = array('status' => 'Error.engine_reorder.1');
	echo json_encode( $res );	
	//echo "Error.sessions_saving.1";
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
  $res = array('status' => 'Error.sessions_saving.3');
  echo json_encode( $res );	
  //echo "Error.sessions_saving.3";
  exit();
}

$getJobs = $dbh->prepare('SELECT * FROM `jobs` WHERE `user_id`=? AND ( `job_id` BETWEEN ? AND ? )');
$getJobs->execute( array($_SESSION['userid'], $_POST['first'], $_POST['last']) );
$results = $getJobs->fetchAll(PDO::FETCH_ASSOC);

$check_engine_result = $dbh->prepare('SELECT `engine_result`, `first_id`, `last_id` FROM `engine` WHERE `user_id`=?');
$check_engine_result->execute( array($_SESSION['userid']) );
$engine_result = $check_engine_result->fetch(PDO::FETCH_ASSOC);

$engine_result = unserialize($engine_result['engine_result']);
//print_r($engine_result['orders']);
$tempOrders = array();
$new_orders = array();

$ids = array();
$jobs = array();
foreach( $results as $index => $job ) {
	$id = $job['job_id'];
	unset( $job['job_id'] );
	unset( $job['user_id'] );
	array_push($ids, $id);
	$tempJob = array();
	foreach( $job as $name => $value ) {
		array_push($tempJob, $value);
	}
	$jobs[ $id ] = $tempJob;
	$tempOrders[ $id ] = $engine_result['orders'][ $index ];
	//array_push($jobs, $job);
}

$updateJob = $dbh->prepare('UPDATE `jobs` SET `job_title`=?,`job_priority`=?,`job_status`=?,`job_start_date`=?,`job_end_date`=?,`job_description`=?,`created_datetime`=? WHERE `user_id`=? AND `job_id`=?');
foreach( $_POST['jobs'] as $index => $job_id ) {
	$job_data = $jobs[ $job_id ];
	array_push($job_data, $_SESSION['userid']);
	array_push($job_data, $ids[$index]);
	//print_r($job_data);
	$updateJob->execute( $job_data );
	$new_orders[ $index ] = $tempOrders[ $job_id ];
}

$engine_result['orders'] = $new_orders;
$updateEngine = $dbh->prepare('UPDATE `engine` SET `engine_result`=? WHERE `user_id`=?');
$updateEngine->execute( array(serialize( $engine_result ), $_SESSION['userid']) );

/*$save_engine_result = $dbh->prepare('INSERT INTO `engine` (`user_id`, `engine_result`, `first_id`, `last_id`) VALUES('.$_SESSION['userid'].', ?, ?, ?)');
$save_engine_result->execute( array(serialize($_POST), $firstJobID, $lastJobID) );*/

/*
$delet_prev_jobs = $dbh->prepare('DELETE FROM `jobs` WHERE `user_id`=? AND ( `job_id` BETWEEN ? AND ? )');
$delet_prev_jobs->execute( array($_SESSION['userid'], $_POST['first'], $_POST['last']) );

$add_jobs_params = array();
$add_jobs_query = 'INSERT INTO `jobs` (`user_id`, `job_title`, `job_start_date`, `job_end_date`, `created_datetime`) VALUES ';
foreach( $_POST['jobs'] as $index => $job ) {
	$add_jobs_query .= '('.$_SESSION['userid'].', ?, "'.date('Y-m-d').'", "'.date('Y-m-d').'", "'.date('Y-m-d H:i:s').'")';
	if( $index != count($_POST['jobs']) - 1 ) {
		$add_jobs_query .= ', ';
	}
	array_push($add_jobs_params, $job );
}
$add_jobs = $dbh->prepare( $add_jobs_query );
$add_jobs->execute( $add_jobs_params );
*/
$res = array('status' => 'success' );
echo json_encode( $res );
?>