<?php
if ( 0 )
{
	ini_set('display_errors',1);
	error_reporting(E_ALL);
}

$uid = $_SESSION['userid'];


/* Post-Redirect-Session, avoid refresh ask re-post */
if ( isset($_POST) && count($_POST) )
{
	$_SESSION['post'] = $_POST;
	ob_end_clean();
    header("Location: http://" .  $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}
else
{
	$_POST = $_SESSION['post'];
	unset($_SESSION['post']);
}


/* Indices */
$durings = array( '前三年','前兩年','前一年', '前半年' );
$durings_month_unit = array( 36, 24 ,12, 6 );
// $durings = array( '前一年', '前半年' );
// $durings_month_unit = array( 12, 6 );
$intervals = array( '每月', '每季', '每年' );
$intervals_month_unit = array( 1, 3, 'x' ); // 'x' for only osne column
//$intervals_columns = array( 12, 4, 1 ) ;


/* Selected During */
$selectedDuring = 2; // Default value
if( isset($_POST['selectedDuring']) && in_array( intval( $_POST['selectedDuring']), array( 0, 1, 2, 3 ) ) )
{
	$selectedDuring = intval($_POST['selectedDuring']);
}

/* View interval */
$selectedInterval = 0; // Default value
if( isset($_POST['interval']) && in_array( intval( $_POST['interval']), array( 0, 1, 2 ) ) )
{
	$selectedInterval = intval($_POST['interval']);
}

/* selfLastDate */
$selfLastDate = date('Y-m-t');
if( isset($_POST['selfLastDate']) && preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $_POST['selfLastDate']) )
{
	$selfLastDate = date('Y-m-t', strtotime($_POST['selfLastDate']));
}

/* Interval columns */
$intervals_columns = 0;
if ( $selectedInterval == 2 )
{
	$intervals_columns = 1;
}
else
{
	$intervals_columns = $durings_month_unit[ $selectedDuring ] / $intervals_month_unit[ $selectedInterval ];
}



/* First month and Last month */
if ( in_array( $selectedInterval, array( 0, 2 ) ) )
{
	// For interval is month or year
	$first_month_date = calculate_month( $selfLastDate, -$durings_month_unit[$selectedDuring] );
	$first_month = date('Y-m', strtotime( $first_month_date ) );

	$last_month_date = $selfLastDate;
	$last_month = date('Y-m', strtotime($last_month_date));
}
else
{
	$current_month = date('m', strtotime($selfLastDate));
	if ( in_array( intval($current_month), array(1, 2, 3) ) )
	{
		$last_month_date = date('Y-03-31', strtotime($selfLastDate));
	}
	elseif ( in_array( intval($current_month), array(4, 5, 6) ) )
	{
		$last_month_date = date('Y-06-30', strtotime($selfLastDate));
	}
	elseif ( in_array( intval($current_month), array(7, 8, 9) ) )
	{
		$last_month_date = date('Y-09-30', strtotime($selfLastDate));
	}
	else
	{
		$last_month_date = date('Y-12-31', strtotime($selfLastDate));
	}

	$first_month_date = calculate_month( $last_month_date, -$durings_month_unit[$selectedDuring] );
	$first_month = date('Y-m', strtotime( $first_month_date ) );

}


/* Months  */
$months_last_dates = array();
if ( $selectedInterval == 0 ) // For interval is month or year
{
	// For interval is month or year
	for ( $i = $intervals_month_unit[$selectedInterval] ; $i < $durings_month_unit[$selectedDuring]+1 ; $i += $intervals_month_unit[$selectedInterval] )
	{
		$months_last_dates[] = strtotime( calculate_month( $last_month_date, -$i ) );
	}
	$months_last_dates = array_reverse($months_last_dates);
}
elseif ( $selectedInterval == 1 )
{
	// For interval is season
	for ( $i = 0 ; $i < $durings_month_unit[$selectedDuring] ; $i += $intervals_month_unit[$selectedInterval] )
	{
		if ( $i == 0 )
		{
			$months_last_dates[] = strtotime( calculate_month( $last_month_date, -$i ) );
		}
		else
		{
			$months_last_dates[] = strtotime( calculate_month( $last_month_date, -($i+1) ) );
		}
	}
	$months_last_dates = array_reverse($months_last_dates);
}
elseif ( $selectedInterval == 2 )
{
	$months_last_dates[] = strtotime( $selfLastDate );
}


