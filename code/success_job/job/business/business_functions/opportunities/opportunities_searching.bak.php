<?php
session_start();
header('Content-Type: application/json');
require "../../../../config_conn.inc.php";

/*
 Indexes
*/
$business_status = array( '報價', '開案', '出貨', '流標' );

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

$params_name = array('businessNo', 'clientName', 'start-date', 'end-date', 
					 'requireProductStandard', 'proposalProductStandard', 'typeNumber', 'status');

foreach( $_POST as $name => $value ) {
	if( !in_array($name, $params_name) ) {
		$res = array('status' => 'Error.opportunities_searching.1', 'resultTable' => $name);
		echo json_encode( $res );
		exit();
	}
}

$params_db_name = array('businessNo' => 'business_no', 'clientName' => 'business_client_name',
					 //'start-date' => '', 'end-date', 
					 'requireProductStandard' => 'business_product_require_standard', 'proposalProductStandard' => 'business_product_proposal_standard',
					 'typeNumber' => 'business_product_type_number', 'status' => 'business_status');

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

$search_opptortunities_query = 'SELECT `business_no`, `created_datetime`, `business_status`, `business_client_name`, `business_product_proposal_standard`, `business_product_require_standard`, `business_product_type_number` FROM `businesses` ';
$search_opptortunities_query .= 'WHERE `user_id`=? ';
$search_opptortunities_params = array($_SESSION['userid']);
foreach( $params_db_name as $name => $value ) {
	if( trim( $_POST[$name] ) != '' ) {
		$search_opptortunities_query .= 'AND `'.$params_db_name[$name].'`=? ';
		array_push( $search_opptortunities_params, trim( $_POST[$name] ) );
	}
}
if( trim($_POST['start-date']) != '' || trim($_POST['end-date']) != '' ) {
	$search_opptortunities_query .= 'AND (`created_datetime` BETWEEN ? AND ?) ';
	if( trim($_POST['start-date']) != '' ) {
		$sdate = date('Y-m-d 00:00:00', strtotime($_POST['start-date']));
	}
	else {
		$sdate = date('Y-m-d 00:00:00');
	}
	if( trim($_POST['end-date']) != '' ) {
		$edate = date('Y-m-d 23:59:59', strtotime($_POST['end-date']));
	}
	else {
		$edate = date('Y-m-d 23:59:59');
	}
	array_push( $search_opptortunities_params, $sdate );
	array_push( $search_opptortunities_params, $edate );
}

$search_opptortunities = $dbh->prepare( $search_opptortunities_query );
$search_opptortunities->execute( $search_opptortunities_params );
$results = $search_opptortunities->fetchAll(PDO::FETCH_ASSOC);

$resultsNum = count($results);
$default_rowNum = 16;

$resultTable = '<div id="search-results">';
$resultTable .= '<div class="row column-name"><div class="column" style="border-left: none; width: 107px;">商機序號</div><div class="column">日期</div><div class="column">狀態</div><div class="column">客戶名稱</div><div class="column">客戶產品規格</div><div class="column">我的產品規格</div><div class="column">型號</div></div>';
foreach( $results as $index => $opportunity ) {
	if( $index == $default_rowNum - 1 ) {
		$resultTable .= '<div class="row last-row">';	
	}
	else {
		$resultTable .= '<div class="row">';
	}
	$resultTable .= '<div class="column" style="border-left: none; width: 107px;"><div class="column-value">'.$opportunity['business_no'].'</div></div>';
	$resultTable .= '<div class="column"><div class="column-value">'.date('Y/m/d', strtotime($opportunity['created_datetime'])).'</div></div>';
	$resultTable .= '<div class="column"><div class="column-value">'.$opportunity['business_status'].'</div></div>';
	$resultTable .= '<div class="column"><div class="column-value">'.$opportunity['business_client_name'].'</div></div>';
	$resultTable .= '<div class="column"><div class="column-value">'.$opportunity['business_product_proposal_standard'].'</div></div>';
	$resultTable .= '<div class="column"><div class="column-value">'.$opportunity['business_product_require_standard'].'</div></div>';
	$resultTable .= '<div class="column"><div class="column-value">'.$opportunity['business_product_type_number'].'</div></div>';
	$resultTable .= '</div>';
}

$paddingNum = $default_rowNum - $resultsNum;
if( $resultsNum < $default_rowNum ) {
	for( $i = 0 ; $i < $paddingNum ; $i++ ) {
		if( $i == $paddingNum-1 ) {
			$resultTable .= '<div class="row last-row">';	
		}
		else {
			$resultTable .= '<div class="row">';
		}
		$resultTable .= '<div class="column" style="border-left: none; width: 107px;"><div class="column-value">&nbsp;</div></div>';
		for( $j = 0 ; $j < 6; $j++) { 
			$resultTable .= '<div class="column"><div class="column-value">&nbsp;</div></div>';
		}
		$resultTable .= '</div>';
	}
}
$resultTable .= '</div>';

$test = print_r($results, true);
$res = array('status' => 'success', 'resultTable' => $resultTable, 'num' => $resultsNum, 'params' => $test );
echo json_encode( $res );

?>