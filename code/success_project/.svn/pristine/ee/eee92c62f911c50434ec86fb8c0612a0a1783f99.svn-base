<?php
/* Get all loan accounts */

session_start();
header( "Content-Type: application/json", true );
require "../../../../config_conn.inc.php";

require_once "../../lib/ipmt_ppmt_for_success_project.php";

/* Connect to DB */
$status = false;
$emsg = '';
$all_loan_accounts = array();

try
{
    $dbh = new PDO($DB_connection_array['finance']['driver_name'].':host='.$DB_connection_array['finance']['host'].';dbname='.$DB_connection_array['finance']['db_name'], $DB_connection_array['finance']['user_name'], $DB_connection_array['finance']['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->exec("SET NAMES 'utf8';");
}
catch (PDOException $e) {
    error("Can't connect to database. ".$e->getMessage().' (Error 1021)' );
}


try
{
    $uid = $_SESSION['userid'];
    /* Get loan accounts data of the user */
    $query_string = 'SELECT  `account_id` as `aid`, `account_type` as `atype`,`account_name` as `aname`, `account_balance` as `balance`, `year_rate` as `yrate`, `time_length` as `tlength`, `time_length_unit` as `tlengthunit`, `start_date` as `dstart`, `money` FROM `accounts` WHERE `user_id`=? AND `account_type`=4 ORDER BY  `created`';
    $query = $dbh->prepare( $query_string );
    $query->execute( array( $uid ) );
    $all_loan_accounts = $query->fetchAll( PDO::FETCH_ASSOC );

    if ($all_loan_accounts)
    {
        foreach ($all_loan_accounts as $key => $account) {
            $tmonthlength = 0;
            switch ($account["tlengthunit"])
            {
                case 0:
                    $tmonthlength = $account["tlength"] * 12;
                    break;
                case 1:
                    $tmonthlength = $account["tlength"];
                    break;
                case 2:
                    $tmonthlength = ceil($account["tlength"] / 4);
                    break;
            }



            $start_date = $account["dstart"];
            if ($account["money"] != $account["balance"])
            {
                $org_account_ppmt = new PpmtLoanMoneyForSuccessProject($account["money"], $account["yrate"], $tmonthlength, $account["dstart"]);

                $start_date = new DateTime();
                $end_date = new DateTime($org_account_ppmt->get_target_date($tmonthlength));

                $diff = date_diff($start_date, $end_date);
                $tmonthlength =  $diff->format("%y") * 12 +  $diff->format("%m");

                $start_date = date_format($start_date,"Y-m-d");
            }

            $account_ppmt = new PpmtLoanMoneyForSuccessProject($account["balance"], $account["yrate"], $tmonthlength, $start_date);
            $all_loan_accounts[$key]['tmonthlength'] = $tmonthlength;
            $all_loan_accounts[$key]['pmt'] = $account_ppmt->get_pmt();
            $all_loan_accounts[$key]['deadline_time'] = $account_ppmt->get_target_date($tmonthlength);
            $all_loan_accounts[$key]['total_interest'] = $account_ppmt->get_total_interest();
            $all_loan_accounts[$key]['data'] = $account_ppmt->get_all_period_data();
            $all_loan_accounts[$key]["dstart"] = $start_date;
        }

        $status = true;
    }
    else
    {
        $emsg = "請至帳戶管理新增一個債務帳戶";
    }
}
catch (PDOException $e)
{
  echo $e->getMessage();
  exit();
}

$result = array('status' => $status, 'result' => $all_loan_accounts, 'emsg' => $emsg);
echo json_encode ($result);

?>



