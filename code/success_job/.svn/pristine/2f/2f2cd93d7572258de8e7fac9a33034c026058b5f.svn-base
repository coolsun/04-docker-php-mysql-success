<?php
session_start();
header('Content-Type: application/json');
require "../../../../config_conn.inc.php";

ini_set("display_errors", "On"); // 顯示錯誤是否打開( On=開, Off=關 )
error_reporting(E_ALL & ~E_NOTICE);

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
		$res = array('status' => 'Error.opportunities_searching.1');
		echo json_encode( $res );
		exit();
	}
}
/*'businessNo' => 'business_no', */
$params_db_name = array('clientName' => 'business_client_name',
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

$search_opptortunities_query = 'SELECT `business_no`, `created_datetime`, `business_status`, `business_client_name`, `business_product_require_standard`, `business_product_proposal_standard`, `business_product_type_number` FROM `businesses` ';
$search_opptortunities_query .= 'WHERE `user_id`=? ';
$search_opptortunities_params = array($_SESSION['userid']);
if( trim( $_POST['businessNo']) != '' ) {
	$search_opptortunities_query .= 'AND `business_no`=? ';
	array_push( $search_opptortunities_params, trim( $_POST['businessNo'] ) );
}
else {
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
}

$search_opptortunities = $dbh->prepare( $search_opptortunities_query );
$search_opptortunities->execute( $search_opptortunities_params );
$results = $search_opptortunities->fetchAll(PDO::FETCH_ASSOC);

$resultsNum = count($results);
$default_rowNum = 16;

$resultTable = '<table class="search-results" style="width: 100%; border-collapse: separate; border-spacing: 0; margin: 0; ">';
$resultTable .= '<tr class="row column-name"><td class="column" style="border-left: none; width: 107px;">商機序號</td><td class="column">日期</td><td class="column">狀態</td><td class="column">客戶名稱</td><td class="column">客戶產品規格</td><td class="column">我的產品規格</td><td class="column">型號</td></tr>';
$resultTable .= '</tbody></table>';
$resultTable .= '<div class="search-results-scrollwrap"><table class="search-results" style="width: 100%; border-collapse: separate; border-spacing: 0; margin: 0;"  cellpadding="0"><tbody style="display: block;">';
foreach( $results as $index => $opportunity ) {
	if( count($results) >= 16 && $index == count($results) - 1 ) {
		$resultTable .= '<tr class="row data-row last-row">';	
	}
	else {
		$resultTable .= '<tr class="row data-row">';
	}
	$resultTable .= '<td class="column" style="border-left: none; width: 107px;"><div class="column-value b_no">'.$opportunity['business_no'].'</div></td>';
	$resultTable .= '<td class="column"><div class="column-value">'.date('Y/m/d', strtotime($opportunity['created_datetime'])).'</div></td>';
	$resultTable .= '<td class="column"><div class="column-value">'.$business_status[$opportunity['business_status']].'</div></td>';
	$resultTable .= '<td class="column"><div class="column-value">'.$opportunity['business_client_name'].'</div></td>';
	$resultTable .= '<td class="column"><div class="column-value">'.$opportunity['business_product_require_standard'].'</div></td>';
	$resultTable .= '<td class="column"><div class="column-value">'.$opportunity['business_product_proposal_standard'].'</div></td>';
	$resultTable .= '<td class="column"><div class="column-value">'.$opportunity['business_product_type_number'].'</div></td>';
	$resultTable .= '</tr>';
}

$paddingNum = $default_rowNum - $resultsNum;
if( $resultsNum < $default_rowNum ) {
	for( $i = 0 ; $i < $paddingNum ; $i++ ) {
		if( $i == $paddingNum-1 ) {
			$resultTable .= '<tr class="row last-row">';	
		}
		else {
			$resultTable .= '<tr class="row">';
		}
		$resultTable .= '<td class="column" style="border-left: none; width: 107px;"><div class="column-value">&nbsp;</div></td>';
		for( $j = 0 ; $j < 6; $j++) { 
			$resultTable .= '<td class="column"><div class="column-value">&nbsp;</div></td>';
		}
		$resultTable .= '</tr>';
	}
}
$resultTable .= '</tbody></table></div>';

//$test = print_r($results, true);
$res = array('status' => 'success', 'resultTable' => $resultTable, 'num' => $resultsNum);
echo json_encode( $res );

?>