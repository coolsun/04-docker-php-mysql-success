<?php
session_start();
header( "Content-Type: application/json", true );
require "../../../../config_conn.inc.php";

ignore_user_abort(true); // Ignore user aborts and allow the script to run forever
set_time_limit(0); // disable php time limit

if ( 1 )
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

if ( isset( $_POST['data'] ) && is_JSON( $_POST['data'] ) )
{
	$data = cleanXSS( json_decode( $_POST['data'], true ) );
}
else 
{
	error('Unvalid data format. (Error 1020)');
}


/* Connect to DB */
try
{
  	$dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
	error("Can't connect to database. ".$e->getMessage().' (Error 1021)' );
}


/* Data Validation for input */
if ( !isset($data['aid']) || !is_numeric($data['aid']) )
{
    error('Unvalid params. (Error 1023)');
}
$data['aid'] = intval($data['aid']);
if ( !isset($data['sid']) || !is_numeric($data['sid']) )
{
    error('Unvalid params. (Error 1024)');
}
$data['sid'] = intval($data['sid']);
if ( !isset($data['dtype']) ||
     !in_array( intval($data['dtype']), array(0, 1) ) )
{
    error('Unvalid params. (Error 1026)');
}
$data['dtype'] = intval($data['dtype']);
if ( !isset($data['date']) ||
     !preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $data['date']) )
{
    error('日期格式不正確.');
}
$data['date'] = str_replace('/', '-', $data['date']);
if ( strtotime($data['date']) < strtotime(date('Y-m-d')) )
{
    error('不合理的日期.');
}

// Get the saving
try
{
    $get_query_string = "SELECT * FROM `savings` WHERE `user_id`=? AND `account_id`=? AND `saving_id`=?";
    $get_query = $dbh->prepare( $get_query_string );
    $get_query->execute( array($uid, $data['aid'], $data['sid']) );
    $saving = $get_query->fetch( PDO::FETCH_ASSOC );
    if ( !$saving )
    {
        error('資料庫中沒有此筆資料, 更新失敗.');
    }
}
catch (PDOException $e) {
    error("Can't connect to database. ".$e->getMessage().' (Error 1017)' );
}

$res = array( 'status' => true );
if ( $data['dtype'] == 0 )
{
    // Pass one date
    $thisSavingPassDates = json_decode($saving['pass_dates']);
    if ( !in_array($data['date'], $thisSavingPassDates) )
    {
        $thisSavingPassDates[] = $data['date'];
    }

    try
    {
        $update_query_string = "UPDATE `savings` SET `pass_dates`=? WHERE `user_id`=? AND `account_id`=? AND `saving_id`=?";
        $update_query = $dbh->prepare( $update_query_string );
        $update_query->execute( array(
            json_encode($thisSavingPassDates),
            $uid, $data['aid'], $data['sid']
        ) );
    }
    catch (PDOException $e) {
        error("Can't connect to database. ".$e->getMessage().' (Error 1018)' );
    }
}
else if ( $data['dtype'] == 1 )
{
    // End at one date
    try
    {
        $update_query_string = "UPDATE `savings` SET `end_date`=? WHERE `user_id`=? AND `account_id`=? AND `saving_id`=?";
        $update_query = $dbh->prepare( $update_query_string );
        $update_query->execute( array(
            $data['date'],
            $uid, $data['aid'], $data['sid']
        ) );
    }
    catch (PDOException $e) {
        error("Can't connect to database. ".$e->getMessage().' (Error 1018)' );
    }
}

echo json_encode( $res );
?>