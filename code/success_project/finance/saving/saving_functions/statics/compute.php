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
else
{
    error_reporting(E_ERROR);
}

$uid = isset($_SESSION['userid']) ? $_SESSION['userid'] : 1;

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
            $year = $year + floor( ($month + $number_month) / 12 );
            if ( ($month + $number_month) % 12 == 0 )
            {
                $year = $year -1;
            }
        }
        $month = ( $month + $number_month ) % 12 - 1;
        if ( $month == -1 )
        {
            $month = ( intval($tmp[1]) + $number_month ) % 13 - 1;
            if ( floor((intval($tmp[1]) + $number_month) / 12) >= 2 )
            {
                $month = $month + floor((intval($tmp[1]) + $number_month) / 12) - 1;
            }
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
            $year = $year + floor( ($month + $number_month) / 12 );
            $month = ($month + $number_month) % 12 + 12 + 1;
        }
        $month = $month % 12;
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
	error('Unvalid data format. (Error 1000)');
}

/* Connect to DB */
try
{
  	$dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$dbh->exec("SET NAMES 'utf8';");
}
catch ( PDOException $e ) {
	error("Can't connect to database. ".$e->getMessage().' (Error 1001)' );
}


/* selfFirstDate */
$selfFirstDate = date('Y-m-d');
$selfFirstDateInt = strtotime($selfFirstDate);


/* Data Validation for input */
if ( !isset($data['aid']) || !is_numeric($data['aid']) )
{
    error('Unvalid params. (Error 1013)');
}
$data['aid'] = intval($data['aid']);
if ( !isset($data['atype']) || !is_numeric($data['atype']) )
{
    error('Unvalid params. (Error 1014)');
}
$data['atype'] = intval($data['atype']);
if ( !isset($data['money']) || !is_numeric($data['money']) )
{
    $data['money'] = 0;
}
$data['money'] = floatval($data['money']);

/* Get account data */
try
{
	/* Get accounts data of the user */
	$query_string = 'SELECT * FROM `accounts` WHERE `user_id`=? AND `account_id`=? AND `account_type`=?';
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid, $data['aid'], $data['atype'] ) );
	$account = $query->fetch( PDO::FETCH_ASSOC );
	if ( !$account )
	{
		error('沒有此帳戶.');
	}
}
catch (PDOException $e)
{
	echo $e->getMessage();
	exit();
}

if ($account['account_balance'] > $data['money'])
{
	error('目標金額不能小於目前帳戶餘額');
}

$initial_balance = floatval($account['account_balance']);
$current_balance = floatval($account['account_balance']);

/* Get savings list */
$savings_list = array();
try
{
	// $lastDate = $selfLastDate;
	// $lastDateInt = strtotime($lastDate);
	$query_string = 'SELECT * FROM `savings` WHERE `user_id`=? AND `account_id`=? AND (`end_date`="0000-00-00" OR `end_date`>=?) ORDER BY `start_date`, `created` DESC';
	$query = $dbh->prepare( $query_string );
	$query->execute( array($uid, $data['aid'], $selfFirstDate) );
	$savings_list = $query->fetchAll( PDO::FETCH_ASSOC );

	// echo $selfFirstDate.' -> '.$lastDate;
}
catch (PDOException $e)
{
	echo $e->getMessage();
	exit();
}

$lastEndDate = "0000-00-00";
foreach ( $savings_list as $i => $saving )
{
	if ( $saving['end_date'] != "0000-00-00" &&
		 strtotime( $saving['end_date'] ) > strtotime($lastEndDate) )
	{
		$lastEndDate = $saving['end_date'];
	}
	$savings_list[$i]['start_date_exclude_flag'] = false;
	if ( strtotime($saving['start_date']) < $selfFirstDateInt )
	{
		$savings_list[$i]['start_date_exclude_flag'] = true;
	}
}
$lastEndDateInt = strtotime($lastEndDate);


$res = array( 'status' => false );

if ( $initial_balance == $data['money'] )
{
	$res['status'] = true;
	$res['date'] = date('Y/m/d');
	echo json_encode( $res );
	exit();
}

$history = array();