try
{
	/* Get accounts data of the user */
	$query_string = 'SELECT  `account_type`, `account_id`, `account_name` FROM `accounts` WHERE `user_id`=? ORDER BY `account_type`, `created`';
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid ) );
	$all_accounts = $query->fetchAll( PDO::FETCH_GROUP | PDO::FETCH_ASSOC );


	/* Get monthly accounts data of the user */
	$query_string = 'SELECT `account_type`, `account_id`, `account_balance`, `updated_date` FROM `accounts_monthly` WHERE `user_id`=? AND ( `updated_date` BETWEEN ? AND ? ) ORDER BY `account_id`,`updated_date`';
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid, $first_month_date, $last_month_date ) );
	$all_accounts_monthly = $query->fetchAll( PDO::FETCH_GROUP | PDO::FETCH_ASSOC );
}
catch (PDOException $e)
{
	echo $e->getMessage();
	exit();
}


/* Merge $all_accounts and $all_accounts_monthly data structure */
foreach ( $all_accounts as $t => $as )
{
	$all_accounts[ $t ] = array();
	foreach ( $as as $i => $a )
	{
		$all_accounts[$t][ $a['account_id'] ] = array(
			'aname' => $a['account_name'],
			'balances' => array_fill( 0, $intervals_columns, '--' )
		);
	}
}

$p_subtotal_monthly = array_fill( 0, $intervals_columns, 0 );
$n_subtotal_monthly = array_fill( 0, $intervals_columns, 0 );
$sum_monthly = array_fill( 0, $intervals_columns, 0 );

foreach ( $all_accounts_monthly as $t => $as ) // account types loop
{
	foreach ( $as as $a ) // account loop
	{
		foreach ( $months_last_dates as $i => $date ) // columns loop
		{
			$adate = strtotime( $a['updated_date'] );
			if ( $selectedInterval == 0 )
			{
				if ( $i < $intervals_columns - 1 && $date <= $adate && $adate < $months_last_dates[ $i+1 ] )
				{
					$all_accounts[ $t ][ $a['account_id'] ]['balances'][ $i ] = floatval($a['account_balance']);
					if ( in_array( $t, array(0, 2, 3) ) )
					{
						$sum_monthly[$i] += floatval($a['account_balance']);
						$p_subtotal_monthly[$i] += floatval($a['account_balance']);
					}
					else
					{
						$sum_monthly[$i] -= floatval($a['account_balance']);
						$n_subtotal_monthly[$i] += floatval($a['account_balance']);
					}
					break;
				}
				elseif ( $i == $intervals_columns - 1 && $date <= $adate )
				{
					$all_accounts[ $t ][ $a['account_id'] ]['balances'][ $i ] = floatval($a['account_balance']);
					if ( in_array( $t, array(0, 2, 3) ) )
					{
						$sum_monthly[$i] += floatval($a['account_balance']);
						$p_subtotal_monthly[$i] += floatval($a['account_balance']);
					}
					else
					{
						$sum_monthly[$i] -= floatval($a['account_balance']);
						$n_subtotal_monthly[$i] += floatval($a['account_balance']);
					}
					break;
				}
			}
			elseif ( $selectedInterval == 1 || $selectedInterval == 2 )
			{
				$date = strtotime( date('Y-m-t', $date) );
				if ( $adate <= $date )
				{
					$all_accounts[ $t ][ $a['account_id'] ]['balances'][ $i ] += floatval($a['account_balance']);
					if ( in_array( $t, array(0, 2, 3) ) )
					{
						$sum_monthly[$i] += floatval($a['account_balance']);
						$p_subtotal_monthly[$i] += floatval($a['account_balance']);
					}
					else
					{
						$sum_monthly[$i] -= floatval($a['account_balance']);
						$n_subtotal_monthly[$i] += floatval($a['account_balance']);
					}
					break;
				}
			}
		}
	}
}


?>


<?php include_once('statics_view.php'); ?>