<?php
session_start();
header( "Content-Type: application/json", true );
require "../../../../config_conn.inc.php";

ignore_user_abort(true); // Ignore user aborts and allow the script to run forever
set_time_limit(0); // disable php time limit

if ( 1 )
{
	ini_set('display_errors',1);
	error_reporting(E_ALL);
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

function nextPeriodDate( $startDate, $period )
{
    $thisStartDate = $startDate;
  $thisStartDateInt = strtotime($thisStartDate);
  $thisStartDate_y = intval(date('Y', $thisStartDateInt));
  $thisStartDate_m = intval(date('m', $thisStartDateInt));
  $thisStartDate_d = intval(date('d', $thisStartDateInt));
  $thisStartDate_m_last_d = date('t', $thisStartDateInt);

  $turn = 1;
  if ( $period == "week" )
  {
      $deriveSavingDateInt = strtotime($thisStartDate.' +1 week');
  }
  else if ( $period == "month" )
  {
      $nextMonthFirstDate = calculate_month($thisStartDate, ($turn+1));
      $nextMonthFirstDateInt = strtotime($nextMonthFirstDate);

      $nextMonthFirstDate_m = date('m', $nextMonthFirstDateInt);
      $nextMonthFirstDate_m_last_d = date('t', $nextMonthFirstDateInt);
      if ( $thisStartDate_d < 28 )
      {
          $deriveSavingDateInt = strtotime( date(
              'Y-m-'.str_pad($thisStartDate_d, 2, '0', STR_PAD_LEFT),
              strtotime( $nextMonthFirstDate )
          ) );
      }
      else
      {
          if ( $thisStartDate_d == $thisStartDate_m_last_d )
          {
              $deriveSavingDateInt = strtotime( date(
                  'Y-m-t',
                  strtotime( $nextMonthFirstDate )
              ) );
          }
          else if ( $thisStartDate_d > $nextMonthFirstDate_m_last_d )
          {
              $deriveSavingDateInt = strtotime( date(
                  'Y-m-t',
                  strtotime( $nextMonthFirstDate )
              ) );
          }
          else
          {
              $deriveSavingDateInt = strtotime( date(
                  'Y-m-'.str_pad($thisStartDate_d, 2, '0', STR_PAD_LEFT),
                  strtotime( $nextMonthFirstDate )
              ) );
          }
      }
  }
  else if ( $period == "quarter" )
  {
      $nextQuarterMonthFirstDate = calculate_month( $thisStartDate, ($turn*3+1) );
      $nextQuarterMonthFirstDateInt = strtotime($nextQuarterMonthFirstDate);

      $nextQuarterMonthFirstDate_m = date('m', $nextQuarterMonthFirstDateInt);
      $nextQuarterMonthFirstDate_m_last_d = date('t', $nextQuarterMonthFirstDateInt);

      if ( $thisStartDate_d < 28 )
      {
          $deriveSavingDateInt = strtotime( date(
              'Y-m-'.str_pad($thisStartDate_d, 2, '0', STR_PAD_LEFT),
              strtotime( $nextQuarterMonthFirstDate )
          ) );
      }
      else
      {
          if ( $thisStartDate_d == $thisStartDate_m_last_d )
          {
              $deriveSavingDateInt = strtotime( date(
                  'Y-m-t',
                  strtotime( $nextQuarterMonthFirstDate )
              ) );
          }
          else if ( $thisStartDate_d > $nextQuarterMonthFirstDate_m_last_d )
          {
              $deriveSavingDateInt = strtotime( date(
                  'Y-m-t',
                  strtotime( $nextQuarterMonthFirstDate )
              ) );
          }
          else
          {
              $deriveSavingDateInt = strtotime( date(
                  'Y-m-'.str_pad($thisStartDate_d, 2, '0', STR_PAD_LEFT),
                  strtotime( $nextQuarterMonthFirstDate )
              ) );
          }
      }
  }
  else if ( $period == "year" )
  {
      $nextYearMonthFirstDate = calculate_month( $thisStartDate, ($turn*12+1) );
      $nextYearMonthFirstDateInt = strtotime($nextYearMonthFirstDate);

      $nextYearMonthFirstDate_m = date('m', $nextYearMonthFirstDateInt);
      $nextYearMonthFirstDate_m_last_d = date('t', $nextYearMonthFirstDateInt);

      if ( $thisStartDate_d < 28 )
      {
          $deriveSavingDateInt = strtotime( date(
              'Y-m-'.str_pad($thisStartDate_d, 2, '0', STR_PAD_LEFT),
              strtotime( $nextYearMonthFirstDate )
          ) );
      }
      else
      {
          if ( $thisStartDate_d == $thisStartDate_m_last_d )
          {
              $deriveSavingDateInt = strtotime( date(
                  'Y-m-t',
                  strtotime( $nextYearMonthFirstDate )
              ) );
          }
          else if ( $thisStartDate_d > $nextYearMonthFirstDate_m_last_d )
          {
              $deriveSavingDateInt = strtotime( date(
                  'Y-m-t',
                  strtotime( $nextYearMonthFirstDate )
              ) );
          }
          else
          {
              $deriveSavingDateInt = strtotime( date(
                  'Y-m-'.str_pad($thisStartDate_d, 2, '0', STR_PAD_LEFT),
                  strtotime( $nextYearMonthFirstDate )
              ) );
          }
      }
  }

  return date('Y-m-d', $deriveSavingDateInt);
}

if ( isset( $_POST['data'] ) && is_JSON( $_POST['data'] ) )
{
	$data = cleanXSS( json_decode( $_POST['data'], true ) );
}
else
{
	error('Unvalid data format. (Error 1010)');
}


/* Connect to DB */
try
{
  	$dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
	error("Can't connect to database. ".$e->getMessage().' (Error 1011)' );
}


/* Data Validation for input */
if ( !isset($data['aid']) || !is_numeric($data['aid']) )
{
    error('Unvalid params. (Error 1013)');
}
$data['aid'] = intval($data['aid']);
if ( !isset($data['sid']) || !is_numeric($data['sid']) )
{
    error('Unvalid params. (Error 1014)');
}
$data['sid'] = intval($data['sid']);
// if ( !isset($data['type']) || !in_array( intval($data['type']), array(0, 1) ) )
// {
//     error('Unvalid params. (Error 1005)');
// }
// $data['type'] = intval($data['type']);
if ( !isset($data['date']) ||
     !preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $data['date']) )
{
    error('日期格式不正確.');
}
$data['date'] = str_replace('/', '-', $data['date']);
if ( strtotime($data['date']) < strtotime(date('Y-m-d')) )
{
    error('不能新增過去日期的項目.');
}
if ( !(isset($data['sname']) && strlen( trim($data['sname']) ) > 0) ) // Check null name
{
    error("收款/放款人欄位不能為空白.");
}
$data['sname'] = trim($data['sname']);
if ( !(isset($data['iname']) && strlen( trim($data['iname']) ) > 0) ) // Check null name
{
    error("品項欄位不能為空白.");
}
$data['iname'] = trim($data['iname']);
if ( !isset($data['money']) || !is_numeric($data['money']) )
{
    $data['money'] = 0;
}
$data['money'] = abs( floatval($data['money']) );
if ( !isset($data['period']) ||
     !in_array( intval($data['period']), array(0, 1, 2, 3) ) )
{
    error('Unvalid params. (Error 1016)');
}
$data['period'] = intval($data['period']);
if ( !isset($data['utype']) ||
     !in_array( intval($data['utype']), array(0, 1) ) )
{
    error('Unvalid params. (Error 1017)');
}
$data['utype'] = intval($data['utype']);

