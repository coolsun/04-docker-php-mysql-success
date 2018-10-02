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

if ( isset( $_POST['data'] ) && is_JSON( $_POST['data'] ) )
{
	$data = cleanXSS( json_decode( $_POST['data'], true ) );
}
else 
{
	error('Unvalid data format. (Error 950)');
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

	$date = date('Y-m-d H:i:s');

	$default_bills_class_json = file_get_contents('../../bills_class.json', 1);
	$default_bills_class = json_decode( $default_bills_class_json, true );

	$names = array();

	foreach ( $default_bills_class[0]['subclass'] as $mid => $mclass )
	{
		if ( $mclass['name'] != $bills_class[0]['subclass'][$mid]['name'] ) // must match the same main class name
		{
			continue;
		}

		foreach ( $mclass['subclass'] as $sid => $sclass )
		{
			foreach ( $bills_class[0]['subclass'][$mid]['subclass'] as $bsid => $bsclass )
			{
				if ( $sclass['name'] != $bsclass['name'] ) // must match the same sub class name
				{
					continue;
				}
				else if ( $sclass['name'] == $bsclass['name'] )
				{
					if ( isset( $bsclass['budget'] ) )
					{
						$default_bills_class[0]['subclass'][$mid]['subclass'][$sid]['budget'] = $bsclass['budget'];
						break;
					}
				}	
			}
		}

		/*if ( $mclass['name'] == $bills_class[0]['subclass'][$mid]['name'] ) // must match the same mid and class name
		{
			foreach ( $mclass['subclass'] as $sid => $sclass )
			{
				if ( $sclass['name'] == $bills_class[0]['subclass'][$mid]['subclass'][$sid]['name'] ) // must match the same mid and class name
				{
					if ( isset( $bills_class[0]['subclass'][$mid]['subclass'][$sid]['budget'] ) )
					{
						$default_bills_class[0]['subclass'][$mid]['subclass'][$sid]['budget'] = $bills_class[0]['subclass'][$mid]['subclass'][$sid]['budget'];
						
					}
				}
			}
		}*/	
	}

	$default_bills_class = json_encode( $default_bills_class );

	// Update bills class
	$update_query_string = "UPDATE `bills_class` SET `version`=`version`+1, `class`=?, `updated`=? WHERE `user_id`=?";
	$update_query = $dbh->prepare( $update_query_string );
	$update_query->execute( array( $default_bills_class, $date, $uid ) );


  	$res = array( 'status' => true );
  	$res['ver'] = $bills_class_ver + 1;
}
catch (PDOException $e)
{
	error("Can't connect to database. ".$e->getMessage().' (Error 951)' );
}

echo json_encode( $res );
?>