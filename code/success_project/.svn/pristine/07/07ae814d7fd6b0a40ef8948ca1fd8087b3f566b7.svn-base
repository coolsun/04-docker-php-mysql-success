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

/* Test data */
//$_POST['selectedDuring'] = 1;
//$_POST['selectedBillType'] = 0;
//$_POST['selfLastDate'] = '2014/08/30';


/* Indices */
$bill_types = array(
	0 => array( 0 => '支出', 1 => '收入'),
	1 => array( 0 => '刷卡', 1 => '繳款' ),
	3 => array( 0 => '減少', 1 => '增加' ),
	4 => array( 0 => '增加', 1 => '減少' ),
);
$durings = array( '前30天', '前60天', '前半年', '前一年' );
$durings_units = array( 30, 60, 183, 366);


/* Get all accounts id */
try
{
	/* Get accounts data of the user */
	$query_string = 'SELECT  `account_type`, `account_id`, `account_name` FROM `accounts` WHERE `user_id`=? AND `account_type` <> 2 ORDER BY `account_type`, `created`';
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


if (isset($_SESSION['bills_selected_atype']) && isset($_SESSION['bills_selected_aid']))
{
  $selected_atype = $_SESSION['bills_selected_atype'];
  $selected_aid = $_SESSION['bills_selected_aid'];
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
			$in_accounts_flag = true;
			break;
		}
		break;
	}
}

$_SESSION['bills_selected_atype'] = $selected_atype;
$_SESSION['bills_selected_aid'] = $selected_aid;
//echo $selected_atype.' => '.$selected_aid.'<br/>';


/* Selected During */
$selectedDuring = 0; // Default value
if( isset($_POST['selectedDuring']) && in_array( intval( $_POST['selectedDuring']), array( 0, 1, 2, 3 ) ) )
{
	$selectedDuring = intval($_POST['selectedDuring']);
}
else if( isset($_SESSION['selectedDuring']) && in_array( intval( $_SESSION['selectedDuring']), array( 0, 1, 2, 3 ) ) )
{
  $selectedDuring = intval($_SESSION['selectedDuring']);
}

$_SESSION['selectedDuring'] = $selectedDuring;

//echo $selectedDuring.' : ';

/* selfLastDate */
$selfLastDate = date('Y-m-d');
if( isset($_POST['selfLastDate']) && preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $_POST['selfLastDate']) )
{
	$selfLastDate = date('Y-m-d', strtotime($_POST['selfLastDate']));
}

/* SelectedBillTyoe */
$selectedBillType= -1; // Default value

if( isset($_POST['selectedBillType']) && in_array( intval( $_POST['selectedBillType']), array( -1, 0, 1 ) ) )
{
	$selectedBillType = intval($_POST['selectedBillType']);
}
else if( isset($_SESSION['selectedBillType']) && in_array( intval( $_SESSION['selectedBillType']), array( -1, 0, 1 ) ) )
{
  $selectedBillType = intval($_SESSION['selectedBillType']);
}

$_SESSION['selectedBillType'] = $selectedBillType;

//echo $selectedBillType.'<br/>';


/* Get account monthly balance of the selfLastDate month */
try
{
	$year_month = date('Y-m', strtotime($selfLastDate));
	$t = date('t', strtotime($selfLastDate));
	$query_string = "SELECT `account_balance` FROM `accounts_monthly` WHERE `user_id`=? AND `account_id`=? AND (`updated_date` BETWEEN ? AND ?) LIMIT 1";
	$query = $dbh->prepare( $query_string );
	$query->execute( array($uid, $selected_aid, $year_month.'-01', $year_month.'-'.$t) );
	$month_balance = $query->fetchColumn();
}
catch(PDOException $e)
{
	echo $e->getMessage();
	exit();
}

//echo $month_balance.'<br/>';


