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
    error('Unvalid data format. (Error 920)');
}


/* Connect to DB */
try
{
  $dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
    error("Can't connect to database. ".$e->getMessage().' (Error 921)' );
}

try
{
    if ( !isset($data['aid']) || !is_numeric( $data['aid'] ) )
    {
        error('Unvalid params. (Error 923)');
    }
    $data['aid'] = intval($data['aid']);
    if ( !isset($data['bid']) || !is_numeric( $data['bid'] ) )
    {
        error('Unvalid params. (Error 924)');
    }
    $data['bid'] = intval($data['bid']);
    

    $positive_atypes = array(0, 3);

    // Today datetime
    $date = date('Y-m-d H:i:s');

    // Get account type
    $query_string = "SELECT `account_type` FROM `accounts` WHERE `user_id`=? AND `account_id`=?";
    $query = $dbh->prepare( $query_string );
    $query->execute( array($uid, $data['aid']) );
    $account_type = $query->fetchColumn();

    
    /* Get the bill */
    $get_query_string = "SELECT * FROM `bills` WHERE `user_id`=? AND `account_id`=? AND `bill_id`=?";
    $get_query = $dbh->prepare( $get_query_string );
    $get_query->execute( array($uid, $data['aid'], $data['bid']) );
    $bill = $get_query->fetch( PDO::FETCH_ASSOC );
    if ( !$bill )
    {
        error('資料庫中沒有此帳目, 刪除失敗.');
    }

    /* Delete account form accounts table and accounts_monthly(by foreign key) */
    $delelte_query_string = 'DELETE FROM `bills` WHERE `user_id`=? AND `bill_id`=?';
    $params = array( $uid, intval($data['bid']) );
    $delelte_query = $dbh->prepare( $delelte_query_string );
    $delelte_query->execute( $params );
    if ( $delelte_query->rowCount() == 0 )
    {
        error('資料庫中沒有此帳目, 刪除失敗.');
    }

    /* Update the bills balance before the deleted bill */
    if ( $bill['bill_type'] == 0 )
    {
        if ( in_array($account_type, $positive_atypes) )
        {
            $money = '+'.$bill['money'];
        }
        else
        {
            $money = '-'.$bill['money'];        
        }
    }
    else
    {
        if ( in_array($account_type, $positive_atypes) )
        {
            $money = '-'.$bill['money'];
        }
        else
        {
            $money = '+'.$bill['money'];        
        }   
    }
    // $money = ( $bill['bill_type'] == 0 && in_array($account_type, $positive_atypes ) ) ? '+'.$bill['money'] : '-'.$bill['money'] ; // if type == 0, increase
    $update_query_string = "UPDATE `bills` SET `balance`=`balance`".$money.", updated=? WHERE (`user_id`=? AND `account_id`=? AND `bill_date`>?) OR (`user_id`=? AND `account_id`=? AND `bill_date`=? AND `created`>?)";
    $update_query = $dbh->prepare( $update_query_string );
    $update_query->execute( array($date, $uid, $data['aid'], $bill['bill_date'], $uid, $data['aid'], $bill['bill_date'], $bill['created']) );


    /* Update account balacne and account monthly balance */
    $year_month = date('Y-m', strtotime($bill['bill_date']));

    $update_query_string = "UPDATE `accounts` SET `account_balance`=`account_balance`".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=?";
    $update_query = $dbh->prepare( $update_query_string );
    $update_query->execute( array($date, $uid, $data['aid']) );

    $update_query_string = "UPDATE `accounts_monthly` SET `account_balance`=`account_balance`".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=? AND `updated_date`>=?";
    $update_query = $dbh->prepare( $update_query_string );
    $update_query->execute( array($date, $uid, $data['aid'], $year_month.'-01') );
    

    $res = array( 'status' => true );
}
catch(Exception $e)
{
    error('Proccess error '.$e->getMessage().' (Error 922)' );
}


echo json_encode( $res );
?>