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

function error( $emsg = 'Error' )
{
	$res = array('status' => false, 'emsg' => $emsg);
	echo json_encode($res);
	exit();
	return false;
}

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

if ( isset( $_POST['data'] ) && is_JSON( $_POST['data'] ) )
{
	$data = cleanXSS( json_decode( $_POST['data'], true ) );
}
else
{
	error('Unvalid data format. (Error 1100)');
}

/* Connect to DB */
try
{
  	$dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$dbh->exec("SET NAMES 'utf8';");
}
catch ( PDOException $e ) {
	error("Can't connect to database. ".$e->getMessage().' (Error 1101)' );
}

/* Data Validation for input */
if ( !isset($data['aid']) || !is_numeric($data['aid']) )
{
	error('Unvalid params. (Error 1103)');
}
$data['aid'] = intval($data['aid']);
if ( !isset($data['aid']) || !is_numeric($data['aid']) || !isset($data['iname']) )
{
	error('Unvalid params. (Error 1104)');
}
$data['aid'] = intval($data['aid']);

$res = array("status" => true);

try
{
  $delete_query_string = "DELETE FROM `marketcaps` WHERE `user_id`=? AND `account_id`=? AND `invest_name`=?";
  // echo $delete_query_string."\n";
  $delete_query = $dbh->prepare( $delete_query_string );
  $delete_query->execute( array(
    $uid, $data["aid"], $data["iname"]
  ));
}
catch ( PDOException $e )
{
	error("Error - ".$e->getMessage().' (Error 1102)' );
}

echo json_encode( $res );









