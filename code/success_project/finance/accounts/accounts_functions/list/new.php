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
	error('Invalid data format. (Error 800)');
}


/* Connect to DB */
try
{
  	$dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
	error("Can't connect to database. ".$e->getMessage().' (Error 801)' );
}



try
{
	/* Data Validation for all type */
	if ( !(isset($data['aname']) && strlen( trim($data['aname']) ) > 0) ) // Check null name
	{
			error("帳戶名稱不能為空白.");
	}
	$check_query_string = 'SELECT * FROM `accounts` WHERE `user_id`=? AND `account_type`=? AND `account_name`=? LIMIT 1'; // Check duplicate name in same account type
	$check_query = $dbh->prepare( $check_query_string );
	$check_query->execute( array( $uid, intval($data['atype']), trim( $data['aname'] ) ) );
	$check_result = $check_query->fetchAll( PDO::FETCH_ASSOC );
	if ( count( $check_result ) > 0 )
	{
		error('同類型的帳戶名稱不能重複.');
	}
	if ( !isset( $data['atype'] ) || !is_int( intval( $data['atype'] ) ) )
	{
		error('Invalid params. (Error 804)' );
	}
	if ( !isset( $data['money'] ) || !is_numeric( $data['money'] ) )
	{
		if ( intval($data['atype']) == 4 )
		{
			$data['money'] = ( isset($data['lmoney']) ) ? $data['lmoney'] : 0;
		}
		else
		{
			error('餘額應為數字.');
		}
	}

	/* Date for all type */
	$datetime = date('Y-m-d H:i:s');
	$date = date('Y-m-d', strtotime($datetime));

	if ( intval($data['atype']) == 0 ) // Bank Account
	{
		/* Insert to accounts table */
		$insert_query_string = 'INSERT INTO `accounts` (`user_id`, `account_type`, `account_name`, `account_balance`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?)';
		$params = array( $uid, 0, trim($data['aname']), abs(floatval($data['money'])), $datetime, $datetime );
		$insert_query = $dbh->prepare( $insert_query_string );
		$insert_query->execute( $params );
		$account_id = $dbh->lastInsertId();

		/* Insert to account_monthly table */
		$insert_query_string = 'INSERT INTO `accounts_monthly` (`user_id`, `account_id`, `account_type`, `account_name`, `account_balance`, `updated_date`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		$params = array( $uid, $account_id, 0, trim($data['aname']), abs(floatval($data['money'])), $date, $datetime, $datetime );
		$insert_query = $dbh->prepare( $insert_query_string );
		$insert_query->execute( $params );

		$res = array( 'status' => true, 'id' => intval($account_id) );

	}
	elseif ( intval($data['atype']) == 1 ) // Credit Account
	{
		/* Data Validation for credit account */
		if( !isset( $data['yrate'] ) || !is_numeric( $data['yrate'] ) )
		{
			$data['yrate'] = 0.0; // Default year rate
		}

		/* Insert to accounts table */
		$insert_query_string = 'INSERT INTO `accounts` (`user_id`, `account_type`, `account_name`, `account_balance`, `year_rate`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$params = array( $uid, 1, trim($data['aname']), abs(floatval($data['money'])), abs(floatval($data['yrate'])), $datetime, $datetime );
		$insert_query = $dbh->prepare( $insert_query_string );
		$insert_query->execute( $params );
		$account_id = $dbh->lastInsertId();

		/* Insert to account_monthly table */
		$insert_query_string = 'INSERT INTO `accounts_monthly` (`user_id`, `account_id`, `account_type`, `account_name`, `account_balance`, `updated_date`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		$params = array( $uid, $account_id, 1, trim($data['aname']), abs(floatval($data['money'])), $date, $datetime, $datetime );
		$insert_query = $dbh->prepare( $insert_query_string );
		$insert_query->execute( $params );

		$res = array( 'status' => true, 'id' => intval($account_id) );
	}
	elseif ( intval($data['atype']) == 2 ) // Invest Account
	{
    foreach ( $data['invests'] as $index => $invest )
    {
      /* Data Validation for invests */
      if( !is_array( $invest ) )
      {
        error('Invalid format of invest. (Error 807)');
        break;
      }
      if ( !isset( $invest['iname'] ) || !strlen( trim( $invest['iname'] ) ) > 0 )
      {
        error('Invalid format of invest. (Error 808)');
        break;
      }
      if ( !isset( $invest['itype'] ) || !in_array( intval($invest['itype']), array(0, 1, 2, 3, 4) ) )
      {
        error('Invalid format of invest. (Error 809)');
        break;
      }
      if( !isset( $invest['iquantity'] ) || !is_int( intval($invest['iquantity']) ) )
      {
        error('Invalid format of invest. (Error 810)');
        break;
      }
      if( !isset( $invest['iprice'] ) || !is_float( floatval($invest['iprice']) ) )
      {
        error('Invalid format of invest. (Error 811)');
        break;
      }

      $data['money'] -= $invest['iquantity'] * $invest['iprice'];
    }


		/* Insert to accounts table */
		$insert_query_string = 'INSERT INTO `accounts` (`user_id`, `account_type`, `account_name`, `account_balance`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?)';
		$params = array( $uid, 2, trim($data['aname']), abs(floatval($data['money'])), $datetime, $datetime );
		$insert_query = $dbh->prepare( $insert_query_string );
		$insert_query->execute( $params );
		$account_id = $dbh->lastInsertId();

		/* Insert to account_monthly table */
		$insert_query_string = 'INSERT INTO `accounts_monthly` (`user_id`, `account_id`, `account_type`, `account_name`, `account_balance`, `updated_date`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		$params = array( $uid, $account_id, 2, trim($data['aname']), abs(floatval($data['money'])), $date, $datetime, $datetime );
		$insert_query = $dbh->prepare( $insert_query_string );
		$insert_query->execute( $params );


		if ( isset( $data['invests'] ) && count( $data['invests'] ) > 0 )
		{

			$insert_query_string = 'INSERT INTO `invests` (`user_id`, `account_id`, `name`, `action`, `quantity`, `price`, `buytime`, `updated`, `created` ) VALUES ';
			$insert_params_string = '('.$uid.', '.$account_id.', ?, 0, ?, ?, "'.$datetime.'", "'.$datetime.'", "'.$datetime.'")';
			$params = array();

			$hasInvests = false;

			foreach ( $data['invests'] as $index => $invest )
			{
				/* Data Validation for invests */
				// if( !is_array( $invest ) )
				// {
				// 	continue;
				// }
				// if ( !isset( $invest['iname'] ) || !strlen( trim( $invest['iname'] ) ) > 0 )
				// {
				// 	continue;
				// }
				// if ( !isset( $invest['itype'] ) || !in_array( intval($invest['itype']), array(0, 1, 2, 3, 4) ) )
				// {
				// 	continue;
				// }
				// if( !isset( $invest['iquantity'] ) || !is_int( intval($invest['iquantity']) ) )
				// {
				// 	continue;
				// }
				// if( !isset( $invest['iprice'] ) || !is_float( floatval($invest['iprice']) ) )
				// {
				// 	continue;
				// }

				if ( $index > 0 )
				{
					$insert_query_string .= ', ';
				}
				$insert_query_string .= $insert_params_string;

				$params[] = trim( $invest['iname'] );
				// $params[] = intval( $invest['itype'] );
				$params[] = intval( $invest['iquantity'] );
				$params[] = floatval( $invest['iprice'] );

				$hasInvests = true;
			}

			if ( $hasInvests )
			{
				$insert_query = $dbh->prepare( $insert_query_string );
				$insert_query->execute( $params );
			}
		}

		$res = array( 'status' => true, 'id' => intval($account_id) );
	}
	elseif ( intval($data['atype']) == 3 ) // Asset Account
	{
		/* If asset has match loan account */
		if ( isset( $data['loan'] ) )
		{
			$loan = $data['loan'];

			if ( isset( $loan['id'] ) && is_int( intval( $loan['id'] ) ) )
			{
				/* Data Validation for loan account */
				$check_query_string = 'SELECT `account_id` FROM `accounts` WHERE `user_id`=? AND `account_id`=? AND `account_type`=?  LIMIT 1'; // Check duplicate name in same account type
				$check_query = $dbh->prepare( $check_query_string );
				$check_query->execute( array( $uid, intval($loan['id']), 4 ) );
				$check_result = $check_query->fetchAll( PDO::FETCH_ASSOC );
				if ( count( $check_result ) != 1 )
				{
					error('資料庫中沒有此對應資產.');
				}
			}
			elseif ( isset( $loan['atype'] ) && is_int( intval( $loan['atype'] ) ) && intval( $loan['atype'] ) == 4 )
			{
				/* Data Validation for loan account */
				if ( !(isset($loan['aname']) && strlen( trim($loan['aname']) ) > 0) ) // Check null name
				{
					error("貸款帳戶名稱不能為空白.");
				}
				$check_query_string = 'SELECT * FROM `accounts` WHERE `user_id`=? AND `account_type`=? AND `account_name`=? LIMIT 1'; // Check duplicate name in same account type
				$check_query = $dbh->prepare( $check_query_string );
				$check_query->execute( array( $uid, 4, trim( $loan['aname'] ) ) );
				$check_result = $check_query->fetchAll( PDO::FETCH_ASSOC );
				if ( count( $check_result ) > 0 )
				{
					error('貸款帳戶中已有此帳戶名稱.');
				}
				if( !isset( $loan['sdate'] ) || !preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $loan['sdate']) )
				{
					error('貸款開始日期格式不正確.');
				}
				$loan['sdate'] = str_replace('/', '-', $loan['sdate']);
				if ( !isset( $loan['money'] ) || !is_numeric( $loan['money'] ) )
				{
					error('貸款餘額應為數字.');
				}
				if( !isset( $loan['lmoney'] ) || !is_numeric( $loan['lmoney'] ) )
				{
					error('貸款金額應為數字且不能為空.');
				}
				if( !isset( $loan['tunit'] ) || !in_array( intval( $loan['tunit'] ) , array( 0, 1, 2 ) ) )
				{
					error('貸款單位不正確');
				}
				if ( !isset( $loan['tlength'] ) || !is_int( intval( $loan['tlength'] ) ) )
				{
					error('貸款長度不正確');
				}
				switch( $loan['tunit'] )
				{
					case 0:
					if ( intval( $loan['tlength'] ) > 20 || intval( $loan['tlength'] ) < 0 )
					{
						error('貸款長度最多20年');
					}
					break;

					case 1:
					if ( intval( $loan['tlength'] ) > 240 || intval( $loan['tlength'] ) < 0 )
					{
						error('貸款長度最多240月');
					}
					break;

					case 1:
					if ( intval( $loan['tlength'] ) > 960 || intval( $loan['tlength'] ) < 0 )
					{
						error('貸款長度最多960周');
					}
					break;
				}
				if( !isset( $data['yrate'] ) || !is_numeric( $data['yrate'] ) )
				{
					$data['yrate'] = 0.0; // Default year rate
				}


				/* Insert loan account to accounts table */
				$insert_query_string = 'INSERT INTO `accounts` (`user_id`, `account_type`, `account_name`, `account_balance`, `year_rate`, `start_date`, `money`, `time_length`, `time_length_unit`, `pay_period`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
				$params = array( $uid, 4, trim($loan['aname']), abs(floatval($loan['money'])), abs(floatval($loan['yrate'])), $loan['sdate'], floatval($loan['lmoney']), intval($loan['tlength']), intval($loan['tunit']), 0, $datetime, $datetime );
				$insert_query = $dbh->prepare( $insert_query_string );
				$insert_query->execute( $params );
				$loan_id = $dbh->lastInsertId();

				/* Insert loan account to account_monthly table */
				$insert_query_string = 'INSERT INTO `accounts_monthly` (`user_id`, `account_id`, `account_type`, `account_name`, `account_balance`, `year_rate`, `updated_date`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
				$params = array( $uid, $loan_id, 4, trim($loan['aname']), abs(floatval($loan['money'])), abs(floatval($loan['yrate'])), $date, $datetime, $datetime );
				$insert_query = $dbh->prepare( $insert_query_string );
				$insert_query->execute( $params );

				$loan['id'] = $loan_id;
			}
			else
			{
				error('Invalid params. (Error 805)' );
			}
		}
		else
		{
			$loan['id'] = false;
		}


		/* Data Validation for asset account */
		if( !isset( $data['bdate'] ) || !preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $data['bdate']) )
		{
			error('資產購買日期格式不正確.');
		}
		$data['bdate'] = str_replace('/', '-', $data['bdate']);
		if( !isset( $data['bprice'] ) || !is_numeric( $data['bprice'] ) )
		{
			error('購買金額應為數字且不能為空.');
		}


		/* Insert asset account to accounts table */
		$insert_query_string = 'INSERT INTO `accounts` (`user_id`, `account_type`, `account_name`, `account_balance`, `start_date`, `money`, `match_account_id`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$params = array( $uid, 3, trim($data['aname']), abs(floatval($data['money'])), $data['bdate'], floatval($data['bprice']), $loan['id'], $datetime, $datetime );
		$insert_query = $dbh->prepare( $insert_query_string );
		$insert_query->execute( $params );
		$account_id = $dbh->lastInsertId();

		/* Insert asset account to account_monthly table */
		$insert_query_string = 'INSERT INTO `accounts_monthly` (`user_id`, `account_id`, `account_type`, `account_name`, `account_balance`, `updated_date`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		$params = array( $uid, $account_id, 3, trim($data['aname']), abs(floatval($data['money'])), $date, $datetime, $datetime );
		$insert_query = $dbh->prepare( $insert_query_string );
		$insert_query->execute( $params );


		/* Update match account id for loan account */
		/*
		$update_query_string = "UPDATE `accounts` SET `match_account_id`=? WHERE `user_id`=? AND `account_id`=? AND `account_type`=?";
        $params = array( $account_id, $uid, intval($data['id']), intval($data['atype']) );
        $update_query = $dbh->prepare( $update_query_string );
        $update_query->execute( $params );
        */

		$res = array( 'status' => true, 'id' => intval($account_id), 'lid' => $loan['id'] );
	}
	elseif ( intval($data['atype']) == 4 ) // Loan Account
	{
		/* Data Validation for loan account */
		if( !isset( $data['sdate'] ) || !preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $data['sdate']) )
		{
			error('貸款開始日期格式不正確.');
		}
		$data['sdate'] = str_replace('/', '-', $data['sdate']);
		if( !isset( $data['lmoney'] ) || !is_numeric( $data['lmoney'] ) )
		{
			error('貸款金額應為數字且不能為空.');
		}
		if( !isset( $data['tunit'] ) || !in_array( intval( $data['tunit'] ) , array( 0, 1, 2 ) ) )
		{
			error('貸款單位不正確');
		}
		if ( !isset( $data['tlength'] ) || !is_int( intval( $data['tlength'] ) ) )
		{
			error('貸款長度不正確');
		}
		switch( $data['tunit'] )
		{
			case 0:
			if ( intval( $data['tlength'] ) > 20 || intval( $data['tlength'] ) < 0 )
			{
				error('貸款長度最多20年');
			}
			break;

			case 1:
			if ( intval( $data['tlength'] ) > 240 || intval( $data['tlength'] ) < 0 )
			{
				error('貸款長度最多240月');
			}
			break;

			case 1:
			if ( intval( $data['tlength'] ) > 960 || intval( $data['tlength'] ) < 0 )
			{
				error('貸款長度最多960周');
			}
			break;
		}


		/* Insert loan account to accounts table */
		$insert_query_string = 'INSERT INTO `accounts` (`user_id`, `account_type`, `account_name`, `account_balance`, `year_rate`, `start_date`, `money`, `time_length`, `time_length_unit`, `pay_period`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$params = array( $uid, 4, trim($data['aname']), abs(floatval($data['money'])), abs(floatval($data['yrate'])), $data['sdate'], floatval($data['lmoney']), intval($data['tlength']), intval($data['tunit']), 0, $datetime, $datetime );
		$insert_query = $dbh->prepare( $insert_query_string );
		$insert_query->execute( $params );
		$account_id = $dbh->lastInsertId();

		/* Insert loan account to account_monthly table */
		$insert_query_string = 'INSERT INTO `accounts_monthly` (`user_id`, `account_id`, `account_type`, `account_name`, `account_balance`, `year_rate`, `updated_date`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$params = array( $uid, $account_id, 4, trim($data['aname']), abs(floatval($data['money'])), abs(floatval($data['yrate'])), $date, $datetime, $datetime );
		$insert_query = $dbh->prepare( $insert_query_string );
		$insert_query->execute( $params );

		$asset_id = false;

		if( isset( $data['asset'] ) )
		{
			$asset = $data['asset'];

			if ( isset( $asset['atype'] ) && is_int( intval( $asset['atype'] ) ) && intval( $asset['atype'] ) == 3 )
			{
				/* Data Validation for asset account */
				if ( !(isset($asset['aname']) && strlen( trim($asset['aname']) ) > 0) ) // Check null name
				{
					error("資產帳戶名稱不能為空白.");
				}
				$check_query_string = 'SELECT * FROM `accounts` WHERE `user_id`=? AND `account_type`=? AND `account_name`=? LIMIT 1'; // Check duplicate name in same account type
				$check_query = $dbh->prepare( $check_query_string );
				$check_query->execute( array( $uid, 4, trim( $asset['aname'] ) ) );
				$check_result = $check_query->fetchAll( PDO::FETCH_ASSOC );
				if ( count( $check_result ) > 0 )
				{
					error('資產帳戶中已有此帳戶名稱.');
				}
				if( !isset( $asset['money'] ) || !is_numeric( $asset['money'] ) )
				{
					error('資產市值應為數字且不能為空.');
				}

				/* Insert asset account to accounts table */
				$insert_query_string = 'INSERT INTO `accounts` (`user_id`, `account_type`, `account_name`, `account_balance`, `match_account_id`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?)';
				$params = array( $uid, 3, trim($asset['aname']), abs(floatval($asset['money'])), $account_id, $datetime, $datetime );
				$insert_query = $dbh->prepare( $insert_query_string );
				$insert_query->execute( $params );
				$asset_id = $dbh->lastInsertId();

				if ( $asset_id != 0 )
				{
					/* Insert asset account to account_monthly table */
					$insert_query_string = 'INSERT INTO `accounts_monthly` (`user_id`, `account_id`, `account_type`, `account_name`, `account_balance`, `updated_date`, `updated`, `created` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
					$params = array( $uid, $asset_id, 3, trim($asset['aname']), abs(floatval($asset['money'])), $date, $datetime, $datetime );
					$insert_query = $dbh->prepare( $insert_query_string );
					$insert_query->execute( $params );
				}

				$res = array(
					'status' => true,
					'id' => intval($account_id),
					'aid' => ( $asset_id != 0 ) ? $asset_id : false
				);
			}
			else
			{
				error('Invalid params. (Error 806)' );
			}
		}
		else
		{
			$res = array(
				'status' => true,
				'id' => intval($account_id),
				'aid' => false
			);
		}

	}
	else
	{
		error('Invalid params. (Error 803)' );
	}
}
catch(Exception $e)
{
	error('Proccess error '.$e->getMessage().' (Error 802)' );
}

//$res['data'] = $data;

echo json_encode( $res );
?>
