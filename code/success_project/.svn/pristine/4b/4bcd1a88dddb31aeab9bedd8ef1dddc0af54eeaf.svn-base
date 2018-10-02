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
    error('Unvalid data format. (Error 820)');
}


/* Connect to DB */
try
{
  $dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
    error("Can't connect to database. ".$e->getMessage().' (Error 821)' );
}

try
{
    if ( isset($data['id']) && is_int( intval($data['id']) ) && isset($data['atype']) && in_array( intval($data['atype']), array(0, 1, 2, 3, 4) ) )
    {
        /* Delete account form accounts table and accounts_monthly(by foreign key) */
        $delelte_query_string = 'DELETE FROM `accounts` WHERE `user_id`=? AND `account_id`=? AND `account_type`=?';
        $params = array( $uid, intval($data['id']), intval($data['atype']) );
        $delelte_query = $dbh->prepare( $delelte_query_string );
        $delelte_query->execute( $params );
        if ( $delelte_query->rowCount() == 0 )
        {
            error('資料庫中沒有此帳戶, 刪除失敗.');
        }

        $res = array( 'status' => true );
    }
    else
    {
        error('Unvalid params. (Error 823)' );
    }
}
catch(Exception $e)
{
    error('Proccess error '.$e->getMessage().' (Error 822)' );
}


echo json_encode( $res );
?>