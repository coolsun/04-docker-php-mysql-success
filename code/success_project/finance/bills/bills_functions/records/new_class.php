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
	error('Unvalid data format. (Error 930)');
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
	error("Can't connect to database. ".$e->getMessage().' (Error 931)' );
}


try
{
	/* Data validation */
	if ( !isset($data['ver']) || !is_numeric($data['ver']) )
	{
		error('Unvalid params. (Error 933)');
	}
	$data['ver'] = intval($data['ver']);
	if ( !isset($data['name']) || !trim($data['name']) )
	{
		error('項目名稱不能為空.');
	}
	$data['name'] = trim($data['name']);
	if ( !isset($data['type']) || !in_array($data['type'], array(0, 1)) )
	{
		error('Unvalid params. (Error 934)');
	}
	if ( isset($data['mid']) )
	{
		if ( !is_numeric($data['mid']) )
		{
			error('Unvalid params. (Error 935)');
		}
		$data['mid'] = intval($data['mid']);
	}


	/* Get bill class */
	$query_string = "SELECT `version`, `class` FROM `bills_class` WHERE `user_id` = ? LIMIT 1";
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid ) );
	$bills_class = $query->fetch( PDO::FETCH_ASSOC );
	if ( !$bills_class )
	{
		error('資料庫中沒有收入/支出項目. (Error 936)');
	}
	$bills_class_ver = intval($bills_class['version']);
	if ( $bills_class_ver != $data['ver'] )
	{
		error('已修改過項目, 請重新整理取得最新項目選項.');
	}
	$bills_class = json_decode( $bills_class['class'], true );

	$res = array( 'status' => true );

	$date = date('Y-m-d H:i:s');
	
	if ( !isset( $data['mid'] ) ) // Add main class
	{
		// Check main class item name is exist
		foreach ( $bills_class[ $data['type'] ]['subclass'] as $main_class )
		{
			if ( $main_class['name'] == $data['name'] )
			{
				error('已存在此主項目.');
			}
		}

		$bills_class[ $data['type'] ]['subclass'][] = array( 
			'name' => $data['name'],
			'subclass' => array() 
		);
		$res['mid'] = count( $bills_class[ $data['type'] ]['subclass'] ) - 1;
	}
	else // Add sub class item
	{
		// Check main class item id is exist
		if ( !isset( $bills_class[ $data['type'] ]['subclass'][ $data['mid'] ] ) )
		{
			error('Unvalid params. (Error 935)');
		}

		// Check main class item name is exist
		foreach ( $bills_class[ $data['type'] ]['subclass'][ $data['mid'] ]['subclass'] as $sub_class )
		{
			if ( $sub_class['name'] == $data['name'] )
			{
				error('已存在此子項目.');
			}
		}

		$bills_class[ $data['type'] ]['subclass'][ $data['mid'] ]['subclass'][] = array( 'name' => $data['name'] );
		$res['sid'] = count( $bills_class[ $data['type'] ]['subclass'][ $data['mid'] ]['subclass'] ) - 1;
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
	error("Can't connect to database. ".$e->getMessage().' (Error 932)' );
}

echo json_encode( $res );
?>