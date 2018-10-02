<?php
session_start();
header( "Content-Type: application/json", true );
require "../../../../config_conn.inc.php";

ignore_user_abort(true); // Ignore user aborts and allow the script to run forever
set_time_limit(0); // disable php time limit

if ( 0 )
{
	ini_set('display_errors',1); 
	error_reporting(E_ALL);
}

$uid = $_SESSION['userid'];

/* Check JSON string */
function is_JSON( $string )
{
	return is_object( json_decode( $string ) );
}

/* Avoid XSS */
function cleanXSS( $var ) 
{
    if( is_array( $var ) )
    {
        $temp = array();
        foreach ( $var as $key => $value )
        {
            $key = preg_replace('/[^\d\w_]/', '', $key);
            $temp[ $key ] = cleanXSS( $value );
        }
        return $temp;
    }
    return htmlspecialchars( $var );
}

function error( $emsg = 'Error' )
{
	$res = array('status' => false, 'emsg' => $emsg); 
	echo json_encode($res);
	exit();
	return false;
}

/* Diff months */
function diff_months_between_two_date( $date1, $date2 )
{
    $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);

    if ( $ts1 > $ts2 )
    {
        return false;
    }

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

    return $diff;
}

/* Increase or decrease months of date */
function calculate_month( $date, $number_month )
{
    $tmp = explode('-', $date);
    $year = intval( $tmp[0] );
    $month = intval( $tmp[1] );

    if ( $number_month > 0 )
    {
        if ( ($month + $number_month) > 12 )
        {
            $year = $year + 1;
        }
        $month = ( $month + $number_month ) % 12 - 1;
        if ( $month == -1 )
        {
        	$month = ( intval($tmp[1]) + $number_month ) % 13 - 1;
        }
        if ( $month == 0 )
        {
            $year = $year - 1;
        }
    }
    elseif ( $number_month < 0 )
    {
        if ( $month >= abs( $number_month ) )
        {
            $month = $month + $number_month + 1;
        }
        else
        {
            $year = $year - 1;
            $month = $month + $number_month + 13;
        }
    }

    if ( $month == 0 )
    {
        $month = 12;
    }

    return date('Y-m-01', strtotime($year.'-'.str_pad($month, 2, "0", STR_PAD_LEFT)));
}

if ( isset( $_POST['data'] ) && is_JSON( $_POST['data'] ) )
{
	$data = cleanXSS( json_decode( $_POST['data'], true ) );
}
else 
{
	error('Unvalid data format. (Error 1000)');
}

/* Connect to DB */
try
{
  	$dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$dbh->exec("SET NAMES 'utf8';");
}
catch ( PDOException $e ) {
	error("Can't connect to database. ".$e->getMessage().' (Error 1001)' );
}

/* Data Validation for input */
if ( !isset($data['aid']) || !is_numeric($data['aid']) )
{
    error('Unvalid params. (Error 1003)');
}
$data['aid'] = intval($data['aid']);
if ( !isset($data['type']) || !in_array( intval($data['type']), array(0, 1) ) )
{
    error('Unvalid params. (Error 1004)');
}
$data['type'] = intval($data['type']);
if ( !isset($data['date']) ||
     !preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $data['date']) )
{
    error('日期格式不正確.');
}
$data['date'] = str_replace('/', '-', $data['date']);
if ( strtotime($data['date']) < strtotime(date('Y-m-d')) )
{
    error('不能新增過去日期的項目.');
}
if ( !(isset($data['sname']) && strlen( trim($data['sname']) ) > 0) ) // Check null name
{
    error("收款/放款人欄位不能為空白.");
}
$data['sname'] = trim($data['sname']);
if ( !(isset($data['iname']) && strlen( trim($data['iname']) ) > 0) ) // Check null name
{
    error("品項欄位不能為空白.");
}
$data['iname'] = trim($data['iname']);
if ( !isset($data['money']) || !is_numeric($data['money']) )
{
    $data['money'] = 0;
}
$data['money'] = abs( floatval($data['money']) );
if ( !isset($data['period']) ||
     !in_array( intval($data['period']), array(0, 1, 2, 3) ) )
{
    error('Unvalid params. (Error 1005)');
}
$data['period'] = intval($data['period']);


// Today datetime
$datetime = date('Y-m-d H:i:s');

try
{
    $res = array( 'status' => true );

    $insert_query_string = "INSERT INTO `savings`(`user_id`, `account_id`, `source_name`, `saving_type`, `start_date`, `pass_dates`, `end_date`, `item_name`, `money`, `period`, `updated`, `created`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    $insert_query = $dbh->prepare( $insert_query_string );
    $insert_query->execute( array(
        $uid, $data['aid'], $data['sname'], $data['type'],
        $data['date'],  '[]', '0000-00-00 00:00:00',
        $data['iname'], $data['money'], $data['period'],
        $datetime, $datetime
    ) );
    if ( $insert_query->rowCount() != 1 )
    {
        error('新增項目失敗. (Error 1007)');
    }
    $saving_id = $dbh->lastInsertId();
    $res['sid'] = $saving_id;

}
catch ( PDOException $e )
{
    error("Error - ".$e->getMessage().' (Error 1002)' );
}

echo json_encode( $res );
?>