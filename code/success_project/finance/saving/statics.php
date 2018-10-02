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

/* selfFirstDate */
$selfFirstDate = date('Y-m-d');
if( isset($_POST['selfFirstDate']) && preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $_POST['selfFirstDate']) )
{
	$selfFirstDate = date('Y-m-d', strtotime($_POST['selfFirstDate']));
}
$selfFirstDateInt = strtotime($selfFirstDate);

/* selfLastDate */
$selfLastDate = date('Y-m-d');
$selfLastDate = date('Y-m-d', strtotime($selfFirstDate.' +'.$durings_units[$selectedDuring].' day'));
if( isset($_POST['selfLastDate']) && preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $_POST['selfLastDate']) )
{
	$selfLastDate = date('Y-m-d', strtotime($_POST['selfLastDate']));
}
// $selfLastDateInt = strtotime($selfLastDate);


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

$account_balance = $current_balance;

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
	$lastDate = $selfLastDate;
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

// echo json_encode($savings_items);

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
    else
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
date_default_timezone_set('UTC');

$today = date('Y-m-d');
$plusDay = -1;
$tempDate = '';
$preDate = '';
$chartData = array();
while (1) {
	$plusDay += 1;
	// echo $plusDay."...";

	$tempDateInt = strtotime($selfFirstDate. ' +'.$plusDay. ' day');
	$tempDate = date('Y-m-d', $tempDateInt);

	// echo $tempDate."(".$preDate.")<br>";

	if ( !isset($savings_items_by_date[$tempDate]) && isset($savings_items_by_date[$preDate]) )
	{
		$chartData[] = array(
			'x'	=> ($tempDateInt * 1000),
			'y'	=> floatval($savings_items_by_date[$preDate][ count($savings_items_by_date[$preDate]) - 1 ]['balance']),
			'marker' => array(
	            'radius' => 0,
	            'states' => array(
					'hover' => array(
						'enabled' => false
					)
				)
			)
		);
		// echo $tempDate."<br>";
	}
	else if ( isset($savings_items_by_date[$tempDate]) )
	{
		$chartData[] = array(
			'x'	=> ($tempDateInt * 1000),
			'y'	=> floatval($savings_items_by_date[$tempDate][ count($savings_items_by_date[$tempDate]) - 1 ]['balance'])
		);
		$preDate = $tempDate;
		// echo $tempDate."<br>";
	}
	else if ( $tempDate == $today || $preDate == $today )
	{
		// For today not in derivatives
		$chartData[] = array(
			'x'	=> ($tempDateInt * 1000),
			'y'	=> floatval($account_balance),
			'marker' => array(
	            'radius' => 0,
	            'states' => array(
					'hover' => array(
						'enabled' => false
					)
				)
			),
		);
		$preDate = $today;
	}

	if ( $tempDate == $selfLastDate )
	{
		break;
	}
}

// $chartData = array();
// foreach ( $savings_items_by_date as $date => $items )
// {
// 	$chartData[] = array(
// 		'x'	=> (strtotime($date) * 1000),
// 		'y'	=> floatval($items[ count($items) - 1 ]['balance'])
// 	);
// }
// if ( !isset($savings_items_by_date[$selfFirstDate]) )
// {
// 	array_unshift($chartData, array(
// 		'x'	=> (strtotime($selfFirstDate) * 1000),
// 		'y'	=> floatval($account_balance),
// 		'marker' => array(
//             'radius' => 0,
//             'states' => array(
// 				'hover' => array(
// 					'enabled' => false
// 				)
// 			)
// 		),
// 	));
// }
?>

<pre>
<?php //print_r($savings_items_by_date); ?>
</pre>

<style type="text/css">
.tar {
	text-align: right;
}
/*.paddingtb4 {
	padding-top: 4px;
	padding-bottom: 4px;
}*/
.paddinglr6 {
	padding-left: 6px;
	padding-right: 6px;
}
.tooltip-table {
	min-width: 400px;
}
.tooltip-table th, .tooltip-table td {
	padding-top: 4px;
	padding-bottom: 4px;
	padding-left: 6px;
	padding-right: 6px;
	text-align: center;
}
.tooltip-table th {
	background-color: #E5E5E5;
	border: 1px solid  #c7c7c7;
	box-shadow: -1px 1px 0 #ffffff inset;
}
.tooltip-table td {
	border: 1px solid  #c7c7c7;
	border-top: none;
}
</style>

<script src="js/charts/highstock.js"></script>
<script src="js/charts/accounting.min.js"></script>

<!-- <button id="compute">Compute</button> -->

