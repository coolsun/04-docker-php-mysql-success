<?php // modify file ?>
<?php if(empty($_GET["only_main_content"])){ ?>
  <script src="js/charts/highstock.js"></script>
  <script src="js/charts/chartslib.js"></script>
<?php } ?>
<script type="text/javascript" src="finance/js/number_format.js"></script>
<link href="finance/css/saving.css" rel="stylesheet" />

<!-- popup windows -->
<div style="display:none;">
    <a id="alert_show" href="#alert_window" style="display:none;" >#</a>
    <div id="alert_window">
        <div class='page-outer repayment_page-outer' style='width: 250px; height: 95px;'>
            <div class='normal-inner'>
              <p id="alert_msg"></p>
            </div>
            <div id="primary-action">
                <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="確 定" />
            </div>
        </div>
    </div>

    <a id="repayment_add_block_0_show" href="#repayment_add_block_0" style="display:none;" >#</a>
    <div id="repayment_add_block_0">
        <div class='page-outer repayment_page-outer' style='width: 450px; height: 350px;'>
            <div class='normal-inner'>
                 <p>請勾選欲加入還債計畫的選項</p>

                 <div  style="max-height: 250px; overflow: hidden; overflow-y: scroll;">
                   <table id="" class="div_data_table saving_table">
                      <thead>
                          <tr>
                              <th class="thead" width="40px">選項</th>
                              <th class="thead">種類</th>
                              <th class="thead">名稱</th>
                              <th class="thead" width="115px">債款餘額</th>
                              <th class="thead" width="75px">年利率</th>
                          </tr>
                      </thead>
                      <tbody id="repayment_add_block_0_tbody" class="twoColorRow repayment_tbody">
                      </tbody>
                  </table>
                </div>
                <div class="div_data_table_tail center"></div>
            </div>
            <div id="primary-action">
                <input id="repayment_add_block_0_next_btn" class="btn func-btn" type="button" value="下一步" onclick="repayment_add_block_0_btn_action('next')"></input>
            </div>
        </div>
    </div>


    <a id="repayment_add_block_1_show" href="#repayment_add_block_1" style="display:none;" >#</a>
    <div id="repayment_add_block_1">
        <div class='page-outer repayment_page-outer' style='width: 450px; height: 350px;'>
            <div class='normal-inner'>
                <label id="total_payments_balance"></label>

                <div  style="max-height: 250px; overflow: hidden; overflow-y: scroll;">
                  <table id="" class="div_data_table saving_table">
                      <thead>
                          <tr>
                              <th class="thead">種類</th>
                              <th class="thead">名稱</th>
                              <th class="thead">債款餘額</th>
                              <th class="thead">年利率</th>
                          </tr>
                      </thead>
                      <tbody id="repayment_add_block_1_tbody" class="twoColorRow repayment_tbody">
                      </tbody>
                  </table>
                </div>
                <div class="div_data_table_tail center"></div>
            </div>
            <div id="primary-action">
                <input id="repayment_add_block_1_last_btn" class="btn func-btn" type="button" value="上一步" onclick="repayment_add_block_1_btn_action('last')"></input>
                <input id="repayment_add_block_1_next_btn" class="btn func-btn" type="button" value="下一步" onclick="repayment_add_block_1_btn_action('next')"></input>
            </div>
        </div>
    </div>


    <a id="repayment_add_block_2_show" href="#repayment_add_block_2" style="display:none;" >#</a>
    <div id="repayment_add_block_2">
        <div class='page-outer repayment_page-outer' style='width: 450px; height: 350px;'>
            <div class='normal-inner'>
                <p>優先順序: 利率高的先償清</p>
                <div  style="max-height: 250px; overflow: hidden; overflow-y: scroll;">
                  <table id="" class="div_data_table saving_table">
                      <thead>
                          <tr>
                              <th class="thead">順序</th>
                              <th class="thead">種類</th>
                              <th class="thead">名稱</th>
                              <th class="thead">債款餘額</th>
                              <th class="thead">年利率</th>
                          </tr>
                      </thead>
                      <tbody id="repayment_add_block_2_tbody" class="twoColorRow repayment_tbody">
                      </tbody>
                  </table>
                </div>
                <div class="div_data_table_tail center"></div>
            </div>
            <div id="primary-action">
                <input id="repayment_add_block_2_last_btn" class="btn func-btn" type="button" value="上一步" onclick="repayment_add_block_2_btn_action('last')"></input>
                <input id="repayment_add_block_2_next_btn" class="btn func-btn" type="button" value="下一步" onclick="repayment_add_block_2_btn_action('next')"></input>
            </div>
        </div>
    </div>

    <a id="repayment_add_block_3_show" href="#repayment_add_block_3" style="display:none;" >#</a>
    <div id="repayment_add_block_3">
        <div class='page-outer repayment_page-outer' style='width: 450px; height: 350px;'>
            <div class='normal-inner'>
                <div style="border-bottom: dashed 1px;">
                    <p>一次償還:</p>
                    <div>從現有流動資金的帳戶內挪出一筆可用的金額來繳交利率最高的債務(僅此一次)</div>
                </div>
                <br />
                <div id="repayment_add_block_3_table_div" style="max-height: 185px; overflow: hidden; overflow-y: scroll;"></div>
                <div>
                  <p>預計調撥金額: <input id="repayment_add_block_3_transfer_amount" style='text-align: right;' /></p>
                </div>
            </div>
            <div id="primary-action">
                <input id="repayment_add_block_3_last_btn" class="btn func-btn" type="button" value="上一步" onclick="repayment_add_block_3_btn_action('last')"></input>
                <input id="repayment_add_block_3_next_btn" class="btn func-btn" type="button" value="下一步" onclick="repayment_add_block_3_btn_action('next')"></input>
            </div>
        </div>
    </div>

    <a id="repayment_add_block_4_show" href="#repayment_add_block_4" style="display:none;" >#</a>
    <div id="repayment_add_block_4">
        <div class='page-outer repayment_page-outer' style='width: 450px; height: 350px;'>
            <div class='normal-inner'>
                <p>縮減預算:</p>
                <p>縮減每個月支出預算，以提撥部分金額出來還債</p>

                <div  style="max-height: 200px; overflow: hidden; overflow-y: scroll;">
                  <table id="" class="div_data_table saving_table">
                      <thead>
                          <tr>
                              <th class="thead">項目</th>
                              <th class="thead">每月預算</th>
                              <th class="thead">提撥金額</th>
                          </tr>
                      </thead>
                      <tbody id="repayment_add_block_4_tbody" class="twoColorRow repayment_tbody">
                        <?php echo $str_block_4_table_tbody; ?>
                      </tbody>
                  </table>
                </div>
                <div class="div_data_table_tail center"></div>

                <p style="text-align: right;">每月可提撥金額: <span id="total_reduce_budget"></span></p>
            </div>
            <div id="primary-action">
                <input id="repayment_add_block_4_last_btn" class="btn func-btn" type="button" value="上一步" onclick="repayment_add_block_4_btn_action('last')"></input>
                <input id="repayment_add_block_4_next_btn" class="btn func-btn" type="button" value="下一步" onclick="repayment_add_block_4_btn_action('next')"></input>
            </div>
        </div>
    </div>

    <a id="repayment_add_block_5_show" href="#repayment_add_block_5" style="display:none;" >#</a>
    <div id="repayment_add_block_5">
        <div class='page-outer repayment_page-outer' style='width: 700px; height: 530px;'>
            <div class='normal-inner'>
                <table>
                    <tr>
                        <td colspan="5"><div id="repayment_add_block_5_chart"></div><p id="repayment_add_block_5_aname"></p></td>
                    </td>
                    <tr>
                        <td colspan="2" style="border-left: 1px solid black; padding-left: 10px;">舊計畫</td>
                        <td>&nbsp&nbsp</td>
                        <td colspan="2" style="border-left: 1px solid #BE0200; padding-left: 10px;">新計畫</td>
                    </tr>
                    <tr>
                        <td style="border-left: 1px solid black; padding-left: 10px;">每月繳款金額</td>
                        <td id="repayment_add_block_5_month_pay_old" style="text-align: right;"></td>
                        <td>&nbsp&nbsp</td>
                        <td style="border-left: 1px solid #BE0200; padding-left: 10px;">每月繳款金額</td>
                        <td id="repayment_add_block_5_month_pay_new" style="text-align: right;"></td>
                    </tr>
                    <tr>
                        <td style="border-left: 1px solid black; padding-left: 10px;">還清日期</td>
                        <td id="repayment_add_block_5_dead_line_old" style="text-align: right;"></td>
                        <td>&nbsp&nbsp</td>
                        <td style="border-left: 1px solid #BE0200; padding-left: 10px;">還清日期</td>
                        <td id="repayment_add_block_5_dead_line_new" style="text-align: right;"></td>
                    </tr>
                    <tr>
                        <td style="border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px; padding-bottom: 10px;">利息總計</td>
                        <td id="repayment_add_block_5_total_interest_old" style="border-bottom: 1px solid black; text-align: right; padding-bottom: 10px;"></td>
                        <td>&nbsp&nbsp</td>
                        <td style="border-left: 1px solid #BE0200; border-bottom: 1px solid #BE0200; padding-left: 10px; padding-bottom: 10px;">利息總計</td>
                        <td id="repayment_add_block_5_total_interest_new" style="border-bottom: 1px solid #BE0200; text-align: right; padding-bottom: 10px;"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td id="repayment_add_block_5_result_month_pay_msg" style="text-align: right;"></td>
                    </tr>
                    <tr>
                        <td width="15%"></td>
                        <td width="30%"></td>
                        <td></td>
                        <td width="15%"></td>
                        <td width="30%" id="repayment_add_block_5_result_total_interest" style="text-align: right;"></td>
                    </tr>
                </table>
            </div>
            <div id="primary-action" style="margin-top: 10px;">
                <input id="repayment_add_block_5_last_btn" class="btn func-btn" type="button" value="上一步" onclick="repayment_add_block_5_btn_action('last')"></input>
                <input id="repayment_add_block_5_next_btn" class="btn func-btn" type="button" value="下一步" onclick="repayment_add_block_5_btn_action('next')"></input>
                <input id="repayment_add_block_5_close_btn" class="btn func-btn" type="button" value="確認" onclick="save_plan();"></input>

            </div>
        </div>
    </div>

    <a id="repayment_add_block_loan_each_check_show" href="#repayment_add_block_loan_each_check" style="display:none;" >#</a>
    <div id="repayment_add_block_loan_each_check">
        <div class='page-outer repayment_page-outer' style='width: 450px; height: 350px;'>
            <div class='normal-inner'>

                <p>請確認以下資訊</p>
                <div>
                    <p>--------- <span id="repayment_add_block_loan_each_check_atype"></span> ---------</p>
                    <table style="width: 100%">
                      <tr>
                        <td>帳戶名稱:</td>
                        <td style="text-align: right; padding-right: 90px;"><span id="repayment_add_block_loan_each_check_account"></span></td>
                      </tr>
                      <tr>
                        <td>貸款餘額:</td>
                        <td style="text-align: right; padding-right: 90px;"><span id="repayment_add_block_loan_each_check_balance"></span></td>
                      </tr>
                      <tr>
                        <td>貸款金額:</td>
                        <td style="text-align: right; padding-right: 90px;"><span id="repayment_add_block_loan_each_check_money"></span></td>
                      </tr>
                      <tr>
                        <td>貸款長度:</td>
                        <td style="text-align: right; padding-right: 90px;"><span id="repayment_add_block_loan_each_check_length"></span></td>
                      </tr>
                      <tr>
                        <td>開始日期:</td>
                        <td style="text-align: right; padding-right: 90px;"><span id="repayment_add_block_loan_each_check_start_date"></span></td>
                      </tr>
                      <tr>
                        <td>年利率:</td>
                        <td style="text-align: right; padding-right: 90px;"><span id="repayment_add_block_loan_each_check_yrate"></span></td>
                      </tr>
                      <tr>
                        <td>付款週期:</td>
                        <td style="text-align: right; padding-right: 90px;"><span id="repayment_add_block_loan_each_check_period"></span></td>
                      </tr>
                      <tr>
                        <td>目前每月繳款金額:</td>
                        <td style="text-align: right; padding-right: 90px;"><span id="repayment_add_block_loan_each_check_month_pay"></span></td>
                      </tr>
                    </table>
                </div>
            </div>
            <div id="primary-action">
                <input id="repayment_add_block_loan_each_check_last_btn" class="btn func-btn" type="button" value="上一步" onclick="repayment_add_block_loan_each_check_btn_action('last')"></input>
                <input id="repayment_add_block_loan_each_check_next_btn" class="btn func-btn" type="button" value="下一步" onclick="repayment_add_block_loan_each_check_btn_action('next')"></input>
            </div>
        </div>
    </div>

    <a id="repayment_add_block_loan_each_dead_line_show" href="#repayment_add_block_loan_each_dead_line" style="display:none;" >#</a>
    <div id="repayment_add_block_loan_each_dead_line">
        <div class='page-outer repayment_page-outer' style='width: 450px; height: 350px;'>
            <div class='normal-inner'>
                <div>
                    <p>這是您原始的還債進度</p>
                    <p>帳戶名稱: <span id="repayment_add_block_loan_each_dead_line_aname"></span></p>
                    <div style="width: 100%;">
                        <div style="border: 1px solid; padding: 5px; margin-top: 10px; float: left;">
                            <p>償清日期: <span id="repayment_add_block_loan_each_dead_line_time"></span></p>
                            <p>利息總計: <span id="repayment_add_block_loan_each_dead_line_rate_total"></span></p>
                        </div>
                    </div>
                    <div id="block_loan_each_dead_line_the_last_msg" style="border-top: 1px dashed; float: left; margin-top: 10px;">
                        <p>開啟還債計畫之後，將為您有效縮短還債的利息。</p>
                    </div>
                </div>
            </div>
            <div id="primary-action">
                <input id="repayment_add_block_loan_each_dead_line_last_btn" class="btn func-btn" type="button" value="上一步" onclick="repayment_add_block_loan_each_dead_line_btn_action('last')"></input>
                <input id="repayment_add_block_loan_each_dead_line_next_btn" class="btn func-btn" type="button" value="下一步" onclick="repayment_add_block_loan_each_dead_line_btn_action('next')"></input>
            </div>
        </div>
    </div>

    <a id="save_plan_result_show" href="#save_plan_result_window" style="display:none;" >#</a>
    <div id="save_plan_result_window">
        <div class='page-outer repayment_page-outer' style='width: 250px; height: 95px;'>
            <div class='normal-inner'>
              <p id="save_plan_result_msg"></p>
            </div>
            <div id="primary-action">
                <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="確 定" />
            </div>
        </div>
    </div>

    <div id="repayment_notice_window">
        <div class='page-outer repayment_page-outer' style='width: 350px; height: 130px;'>
            <div class='normal-inner'>
              <p id="repayment_notice_msg">此還債計畫公式採用一般銀行常用的年金法本息平均攤還法, 也就是年利率固定,每月繳款金額固定。</p>
            </div>
            <div id="primary-action">
                <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="確 定" />
            </div>
        </div>
    </div>
