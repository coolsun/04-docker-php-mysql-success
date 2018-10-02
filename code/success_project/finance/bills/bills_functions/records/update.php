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
	error('Unvalid data format. (Error 910)');
}


/* Indices */
$time_units = array('每週', '每月', '每季');


/* Connect to DB */
try
{
  	$dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
	error("Can't connect to database. ".$e->getMessage().' (Error 911)' );
}


try
{
    /* Data Validation for all type */
    if ( !isset($data['aid']) || !is_numeric( $data['aid'] ) )
    {
        error('Unvalid params. (Error 913)');
    }
    $data['aid'] = intval($data['aid']);
    if ( !isset($data['bid']) || !is_numeric( $data['bid'] ) )
    {
        error('Unvalid params. (Error 914)');
    }
    $data['bid'] = abs( intval($data['bid']) );
    if ( isset($data['payee']) )
    {
        $data['payee'] = trim( $data['payee'] );
    }
    else
    {
        $data['payee'] = '';
    }
    if ( isset($data['description']) )
    {
        $data['description'] = trim( $data['description'] );
    }
    else
    {
        $data['description'] = '';
    }
    if ( !isset($data['money']) || !is_numeric( $data['money'] ) )
    {
       error('Unvalid params. (Error 915)');
    }
    $data['money'] = floatval($data['money']);


     // Today datetime
    $date = date('Y-m-d H:i:s');


    /* Get the bill */
    $get_query_string = "SELECT * FROM `bills` WHERE `user_id`=? AND `account_id`=? AND `bill_id`=?";
    $get_query = $dbh->prepare( $get_query_string );
    $get_query->execute( array($uid, $data['aid'], $data['bid']) );
    $bill = $get_query->fetch( PDO::FETCH_ASSOC );
    if ( !$bill )
    {
        error('資料庫中沒有此帳目, 更新失敗.');
    }

    $diff_money = abs( $bill['money'] - $data['money'] );

    if ( $bill['bill_type'] == 0 && $bill['money'] < $data['money'] )
    {
        $diff_money = '-'.$diff_money;
    }
    elseif ( $bill['bill_type'] == 0 && $bill['money'] > $data['money'] )
    {
        $diff_money = '+'.$diff_money;   
    }
    elseif ( $bill['bill_type'] == 1 && $bill['money'] < $data['money'] )
    {
        $diff_money = '+'.$diff_money;
    }
    elseif ( $bill['bill_type'] == 1 && $bill['money'] > $data['money'] )
    {
        $diff_money = '-'.$diff_money;   
    }


    if ( abs( $bill['money'] - $data['money'] ) != 0 )
    {
        /* Update the bill */
        $update_query_string = "UPDATE `bills` SET `balance`=`balance`".$diff_money.", `payee`=?, `description`=?, `money`=? WHERE `user_id`=? AND `account_id`=? AND `bill_id`=?";
        $update_query = $dbh->prepare( $update_query_string );
        $update_query->execute( array( $data['payee'], $data['description'], $data['money'], $uid, $data['aid'], $data['bid'] ) );

        /* Update bills */
        $update_query_string = "UPDATE `bills` SET `balance`=`balance`".$diff_money.", updated=? WHERE (`user_id`=? AND `account_id`=? AND `bill_date`>?) OR (`user_id`=? AND `account_id`=? AND `bill_date`=? AND `created`<?)";
        $update_query = $dbh->prepare( $update_query_string );
        $update_query->execute( array($date, $uid, $data['aid'], $bill['bill_date'], $uid, $data['aid'], $bill['bill_date'], $bill['created']) );

        /* Update account balacne and account monthly balance */
        $year_month = date('Y-m', strtotime($data['date']));

        $update_query_string = "UPDATE `accounts` SET `account_balance`=`account_balance`".$diff_money.", `updated`=? WHERE `user_id`=? AND `account_id`=?";
        $update_query = $dbh->prepare( $update_query_string );
        $update_query->execute( array($date, $uid, $data['aid']) );

        $update_query_string = "UPDATE `accounts_monthly` SET `account_balance`=`account_balance`".$diff_money.", `updated`=? WHERE `user_id`=? AND `account_id`=? AND `updated_date`>=?";
        $update_query = $dbh->prepare( $update_query_string );
        $update_query->execute( array($date, $uid, $data['aid'], $year_month.'-01') );
    }
    else
    {
        /* Update the bill */
        $update_query_string = "UPDATE `bills` SET `payee`=?, `description`=?, `money`=? WHERE `user_id`=? AND `account_id`=? AND `bill_id`=?";
        $update_query = $dbh->prepare( $update_query_string );
        $update_query->execute( array( $data['payee'], $data['description'], $data['money'], $uid, $data['aid'], $data['bid'] ) );
    }

    $res = array( 'status' => true );
}
catch (PDOException $e) {
  error("Can't connect to database. ".$e->getMessage().' (Error 912)' );
}


echo json_encode( $res );
?>