<?php // modify file ?>
<?php
/* Get invest accounts id */
try
{
	/* Get invest accounts data of the user */
	$query_string = 'SELECT  `account_type`, `account_id`, `account_name`, `account_balance` FROM `accounts` WHERE `user_id`=? AND `account_type` = 2 ORDER BY `account_type`, `created`';
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid ) );
  $all_accounts = $query->fetchAll( PDO::FETCH_ASSOC );
	// $all_accounts = $query->fetchAll( PDO::FETCH_GROUP | PDO::FETCH_ASSOC );
	if ( !$all_accounts )
	{
		echo "請先至帳戶管理新增投資帳戶";
		exit();
	}
}
catch (PDOException $e)
{
	echo $e->getMessage();
	exit();
}

$selected_account = null;
$in_accounts_flag = false;

if (isset($_SESSION['invest_selected_aid']))
{
  $selected_aid =  $_SESSION['invest_selected_aid'];
}

if ( isset($_POST['account']) )
{
	$selected_aid = $_POST['account'];
}

if(isset($selected_aid))
{
   // check post account is in account list
  foreach ( $all_accounts as $i => $account )
  {
    if ( $account['account_id'] == $selected_aid )
    {
      $in_accounts_flag = true;
      $selected_account = $account;
      break;
    }
  }
}

if ( !$in_accounts_flag && count($all_accounts) > 0 )
{
  $selected_aid = $all_accounts[0]["account_id"];
  $selected_account = $all_accounts[0];
}

$_SESSION['invest_selected_aid'] = $selected_aid;

try {
  $query_string = "SELECT `name`, `id`, `action`, `quantity`, `price`, `fee`  FROM `invests` WHERE `user_id` = ? AND `account_id` = ? ORDER BY `price`";
  $query = $dbh->prepare($query_string);
  $query->execute(array($uid, $selected_aid));
  $existInvests = $query->fetchAll( PDO::FETCH_GROUP | PDO::FETCH_ASSOC ); // group by name

  $query_string = "SELECT `invest_name`, `price` FROM `marketcaps` WHERE `user_id` = ? AND `account_id` = ?";
  $query = $dbh->prepare($query_string);
  $query->execute(array($uid, $selected_aid));
  $marketcaps = $query->fetchAll( PDO::FETCH_GROUP | PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC );
}
catch (PDOException $e)
{
	echo $e->getMessage();
	exit();
}

$lastInvests = array();
foreach ($existInvests as $name => $invests) {
  $buyInvests = array();
  $sellInvests = array();
  foreach ($invests as $invest) {
    if ($invest['action'] == 0) {
      $buyInvests[] = $invest;
    } else if ($invest['action'] == 1) {
      $sellInvests[] = $invest;
    }
  }

  foreach ($sellInvests as $sellInvest) {
    $sellQuantity = $sellInvest['quantity'];
    foreach ($buyInvests as $i => $buyInvest) {
      $buyQuantity = $buyInvest['quantity'];
      if ($sellQuantity <= $buyQuantity) {
        $buyInvests[$i]['quantity'] -= $sellQuantity;
        break;
      } else if ($sellQuantity > $buyQuantity) {
        $sellQuantity -= $buyQuantity;
        unset($buyInvests[$i]);
      }
    }
  }

  $tempInvest = array(
    'name' => $name,
    'marketcap' => 0.0,
    'quantity' => 0,
    'total_value' => 0.0,
    'cost' => 0.0,
    'net_profit' => 0.0,
    'percent' => '0%',
  );
  foreach ($buyInvests as $invest) {
    $tempInvest['quantity'] += $invest['quantity'];
    $tempInvest['cost'] += ($invest['quantity'] * $invest['price']) + $invest['fee'];
  }
  if ($tempInvest['quantity'] > 0 ) {
    if (isset($marketcaps[$name])) {
      $tempInvest['marketcap'] = $marketcaps[$name]['price'];
      $tempInvest['total_value'] = $tempInvest['quantity'] * $tempInvest['marketcap'];
      $tempInvest['net_profit'] = $tempInvest['total_value'] - $tempInvest['cost'];
      $tempInvest['percent'] = sprintf("%.2f", ($tempInvest['net_profit'] / $tempInvest['cost']) * 100) .'%' ;
    }
    $lastInvests[] = $tempInvest;
  }
}
?>

<?php include('marketcap_view.php'); ?>
