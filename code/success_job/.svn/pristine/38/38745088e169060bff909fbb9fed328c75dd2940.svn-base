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


if( isset($_POST['changeStatus']) ) {
	$statuss = array(0, 1, 2, 3);
	if( in_array($_POST['changeStatus'], $statuss) ) {
		$update_opportunity_query = 'UPDATE `businesses` SET `business_status`=? WHERE `user_id`=? AND `business_no`=?';
		$update_opportunity = $dbh->prepare( $update_opportunity_query );
		$update_opportunity->execute( array( $_POST['changeStatus'], $_SESSION['userid'], $_POST['businessNo'] ) );
		echo "success";
	}
}
else {
	/*
	 Transfer Date
	*/
	$_POST['requireDate'] = strtotime($_POST['requireDate']);
	$_POST['deliverDate'] = strtotime($_POST['deliverDate']);

	$no = $_POST['businessNo'];
	unset($_POST['businessNo']);
	$params = array();
	foreach( $_POST as $value ) {
		array_push($params, $value);
	}
	array_push($params, $_SESSION['userid']);
	array_push($params, $no);

	//print_r($params);

	/*
	Array ( 
	[businessNo] => 2 [clientName] => 第二 [requireProductStandard] => a [requireDescription] => [requireAmount] => 1 
	[requireDate] => [application] => [salesArea] => [competitor] => [expectedAmount] => 0 [proposalProductStandard] => a 
	[typeNumber] => [productPrice] => 1 [minOrderNum] => 0 [productCost] => 1 [deliver_date] => [supplier] => 
	[paymentCondition] => [proposalDescription] => )
	*/

	$update_opportunity_query = 'UPDATE `businesses` SET `business_client_name`=?, `business_product_require_standard`=?, ';
	$update_opportunity_query .= '`business_product_require_description`=?, `business_product_require_amount`=?, `business_product_require_date`=?, ';
	$update_opportunity_query .= '`business_product_application`=?, `business_product_sales_area`=?, `business_product_competitor`=?, ';
	$update_opportunity_query .= '`business_product_expected_amount`=?, `business_product_proposal_standard`=?, `business_product_type_number`=?, ';
	$update_opportunity_query .= '`business_product_price`=?, `business_product_min_order_num`=?, `business_product_cost`=?, ';
	$update_opportunity_query .= '`business_product_deliver_date`=?, `business_product_supplier`=?, `business_product_payment_condition`=?, ';
	$update_opportunity_query .= '`business_product_proposal_description`=? WHERE `user_id`=? AND `business_no`=?;';

	$update_opportunity = $dbh->prepare( $update_opportunity_query );
	$update_opportunity->execute( $params );

	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ".$_SERVER['HTTP_REFERER']);
}
?>