<script type="text/javascript">
$(function()
{
	var saving_types = <?=json_encode($saving_types)?>;
	var savings_items_by_date = <?=json_encode($savings_items_by_date)?>;
	var chart = $('#chart').highcharts({
        chart: {
            height: 300,
        },
        credits: {
            enabled: false
        },
        title: {
            text: '',
        },
        legend: {
            enabled: false,
        },
        colors: [
        	'#BE0200'
        ],
        tooltip: {
        	backgroundColor: '#ffffff',
        	borderColor: '#666666',
        	// snap: 50,
            formatter: function() {
            	var d = new Date(this.x);
            	var year = d.getFullYear();
            	var month = "0"+(d.getMonth()+1);
            	month = month.substr(month.length-2);
            	var date = "0"+d.getDate();
            	date = date.substr(date.length-2);
            	var thisDate = [year, month, date].join('-');
            	// console.log(thisDate);
            	// console.log(Object.keys(savings_items_by_date).indexOf(thisDate));
            	if ( Object.keys(savings_items_by_date).indexOf(thisDate) < 0 )
            	{
            		return false;
            	}

            	var itemHTML = [];
            	// console.log(savings_items_by_date[thisDate]);
            	for ( var key in savings_items_by_date[thisDate] )
            	{
            		var item = savings_items_by_date[thisDate][key];

            		itemHTML = itemHTML.concat([
            			'<tr>',
	            			'<td>',
	            				saving_types[ parseInt( item['type'] ) ],
	            			'</td>',
	            			'<td>',
	            				item['date'].replace(/-/g, '/'),
	            			'</td>',
	            			'<td>',
	            				item['sname'],
	            			'</td>',
	            			'<td>',
	            				(( parseInt( item['type'] ) == 0 ) ? '-' : '' ),
	            				item['money']+'',
	            			'</td>',
	            		'</tr>',
            		]);
            	}

            	var tooltipHTML = [
            		'<h3 class="paddinglr6" style="padding-bottom:6px;">',
            			this.series.name,
            		'</h3>',
            		'<table class="tooltip-table">',
            		'<thead>',
            		'<tr>',
            			'<th>種類</th>',
            			'<th>日期</th>',
            			'<th>收款/放款人</th>',
            			'<th>金額</th>',
            		'</tr>',
            		'</thead>',
            		'<tbody>'
            	];

            	tooltipHTML = tooltipHTML.concat(itemHTML);

            	tooltipHTML = tooltipHTML.concat([
            		'</tbody>',
            		'</table>',
            		'<div class="tar paddinglr6" style="padding-top:6px;">帳戶餘額 ',
            			accounting.formatMoney(this.y),
            		'</div>'
            	]);

            	tooltipHTML = tooltipHTML.join('');

            	return tooltipHTML;
            },
            useHTML: true
        },
        xAxis: {
        	min: <?=(strtotime($selfFirstDate) * 1000)?>,
            type: 'datetime',
            dateTimeLabelFormats: {
                day: '%m/%e',
                week: '%m/%e',
                month: '%m/%e',
				year: '%m/%e',
            },
            tickPosition: 'inside',
        },
        yAxis: {
            lineWidth: 1,
            title: {
                    text: '(單位:千元)',
                    rotation: 0,
                    align: 'high'
            },
            labels: {
                formatter: function() {
                    var maxElement = this.axis.max;
                    var minElement = this.axis.min;
                    if (maxElement >= 1000 || minElement <= -1000) {
                        return (this.value / 1000.0) + " K";
                    }
                    else {
                        return this.value;
                    }
                }
            },
            // startOnTick: false,
            tickWidth: 1,
            tickPosition: 'inside',
        },
        plotOptions: {
            series: {
                marker: {
                    radius: 3
                },
                 // stickyTracking: false
            },
            line: {
                lineWidth: 1
            }
		},
        series: [{
        	name: '<?=$accounts_names[$selected_aid]?>',
            data: <?=json_encode($chartData)?>,
            pointStart: <?=(strtotime($selfFirstDate) * 1000)?>,
            pointInterval: 24 * 3600 * 1000 // one day
        }]
    });

	// $('#compute').on('click', function()
	// {
	// 	var params = {
	// 		'aid' : 144,
	// 		'atype' : 0,
	// 		'money' : 79500
	// 	};
	// 	var json = JSON.stringify(params);

	// 	$.ajax({
	// 		url: 'finance/saving/saving_functions/statics/compute.php',
	// 		type: "POST",
	// 		dataType: 'json',
	// 		data: { 'data' : json },
	//         error: function(xhr) {
	//         	console.log('AJAX Error');
	//         },
	//         success: function(res) {
	//         	console.log( res );
	//         }
	// 	});
	// });
});
</script>

<?php include_once('statics_view.php'); ?>
