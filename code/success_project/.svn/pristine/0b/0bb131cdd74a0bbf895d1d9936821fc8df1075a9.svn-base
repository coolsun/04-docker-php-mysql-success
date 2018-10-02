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

function encode_ch(&$value, $key)
{
	if( is_string($value) )
	{
		$value = urlencode($value);
	}
}

if ( isset( $_POST['data'] ) && is_JSON( $_POST['data'] ) )
{
	$data = cleanXSS( json_decode( $_POST['data'], true ) );
}
else 
{
	error('Unvalid data format. (Error 940)');
}


/* Connect to DB */
try
{
  	$dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e)
{
	error("Can't connect to database. ".$e->getMessage().' (Error 941)' );
}


try
{
	/* Data validation */
	if ( !isset($data['ver']) || !is_numeric($data['ver']) )
	{
		error('Unvalid params. (Error 943)');
	}
	$data['ver'] = intval($data['ver']);
	if ( !isset($data['type']) || !in_array($data['type'], array(0, 1)) )
	{
		error('Unvalid params. (Error 944)');
	}
	if ( !isset($data['mid']) || !is_numeric($data['mid']) )
	{
		error('Unvalid params. (Error 945)');
	}
	$data['mid'] = intval($data['mid']);
	if ( isset($data['sid']) )
	{
		if ( !is_numeric($data['sid']) )
		{
			error('Unvalid params. (Error 946)');
		}
		$data['sid'] = intval($data['sid']);
	}


	/* Get bill class */
	$query_string = "SELECT `version`, `class` FROM `bills_class` WHERE `user_id` = ? LIMIT 1";
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid ) );
	$bills_class = $query->fetch( PDO::FETCH_ASSOC );
	if ( !$bills_class )
	{
		error('資料庫中沒有收入/支出項目. (Error 947)');
	}
	$bills_class_ver = intval($bills_class['version']);
	if ( $bills_class_ver != $data['ver'] )
	{
		error('已修改過項目, 請重新整理取得最新項目選項.');
	}
	$bills_class = json_decode( $bills_class['class'], true );

	$res = array( 'status' => true );

	$date = date('Y-m-d H:i:s');

	// Check main class item id is exist
	if ( !isset( $bills_class[ $data['type'] ]['subclass'][ $data['mid'] ] ) )
	{
		error('Unvalid params. (Error 938)');
	}
	
	if ( !isset($data['sid']) ) // Delete main class item
	{
		if ( $data['mid'] != count( $bills_class[ $data['type'] ]['subclass'] ) -1 )
		{
			/* If is not the last main class item of bill type */

			// Update sub class id of bills
			$update_query_string = "UPDATE `bills` SET `main_class_id`=`main_class_id`-1, `updated`=? WHERE `user_id`=? AND `bill_type`=? AND `main_class_id`>?";
			$update_query = $dbh->prepare( $update_query_string );
			$update_query->execute( array( $date, $uid, $data['type'], $data['mid'] ) );
		}

		unset( $bills_class[ $data['type'] ]['subclass'][ $data['mid'] ] );
		$bills_class[ $data['type'] ]['subclass'] = array_values($bills_class[ $data['type'] ]['subclass']);
	}
	else // Delete sub class item
	{
		// Check sub class item id is exist
		if ( !isset( $bills_class[ $data['type'] ]['subclass'][ $data['mid'] ]['subclass'][ $data['sid'] ] ) )
		{
			error('Unvalid params. (Error 939)');
		}

		if ( $data['sid'] != count( $bills_class[ $data['type'] ]['subclass'][ $data['mid'] ]['subclass'] ) -1 )
		{
			/* If is not the last sub class item of main class item */

			// Update old sub class id of bills
			$update_query_string = "UPDATE `bills` SET `main_class_id`=-1, `sub_class_id`=-1, `updated`=? WHERE `user_id`=? AND `bill_type`=? AND `main_class_id`=? AND `sub_class_id`=?";
			$update_query = $dbh->prepare( $update_query_string );
			$update_query->execute( array( $date, $uid, $data['type'], $data['mid'], $data['sid'] ) );

			// Update sub class id of bills
			$update_query_string = "UPDATE `bills` SET `sub_class_id`=`sub_class_id`-1, `updated`=? WHERE `user_id`=? AND `bill_type`=? AND `main_class_id`=? AND `sub_class_id`>?";
			$update_query = $dbh->prepare( $update_query_string );
			$update_query->execute( array( $date, $uid, $data['type'], $data['mid'], $data['sid'] ) );
		}

		unset( $bills_class[ $data['type'] ]['subclass'][ $data['mid'] ]['subclass'][ $data['sid'] ] );
		$bills_class[ $data['type'] ]['subclass'][ $data['mid'] ]['subclass'] = 
			array_values($bills_class[ $data['type'] ]['subclass'][ $data['mid'] ]['subclass']);
	}

	/*array_walk_recursive($bills_class, function(&$value, $key) {
	    if( is_string($value) )
	    {
	        $value = urlencode($value);
	    }
	});*/
	array_walk_recursive($bills_class, 'encode_ch');
	$bills_class = urldecode( json_encode($bills_class) );

	// Update bills class
	$update_query_string = "UPDATE `bills_class` SET `version`=`version`+1, `class`=?, `updated`=? WHERE `user_id`=?";
	$update_query = $dbh->prepare( $update_query_string );
	$update_query->execute( array( $bills_class, $date, $uid ) );

	$res['ver'] = $bills_class_ver + 1;

}
catch (PDOException $e)
{
	error("Can't connect to database. ".$e->getMessage().' (Error 942)' );
}

echo json_encode( $res );
?>