$try = 1;
$outline_try = 1;
$outline_diff_balances = array();
$lastDate = date('Y-m-d');
while(1)
{
	/**
	 * For each try, generate savings items of 30 days
	 */
	$lastDate = date('Y-m-d', strtotime($lastDate.' +30 day'));
	$lastDateInt = strtotime($lastDate);

	// remove end_date is expired saving
	if ( $try > 1 )
	{
		$income_savings_list = array();
		$outcome_savings_list = array();
		$temp_savings_list = array();
		foreach ( $savings_list as $i => $saving )
		{
			// $temp_savings_list[] = $saving;
			if ( $saving['saving_type'] == 0 )
			{
				$outcome_savings_list[] = $saving;
			}
			else if ( $saving['saving_type'] == 1 )
			{
				$income_savings_list[] = $saving;
			}
			/*if ( $saving['end_date'] == '0000-00-00' ||
				 strtotime($saving['end_date']) >= $lastDateInt )
			{
				$temp_savings_list[] = $saving;
				if ( $saving['saving_type'] == 0 )
				{
					$outcome_savings_list[] = $saving;
				}
				else if ( $saving['saving_type'] == 1 )
				{
					$income_savings_list[] = $saving;
				}
			}
			else
			{
				$history[] = array(
					'sid' => $saving['saving_id'],
					'endDate' => $saving['end_date'],
					'lastDate' => $lastDate
				);
			}*/
		}
		// $savings_list = $temp_savings_list;

		// Check weather the target date can be done or not.
		$failedFlag = false;
		if ( $data['money'] <= 0 &&
			 count($outcome_savings_list) == 0 )
	    {
	    	$failedFlage = true;
	    }
	    else if ( $data['money'] >= 0 &&
	    		  count($income_savings_list) == 0 )
	    {
	    	$failedFlage = true;
	    }
	    else if ( $lastDateInt > $lastEndDateInt )
	    {
	    	if ( diff_months_between_two_date($selfFirstDate, $lastDate) >=12*$outline_try  )
	    	{
	    		$outline_diff_balances[] = abs($data['money'] - $current_balance);
	    		$outline_try += 1;
	    	}

	    	if ( count( $outline_diff_balances ) == 3 )
	    	{
	    		if ( !($outline_diff_balances[0] > $outline_diff_balances[1] &&
	    		 	   $outline_diff_balances[1] > $outline_diff_balances[2] ) )
	    		{
	    			$failedFlage = true;
	    			// $res['test'] = $current_balance;
	    		}
	    	}
	    }

	    if ( $failedFlage )
	    {
	    	$res['emsg'] = "無法達成.";
	    	break;
	    }
	}

	// if ( $try > 100 )
	// {
	// 	$res['outline_try'] = $outline_try;
	// 	break;
	// }

	$savings_items = array();
	foreach ( $savings_list as $i => $saving )
	{
		$thisSavingStartDate = $saving['start_date'];
		$thisSavingStartDateInt = strtotime($thisSavingStartDate);
		$thisSavingPassDates = json_decode($saving['pass_dates']);
		$thisSavingEndDate = $saving['end_date'];
		$thisSavingEndDateInt = strtotime($thisSavingEndDate);
		$thisSavingPeriodUnit = $periods_units[ $saving['period'] ];

		$thisSavingStartDate_y = intval(date('Y', $thisSavingStartDateInt));
		$thisSavingStartDate_m = intval(date('m', $thisSavingStartDateInt));
		$thisSavingStartDate_d = intval(date('d', $thisSavingStartDateInt));


		// Only for try 1
		if ( !$saving['start_date_exclude_flag'] &&
			 $selfFirstDateInt <= $thisSavingStartDateInt &&
			 $thisSavingStartDateInt <= $lastDateInt &&
			 !in_array($thisSavingStartDate, $thisSavingPassDates) &&
			 $thisSavingStartDateInt != $thisSavingEndDateInt )
		{
			$savings_items[] = array(
				'sid' 	=> $saving['saving_id'],
				'aid' 	=> $saving['account_id'],
				'type'	=> $saving['saving_type'],
				'date'	=> $thisSavingStartDate,
				'dateInt'	=> $thisSavingStartDateInt,
				'money'	=> floatval($saving['money']),
				'period'	=> intval($saving['period']),
				// 'list_first'	=> 1
			);
			$savings_list[$i]['start_date_exclude_flag'] = true;
		}


		$turn = 1;
		$deriveSavingDates = array();
		while( 1 )
		{
			if ( $saving['period'] == 0 )
			{
				$deriveSavingDateInt = strtotime($thisSavingStartDate.' +'.$turn.' week');
			}
			else if ( $saving['period'] == 1 )
			{
				$nextMonthFirstDate = calculate_month( $thisSavingStartDate, ($turn+1) );
				$nextMonthFirstDateInt = strtotime($nextMonthFirstDate);

				$nextMonthFirstDate_m = date('m', $nextMonthFirstDateInt);
				$nextMonthFirstDate_m_last_d = date('t', $nextMonthFirstDateInt);

				if ( $thisSavingStartDate_d < 28 )
				{
					$deriveSavingDateInt = strtotime( date(
						'Y-m-'.str_pad($thisSavingStartDate_d, 2, '0', STR_PAD_LEFT),
						strtotime( $nextMonthFirstDate )
					) );
				}
				else
				{
					if ( $thisSavingStartDate_d == $thisSavingStartDate_m_last_d )
					{
						$deriveSavingDateInt = strtotime( date(
							'Y-m-t',
							strtotime( $nextMonthFirstDate )
						) );
					}
					else if ( $thisSavingStartDate_d > $nextMonthFirstDate_m_last_d )
					{
						$deriveSavingDateInt = strtotime( date(
							'Y-m-t',
							strtotime( $nextMonthFirstDate )
						) );
					}
					else
					{
						$deriveSavingDateInt = strtotime( date(
							'Y-m-'.str_pad($thisSavingStartDate_d, 2, '0', STR_PAD_LEFT),
							strtotime( $nextMonthFirstDate )
						) );
					}
				}
			}
			else if ( $saving['period'] == 2 )
			{
				$nextQuarterMonthFirstDate = calculate_month( $thisSavingStartDate, ($turn*3+1) );
				$nextQuarterMonthFirstDateInt = strtotime($nextQuarterMonthFirstDate);

				$nextQuarterMonthFirstDate_m = date('m', $nextQuarterMonthFirstDateInt);
				$nextQuarterMonthFirstDate_m_last_d = date('t', $nextQuarterMonthFirstDateInt);

				if ( $thisSavingStartDate_d < 28 )
				{
					$deriveSavingDateInt = strtotime( date(
						'Y-m-'.str_pad($thisSavingStartDate_d, 2, '0', STR_PAD_LEFT),
						strtotime( $nextQuarterMonthFirstDate )
					) );
				}
				else
				{
					if ( $thisSavingStartDate_d == $thisSavingStartDate_m_last_d )
					{
						$deriveSavingDateInt = strtotime( date(
							'Y-m-t',
							strtotime( $nextQuarterMonthFirstDate )
						) );
					}
					else if ( $thisSavingStartDate_d > $nextQuarterMonthFirstDate_m_last_d )
					{
						$deriveSavingDateInt = strtotime( date(
							'Y-m-t',
							strtotime( $nextQuarterMonthFirstDate )
						) );
					}
					else
					{
						$deriveSavingDateInt = strtotime( date(
							'Y-m-'.str_pad($thisSavingStartDate_d, 2, '0', STR_PAD_LEFT),
							strtotime( $nextQuarterMonthFirstDate )
						) );
					}
				}
			}
			else if ( $saving['period'] == 3 )
			{
				$nextYearMonthFirstDate = calculate_month( $thisSavingStartDate, ($turn*12+1) );
				$nextYearMonthFirstDateInt = strtotime($nextYearMonthFirstDate);

				$nextYearMonthFirstDate_m = date('m', $nextYearMonthFirstDateInt);
				$nextYearMonthFirstDate_m_last_d = date('t', $nextYearMonthFirstDateInt);

				if ( $thisSavingStartDate_d < 28 )
				{
					$deriveSavingDateInt = strtotime( date(
						'Y-m-'.str_pad($thisSavingStartDate_d, 2, '0', STR_PAD_LEFT),
						strtotime( $nextYearMonthFirstDate )
					) );
				}
				else
				{
					if ( $thisSavingStartDate_d == $thisSavingStartDate_m_last_d )
					{
						$deriveSavingDateInt = strtotime( date(
							'Y-m-t',
							strtotime( $nextYearMonthFirstDate )
						) );
					}
					else if ( $thisSavingStartDate_d > $nextYearMonthFirstDate_m_last_d )
					{
						$deriveSavingDateInt = strtotime( date(
							'Y-m-t',
							strtotime( $nextYearMonthFirstDate )
						) );
					}
					else
					{
						$deriveSavingDateInt = strtotime( date(
							'Y-m-'.str_pad($thisSavingStartDate_d, 2, '0', STR_PAD_LEFT),
							strtotime( $nextYearMonthFirstDate )
						) );
					}
				}
			}

			if ( $deriveSavingDateInt > $lastDateInt )
			{
				break;
			}
			if ( $thisSavingEndDate != '0000-00-00' &&
				 $deriveSavingDateInt >= $thisSavingEndDateInt )
			{
				break;
			}
			$turn += 1;

			if ( $deriveSavingDateInt < $selfFirstDateInt )
			{
				continue;
			}

			$deriveSavingDate = date('Y-m-d', $deriveSavingDateInt);
			if ( in_array($deriveSavingDate, $thisSavingPassDates) )
			{
				continue;
			}
			$savings_items[] = array(
				'sid' 	=> $saving['saving_id'],
				'aid' 	=> $saving['account_id'],
				'type'	=> $saving['saving_type'],
				'startDate' => $thisSavingStartDate,
				'date'	=> $deriveSavingDate,
				'dateInt'	=> $deriveSavingDateInt,
				'money'	=> floatval($saving['money']),
				'period'	=> intval($saving['period'])
			);
			$deriveSavingDates[] = $deriveSavingDate;
		}

		// For next while(1) try
		if ( count($deriveSavingDates) > 0 )
		{
			$savings_list[$i]['start_date'] = $deriveSavingDates[ count($deriveSavingDates) - 1 ];
		}

	}

	$datesInts = array();
	/* Sort saving items by date */
	foreach ( $savings_items as $key => $row )
	{
	    $datesInts[$key]  = $row['dateInt'];
	}
	if ( count( $datesInts ) > 0 )
	{
		array_multisort($datesInts, SORT_ASC, $savings_items);
	}

	$savings_items_by_date = array();
	foreach ( $savings_items as $key => $item )
	{
	    if ( $item['type'] == 0 )
	    {
	    	$current_balance -= $item['money'];
	    }
	    else if ( $item['type'] == 1 )
	    {
	    	$current_balance += $item['money'];
	    }
	    $savings_items[$key]['balance'] = $current_balance;

	    if ( !isset( $savings_items_by_date[ $savings_items[$key]['date'] ] ) )
	    {
	    	$savings_items_by_date[ $savings_items[$key]['date'] ] = array();
	    }
	    $savings_items_by_date[ $savings_items[$key]['date'] ][] = $savings_items[$key];
	}

	$doneFlage = false;
	// $doneDate = '';
	foreach ( $savings_items_by_date as $date => $items )
	{
		$dateLastItemBalance = $items[ count($items) - 1 ]['balance'];
		if ( $data['money'] <= 0 &&
	    	 $data['money'] <= $initial_balance )
	    {
	    	if ( $dateLastItemBalance > $data['money'] )
	    	{
	    		continue;
	    	}
	    	else
	    	{
	    		$doneFlage = true;
	    	}
	    }
		else if ( $data['money'] <= 0 &&
	    	 $dateLastItemBalance <= $data['money'] )
	    {
	    	$doneFlage = true;
	    }
	    else if ( $data['money'] >= 0 &&
	    		  $data['money'] <= $initial_balance )
	    {
	    	if ( $dateLastItemBalance > $data['money'] )
	    	{
	    		continue;
	    	}
	    	else
	    	{
	    		$doneFlage = true;
	    	}
	    }
	    else if ( $data['money'] >= 0 &&
	   			  $dateLastItemBalance >= $data['money'] )
	    {
	    	$doneFlage = true;
	    }


	    if ( $doneFlage )
	    {
	    	// $doneDate = $item['date'];
	    	$res['status'] = true;
	    	$res['date'] = str_replace('-', '/', $date);
	    	$res['target'] = $data['money'];
	    	$res['ib'] = $initial_balance;
	    	$res['dlib'] = $dateLastItemBalance;
	    	$res['history'] = $history;
	    	$res['item'] = $items[ count($items) - 1 ];
	    	$res['items'] = $savings_items_by_date;
	    	// $res['items'] = $savings_list;
	    	// $res['items'] = $items;
	    	break;
	    }
	}

	if ( $doneFlage )
	{
		break;
	}

	$try += 1;
}

echo json_encode( $res );
?>