/* Check if user bills class is exist , if not , create it */
try
{
	$query_string = "SELECT `version`, `time_unit`, `class` FROM `bills_class` WHERE `user_id` = ? LIMIT 1";
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid ) );
	$bills_class = $query->fetch( PDO::FETCH_ASSOC );

	//print_r($bills_class);

	if ( !$bills_class )
	{
		$bills_class_version = 0;
		$time_unit = 1;
		$default_bills_class_json = file_get_contents('bills_class.json', 1);
		$insert_query_string = "INSERT INTO `bills_class` (`user_id`, `time_unit`, `class`, `updated`, `created`) VALUES (?, ?, ?, ?, ?) ";
		$insert_query = $dbh->prepare( $insert_query_string );
		$datetime = date('Y-m-d H:i:s');
		$insert_query->execute( array($uid, $time_unit, $default_bills_class_json, $datetime, $datetime) );

		$bills_class =  json_decode( $default_bills_class_json, true );
		//$bills_class = $default_bills_class_json;
	}
	else
	{
		$bills_class_version = $bills_class['version'];
		$time_unit = $bills_class['time_unit'];
		$bills_class = json_decode( $bills_class['class'], true );
		//$bills_class = $bills_class['class'];
	}


	$temp_bills_class = array();
	foreach ( $bills_class as $btype_id => $btype ) {
		$temp = array();
		foreach ( $btype['subclass'] as $mid => $mclass ) {
			foreach ( $mclass['subclass'] as $sid => $sclass )
			{
				$temp_bills_class[  $btype_id ][ $mid.'-'.$sid ] = array( 'mn' => $mclass['name'], 'sn' => $sclass['name'] );
			}
		}
	}

	/*echo '<pre>';
	print_r($temp_bills_class);
	echo '</pre>';*/

	/*array_walk_recursive($temp_bills_class, function(&$value, $key) {
		if( is_string($value) )
		{
			$value = urlencode($value);
		}
	});*/

	array_walk_recursive($temp_bills_class, 'encode_ch');

	$bills_class_json = urldecode( json_encode($temp_bills_class) );

}
catch(PDOException $e)
{
	echo $e->getMessage();
	exit();
}


/* Get bills */
try
{
	//$get_query_string  = "SELECT `bill_id`, `bill_date`, `bill_type`, `main_class_id` AS `m`, `sub_class_id` AS `s`, `main_class_name` AS `mn`, `sub_class_name` AS `sn`, `payee`, `money`, `balance`, `description` ";
	$get_query_string  = "SELECT `bill_id`, `bill_date`, `bill_type`, `main_class_name` AS `mn`, `sub_class_name` AS `sn`, `payee`, `money`, `balance`, `description` ";
	$get_query_string .= "FROM `bills` WHERE `user_id`=? AND `account_id`=? ";
	$params = array($uid, $selected_aid);
	if ( $selectedBillType != -1 )
	{
		$get_query_string .= "AND `bill_type`=? ";
		$params[] = $selectedBillType;
	}
	$get_query_string .= "AND (`bill_date` BETWEEN ? AND ? ) ";
	$params[] = date('Y-m-d', strtotime($selfLastDate.' -'.$durings_units[ $selectedDuring ].' day'));
	//echo date('Y-m-d', strtotime($selfLastDate.' -'.$durings_units[ $selectedDuring ].' day'));
	//echo '>>'.$selfLastDate;
	$params[] = $selfLastDate;
	$get_query_string .= "ORDER BY `bill_date` DESC, `created` DESC";
	$get_query = $dbh->prepare( $get_query_string );
	$get_query->execute( $params );
	$bills_list = $get_query->fetchAll( PDO::FETCH_ASSOC );

	if ( !$bills_list )
	{
		$bills_list = array();
	}

	//print_r($bills_list);
}
catch(PDOException $e)
{
	echo $e->getMessage();
	exit();
}

?>

<script type="text/javascript">
	var bills_class = <?=$bills_class_json?>;
</script>

<?php include_once('records_view.php'); ?>