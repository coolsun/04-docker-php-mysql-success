<?php
/*
    2014/08/10 - 更新信用卡或貸款與其他三種分開寫, 需要額外更新利率
*/
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

if ( isset( $_POST['data'] ) && is_JSON( $_POST['data'] ) )
{
    $data = cleanXSS( json_decode( $_POST['data'], true ) );
}
else 
{
    error('Unvalid data format. (Error 810)');
}


/* Connect to DB */
try
{
    $dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
    error("Can't connect to database. ".$e->getMessage().' (Error 811)' );
}

try
{
    /* Data Validation for all type */
    if ( !(isset($data['aname']) && strlen( trim($data['aname']) ) > 0) ) // Check null name
    {
        error("帳戶名稱不能為空白.");
    }

    /* Date for all type */
    $datetime = date('Y-m-d H:i:s');
    $date = date('Y-m-d', strtotime($datetime));

    // Test Data
    /*$datetime = '2014-12-15 13:45:06';
    $date = '2014-12-15';*/

    if ( in_array( intval($data['atype']), array( 0, 2, 3 ) ) ) // Bank Account, Invest Account, Asset Account
    {
        /* Data Validation for Bank, Invest, Asset */
        $check_query_string = 'SELECT `account_id`, `account_name` FROM `accounts` WHERE `user_id`=? AND `account_type`=? AND `account_name`=? LIMIT 1'; // Updated name can't be duplicated to other account in same account type
        $check_query = $dbh->prepare( $check_query_string );
        $check_query->execute( array( $uid, intval($data['atype']), trim( $data['aname'] ) ) );
        $exist_id = $check_query->fetchColumn();
        if ( is_int( $exist_id ) && intval($data['id']) != intval( $exist_id ) )
        {
          error('同類型的帳戶名稱不能重複.'.$exist_id);
        }


        /*  Update account record */
        $update_query_string = "UPDATE `accounts` SET `account_name`=?, `description`=?, `updated`=? WHERE `user_id`=? AND `account_id`=? AND `account_type`=?";
        $params = array( trim($data['aname']), trim($data['description']), $datetime, $uid, intval($data['id']), intval($data['atype']) );
        $update_query = $dbh->prepare( $update_query_string );
        $update_query->execute( $params );
        

        /* Update accounts_monthly */
        $update_query_string = "UPDATE `accounts_monthly` SET `account_name`=?, `description`=? WHERE `user_id`=? AND `account_id`=? AND `account_type`=?";
        $params = array( trim($data['aname']), trim($data['description']), $uid, intval($data['id']), intval($data['atype']) );
        $update_query = $dbh->prepare( $update_query_string );
        $update_query->execute( $params );


        /* Add new monthly account record or not */
        $get_query_string = "SELECT * FROM `accounts_monthly` WHERE `user_id`=? AND `account_id`=? AND `account_type`=? ORDER BY `updated_date` DESC LIMIT 1";
        $params = array( $uid, intval($data['id']), intval($data['atype']) );
        $get_query = $dbh->prepare( $get_query_string );
        $get_query->execute( $params );
        $old_accounts_monthly = $get_query->fetch(PDO::FETCH_ASSOC);
        if ( !count( $old_accounts_monthly ) > 0 )
        {
            error('Updated data was not consistent. (Error 131)');
        }
        $old_date = $old_accounts_monthly['updated_date'];


        if ( intval(date( 'Ym', strtotime( $date ) )) > intval(date( 'Ym', strtotime( $old_date ) )) ) // When new date month greater than old date month, add new monthly account record
        {
            $insert_query_string = 'INSERT INTO `accounts_monthly` (`user_id`, `account_id`, `account_type`, `account_name`, `account_balance`, `updated_date`, `description`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $params = array( $uid, intval($data['id']), intval($data['atype']), trim($data['aname']), $old_accounts_monthly['account_balance'], $date, $old_accounts_monthly['description'], $datetime, $datetime );
            $insert_query = $dbh->prepare( $insert_query_string );
            $insert_query->execute( $params );
        }
        elseif( intval(date( 'Ym', strtotime( $date ) )) < intval(date( 'Ym', strtotime( $old_date ) )) ) // If lower, Error !!
        {
            error('Updated data datetime was unvaild. (Error 132)');
        }
        
    }
    elseif ( in_array( intval($data['atype']), array( 1, 4 ) ) ) // Credit Account, Loan Account
    {
        /* Data Validation for Bank, Invest, Asset */
        if ( !isset($data['yrate']) ) 
        {
            $data['yrate'] = 0.0;
        }
        if ( (!is_int( intval($data['yrate']) )) && (!is_float( floatval($data['yrate']) )) )
        {
            error('利率應為數字.');
        }
        $check_query_string = 'SELECT `account_id`, `account_name` FROM `accounts` WHERE `user_id`=? AND `account_type`=? AND `account_name`=? LIMIT 1'; // Updated name can't be duplicated to other account in same account type
        $check_query = $dbh->prepare( $check_query_string );
        $check_query->execute( array( $uid, intval($data['atype']), trim( $data['aname'] ) ) );
        $exist_id = $check_query->fetchColumn();
        if ( is_int( $exist_id ) && intval($data['id']) != intval( $exist_id ) )
        {
          error('同類型的帳戶名稱不能重複.'.$exist_id);
        }


        /*  Update account record */
        $update_query_string = "UPDATE `accounts` SET `account_name`=?, `description`=?, `year_rate`=?,`updated`=? WHERE `user_id`=? AND `account_id`=? AND `account_type`=?";
        $params = array( trim($data['aname']), trim($data['description']), floatval($data['yrate']), $datetime, $uid, intval($data['id']), intval($data['atype']) );
        $update_query = $dbh->prepare( $update_query_string );
        $update_query->execute( $params );


        /* Update accounts_monthly */
        $update_query_string = "UPDATE `accounts_monthly` SET `account_name`=?, `description`=?, `year_rate`=? WHERE `user_id`=? AND `account_id`=? AND `account_type`=?";
        $params = array( trim($data['aname']), trim($data['description']), floatval($data['yrate']), $uid, intval($data['id']), intval($data['atype']) );
        $update_query = $dbh->prepare( $update_query_string );
        $update_query->execute( $params );


        /* Add new monthly account record or not */
        $get_query_string = "SELECT * FROM `accounts_monthly` WHERE `user_id`=? AND `account_id`=? AND `account_type`=? ORDER BY `updated_date` DESC LIMIT 1";
        $params = array( $uid, intval($data['id']), intval($data['atype']) );
        $get_query = $dbh->prepare( $get_query_string );
        $get_query->execute( $params );
        $old_accounts_monthly = $get_query->fetch(PDO::FETCH_ASSOC);
        if ( !count( $old_accounts_monthly ) > 0 )
        {
            error('Updated data was not consistent. (Error 131)');
        }
        $old_date = $old_accounts_monthly['updated_date'];

        if ( intval(date( 'Ym', strtotime( $date ) )) > intval(date( 'Ym', strtotime( $old_date ) )) ) // When new date month greater than old date month, add new monthly account record
        {
            $insert_query_string = 'INSERT INTO `accounts_monthly` (`user_id`, `account_id`, `account_type`, `account_name`, `account_balance`, `year_rate`, `updated_date`, `description`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $params = array( $uid, intval($data['id']), intval($data['atype']), trim($data['aname']), $old_accounts_monthly['account_balance'], floatval($data['yrate']), $date, $old_accounts_monthly['description'], $datetime, $datetime );
            $insert_query = $dbh->prepare( $insert_query_string );
            $insert_query->execute( $params );
        }
        elseif( intval(date( 'Ym', strtotime( $date ) )) < intval(date( 'Ym', strtotime( $old_date ) )) ) // If lower, Error !!
        {
            error('Updated data datetime was unvaild. (Error 132)');
        }

    }
    else
    {
      error('Unvalid params. (Error 813)' );
    }

    $res = array( 'status' => true );
}
catch(Exception $e)
{
  error('Proccess error '.$e->getMessage().' (Error 812)' );
}

echo json_encode( $res );
?>