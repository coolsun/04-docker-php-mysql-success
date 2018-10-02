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
if ( !isset($data['iid']) || !is_numeric($data['iid']) )
{
	error('Unvalid params. (Error 1104)');
}
$data['iid'] = intval($data['iid']);

$res = array("status" => true);

try
{
  // Get account balance to calculate balance of new bill
	$query_string = "SELECT `account_balance` FROM `accounts` WHERE `user_id`=? AND `account_id`=?";
	$query = $dbh->prepare( $query_string );
	$query->execute( array($uid, $data['aid']) );
	$account = $query->fetch( PDO::FETCH_ASSOC );
	if ( !$account )
	{
		error('錯誤的投資帳號.');
	}
	$account_balance = floatval( $account['account_balance'] );


  $query_string = "SELECT * FROM `invests` WHERE `user_id`=? AND `account_id`=? AND `id`=?";
  $query = $dbh->prepare( $query_string );
	$query->execute( array($uid, $data['aid'], $data['iid']) );
  $thisInvest = $query->fetch( PDO::FETCH_ASSOC );
  if ( !$thisInvest )
  {
    error('資料庫中沒有此投資項目, 刪除失敗.');
  }

  if ($thisInvest['quantity'] != $data['quantity']) {
    $query_string = "SELECT `action`, `quantity` FROM `invests` WHERE `user_id` = ? AND `account_id` = ? AND `id` <> ? AND `name` = ?";
    $query = $dbh->prepare($query_string);
    $query->execute( array(
      $uid, $data['aid'], $data['iid'], $thisInvest['name']
    ) );
    $existInvests = $query->fetchAll( PDO::FETCH_ASSOC );

    $lastQuantity = 0;
    foreach ($existInvests as $existInvest) {
      if ($existInvest['action'] == 0) {
        // echo $existInvest['quantity']."+\n";
        $lastQuantity += $existInvest['quantity'];
      } else if ($existInvest['action'] == 1) {
        // echo $existInvest['quantity']."-\n";
        $lastQuantity -= $existInvest['quantity'];
      }
    }

    if ($thisInvest['action'] == 0 && $lastQuantity < 0) {
      error('這張股票您刪除後的買進數量小於目前的賣出數量，請確認後重新輸入!');
    }
    // else if ($thisInvest['action'] == 1 && $data['quantity'] > $lastQuantity) {
    //   error('這張股票您修改的賣出數量大於目前的買入數量，請確認後重新輸入!');
    // }
  }

  $delete_query_string = "DELETE FROM `invests` WHERE `user_id`=? AND `account_id`=? AND `id`=?";
  // echo $delete_query_string."\n";
  $delete_query = $dbh->prepare( $delete_query_string );
  $delete_query->execute( array($uid, $data["aid"], $data["iid"]) );

  $money = ($thisInvest['price'] * $thisInvest['quantity']);
  if ( $thisInvest['action'] == 0 )
  {
      $money = $money + $thisInvest['fee'];
  }
  else if ( $thisInvest['action'] == 1 )
  {
      $money = -$money + $thisInvest['fee'];
  }

  /* Check has exist monthly account record */
	$year_month = date('Y-m', strtotime($thisInvest['buytime']));
	$t = date('t', strtotime($thisInvest['buytime']));
	$query_string = "SELECT `account_balance` FROM `accounts_monthly` WHERE `user_id`=? AND `account_id`=? AND (`updated_date` BETWEEN ? AND ?) LIMIT 1";
	$query = $dbh->prepare( $query_string );
	$query->execute( array($uid, $data['aid'], $year_month.'-01', $year_month.'-'.$t) );
	$has_monthly_record = $query->fetchColumn();

  if ( $has_monthly_record !== false  ) // If has monthly account reocrd, update that account and accounts monthly after the bill date
	{
		// $res['query'] = "UPDATE `accounts_monthly` SET `account_balance`=`account_balance`+".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=? AND `updated_date`>=?";
		$update_query_string = "UPDATE `accounts_monthly` SET `account_balance`=`account_balance`+".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=? AND `updated_date`>=?";
		$update_query = $dbh->prepare( $update_query_string );
		$update_query->execute( array($datetime, $uid, $data['aid'], $year_month.'-01') );

		$update_query_string = "UPDATE `accounts` SET `account_balance`=`account_balance`+".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=?";
		$update_query = $dbh->prepare( $update_query_string );
		$update_query->execute( array($datetime, $uid, $data['aid']) );
	}
	else
	{
		$query_string = "SELECT * FROM `accounts_monthly` WHERE `user_id`=? AND `account_id`=? ORDER BY `updated_date` LIMIT 1";
		$query = $dbh->prepare( $query_string );
		$query->execute( array($uid, $data['aid']) );
		$record = $query->fetch( PDO::FETCH_ASSOC );
		$oldest_monthly_record = $record['updated_date'];
		if ( $oldest_monthly_record )
		{
			// Add account monthly record from the bill date month  to origin oldest record
			$insert_query_string = "INSERT INTO `accounts_monthly` (`user_id`, `account_id`, `account_name`, `account_balance`, `account_type`, `year_rate`, `updated_date`, `description`, `updated`, `created`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$insert_query = $dbh->prepare( $insert_query_string );
			$diff_month = diff_months_between_two_date( $data['date'], $oldest_monthly_record );
			for( $i = 1 ; $i < $diff_month+1 ; $i++ )
			{
				$params = array(
					$uid, $data['aid'], $record['account_name'], 0, $record['account_type'], floatval( $reocrd['year_rate'] ),
					calculate_month( $data['date'], $i ), $record['description'], $datetime, $datetime
				);
				$insert_query->execute( $params );
			}

			$update_query_string = "UPDATE `accounts_monthly` SET `account_balance`=`account_balance`+".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=? AND `updated_date`>=?";
			$update_query = $dbh->prepare( $update_query_string );
			$update_query->execute( array($date, $uid, $data['aid'], $year_month.'-01') );
			$update_query_string = "UPDATE `accounts` SET `account_balance`=`account_balance`+".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=?";
			$update_query = $dbh->prepare( $update_query_string );
			$update_query->execute( array($date, $uid, $data['aid']) );
		}
	}
}
catch ( PDOException $e )
{
	error("Error - ".$e->getMessage().' (Error 1102)' );
}

echo json_encode( $res );
