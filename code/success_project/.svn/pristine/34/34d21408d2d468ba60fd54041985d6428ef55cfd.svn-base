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
	error('Unvalid data format. (Error 900)');
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
	error("Can't connect to database. ".$e->getMessage().' (Error 901)' );
}


try
{
	/* Data Validation for input */
	if ( !isset($data['aid']) || !is_numeric($data['aid']) )
	{
		error('Unvalid params. (Error 903)');
	}
	$data['aid'] = intval($data['aid']);
	if ( !isset($data['date']) || !preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $data['date']) )
	{
		error('日期格式不正確.');
	}
	if ( strtotime($data['date']) > strtotime(date('Y-m-d')) )
	{
		error('不能新增未來日期的帳目.');
	}
	$data['date'] = str_replace('/', '-', $data['date']);
	if ( !isset($data['type']) || !in_array( intval($data['type']), array(0, 1) ) )
	{
		error('Unvalid params. (Error 904)');
	}
	$data['type'] = intval($data['type']);
	if ( !isset($data['money']) || !is_numeric($data['money']) )
	{
		$data['money'] = 0;
	}
	$data['money'] = abs( floatval($data['money']) );
	if ( !isset($data['class']) || !preg_match('/^(\d+)-(\d+)$/', $data['class'], $class_ids) )
	{
		error('Unvalid params. (Error 905)');
	}
	$main_class_id = $class_ids[1];
	$sub_class_id = $class_ids[2];
	/* Get bills_class, and check bill class item is exist */
	$query_string = "SELECT `time_unit`, `class` FROM `bills_class` WHERE `user_id` = ? LIMIT 1";
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid ) );
	$bills_class = $query->fetch( PDO::FETCH_ASSOC );

	$time_unit = $bills_class['time_unit'];
	$bills_class = json_decode( $bills_class['class'], true );

	if ( !isset( $bills_class[ $data['type'] ]['subclass'][ $main_class_id ]['subclass'][ $sub_class_id ] ) )
	{
		error('Unvalid bill class. (Error 906)');
	}

	$positive_atypes = array(0, 3);
	
	// Today datetime
	$date = date('Y-m-d H:i:s');

	// Get account balance to calculate balance of new bill
	$query_string = "SELECT `account_type`, `account_balance` FROM `accounts` WHERE `user_id`=? AND `account_id`=?";
	$query = $dbh->prepare( $query_string );
	$query->execute( array($uid, $data['aid']) );
	// $account_balance = $query->fetchColumn();
	$account = $query->fetch(PDO::FETCH_ASSOC);
	$account_type = intval($account['account_type']);
	$account_balance = floatval($account['account_balance']);

	/* Get bill balance which is the next bill of the new one */
	//$query_string = "SELECT `bill_type`, `money` FROM `bills` WHERE `user_id`=? AND `account_id`=? AND `bill_date`>=?";
	$query_string = "SELECT `bill_type`, `money` FROM `bills` WHERE `user_id`=? AND `account_id`=? AND `bill_date`>?";
	$query = $dbh->prepare( $query_string );
	$query->execute( array($uid, $data['aid'], $data['date']) );
	$next_bills = $query->fetchAll( PDO::FETCH_ASSOC );

	if ( count( $next_bills ) > 0 ) // if has bills whose bill_date is over than the new one, update there balance
	{
		$sum = 0;
		foreach ( $next_bills as $bill )
		{
			if( $bill['bill_type'] == 0 )
			{
				if ( in_array($account_type, $positive_atypes) )
				{
					$sum -= $bill['money'];	
				}
				else
				{
					$sum += $bill['money'];
				}
			}
			else
			{
				if ( in_array($account_type, $positive_atypes) )
				{
					$sum += $bill['money'];	
				}
				else
				{
					$sum -= $bill['money'];
				}
			}
		}

		if ( in_array($account_type, $positive_atypes) )
		{
			if ( $data['type'] == 0 )
			{
				$money = $data['money']*(-1);
			}
			else
			{
				$money = $data['money'];
			}
		}
		else
		{
			if ( $data['type'] == 0 )
			{
				$money = $data['money'];
			}
			else
			{
				$money = $data['money']*(-1);		
			}	
		}
		// $money = ( $data['type'] == 0 && in_array($account_type, $positive_atypes) ) ? $data['money']*(-1) : $data['money'] ;
		$data['balance'] = $account_balance - $sum + $money ;
	}
	else 
	{
		if ( in_array($account_type, $positive_atypes) )
		{
			if ( $data['type'] == 0 )
			{
				$money = $data['money']*(-1);
			}
			else
			{
				$money = $data['money'];
			}
		}
		else
		{
			if ( $data['type'] == 0 )
			{
				$money = $data['money'];
			}
			else
			{
				$money = $data['money']*(-1);		
			}	
		}
		// $money = ( $data['type'] == 0 && in_array($account_type, $positive_atypes) ) ? $data['money']*(-1) : $data['money'] ;
		$data['balance'] = $account_balance + $money;
	}


	/* Insert new bill */
	$insert_query_string = "INSERT INTO `bills` (`user_id`, `account_id`, `bill_date`, `bill_type`, `main_class_id`, `sub_class_id`, `main_class_name`, `sub_class_name`, `money`, `balance`, `updated`, `created`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$insert_query = $dbh->prepare( $insert_query_string );
	$insert_query->execute( array(
		$uid, $data['aid'], $data['date'], $data['type'], $main_class_id, $sub_class_id,
		$bills_class[ $data['type'] ]['subclass'][ $main_class_id ]['name'],
		$bills_class[ $data['type'] ]['subclass'][ $main_class_id ]['subclass'][ $sub_class_id ]['name'],
		$data['money'], $data['balance'], $date, $date
	) );
	$bill_id = $dbh->lastInsertId();
	if ( $insert_query->rowCount() != 1 )
	{
		error('新增帳目失敗. (Error 907)');
	}


	if ( in_array($account_type, $positive_atypes) )
	{
		if ( $data['type'] == 0 )
		{
			$money = '-'.$data['money'];
		}
		else
		{
			$money = '+'.$data['money'];		
		}
	}
	else
	{
		if ( $data['type'] == 0 )
		{
			$money = '+'.$data['money'];
		}
		else
		{
			$money = '-'.$data['money'];		
		}	
	}
	// $money = ( $data['type'] == 0 && in_array($account_type, $positive_atypes) ) ? '-'.$data['money'] : '+'.$data['money'] ;
	// $update_query_string = "UPDATE `bills` SET `balance`=`balance`".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=? AND `bill_date`>=? AND `created`<?";
	$update_query_string = "UPDATE `bills` SET `balance`=`balance`".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=? AND `bill_id`<>? AND `bill_date`>?";
	$update_query = $dbh->prepare( $update_query_string );
	// $update_query->execute( array($date, $uid, $data['aid'], $data['date'], $date) );
	$update_query->execute( array($date, $uid, $data['aid'], $bill_id, $data['date']) );


	$res = array( 'status' => true );

	/* Check has exist monthly account record */
	$year_month = date('Y-m', strtotime($data['date']));
	$t = date('t', strtotime($data['date']));
	$query_string = "SELECT `account_balance` FROM `accounts_monthly` WHERE `user_id`=? AND `account_id`=? AND (`updated_date` BETWEEN ? AND ?) LIMIT 1";
	$query = $dbh->prepare( $query_string );
	$query->execute( array($uid, $data['aid'], $year_month.'-01', $year_month.'-'.$t) );
	$has_monthly_record = $query->fetchColumn();
	
	/* Update balance of account and monthly accounts */
	if ( $has_monthly_record !== false  ) // If has monthly account reocrd, update that account and accounts monthly after the bill date
	{
		if ( in_array($account_type, $positive_atypes) )
		{
			if ( $data['type'] == 0 )
			{
				$money = '-'.$data['money'];
			}
			else
			{
				$money = '+'.$data['money'];		
			}
		}
		else
		{
			if ( $data['type'] == 0 )
			{
				$money = '+'.$data['money'];
			}
			else
			{
				$money = '-'.$data['money'];		
			}	
		}
		// $money = ( $data['type'] == 0 && in_array($account_type, $positive_atypes) ) ? '-'.$data['money'] : '+'.$data['money'] ;
		$update_query_string = "UPDATE `accounts_monthly` SET `account_balance`=`account_balance`".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=? AND `updated_date`>=?";
		$update_query = $dbh->prepare( $update_query_string );
		$update_query->execute( array($date, $uid, $data['aid'], $year_month.'-01') );
		$update_query_string = "UPDATE `accounts` SET `account_balance`=`account_balance`".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=?";
		$update_query = $dbh->prepare( $update_query_string );
		$update_query->execute( array($date, $uid, $data['aid']) );
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
					calculate_month( $data['date'], $i ), $record['description'], $date, $date
				);
				$insert_query->execute( $params );
			}
			
			// update that account and accounts monthly after the bill date
			if ( in_array($account_type, $positive_atypes) )
			{
				if ( $data['type'] == 0 )
				{
					$money = '-'.$data['money'];
				}
				else
				{
					$money = '+'.$data['money'];		
				}
			}
			else
			{
				if ( $data['type'] == 0 )
				{
					$money = '+'.$data['money'];
				}
				else
				{
					$money = '-'.$data['money'];		
				}	
			}
			// $money = ( $data['type'] == 0 && in_array($account_type, $positive_atypes) ) ? '-'.$data['money'] : '+'.$data['money'] ;
			$update_query_string = "UPDATE `accounts_monthly` SET `account_balance`=`account_balance`".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=? AND `updated_date`>=?";
			$update_query = $dbh->prepare( $update_query_string );
			$update_query->execute( array($date, $uid, $data['aid'], $year_month.'-01') );
			$update_query_string = "UPDATE `accounts` SET `account_balance`=`account_balance`".$money.", `updated`=? WHERE `user_id`=? AND `account_id`=?";
			$update_query = $dbh->prepare( $update_query_string );
			$update_query->execute( array($date, $uid, $data['aid']) );
		}
		else
		{	
			$delelte_query_string = 'DELETE FROM `bills` WHERE `user_id`=? AND `bill_id`=?';
        	$params = array( $uid, intval($bill_id) );
        	$delelte_query = $dbh->prepare( $delelte_query_string );
        	$delelte_query->execute( $params );
			error('更新帳戶失敗. 新增帳目失敗. (Error 908)');
		}

	}


	// Check bill whether over budget
	if ( $data['type'] == 0 && isset( $bills_class[0]['subclass'][ $main_class_id ]['subclass'][ $sub_class_id ]['budget'] ) )
	{
		$query_string = "SELECT SUM(`money`) FROM `bills` WHERE `user_id`=? AND `bill_type`=? AND `main_class_id`=? AND `sub_class_id`=? AND (`bill_date` BETWEEN ? AND ?)";
		$query = $dbh->prepare( $query_string );

		if ( $time_unit == 0 )
		{	
			// 0 => Sunday, ..., 6 => Saturday
			$day = date('w', strtotime($data['date']) );
			$first_date = date( 'Y-m-d', strtotime($data['date'].' -'.$day.' days') );
			$last_date =  date( 'Y-m-d', strtotime($data['date'].' +'.(6-$day).' days') );
		}
		elseif ( $time_unit == 1 )
		{
			$first_date = date('Y-m-01', strtotime($data['date']));
			$last_date = date('Y-m-t', strtotime($data['date']));

		}
		elseif ( $time_unit == 2 )
		{
			$current_month = date('m', strtotime($data['date']));
			if ( in_array( intval($current_month), array(1, 2, 3) ) )
			{
				$first_date = date('Y-01-01', strtotime($data['date']));
				$last_date = date('Y-03-31', strtotime($data['date']));
			}
			elseif ( in_array( intval($current_month), array(4, 5, 6) ) )
			{
				$first_date = date('Y-04-01', strtotime($data['date']));
				$last_date = date('Y-06-30', strtotime($data['date']));
			}
			elseif ( in_array( intval($current_month), array(7, 8, 9) ) )
			{
				$first_date = date('Y-07-01', strtotime($data['date']));
				$last_date = date('Y-09-30', strtotime($data['date']));	
			}
			else
			{
				$first_date = date('Y-10-01', strtotime($data['date']));
				$last_date = date('Y-12-31', strtotime($data['date']));
			}
		}
		else
		{
			error('Unvalid budget time unit. (Error 908)');
		}

		$query->execute( array( $uid, 0, $main_class_id, $sub_class_id, $first_date, $last_date ) );
		$bill_total = floatval( $query->fetchColumn() );

		if ( $bill_total > $bills_class[0]['subclass'][ $main_class_id ]['subclass'][ $sub_class_id ]['budget'] ) 
		{
			//$res['msg'] = '此帳款超出'.$time_units[ $time_unit ].'預算.';
			$res['msg'] = '您已超支此項目的預算.';
		}

		$res['budget'] = $bills_class[0]['subclass'][ $main_class_id ]['subclass'][ $sub_class_id ]['budget'];
		$res['total'] = $bill_total;
	}

	

}
catch(PDOException $e)
{
	error("Can't connect to database. ".$e->getMessage().' (Error 902)' );
}

echo json_encode( $res );
?>