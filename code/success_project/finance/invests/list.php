<?php // modify file ?>
<?php
if ( 1 )
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

$action_options = array('買進', '賣出');
$durings = array( '前30天', '前60天', '前90天', '前半年', '前一年' );
$durings_units = array( 30, 60, 90, 188, 365 );


/* Get invest accounts id */
try
{
	/* Get invest accounts data of the user */
	$query_string = 'SELECT  `account_type`, `account_id`, `account_name`, `account_balance` FROM `accounts` WHERE `user_id`=? AND `account_type` = 2 ORDER BY `account_type`, `created`';
	$query = $dbh->prepare( $query_string );
	$query->execute( array( $uid ) );
  $all_accounts = $query->fetchAll( PDO::FETCH_ASSOC );
	// $all_accounts = $query->fetchAll( PDO::FETCH_GROUP | PDO::FETCH_ASSOC );
	/*
	if ( !$all_accounts )
	{
		echo "請先至帳戶管理新增投資帳戶";
		exit();
	}
   * */
}
catch (PDOException $e)
{
	echo $e->getMessage();
	exit();
}

if (0 == count($all_accounts))
{
  unset($_SESSION['invest_selected_aid']);
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

if(isset($selected_aid))
{
  $_SESSION['invest_selected_aid'] = $selected_aid;
}

/* Selected During */
$selectedDuring = 0; // Default value
if( isset($_POST['selectedDuring']) && in_array( intval( $_POST['selectedDuring']), array( 0, 1, 2, 3, 4 ) ) )
{
	$selectedDuring = intval($_POST['selectedDuring']);
}

/* selfLastDate */
$selfLastDate = date('Y-m-d');
if( isset($_POST['selfLastDate']) && preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $_POST['selfLastDate']) )
{
	$selfLastDate = date('Y-m-d', strtotime($_POST['selfLastDate']));
}

/* Get invests of selected account */
$invests_list = array();
if (isset($selected_aid))
{
  try
  {
    $query_string = "SELECT * FROM `invests` WHERE `user_id`=? AND `account_id`=? AND (`buytime` BETWEEN ? AND ?) ORDER BY `buytime` DESC, `created` DESC, `id` DESC";
    $query = $dbh->prepare( $query_string );
    $params = array();
    $params[] = $uid;
    $params[] = $selected_aid;
    $params[] = date("Y-m-d 00:00:00", strtotime($selfLastDate." -". $durings_units[$selectedDuring] ." days"));
    $params[] = $selfLastDate;
    $query->execute( $params );
    $invests_list = $query->fetchAll( PDO::FETCH_ASSOC );

    // $query_string = "SELECT `action`, `quantity`, `price`, `fee` FROM `invests` WHERE `buytime` < ?";
    // $query = $dbh->prepare( $query_string );
    // $query->execute( array(date("Y-m-d 00:00:00", strtotime($selfLastDate." -". $durings_units[$selectedDuring] ." days"))) );
    // $past_invests_list = $query->fetchAll( PDO::FETCH_ASSOC );
  }
  catch(PDOException $e)
  {
    echo $e->getMessage();
    exit();
  }

  // $past_cost = 0.0;
  // foreach ($past_invests_list as $k => $invest)
  // {
  //   if ($invest["action"] == 0)
  //   {
  //     $past_cost -= ($invest["price"]*$invest["quantity"]) + $invest["fee"];
  //   }
  //   else
  //   {
  //     $past_cost += ($invest["price"]*$invest["quantity"] - $invest["fee"]);
  //   }
  // }

   // $invests_list = array_reverse($invests_list);

  // Shown invests list
  // $balance = $selected_account["account_balance"];// - $past_cost;
  // $preInvestMoney = 0.0;
  $lastK = count($invests_list) - 1;
  foreach ($invests_list as $k => $invest)
  {
    if ($invest["action"] == 0)
    {
      $invests_list[$k]["money"] = ($invest["price"]*$invest["quantity"]) + $invest["fee"];
      if ($k == 0)
      {
        $invests_list[$k]["balance"] = $selected_account["account_balance"];// - $past_cost;
      }
      else
      {
        // $invests_list[$k]["balance"] = $balance + ($invest["price"]*$invest["quantity"]) - $invest["fee"];
        $invests_list[$k]["balance"] = $invests_list[$k-1]["balance"] + $invests_list[$k-1]["money"];
      }
      // $invests_list[$k]["balance"] = $balance - ($invest["price"]*$invest["quantity"]) - $invest["fee"];
      // $balance = $invests_list[$k]["balance"];
    }
    else if ($invest["action"] == 1)
    {
      $invests_list[$k]["money"] = ($invest["price"]*$invest["quantity"]) - $invest["fee"];
      if ($k == 0)
      {
        $invests_list[$k]["balance"] = $selected_account["account_balance"];// - $past_cost;
      }
      else
      {
        // $invests_list[$k]["balance"] = $balance - ($invest["price"]*$invest["quantity"]) - $invest["fee"];
        $invests_list[$k]["balance"] = $invests_list[$k-1]["balance"] - $invests_list[$k-1]["money"];
      }
      // $invests_list[$k]["balance"] = $balance + ($invest["price"]*$invest["quantity"]) - $invest["fee"];
      // $balance = $invests_list[$k]["balance"];
    }
    $invests_list[$k]["buytime"] = str_replace("-", "/", $invests_list[$k]["buytime"]);
  }

  // $invests_list = array_reverse($invests_list);
}

?>



<?php include('list_view.php'); ?>
