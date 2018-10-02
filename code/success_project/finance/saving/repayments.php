<?php // xing modify file ?>

<?php
if ( 1 )
{
	ini_set('display_errors',1);
	error_reporting(E_ALL);
}


require_once "lib/ipmt_ppmt_for_success_project.php";

$uid = $_SESSION['userid'];

$the_last_plan = null;
$str_the_last_plan_sequence = '';
$str_the_last_plan_transfer_amount = '';
$str_the_last_plan_reduce_budget = '';
$str_the_last_plan_analytic_result = array();
$str_block_4_table_tbody = '';   //縮減預算
$str_the_last_plan_selected_account_table = '';
$str_the_last_plan_detail_table = '';



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


function selected_accounts_html($accounts)
{
    $account_types = array( '銀行帳戶', '信用卡', '投資帳戶', '資產', '貸款' );
    $html = '';
    $html .= '<table class="saving_table">
                    <thead>
                        <tr>
                            <th class="thead" style="padding: 5px 10px;">順序</th>
                            <th class="thead" style="padding: 5px 10px;">種類</th>
                            <th class="thead" style="width: 100px;padding: 5px 10px;">名稱</th>
                            <th class="thead" style="width: 100px;padding: 5px 10px;">債款餘額</th>
                            <th class="thead" style="padding: 5px 10px;">年利率</th>
                        </tr>
                    </thead>
                    <tbody class="twoColorRow repayment_tbody">
                    ';

    for ($i = 0; $i < count($accounts); $i++)
    {
        $html .= "<tr style='text-align: center;'>";
        $html .= "<td>" . ($i + 1) . "</td>";
        $html .= "<td>" . $account_types[$accounts[$i]["atype"]] . "</td>";
        $html .= "<td>" . $accounts[$i]["aname"] . "</td>";
        $html .= "<td>$" . number_format(round($accounts[$i]["balance"])) . "</td>";
        $html .= "<td>" . round($accounts[$i]["yrate"], 2) . "%</td>";
        $html .= "</tr>";
    }

    $html .= '<tr class="div_data_table_tail" style="height: 5px;"><td colspan="5"></td></tr></tbody></table>';

    return ($html);
}


function mk_chart_data($old_data, $new_data)
{
    $amounts = array();
    $old_amounts = array();
    $new_amounts = array();
    $dates = array();

    $old_data_length = count($old_data);
    $new_data_length = count($new_data);

    $first_month = date_create($old_data[0]["date"]);
    $last_month = date_create($old_data[$old_data_length - 1]["date"]);

    $diff = date_diff($first_month, $last_month);
    $diff_total_months = $diff->format("%y") * 12 + $diff->format("%m");


    $spacing = 1;
    if (12 * 10 <= $diff_total_months)
    {
        $spacing = 12;
    }
    else if(12 * 3 <= $diff_total_months)
    {
        $spacing = 6;
    }

    for($i = 0; $i < $old_data_length; $i++)
    {
        if (0 == $i % $spacing || $i == ($old_data_length - 1))
        {
            array_push($old_amounts, round($old_data[$i]["remain"]));
            array_push($dates, date_format(date_create($old_data[$i]["date"]), "Y-m"));
        }
    }

    if ($old_data[0]["remain"] != $new_data[0]["remain"])
    {
        for($i = 0; $i < $new_data_length; $i++)
        {
            if (0 == $i % $spacing || $i == ($new_data_length - 1))
            {
                array_push($new_amounts, round($new_data[$i]["remain"]));
            }
        }
    }

    //$amounts = array($old_amounts, $new_amounts);

    return (array(
      //amounts => $amounts,
      "old_amounts" => $old_amounts,
      "new_amounts" => $new_amounts,
      "dates" => $dates
    ));
}

