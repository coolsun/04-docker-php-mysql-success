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

$params_name = array('status', 'class');

foreach( $_POST as $name => $value ) {
	if( !in_array($name, $params_name) ) {
		$res = array('status' => 'Error.opportunities_analysis.1');
		echo json_encode( $res );
		exit();
	}
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
  $res = array('status' => 'Error.opportunities_searching.2');
  echo json_encode( $res );
  exit();
}

$classes = array('business_product_proposal_standard', 'business_client_name');

$getList_query = 'SELECT `'.$classes[$_POST['class']].'` AS `name` FROM `businesses` WHERE `user_id`=? AND `business_status`=? GROUP BY `'.$classes[$_POST['class']].'`; ';
$getList_params = array( $_SESSION['userid'], $_POST['status'] );
$getList = $dbh->prepare( $getList_query );
$getList->execute( $getList_params );
$list = $getList->fetchAll(PDO::FETCH_ASSOC);

//$test = print_r($list, true);
$res = array('status' => 'success', 'list' => $list);
echo json_encode( $res );
exit();
?>