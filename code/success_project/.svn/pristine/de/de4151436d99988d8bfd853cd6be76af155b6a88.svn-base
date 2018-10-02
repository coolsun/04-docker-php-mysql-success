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
elseif ( isset($_SESSION['post']) )
{
	$_POST = $_SESSION['post'];
	unset($_SESSION['post']);
}


function encode_ch(&$value, $key)
{
	if( is_string($value) )
	{
		$value = urlencode($value);
	}
}


/* Indices */
$saving_types = array('支出', '收入');
$durings = array( '未來30天', '未來60天', '未來90天', '未來一年', '未來兩年' );
$durings_units = array( 30, 60, 90, 365, 730 );
$periods = array( '每週', '每月', '每季', '每年' );
$periods_units = array( 7, 30, 90, 365);
// $periods_units = array( 'week', 'month', 'quarter', 'year');

/* Selected During */
$selectedDuring = 3; // Default value
if( isset($_POST['selectedDuring']) && in_array( intval( $_POST['selectedDuring']), array( 0, 1, 2, 3, 4 ) ) )
{
  $selectedDuring = intval($_POST['selectedDuring']);
}
else if( isset($_SESSION['selectedDuring']) && in_array( intval( $_SESSION['selectedDuring']), array( 0, 1, 2, 3, 4 ) ) )
{
  $selectedDuring = intval($_SESSION['selectedDuring']);
}

$_SESSION['selectedDuring'] = $selectedDuring;

//echo $selectedDuring.' : ';

/* selfFirstDate */
$selfFirstDate = date('Y-m-d');
if( isset($_POST['selfFirstDate']) && preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $_POST['selfFirstDate']) )
{
	$selfFirstDate = date('Y-m-d', strtotime($_POST['selfFirstDate']));
}
$selfFirstDateInt = strtotime($selfFirstDate);

/* Get all accounts id */
try
{
	/* Get accounts data of the user */
	$query_string = 'SELECT  `account_type`, `account_id`, `account_name`, `account_balance` as `balance` FROM `accounts` WHERE `user_id`=? AND `account_type`=0 ORDER BY `account_type`, `created`';
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid ) );
	$all_accounts = $query->fetchAll( PDO::FETCH_GROUP | PDO::FETCH_ASSOC );
	if ( !$all_accounts )
	{
		echo "請先至帳戶管理新增帳戶";
		exit();
	}
}
catch (PDOException $e)
{
	echo $e->getMessage();
	exit();
}


/* Check selected account id */
$in_accounts_flag = false;

if (isset($_SESSION['saving_selected_atype']) && isset($_SESSION['saving_selected_aid']))
{
  $selected_atype = $_SESSION['saving_selected_atype'];
  $selected_aid = $_SESSION['saving_selected_aid'];
}

if ( isset($_POST['account']) && preg_match('/^(\d)+-(\d+)$/', $_POST['account'], $match) ) // check post account is in account list
{
	$selected_atype = $match[1];
	$selected_aid   = $match[2];

}

if (isset($selected_aid))
{
  foreach ( $all_accounts[ $selected_atype ] as $i => $account )
  {
    if ( $account['account_id'] == $selected_aid )
    {
      $in_accounts_flag = true;
      $current_balance = $account['balance'];
      break;
    }
  }
}

if ( !$in_accounts_flag ) // if not use first account as default
{
	foreach ( $all_accounts as $atype => $accounts )
	{
		foreach ( $accounts as $i => $account ) {
			$selected_atype = $atype;
			$selected_aid   = $account['account_id'];
			$current_balance = $account['balance'];
			$in_accounts_flag = true;
			break;
		}
		break;
	}
}

$_SESSION['saving_selected_atype'] = $selected_atype;
$_SESSION['saving_selected_aid'] = $selected_aid;

$accounts_names = array();
foreach ( $all_accounts as $atype => $accounts )
{
	foreach ( $accounts as $i => $account )
	{
		$accounts_names[ $account['account_id'] ] = $account['account_name'];
	}
}