</div>



<!-- main content -->
<div class='log-inner'>
    <div class='log-switch'>
        <ul class='menu' style="right: 70px;">
          <?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
            <li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=finance&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
          <?php endforeach; ?>
        </ul>
    </div>
</div>


<?php
  if (!$the_last_plan){
?>
    <div class="repayment_list_block">
        <h3><span>債務清單</span></h3>

        <table id="" class="div_data_table saving_table">
            <thead>
                <tr>
                    <th class="thead">名稱</th>
                    <th class="thead">債款餘額</th>
                    <th class="thead" width="75px">年利率</th>
                </tr>
            </thead>
            <tbody id="repayment_list_tbody" class="twoColorRow repayment_tbody">
            <?php
                foreach ($all_loan_accounts as $index_loan_accounts => $loan_account) {
            ?>
                  <tr>
                      <td><?php echo $loan_account['aname'] ?></td>
                      <td>$<?php echo number_format($loan_account['balance']) ?></td>
                      <td><?php echo round($loan_account['yrate'], 2) ?> %</td>
                  </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
        <div class="div_data_table_tail center"></div>
    </div>
<?php
  }
  else{
?>
    <div class="repayment_list_block">
        <h3><span>債務清單</span></h3>
        <?php echo $str_the_last_plan_selected_account_table ?>
    </div>

    <div class="repayment_list_block">
        <h3><span>還債計畫</span></h3>
        <p class="repayment_line-height">優先順序: <?php echo $str_the_last_plan_sequence ?></p>
        <p class="repayment_line-height">一次償還: <?php echo $str_the_last_plan_transfer_amount ?></p>
        <p class="repayment_line-height">縮減預算: <?php echo $str_the_last_plan_reduce_budget ?></p>
    </div>

    <div class="repayment_list_block">
        <h3><span>結果分析</span></h3>
        <?php foreach($str_the_last_plan_analytic_result as $s_table)
            echo $s_table;
        ?>
    </div>

    <div class="repayment_list_block" style="clear: right; width: 700px;">
        <h3><span>繳款明細</span></h3>
        <?php echo $str_the_last_plan_detail_table ?>

    </div>
<?php
  }
?>

<!-- script -->
<script>
    var ac_types = ['銀行', '信用卡', '投資', '資產', '貸款'];
    var tlengthunits = ['年', '月', '日'];
    var repayment_obj = {};
    repayment_obj['all'] = [];
    repayment_obj['selected'] = [];
    repayment_obj['old'] = [];
    repayment_obj['new'] = [];
    var each_check_count = 0;
    var each_dead_line_count = 0;
    var each_block_5_count = 0;

    function ara_alert(msg) {
      $('#alert_msg').html(msg);
      $("#alert_show").trigger('click');
    }

    function mk_chart_data(old_data, new_data)
    {
        var amounts = [];
        var old_amounts = [];
        var new_amounts = [];
        var dates = [];

        first_month = new Date(old_data[0].date.replace(/\-/g, '/') + '/1');
        last_month = new Date(old_data[old_data.length - 1].date.replace(/\-/g, '/') + '/1');

        diff_year = last_month.getFullYear() - first_month.getFullYear();
        diff_month = last_month.getMonth() - first_month.getMonth();
        diff_total_months = diff_year * 12 + diff_month;


        var spacing = 1;
        if (12 * 10 <= diff_total_months)
        {
            spacing = 12;
        }
        else if(12 * 3 <= diff_total_months)
        {
            spacing = 6;
        }


        for(var i = 0; i < old_data.length; i++)
        {
            if (0 == i % spacing || i == (old_data.length - 1))
            {
                var sdate = old_data[i].date.replace(/\-/g, '/');
                var date = new Date(sdate + '/1');
                var year = date.getFullYear();
                var month = date.getMonth() + 1;
                sdate = year + '-'  + month;

                old_amounts.push(Math.round(old_data[i].remain));
                dates.push(sdate);
            }
        }

        old_amounts.push(null);

        if (old_data[0].remain != new_data[0].remain)
        {
            for(var i = 0; i < new_data.length; i++)
            {
                if (0 == i % spacing || (i == (new_data.length - 1)))
                {
                    new_amounts.push(Math.round(new_data[i].remain));
                }
            }

            new_amounts.push(null);
        }

        amounts = [old_amounts, new_amounts];

        return ({
          amounts: amounts,
          dates: dates
        });
    }

    function calculate_reduce_budget()
    {
        var inputs = $(".block_4_reduce_input");
        var total_reduce_budget = 0;

        for(var i = 0; i < inputs.length; i++)
        {
            var value = parseInt($(inputs[i]).val());
            total_reduce_budget += value ? value : 0;
        }

        $("#total_reduce_budget").text(number_format(total_reduce_budget));

        return(total_reduce_budget);
    }

    function ajax_get_loan_accounts_list_to_block_0()
    {
        $.ajax({
            url: 'finance/saving/saving_functions/repayments/get_loan_accounts_list.php',
            data: {},
            type: 'post',
            dataType: "json",
            success: function(data) {
                if (!data.status)
                {
                    ara_alert(data.emsg);
                }
                else if (data.result)
                {
                    repayment_obj['all'] = data.result;
                    var sHtml = '';
                    $("#repayment_add_block_0_show").trigger('click');

                    for (var i = 0; i < repayment_obj['all'].length; i++)
                    {
                      //選項  種類  名稱  債款餘額  年利率
                      sHtml += "<tr>";
                      sHtml += "<td style='text-align: center;'><input type='checkbox' name='checkbox_repayments' value='" + repayment_obj['all'][i].aid + "' /></td>";
                      sHtml += "<td style='text-align: center;'>" + ac_types[repayment_obj['all'][i].atype] + "</td>";
                      sHtml += "<td style='text-align: center;'>" + repayment_obj['all'][i].aname + "</td>";
                      sHtml += "<td style='text-align: right;'>$" + number_format(repayment_obj['all'][i].balance) + "</td>";
                      sHtml += "<td style='text-align: right;'>" + (Math.round(repayment_obj['all'][i].yrate * 100 ) / 100) + "%</td>";
                      sHtml += "</tr>";
                    }

                    $("#repayment_add_block_0_tbody").html(sHtml);

                };
            },
            error: function() {
                console.log('error');
            }
        });

    }

    function ajax_get_avbl_balances_list_to_block_3()
    {
        $.ajax({
            url: 'finance/saving/saving_functions/repayments/get_avbl_balances_list.php',
            data: {},
            type: 'post',
            dataType: "json",
            success: function(data) {
                if (!data.status)
                {
                    ara_alert(data.emsg);
                }
                else if (data.result)
                {
                    balance_accounts = data.result;

                    var actype_0_list = [];
                    var actype_2_list = [];
                    var table_html = '';

                    for (var i = 0; i < balance_accounts.length; i++)
                    {
                        if (0 == balance_accounts[i].atype)
                        {
                            actype_0_list.push(balance_accounts[i]);
                        }
                        else if (2 == balance_accounts[i].atype)
                        {
                            actype_2_list.push(balance_accounts[i]);
                        }
                    }


                    table_html += '<table style="width: 100%;">';

                    var balance_total = 0;

                    if (0 < actype_0_list.length)
                    {
                        table_html += '<tr><td style="width: 150px;"><span style="border-bottom: 1px solid #B3B3B3;"><b>一般帳戶:</b></span></td><td></td></tr>' ;

                        for (var i = 0; i < actype_0_list.length; i++)
                        {
                            table_html += '<tr>';
                            table_html += '<td style="width: 150px;">';
                            table_html += actype_0_list[i].aname;
                            table_html += ': </td>';
                            table_html += '<td style="text-align: right;">$';
                            table_html += number_format(actype_0_list[i].balance);
                            table_html += '</td>';
                            table_html += '</tr>';

                            balance_total += parseInt(actype_0_list[i].balance);
                        }
                    }

                    if (0 < actype_2_list.length)
                    {
                        table_html += '<tr><td style="width: 150px;"><span style="border-bottom: 1px solid #B3B3B3;"><b>投資帳戶:</b></span></td><td></td></tr>' ;

                        for (var i = 0; i < actype_2_list.length; i++)
                        {
                            table_html += '<tr>';
                            table_html += '<td style="width: 150px;">';
                            table_html += actype_2_list[i].aname;
                            table_html += ': </td>';
                            table_html += '<td style="text-align: right;">$';
                            table_html += number_format(actype_2_list[i].balance);
                            table_html += '</td>';
                            table_html += '</tr>';

                            balance_total += parseInt(actype_2_list[i].balance);
                        }
                    }

                    table_html += '<tr style="border-top: 1px solid #B3B3B3;"><td style="width: 150px;"><span><b>總計:</b></span></td><td style="text-align: right;">$' + number_format(balance_total) + '</td></tr>' ;
                    table_html += '</table>';
                    $("#repayment_add_block_3_table_div").html(table_html);


                };
            },
            error: function() {
                console.log('error');
            }
        });
    }

    function block_1_data_show()
    {
        repayment_obj['selected'] = [];
        repayment_obj['old'] = [];
        var selectedCheckboxRepayments = $('input[name="checkbox_repayments"]:checked');
        var block_1_tbody = $("#repayment_add_block_1_tbody")

        if (selectedCheckboxRepayments.length)
        {
            var aids = [];
            selectedCheckboxRepayments.each(function() {
                aids.push(this.value);
            });

            var sTBodyHtml = '';
            var total_balance = 0;

            for (var i_obj = 0; i_obj < repayment_obj['all'].length; i_obj++)
            {
                for (var i_aid = 0; i_aid < aids.length; i_aid++)
                {
                    if (parseInt(repayment_obj['all'][i_obj].aid) == parseInt(aids[i_aid]))
                    {
                        repayment_obj['selected'].push(repayment_obj['all'][i_obj]);
                        repayment_obj['old'].push(repayment_obj['all'][i_obj]);

                        total_balance += parseFloat(repayment_obj['all'][i_obj].balance);
                        sTBodyHtml += "<tr>";
                        sTBodyHtml += "<td style='text-align: center;'>" + ac_types[repayment_obj['all'][i_obj].atype] + "</td>";
                        sTBodyHtml += "<td style='text-align: center;'>" + repayment_obj['all'][i_obj].aname + "</td>";
                        sTBodyHtml += "<td style='text-align: right;'>$" + number_format(repayment_obj['all'][i_obj].balance) + "</td>";
                        sTBodyHtml += "<td style='text-align: right;'>" + (Math.round(repayment_obj['all'][i_obj].yrate * 100) / 100) + "%</td>";
                        sTBodyHtml += "</tr>";
                    }
                }
            }

            sTBodyHtml += "<tr>";
            sTBodyHtml += "<td style='text-align: center;'>總計</td>";
            sTBodyHtml += "<td></td>";
            sTBodyHtml += "<td style='text-align: right;'>$" + number_format(total_balance) + "</td>";
            sTBodyHtml += "<td></td>";
            sTBodyHtml += "</tr>";

            $("#total_payments_balance").text("你的總債務金額: " + number_format(total_balance));
            block_1_tbody.html(sTBodyHtml);

            $("#repayment_add_block_1_next_btn").show();
        }
        else
        {
            $("#total_payments_balance").text("未選擇貸款項目");
            $("#repayment_add_block_1_next_btn").hide();
        }
    }

    function block_2_data_show()
    {
        var block_2_tbody = $("#repayment_add_block_2_tbody");
        selected_length = repayment_obj['selected'].length;

        for (var i = 0; i < selected_length; i++)
        {
            for (var j = i; j < selected_length; j++)
            {
                if (parseFloat(repayment_obj['old'][i].yrate) < parseFloat(repayment_obj['old'][j].yrate))
                {
                    var tmp = repayment_obj['old'][i];
                    repayment_obj['old'][i] = repayment_obj['old'][j];
                    repayment_obj['old'][j] = tmp;
                }
            }
        }

        var  sTBodyHtml = '';
        for (var i = 0; i < selected_length; i++)
        {
            sTBodyHtml += "<tr>";
            sTBodyHtml += "<td style='text-align: center;'>" + (i + 1) + "</td>";
            sTBodyHtml += "<td style='text-align: center;'>" + ac_types[repayment_obj['old'][i].atype] + "</td>";
            sTBodyHtml += "<td style='text-align: center;'>" + repayment_obj['old'][i].aname + "</td>";
            sTBodyHtml += "<td style='text-align: right;'>$" + number_format(repayment_obj['old'][i].balance) + "</td>";
            sTBodyHtml += "<td style='text-align: right;'>" + (Math.round(repayment_obj['old'][i].yrate * 100) / 100) + "%</td>";
            sTBodyHtml += "</tr>";
        }

        block_2_tbody.html(sTBodyHtml);
    }

    function show_repayment_add() {
        ajax_get_loan_accounts_list_to_block_0();
    }

    function repayment_add_block_0_btn_action(do_what)
    {
        switch(do_what)
        {
            case 'next':
                $("#repayment_add_block_1_show").trigger('click');
                block_1_data_show();
                break;
        }
    }

    function repayment_add_block_1_btn_action(do_what)
    {
        switch(do_what)
        {
            case 'last':
                $("#repayment_add_block_0_show").trigger('click');

                break;
            case 'next':
                repayment_add_block_loan_each_check_btn_action('first');
                break;
        }
    }

    function repayment_add_block_2_btn_action(do_what)
    {
        switch(do_what)
        {
            case 'last':
                  repayment_add_block_loan_each_dead_line_btn_action('theLastOne');
                break;
            case 'next':
                ajax_get_avbl_balances_list_to_block_3();
                $("#repayment_add_block_3_show").trigger('click');
                break;
        }
    }

    function repayment_add_block_3_btn_action(do_what)
    {
        switch(do_what)
        {
            case 'last':
                $("#repayment_add_block_2_show").trigger('click');

                break;
            case 'next':
                $("#repayment_add_block_4_show").trigger('click');
                break;
        }
    }

    function repayment_add_block_4_btn_action(do_what)
    {
        switch(do_what)
        {
            case 'last':
                $("#repayment_add_block_3_show").trigger('click');

                break;
            case 'next':
                repayment_add_block_5_btn_action('first');
                break;
        }
    }

    function block_5_chart_show(old_data, new_data)
    {
      var chart_data = mk_chart_data(old_data, new_data);

      twicelinechart(
        'repayment_add_block_5_chart',
        ['Original', 'New'],
        chart_data['amounts'],
        chart_data['dates'],
        '債務',
        '時間',
        10
      );
    }

    function block_5_data(aname, old_pmt, new_pmt, old_dtime, new_dtime, old_total_interest, new_total_interest)
    {
        //$("#repayment_add_block_5_show").trigger('click');
        $("#repayment_add_block_5_month_pay_old").html('$' + number_format(Math.round(old_pmt)));
        $("#repayment_add_block_5_month_pay_new").html('$' + number_format(Math.round(new_pmt)));
        $("#repayment_add_block_5_dead_line_old").html(old_dtime);
        $("#repayment_add_block_5_dead_line_new").html(new_dtime);
        $("#repayment_add_block_5_total_interest_old").html('$' + number_format(Math.round(old_total_interest)));
        $("#repayment_add_block_5_total_interest_new").html('$' + number_format(Math.round(new_total_interest)));

        $("#repayment_add_block_5_result_month_pay_msg").html('每月繳款金額: $' + number_format(Math.round(new_pmt)));
        $("#repayment_add_block_5_result_total_interest").html('節省利息: $' + number_format(Math.round(old_total_interest - new_total_interest)));

        $("#repayment_add_block_5_aname").text(aname);

    }

    function repayment_add_block_5_btn_action(do_what)
    {
        //$("#repayment_add_block_5_chart").html('');

        switch(do_what)
        {
            case 'last':
                each_block_5_count--;

                if (0 > each_block_5_count)
                {
                    $("#repayment_add_block_4_show").trigger('click');
                }
                else
                {
                    block_5_data(repayment_obj['old'][each_block_5_count].aname, repayment_obj['old'][each_block_5_count].pmt, repayment_obj['new'][each_block_5_count].pmt,
                                repayment_obj['old'][each_block_5_count].deadline_time, repayment_obj['new'][each_block_5_count].deadline_time,
                                repayment_obj['old'][each_block_5_count].total_interest, repayment_obj['new'][each_block_5_count].total_interest);

                    block_5_chart_show(repayment_obj['old'][each_block_5_count].data, repayment_obj['new'][each_block_5_count].data);
                }

                break;
            case 'next':
                each_block_5_count++;

                if (each_block_5_count >= repayment_obj['selected'].length)
                {
                }
                else
                {
                    block_5_data(repayment_obj['old'][each_block_5_count].aname, repayment_obj['old'][each_block_5_count].pmt, repayment_obj['new'][each_block_5_count].pmt,
                                repayment_obj['old'][each_block_5_count].deadline_time, repayment_obj['new'][each_block_5_count].deadline_time,
                                repayment_obj['old'][each_block_5_count].total_interest, repayment_obj['new'][each_block_5_count].total_interest);

                    block_5_chart_show(repayment_obj['old'][each_block_5_count].data, repayment_obj['new'][each_block_5_count].data);
                }

                break;
            case 'first':
                repayment_obj['new'] = []
                each_block_5_count = 0;

                var transfer_amount = parseInt($("#repayment_add_block_3_transfer_amount").val());
                transfer_amount = transfer_amount ? transfer_amount : 0;

                for(var i = 0; i < repayment_obj['selected'].length; i++)
                {
                    repayment_obj['new'][i] = $.extend({}, repayment_obj['old'][i]);

                    if (transfer_amount >= 0)
                    {
                        if (repayment_obj['new'][i].balance > transfer_amount)
                        {
                            repayment_obj['new'][i].balance -= transfer_amount;
                            transfer_amount = 0;
                        }
                        else
                        {
                            transfer_amount -= repayment_obj['new'][i].balance;
                            repayment_obj['new'][i].balance = 0;
                        }

                    }
                    else
                    {
                        console.log('!!!!!!!! error block5 transfer amount');
                    }
                }

                $.ajax({
                    url: 'finance/saving/saving_functions/repayments/recalculate_new_impt.php',
                    data: {
                      data: JSON.stringify(repayment_obj['new'])
                    },
                    type: 'post',
                    dataType: "json",
                    success: function(data) {
                        if (!data.status)
                        {
                            ara_alert(data.emsg);
                        }
                        else if (data.result)
                        {
                            repayment_obj['new'] = data.result;

                            block_5_data(repayment_obj['old'][each_block_5_count].aname, repayment_obj['old'][each_block_5_count].pmt, repayment_obj['new'][each_block_5_count].pmt,
                                        repayment_obj['old'][each_block_5_count].deadline_time, repayment_obj['new'][each_block_5_count].deadline_time,
                                        repayment_obj['old'][each_block_5_count].total_interest, repayment_obj['new'][each_block_5_count].total_interest);

                            block_5_chart_show(repayment_obj['old'][each_block_5_count].data, repayment_obj['new'][each_block_5_count].data);

                            $("#repayment_add_block_5_show").trigger('click');
                        };
                    },
                    error: function() {
                        console.log('error');
                    }
                });

                break;
            case 'theLastOne':
                each_block_5_count = repayment_obj['selected'].length - 1;

                block_5_data(repayment_obj['old'][each_block_5_count].aname, repayment_obj['old'][each_block_5_count].pmt, repayment_obj['new'][each_block_5_count].pmt,
                            repayment_obj['old'][each_block_5_count].deadline_time, repayment_obj['new'][each_block_5_count].deadline_time,
                            repayment_obj['old'][each_block_5_count].total_interest, repayment_obj['new'][each_block_5_count].total_interest);

                block_5_chart_show(repayment_obj['old'][each_block_5_count].data, repayment_obj['new'][each_block_5_count].data);
                $("#repayment_add_block_5_show").trigger('click');
                break;
            default:
        }

        if (each_block_5_count >= repayment_obj['selected'].length - 1)
        {
            $('#repayment_add_block_5_next_btn').hide();
            $('#repayment_add_block_5_close_btn').show();

        }
        else
        {
            $('#repayment_add_block_5_next_btn').show();
            $('#repayment_add_block_5_close_btn').hide();
        }

    }

    function repayment_add_block_create_plan_btn_action(do_what)
    {
        switch(do_what)
        {
            case 'last':
                $("#repayment_add_block_5_show").trigger('theLastOne');
                break;
            case 'create':
                location.reload();
                break;
            default:
        }
    }

    function block_loan_each_check_data(atype, aname, balance, money, tlength, dstart, yrate, tlengthunit, pmt)
    {
        $("#repayment_add_block_loan_each_check_atype").html(ac_types[atype]);
        $("#repayment_add_block_loan_each_check_account").html(aname);
        $("#repayment_add_block_loan_each_check_balance").html('$' + number_format(balance));
        $("#repayment_add_block_loan_each_check_money").html('$' + number_format(money));
        $("#repayment_add_block_loan_each_check_length").html(tlength + tlengthunits[tlengthunit]);
        $("#repayment_add_block_loan_each_check_start_date").html(dstart);
        $("#repayment_add_block_loan_each_check_yrate").html((Math.round(yrate * 100) / 100) + '%');
        //$("#repayment_add_block_loan_each_check_period").html(tlengthunits[tlengthunit]);
        $("#repayment_add_block_loan_each_check_period").html('每月');
        $("#repayment_add_block_loan_each_check_month_pay").html('$' + number_format(Math.round(pmt)));
    }

    function repayment_add_block_loan_each_check_btn_action(do_what)
    {
        switch(do_what)
        {
            case 'last':
                each_check_count--;

                if (0 > each_check_count)
                {
                    $("#repayment_add_block_1_show").trigger('click');
                }
                else
                {
                    block_loan_each_check_data(repayment_obj['selected'][each_check_count].atype, repayment_obj['selected'][each_check_count].aname, repayment_obj['selected'][each_check_count].balance,
                                              repayment_obj['selected'][each_check_count].money, repayment_obj['selected'][each_check_count].tlength, repayment_obj['selected'][each_check_count].dstart,
                                              repayment_obj['selected'][each_check_count].yrate, repayment_obj['selected'][each_check_count].tlengthunit, repayment_obj['selected'][each_check_count].pmt);
                }

                break;
            case 'next':
                each_check_count++;

                if (each_check_count >= repayment_obj['selected'].length)
                {
                    repayment_add_block_loan_each_dead_line_btn_action('first');
                }
                else
                {
                    block_loan_each_check_data(repayment_obj['selected'][each_check_count].atype, repayment_obj['selected'][each_check_count].aname, repayment_obj['selected'][each_check_count].balance,
                                              repayment_obj['selected'][each_check_count].money, repayment_obj['selected'][each_check_count].tlength, repayment_obj['selected'][each_check_count].dstart,
                                              repayment_obj['selected'][each_check_count].yrate, repayment_obj['selected'][each_check_count].tlengthunit, repayment_obj['selected'][each_check_count].pmt);
                }

                break;
            case 'first':
                $("#repayment_add_block_loan_each_check_show").trigger('click');
                each_check_count = 0;

                block_loan_each_check_data(repayment_obj['selected'][each_check_count].atype, repayment_obj['selected'][each_check_count].aname, repayment_obj['selected'][each_check_count].balance,
                                          repayment_obj['selected'][each_check_count].money, repayment_obj['selected'][each_check_count].tlength, repayment_obj['selected'][each_check_count].dstart,
                                          repayment_obj['selected'][each_check_count].yrate, repayment_obj['selected'][each_check_count].tlengthunit, repayment_obj['selected'][each_check_count].pmt);

                break;
            case 'theLastOne':
                $("#repayment_add_block_loan_each_check_show").trigger('click');
                each_check_count = repayment_obj['selected'].length - 1;

                block_loan_each_check_data(repayment_obj['selected'][each_check_count].atype, repayment_obj['selected'][each_check_count].aname, repayment_obj['selected'][each_check_count].balance,
                                          repayment_obj['selected'][each_check_count].money, repayment_obj['selected'][each_check_count].tlength, repayment_obj['selected'][each_check_count].dstart,
                                          repayment_obj['selected'][each_check_count].yrate, repayment_obj['selected'][each_check_count].tlengthunit, repayment_obj['selected'][each_check_count].pmt);

                break;
            default:
        }
    }



    function block_loan_each_dead_line_data(aname, deadline_time, total_interest) {
        $("#repayment_add_block_loan_each_dead_line_aname").html(aname);
        $("#repayment_add_block_loan_each_dead_line_time").html(deadline_time);
        $("#repayment_add_block_loan_each_dead_line_rate_total").html('$' + number_format(Math.round(total_interest)));
    }

    function block_loan_each_dead_line_the_last_msg_show()
    {
      (each_dead_line_count == (repayment_obj['selected'].length - 1)) ? $("#block_loan_each_dead_line_the_last_msg").show() : $("#block_loan_each_dead_line_the_last_msg").hide();
    }

    function repayment_add_block_loan_each_dead_line_btn_action(do_what)
    {
        switch(do_what)
        {
            case 'last':
                each_dead_line_count--;

                if (0 > each_dead_line_count)
                {
                  repayment_add_block_loan_each_check_btn_action('theLastOne');
                }
                else
                {
                    block_loan_each_dead_line_data(repayment_obj['selected'][each_dead_line_count].aname, repayment_obj['selected'][each_dead_line_count].deadline_time, repayment_obj['selected'][each_dead_line_count].total_interest);
                }

                break;
            case 'next':
                each_dead_line_count++;

                if (each_dead_line_count >= repayment_obj['selected'].length)
                {
                    block_2_data_show();
                    $("#repayment_add_block_2_show").trigger('click');
                }
                else
                {
                    block_loan_each_dead_line_data(repayment_obj['selected'][each_dead_line_count].aname, repayment_obj['selected'][each_dead_line_count].deadline_time, repayment_obj['selected'][each_dead_line_count].total_interest);
                }

                break;
            case 'first':
                $("#repayment_add_block_loan_each_dead_line_show").trigger('click');
                each_dead_line_count = 0;

                block_loan_each_dead_line_data(repayment_obj['selected'][each_dead_line_count].aname, repayment_obj['selected'][each_dead_line_count].deadline_time, repayment_obj['selected'][each_dead_line_count].total_interest);

                break;
            case 'theLastOne':
                $("#repayment_add_block_loan_each_dead_line_show").trigger('click');
                each_dead_line_count = repayment_obj['selected'].length - 1;

                block_loan_each_dead_line_data(repayment_obj['selected'][each_dead_line_count].aname, repayment_obj['selected'][each_dead_line_count].deadline_time, repayment_obj['selected'][each_dead_line_count].total_interest);

                break;
            default:
        }

        block_loan_each_dead_line_the_last_msg_show();
    }

    function save_plan()
    {
        for(var i = 0; i < repayment_obj['old'].length; i++)
        {
            delete repayment_obj['old'][i]['data'];
        }


        for(var i = 0; i < repayment_obj['new'].length; i++)
        {
            delete repayment_obj['new'][i]['data'];
        }


        $.ajax({
            url: 'finance/saving/saving_functions/repayments/save_plan.php',
            data: {
              old_repayment: JSON.stringify(repayment_obj['old']),
              new_repayment: JSON.stringify(repayment_obj['new']),
              transfer_amount: parseInt($("#repayment_add_block_3_transfer_amount").val()),
              reduce_budget: calculate_reduce_budget()
            },
            type: 'post',
            dataType: "json",
            success: function(data) {
                if (!data.status)
                {
                    ara_alert(data.emsg);
                }
                else if (data.result)
                {
                    $("#save_plan_result_show").trigger('click');
                    $('#save_plan_result_msg').text(data.result);
                }
                else
                {
                    $("#save_plan_result_show").trigger('click');
                    $('#save_plan_result_msg').text('計畫儲存失敗');
                };
            },
            error: function(a, b, c) {
                $("#save_plan_result_show").trigger('click');
                $('#save_plan_result_msg').text('計畫儲存失敗');
                console.log('error');
            }
        });
    }

    function reflash_main_content()
    {
        $.ajax({
            url: 'index.php',
            data: {
              dept: 'finance',
              ma: 'saving',
              sa: 'repayments',
              only_main_content: true
            },
            type: 'get',
            dataType: "html",
            success: function(data) {
                $("#main-content").html(data.trim());
            },
            error: function(a, b, c) {
                $("#save_plan_result_show").trigger('click');
                $('#save_plan_result_msg').text('計畫儲存失敗');
                console.log('error');
            }
        });
    }

    function title_repayment_breadcrumb(active_number)
    {
      var title_repayment_breadcrumb = '';
      title_repayment_breadcrumb += '<div class="repayment_breadcrumb">';

      title_repayment_breadcrumb += '<li ' + ((1 == active_number) ? 'class="active"' : '') + '>確認現況</li>';
      title_repayment_breadcrumb += '<li ' + ((2 == active_number) ? 'class="active"' : '') + '>還債計畫</li>';
      title_repayment_breadcrumb += '<li ' + ((3 == active_number) ? 'class="active"' : '') + '>結果分析</li>';
      title_repayment_breadcrumb += '</div>';
      return title_repayment_breadcrumb;
    }

    $(document).ready(function() {
        $("#alert_show").fancybox({
            'type': 'inline',
            'title': '',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        // 19 確認現況 選擇加入還債計畫
        $("#repayment_add_block_0_show").fancybox({
            'type': 'inline',
            'title': title_repayment_breadcrumb(1),
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        // 19 選擇債務的總金額
        $("#repayment_add_block_1_show").fancybox({
            'type': 'inline',
            'title': title_repayment_breadcrumb(1),
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        // 20.3 優先順序
        $("#repayment_add_block_2_show").fancybox({
            'type': 'inline',
            'title': title_repayment_breadcrumb(2),
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        // 21 一次償還
        $("#repayment_add_block_3_show").fancybox({
            'type': 'inline',
            'title': title_repayment_breadcrumb(2),
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        // 21 提撥支出預算
        $("#repayment_add_block_4_show").fancybox({
            'type': 'inline',
            'title': title_repayment_breadcrumb(2),
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        // 22 結果分析
        $("#repayment_add_block_5_show").fancybox({
            'type': 'inline',
            'title': title_repayment_breadcrumb(3),
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false/*,
            'onClosed'          : function(){
              if (each_block_5_count >= repayment_obj['selected'].length - 1)
              {
                save_plan();
              }
            }*/
        });

        // 20.1 確認資訊
        $("#repayment_add_block_loan_each_check_show").fancybox({
            'type': 'inline',
            'title': title_repayment_breadcrumb(1),
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        // 20.2 確認資訊
        $("#repayment_add_block_loan_each_dead_line_show").fancybox({
            'type': 'inline',
            'title': title_repayment_breadcrumb(1),
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        // save_plan_result_show
        $("#save_plan_result_show").fancybox({
            'type': 'inline',
            'title': '',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false,
            onClosed: function(){
                //location.reload();
                reflash_main_content();
            }
        });

        // repayment_notice_show
        $("#repayment_notice_show").fancybox({
            'type': 'inline',
            'title': '注意事項',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false,
        });
    });
</script>











