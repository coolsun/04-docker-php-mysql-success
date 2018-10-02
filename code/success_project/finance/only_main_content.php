<?php // xing modify file ?>

<?php
if ( 0 )
{
    ini_set('display_errors',1);
    error_reporting(E_ALL);
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

/* Connect to DB */
try
{
  $dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
  echo $e->getMessage();
  exit();
}

/* Include configs */
include ( 'configs.php' );


/* User id */
$uid = $_SESSION['userid'];

/* Check monthly account balance record, then update it to date */
try
{
    $today_datetime = date('Y-m-d H:i:s');

    // Get accounts which are not update to this month
    $this_month_date = date("Y-m-01"); // this month first day
    $this_month_datetime = date("Y-m-01 00:00:00");
    $get_query_string = "SELECT * FROM `accounts` WHERE `user_id`=? AND `updated` < ?  ORDER BY `account_type` DESC";
    $params = array( $uid, $this_month_datetime );
    $get_query = $dbh->prepare( $get_query_string );
    $get_query->execute( $params );
    $all_accounts = $get_query->fetchAll( PDO::FETCH_ASSOC );

    // Update above account to this month
    $update_query_string = "UPDATE `accounts` SET `updated`=? WHERE `user_id`=? AND `account_id`=? AND `account_type`=?";
    $update_query = $dbh->prepare( $update_query_string );
    foreach ( $all_accounts as $index => $account )
    {
        $params = array( $today_datetime, $uid, $account['account_id'], $account['account_type'] );
        $update_query->execute( $params );
    }


    // Check those monthly accounts record of above account, then padding null record which between $account_monthly_latest month  and now month
    $get_query_string = "SELECT * FROM `accounts_monthly` WHERE `user_id`=? AND `account_id`=? AND `updated_date` < ? ORDER BY `updated_date` DESC LIMIT 1";
    $get_query = $dbh->prepare( $get_query_string );
    foreach ( $all_accounts as $index => $account )
    {
        $params = array( $uid, $account['account_id'], date('Y-m-t') );
        $get_query->execute( $params );
        $account_monthly_latest = $get_query->fetch( PDO::FETCH_ASSOC );
        $column_num = count( $account_monthly_latest );

        $aml_month = $account_monthly_latest['updated_date'];

        $diff_month = diff_months_between_two_date( $account_monthly_latest['updated_date'], $this_month_date );


        /*echo "<pre>";
        print_r( $account_monthly_latest );
        echo "</pre>";

        echo $diff_month;
        echo "<br/>";*/


        if ( $diff_month )
        {

            $account_monthly_latest['updated'] = $today_datetime;
            $account_monthly_latest['created'] = $today_datetime;

            for ( $i = 2 ; $i <= $diff_month+1 ; $i++ ) // i=2 to ignore duplicate months, because calculate_month() ...
            {
                $account_monthly_latest['updated_date'] = calculate_month( $aml_month, $i );
                $insert_query_string = "INSERT INTO `accounts_monthly` VALUES(".str_repeat("?, ", $column_num-1)."?)";
                $insert_query = $dbh->prepare( $insert_query_string );
                $insert_query->execute( array_values( $account_monthly_latest ) );
                /*echo calculate_month( $aml_month, $i );
                echo "<br/>";*/
            }
        }

    }

    unset($all_accounts);
}
catch(PDOException $e)
{
    echo "Error";
    echo $e->getMessage();
    exit();
}

/* Route */
$mas = array(
    'accounts' => '帳戶管理',
    'bills'    => '每日記帳',
    'saving'   => '存錢計畫',
    'invests'  => '投資計畫'
);

$sas = array(
    'accounts' => array(
        'list'    => '帳戶',
        'details' => '明細',
        'statics' => '資產負債'
    ),
    'bills' => array(
        'records' => '記帳本',
        'statics' => '派餅圖',
        'budgets' => '預算管理'
    ),
    'saving' => array(
        'strategies' => '收入支出',
        'statics'    => '存款曲線',
        'repayments'  => '還債計畫'
    ),
    'invests'  => array(
        'list'      => '投資',
        'marketcap' => '市值',
        'profit'    => '分析'
    )
);

$default_ma = 'accounts';

$default_sas = array(
    'accounts' => 'list',
    'bills'    => 'records',
    'saving'   => 'strategies',
    'invests'  => 'list'
);

if( !( isset( $_GET['ma'] ) && trim( $_GET['ma'] ) != '' ) )
{
    $_GET['ma'] = $default_ma;
}
if( !isset( $mas[ $_GET['ma'] ] ) )
{
    $_GET['ma'] = $default_ma;
}
$ma = $_GET['ma'];

if( isset( $_GET['sa'] ) && isset( $sas[ $ma ][ $_GET['sa'] ] ) )
{
    $sa = $_GET['sa'];
}
else
{
    $sa = $default_sas[ $ma ];
}
?>

<?php include( $ma.'/'.$sa.'.php' ) ?>

<?php
/*
 Please don't edit above code.
 */
?>