/* Get savings list */
$savings_list = array();
try
{
	$lastDate = date('Y-m-d', strtotime($selfFirstDate.' +'.$durings_units[ $selectedDuring ].' day'));
	$lastDateInt = strtotime($lastDate);
	$query_string = 'SELECT * FROM `savings` WHERE `user_id`=? AND `account_id`=? AND (`end_date`="0000-00-00" OR `end_date`>=?) ORDER BY `start_date`, `created` DESC';
	$query = $dbh->prepare( $query_string );
	$query->execute( array($uid, $selected_aid, $selfFirstDate) );
	$savings_list = $query->fetchAll( PDO::FETCH_ASSOC );

	// echo $selfFirstDate.' -> '.$lastDate;
}
catch (PDOException $e)
{
	echo $e->getMessage();
	exit();
}

/* Generate saving items */
$savings_items = array();
foreach ( $savings_list as $saving )
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

	$thisSavingStartDate_m_last_d = date('t', $thisSavingStartDateInt);

	if ( $selfFirstDateInt <= $thisSavingStartDateInt &&
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
			'aname'	=> $accounts_names[ $saving['account_id'] ],
			'sname' => $saving['source_name'],
			'iname'	=> $saving['item_name'],
			'money'	=> $saving['money'],
			'period'	=> $saving['period']
		);
	}

	$turn = 1;
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

		// $deriveSavingDateInt = strtotime($thisSavingStartDate.' +'.( $turn*$thisSavingPeriodUnit ).'day');
		// $deriveSavingDateInt = strtotime($thisSavingStartDate.' +'.$turn.' '.$thisSavingPeriodUnit );
		if ( $deriveSavingDateInt > $lastDateInt )
		{
			break;
		}
		if ( $thisSavingEndDate != '0000-00-00' && $deriveSavingDateInt >= $thisSavingEndDateInt )
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
			'date'	=> $deriveSavingDate,
			'dateInt'	=> $deriveSavingDateInt,
			'aname'	=> $accounts_names[ $saving['account_id'] ],
			'sname' => $saving['source_name'],
			'iname'	=> $saving['item_name'],
			'money'	=> $saving['money'],
			'period'	=> $saving['period']
		);
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
foreach ( $savings_items as $key => $item )
{
    if ( $item['type'] == 0 )
    {
    	$current_balance -= $item['money'];
    }
    else
    {
    	$current_balance += $item['money'];
    }
    $savings_items[$key]['balance'] = $current_balance;
}

?>

<?php include_once('strategies_view.php'); ?>

<!-- <button id="new">New</button>
<button id="update">Update</button> -->

<script type="text/javascript">
$(function(){
	$('#new').on('click', function(){
		var json_str = JSON.stringify({
			"aid": 144,
			"date": "2016/03/01",
			"type": 0,
			"money": 2000,
			"sname": "XXX3+",
			"iname": "OOO+",
			"period": 0
		});
		$.ajax({
			url: 'finance/saving/saving_functions/strategies/new.php',
			data: { "data": json_str },
			type: 'post',
			dataType: "json",
			success: function(res) {
				console.log(data);
			},
			error: function() {
				console.log('error');
			}
		});
	});

	$('#update').on('click', function(){
		var json_str = JSON.stringify({
			"aid": 144,
			"sid": 3,
			"date": "2015/09/22",
			"originDate": "2015/09/22",
			"type": 1,
			"money": 1000,
			"sname": "XXX3ex",
			"iname": "OOO",
			"period": 0,
			"utype": 0
		});
		$.ajax({
			url: 'finance/saving/saving_functions/strategies/update.php',
			data: { "data": json_str },
			type: 'post',
			dataType: "json",
			success: function(res) {
				console.log(data);
			},
			error: function() {
				console.log('error');
			}
		});
	});
});
</script>