function analytic_result_html($old_data, $new_data)
{
    $chart_data = mk_chart_data($old_data["data"], $new_data["data"]);
    $id = 'analytic_result_' . $old_data["aid"];

    $s_dates = implode('","', $chart_data["dates"]);
    $s_old_amounts = implode(',', $chart_data["old_amounts"]);
    $s_old_amounts .= (0 < count($chart_data["old_amounts"])) ? ', null' : '';
    $s_new_amounts = implode(',', $chart_data["new_amounts"]);
    $s_new_amounts .= (0 < count($chart_data["new_amounts"])) ? ', null' : '';

    return ('
      <script>
        $( document ).ready(function() {
          twicelinechart(
            "' . $id . '",
            ["Original", "New"],
            [[' . $s_old_amounts . '], [' . $s_new_amounts . ']],
            ["' . $s_dates . '"],
            "債務",
            "時間",
            10
          );
        });
      </script>
      <div>
        <div id="' . $id . '" style="clear: right;"></div>
        <table  class="repayment_line-height" style="margin: 20px 0; float: right; min-width: 600px;">
            <tr>
                <td colspan="5"><h4>' . $new_data["aname"] .'</h4></td>
            </td>
            <tr>
                <td colspan="2" style="border-left: 1px solid black; padding-left: 10px;">舊計畫</td>
                <td>&nbsp&nbsp</td>
                <td colspan="2" style="border-left: 1px solid #BE0200; padding-left: 10px;">新計畫</td>
            </tr>
            <tr>
                <td style="border-left: 1px solid black; padding-left: 10px;">每月繳款金額</td>
                <td style="text-align: right;">$' . number_format(round($old_data['pmt'])) . '</td>
                <td>&nbsp&nbsp</td>
                <td style="border-left: 1px solid #BE0200; padding-left: 10px;">每月繳款金額</td>
                <td style="text-align: right;">$' . number_format(round($new_data['pmt'])) . '</td>
            </tr>
            <tr>
                <td style="border-left: 1px solid black; padding-left: 10px;">還清日期</td>
                <td style="text-align: right;">' . $old_data['deadline_time'] . '</td>
                <td>&nbsp&nbsp</td>
                <td style="border-left: 1px solid #BE0200; padding-left: 10px;">還清日期</td>
                <td style="text-align: right;">' . $new_data['deadline_time'] . '</td>
            </tr>
            <tr>
                <td style="border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px; padding-bottom: 10px;">利息總計</td>
                <td style="border-bottom: 1px solid black; text-align: right; padding-bottom: 10px;">$' . number_format(round($old_data['total_interest'])) . '</td>
                <td>&nbsp&nbsp</td>
                <td style="border-left: 1px solid #BE0200; border-bottom: 1px solid #BE0200; padding-left: 10px; padding-bottom: 10px;">利息總計</td>
                <td style="border-bottom: 1px solid #BE0200; text-align: right; padding-bottom: 10px;">$' . number_format(round($new_data['total_interest'])) . '</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;">每月繳款金額: $'. number_format(round($new_data["pmt"])) .'</td>
            </tr>
            <tr>
                <td width="100"></td>
                <td style="min-width: 125px;"></td>
                <td width="20"></td>
                <td width="100"></td>
                <td style="text-align: right; min-width: 125px;">節省利息: $' . number_format(round($old_data["total_interest"] - $new_data["total_interest"])) . '</td>
            </tr>
        </table>
      </div>
    ');
}


function detail_table_html($accounts)
{
    $html = '';
    //$first_date = '9999-12-31';
    $i_accounts_count = count($accounts);
    $month_combo = array();

/*
    foreach ($accounts as $key => $account) {
        $d1 = new DateTime($first_date);
        $d2 = new DateTime($account["dstart"]);

        $first_date = ($d1 > $d2) ? $account["dstart"] : $first_date;
    }
*/

    foreach ($accounts as $key => $account) {
        $account_name = $account['aname'];
        $pmt = $account['pmt'];

        foreach ($account["data"] as $key => $data)
        {
            $datetime = new DateTime($data['date']);

            if ($datetime)
            {
                $month_key = $datetime->format('Y-m');

                if (!array_key_exists($month_key, $month_combo))
                {
                    $month_combo[$month_key] = array();
                }

                if ($month_key <= $account["deadline_time"])
                {
                    array_push($month_combo[$month_key], array("name" => $account_name, "pmt" => $pmt, "data" => $data));
                }

            }
        }
    }

    $html = '';
    $html .= '<div id="detail_top_block" class="detail_top_block">
                <div class="detail_row repayment_detail_row">
                  <span class="repayment_detail_span" style="text-align:left; padding-left:16px; width:100px;">名稱</span>
                  <span class="repayment_detail_span" style="font-size:12px;">償還本金</span>
                  <span class="repayment_detail_span" style="font-size:12px;">償還利息</span>
                  <span class="repayment_detail_span" style="font-size:12px;">償還本息</span>
                  <span class="repayment_detail_span" style="font-size:12px;">貸款餘額</span>
                </div>
              </div>';

    //$i_show_months_data = 4;
    //$detail_height = (count($accounts) * 24 + 72) * $i_show_months_data + 24;
    $detail_height = 475;
    $html .= '<div id="detail_block" class="detail_block" style="height:' . $detail_height . 'px;width:700px;">';


    $i_count_month = 0;
    $i_month_combo_total = count($month_combo);

    ksort($month_combo);
    foreach ($month_combo as $month_key => $month_value) {
        if (1 > count($month_value))
        {
            continue;
        }

        $html .= '<div class="detail_row repayment_detail_row">
                    <span class="repayment_detail_span" style="text-align:left; padding-left:16px; width:100px;"><b>' . $month_key . '</b></span>
                    <span class="repayment_detail_span"></span>
                    <span class="repayment_detail_span"></span>
                    <span class="repayment_detail_span"></span>
                    <span class="repayment_detail_span"></span>
                </div>';


        $total_ppmt = 0;
        $total_ipmt = 0;
        $total_ppmt_and_ipmt = 0;
        $total_balance = 0;

        foreach ($month_value as $sub_key => $sub_value) {
            $ppmt = round($sub_value["data"]["ppmt"]);
            $total_ppmt += $ppmt;
            $ipmt = round($sub_value["data"]["ipmt"]);
            $total_ipmt += $ipmt;
            $ppmt_and_ipmt = round($sub_value["data"]["ppmt"] + $sub_value["data"]["ipmt"]);
            $total_ppmt_and_ipmt += $ppmt_and_ipmt;
            $balance = abs(round($sub_value["data"]["remain"]));
            $total_balance += $balance;

            $html .= '<div class="detail_row repayment_detail_row">
                    <span class="repayment_detail_span" style="text-align:left; padding-left:16px; width:100px;"><b>' . $sub_value["name"] . '</b></span>
                    <span class="repayment_detail_span">' . number_format($ppmt) . '</span>
                    <span class="repayment_detail_span">' . number_format($ipmt) . '</span>
                    <span class="repayment_detail_span">' . number_format($ppmt_and_ipmt) . '</span>
                    <span class="repayment_detail_span">' . number_format($balance) . '</span>
                </div>';
        }

        $html .= '<div class="detail_row repayment_detail_row">
                <span class="repayment_detail_span" style="text-align:left; padding-left:16px; width:100px;"><b>總計</b></span>
                <span class="repayment_detail_span">' . number_format($total_ppmt) . '</span>
                <span class="repayment_detail_span">' . number_format($total_ipmt) . '</span>
                <span class="repayment_detail_span">' . number_format($total_ppmt_and_ipmt) . '</span>
                <span class="repayment_detail_span">' . number_format($total_balance) . '</span>
            </div>';


        if(++$i_count_month != $i_month_combo_total)
        {
            $html .= '<div class="detail_row repayment_detail_row">
                    <span class="repayment_detail_span"></span>
                    <span class="repayment_detail_span"></span>
                    <span class="repayment_detail_span"></span>
                    <span class="repayment_detail_span"></span>
                    <span class="repayment_detail_span"></span>
                </div>';

        }
    }


    $html .= '</div>';

    return ($html);
}


function block_4_table_tbody_html($bills_class_json)
{
  $html = '';
  foreach ($bills_class_json as $class_value) {
    if ('支出' == $class_value->name)
    {
      $subclass = $class_value->subclass;

      foreach ($subclass as $sub_class_value) {
        $total_budget = 0;

        $sub_sub_class = $sub_class_value->subclass;
        foreach ($sub_sub_class as $sub_sub_class_value) {
          if (isset($sub_sub_class_value->budget))
          {
            $total_budget += $sub_sub_class_value->budget;
          }
        }

        $html .= "<tr>
          <td>{$sub_class_value->name}</td>
          <td>" . number_format($total_budget) . "</td>
          <td><input class='block_4_reduce_input' onkeyup='calculate_reduce_budget()' style='text-align: right;' /></td>
          </tr>";
      }
    }
  }
  return ($html);
}


try
{
  /* Get repayment_plans data of the user */
  $query_string = 'SELECT * FROM `repayment_plans` WHERE `user_id`=? ORDER BY id DESC LIMIT 1';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid ) );
  $query_result = $query->fetchAll( PDO::FETCH_ASSOC );

  if ($query_result)
  {
      $the_last_plan = $query_result[0];

      $old_repayment_data  = json_decode($the_last_plan['old_repayment_data'], true);
      $new_repayment_data  = json_decode($the_last_plan['new_repayment_data'], true);


      foreach ($old_repayment_data as $key => $value) {
          $result = new PpmtLoanMoneyForSuccessProject($value["balance"], $value["yrate"], $value['tmonthlength'], $value["dstart"]);
          $old_repayment_data[$key]['data'] = $result->get_all_period_data();
      }

      foreach ($new_repayment_data as $key => $value) {
          $result = new PpmtLoanMoneyForSuccessProject($value["balance"], $value["yrate"], $value['tmonthlength'], $value["dstart"]);
          $new_repayment_data[$key]['data'] = $result->get_all_period_data();


          if (0 == ($new_repayment_data[$key]['data'][0]["remain"]))
          {
              $new_repayment_data[$key]['deadline_time'] = date('Y-m', strtotime($the_last_plan['created']));
          }
      }

      for ($i_loan_account = 0; $i_loan_account < count($new_repayment_data); $i_loan_account++)
      {
          $str_the_last_plan_sequence .= (string)($i_loan_account + 1) . '.' . $new_repayment_data[$i_loan_account]['aname'] . '&nbsp&nbsp&nbsp';
          $str_the_last_plan_analytic_result[$i_loan_account] = analytic_result_html($old_repayment_data[$i_loan_account], $new_repayment_data[$i_loan_account]);
      }


      $str_the_last_plan_selected_account_table = selected_accounts_html($old_repayment_data);
      $str_the_last_plan_detail_table = detail_table_html($new_repayment_data);

      $str_the_last_plan_transfer_amount = "將$" . number_format($the_last_plan['transfer_amount']) . "繳給利率最高的債務";
      $str_the_last_plan_reduce_budget = "每月提撥出$" . number_format($the_last_plan['reduce_budget']) . "來還債(此項僅為建議,不列入公式計算)";
  }
}
catch (PDOException $e)
{
  echo $e->getMessage();
  exit();
}

if (!$the_last_plan)
{
  /* Get all loan accounts */
  try
  {
    /* Get loan accounts data of the user */
    $query_string = 'SELECT  `account_id` as `aid`, `account_type` as `atype`,`account_name` as `aname`, `account_balance` as `balance`, `year_rate` as `yrate` FROM `accounts` WHERE `user_id`=? AND `account_type`=4 ORDER BY  `created`';
    $query = $dbh->prepare( $query_string );
    $query->execute( array( $uid ) );
    $all_loan_accounts = $query->fetchAll( PDO::FETCH_ASSOC );
    if ( !$all_loan_accounts )
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
}



try
{
  /* Get bills_class of the user */
  $query_string = 'SELECT  `class` FROM `bills_class` WHERE `user_id`=? ORDER BY `version` DESC LIMIT 1';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid ) );
  $result = $query->fetchAll( PDO::FETCH_ASSOC );
  $bills_class_json = json_decode($result[0]['class']);
  $str_block_4_table_tbody = block_4_table_tbody_html($bills_class_json);
}
catch (PDOException $e)
{
  echo $e->getMessage();
  exit();
}





?>


<?php include_once('repayments_view.php'); ?>
