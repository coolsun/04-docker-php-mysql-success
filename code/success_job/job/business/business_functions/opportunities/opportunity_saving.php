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

$params = array('businessNo', 'clientName', 'requireProductStandard', 'requireAmount',
				'proposalProductStandard', 'productPrice', 'productCost', 'status');

foreach( $_POST as $key => $value ) {
	if( !( isset($_POST[$key]) && trim($_POST[$key]) != '' ) ) {
		error_callback( 'Error.opportunity_saving.1' );
	}
}
//print_r($_POST);

/*
 Connect to DB
*/
try {
  $dbh = new PDO($DB_connection_array['job']['driver_name'].':host='.$DB_connection_array['job']['host'].';dbname='.$DB_connection_array['job']['db_name'], $DB_connection_array['job']['user_name'], $DB_connection_array['job']['password']);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
  error_callback( "Error.opportunity_saving.2".$e->getMessage() );
  exit();
}

$add_opportunity = $dbh->prepare('INSERT INTO `businesses`(`user_id`, `business_no`, `business_status`, `business_client_name`, `business_product_require_standard`, `business_product_require_amount`, `business_product_proposal_standard`, `business_product_price`, `business_product_cost`, `created_datetime`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);');
$add_opportunity->execute( array( $_SESSION['userid'], $_POST['businessNo'], $_POST['status'], $_POST['clientName'], $_POST['requireProductStandard'],
								  $_POST['requireAmount'], $_POST['proposalProductStandard'], $_POST['productPrice'], $_POST['productCost'], date('Y-m-d H:i:s') ) );

$getLastBusinessNo = $dbh->prepare('SELECT `business_last_no`, `business_num`, `business_max_num` FROM `businesses_metadata` WHERE `user_id`=?;');
$getLastBusinessNo->execute( array( $_SESSION['userid'] ) );
$bmeta = $getLastBusinessNo->fetch(PDO::FETCH_ASSOC);

try {
	$update_metadata = $dbh->prepare('UPDATE `businesses_metadata` SET `business_last_no`=?, `business_num`=?, `business_max_num`=? WHERE `user_id`=?;');
	$update_metadata->execute( array( $_POST['businessNo'], $bmeta['business_num']+1, $bmeta['business_max_num']+1, $_SESSION['userid'] ) );

	header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$_SERVER['HTTP_REFERER']);
}
catch (PDOException $e) {
  echo $e->getMessage();
  exit();
}
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