$periods_units = array( 7, 30, 90, 365);

// Today datetime
$datetime = date('Y-m-d H:i:s');

$res = array( 'status' => true );

// Get the saving
try
{
    $get_query_string = "SELECT * FROM `savings` WHERE `user_id`=? AND `account_id`=? AND `saving_id`=?";
    $get_query = $dbh->prepare( $get_query_string );
    $get_query->execute( array($uid, $data['aid'], $data['sid']) );
    $saving = $get_query->fetch( PDO::FETCH_ASSOC );
    if ( !$saving )
    {
        error('資料庫中沒有此筆資料, 更新失敗.');
    }
}
catch (PDOException $e) {
  error("Can't connect to database. ".$e->getMessage().' (Error 1018)' );
}

// Update this saving
try
{
    $thisSavingStartDate = $saving['start_date'];
    $thisSavingStartDateInt = strtotime($thisSavingStartDate);
    $thisSavingPassDates = json_decode($saving['pass_dates']);
    $thisSavingEndDate = $saving['end_date'];
    $thisSavingEndDateInt = strtotime($thisSavingEndDate);

    $dataDate = $data['date'];
    $dataDateInt = strtotime($dataDate);

    if ( $saving['period'] == 0 )
    {
        $deriveDataDateInt = strtotime(nextPeriodDate($dataDate, "week"));
        $deriveSavingDateInt = strtotime(nextPeriodDate($thisSavingStartDate, "week"));
    }
    else if ( $saving['period'] == 1 )
    {
        $deriveDataDateInt = strtotime(nextPeriodDate($dataDate, "month"));
        $deriveSavingDateInt = strtotime(nextPeriodDate($thisSavingStartDate, "month"));
    }
    else if ( $saving['period'] == 2 )
    {
        $deriveDataDateInt = strtotime(nextPeriodDate($dataDate, "quarter"));
        $deriveSavingDateInt = strtotime(nextPeriodDate($thisSavingStartDate, "quarter"));
    }
    else if ( $saving['period'] == 3 )
    {
        $deriveDataDateInt = strtotime(nextPeriodDate($dataDate, "year"));
        $deriveSavingDateInt = strtotime(nextPeriodDate($thisSavingStartDate, "year"));
    }



    if ( $data['utype'] == 0 )
    {
        if ( $data['date'] == $saving['start_date'] )
        {
            if ( $thisSavingEndDateInt != $deriveSavingDateInt )
            {
                $insert_query_string = "INSERT INTO `savings`(`user_id`, `account_id`, `source_name`, `saving_type`, `start_date`, `pass_dates`, `end_date`, `item_name`, `money`, `period`, `updated`, `created`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
                $insert_query = $dbh->prepare( $insert_query_string );
                $insert_query->execute( array(
                    $saving['user_id'], $saving['account_id'], $saving['source_name'], $saving['saving_type'],
                    date('Y-m-d', $deriveSavingDateInt),  $saving['pass_dates'], $saving['end_date'],
                    $saving['item_name'], $saving['money'], $saving['period'],
                    $datetime, $datetime
                ) );
                if ( $insert_query->rowCount() != 1 )
                {
                    error('新增項目失敗. (Error 1019)');
                }
            }
            $update_query_string = "UPDATE `savings` SET `source_name`=?, `start_date`=?, `item_name`=?, `money`=?, `period`=?, `end_date`=? WHERE `user_id`=? AND `account_id`=? AND `saving_id`=?";
            $update_query = $dbh->prepare( $update_query_string );
            $update_query->execute( array(
                $data['sname'], $data['date'], $data['iname'],
                $data['money'], $data['period'], date('Y-m-d', $deriveSavingDateInt),
                $uid, $data['aid'], $data['sid']
            ) );
        }
        else
        {
            if ( $thisSavingEndDate != '0000-00-00' && $thisSavingEndDateInt == $deriveSavingDateInt )
            {
                // Change start date
                $update_query_string = "UPDATE `savings` SET `source_name`=?, `start_date`=?, `item_name`=?, `money`=?, `period`=?, `end_date`=? WHERE `user_id`=? AND `account_id`=? AND `saving_id`=?";
                $update_query = $dbh->prepare( $update_query_string );
                $update_query->execute( array(
                    $data['sname'], $data['date'], $data['iname'],
                    $data['money'], $data['period'], date('Y-m-d', $deriveDataDateInt),
                    $uid, $data['aid'], $data['sid']
                ) );
            }
            else
            {
                if ( !in_array($data['date'], $thisSavingPassDates) )
                {
                    $insert_query_string = "INSERT INTO `savings`(`user_id`, `account_id`, `source_name`, `saving_type`, `start_date`, `pass_dates`, `end_date`, `item_name`, `money`, `period`, `updated`, `created`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
                    $insert_query = $dbh->prepare( $insert_query_string );
                    $insert_query->execute( array(
                        $uid, $data['aid'], $data['sname'], $data['type'],
                        $data['date'],  '[]', date('Y-m-d', $deriveDataDateInt),
                        $data['iname'], $data['money'], $data['period'],
                        $datetime, $datetime
                    ) );
                    if ( $insert_query->rowCount() != 1 )
                    {
                        error('新增項目失敗. (Error 1020)');
                    }

                    $thisSavingPassDates[] = $data['date'];
                }
                $update_query_string = "UPDATE `savings` SET `pass_dates`=? WHERE `user_id`=? AND `account_id`=? AND `saving_id`=?";
                $update_query = $dbh->prepare( $update_query_string );
                $update_query->execute( array(
                    json_encode($thisSavingPassDates),
                    $uid, $data['aid'], $data['sid']
                ) );
            }
        }
    }
    else if ( $data['utype'] == 1 )
    {
        if ( $data['date'] == $saving['start_date'] )
        {
            $update_query_string = "UPDATE `savings` SET `source_name`=?, `start_date`=?, `item_name`=?, `money`=?, `period`=? WHERE `user_id`=? AND `account_id`=? AND `saving_id`=?";
            $update_query = $dbh->prepare( $update_query_string );
            $update_query->execute( array(
                $data['sname'], $data['date'], $data['iname'],
                $data['money'], $data['period'],
                $uid, $data['aid'], $data['sid']
            ) );
        }
        else
        {
            if ( $thisSavingEndDate != '0000-00-00' && $thisSavingEndDateInt == $deriveSavingDateInt )
            {
                // Change start date
                $update_query_string = "UPDATE `savings` SET `source_name`=?, `start_date`=?, `item_name`=?, `money`=?, `period`=?, `end_date`=? WHERE `user_id`=? AND `account_id`=? AND `saving_id`=?";
                $update_query = $dbh->prepare( $update_query_string );
                $update_query->execute( array(
                    $data['sname'], $data['date'], $data['iname'],
                    $data['money'], $data['period'], date('Y-m-d', $deriveDataDateInt),
                    $uid, $data['aid'], $data['sid']
                ) );
            }
            else
            {
                $insert_query_string = "INSERT INTO `savings`(`user_id`, `account_id`, `source_name`, `saving_type`, `start_date`, `pass_dates`, `end_date`, `item_name`, `money`, `period`, `updated`, `created`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
                $insert_query = $dbh->prepare( $insert_query_string );
                $insert_query->execute( array(
                    $uid, $data['aid'], $data['sname'], $data['type'],
                    $dataDate,  $saving['pass_dates'], $saving['end_date'],
                    $data['iname'], $data['money'], $data['period'],
                    $datetime, $datetime
                ) );
                if ( $insert_query->rowCount() != 1 )
                {
                    error('新增項目失敗. (Error 1019)');
                }
                $update_query_string = "UPDATE `savings` SET `end_date`=? WHERE `user_id`=? AND `account_id`=? AND `saving_id`=?";
                $update_query = $dbh->prepare( $update_query_string );
                $update_query->execute( array(
                    $dataDate,
                    $uid, $data['aid'], $data['sid']
                ) );
            }
        }
    }

    // if ( $data['date'] == $saving['start_date'] )
    // {
    //     // Would not reset pass date
    //     $update_query_string = "UPDATE `savings` SET `source_name`=?, `start_date`=?, `item_name`=?, `money`=?, `period`=? WHERE `user_id`=? AND `account_id`=? AND `saving_id`=?";
    // }
    // else
    // {
    //     // Would reset pass date
    //     $update_query_string = "UPDATE `savings` SET `source_name`=?, `start_date`=?, `item_name`=?, `money`=?, `period`=?, `pass_dates`='[]' WHERE `user_id`=? AND `account_id`=? AND `saving_id`=?";
    // }
    // $update_query = $dbh->prepare( $update_query_string );
    // $update_query->execute( array(
    //     $data['sname'], $data['date'],$data['iname'],
    //     $data['money'], $data['period'],
    //     $uid, $data['aid'], $data['sid']
    // ) );
}
catch (PDOException $e) {
  error("Can't connect to database. ".$e->getMessage().' (Error 1019)' );
}

echo json_encode( $res );
?>