<?php
/*
 Some variables you can use.

 1. $account_types = array( '銀行帳戶', '信用卡', '投資帳戶', '資產', '貸款' );
 	The index of each element of this array are the params for backend.

 2. $all_accounts = array(
 		// account type index
    array(
      'account_id' => xxx,
      'account_name' => 'xxx',
      'account_balance' => xxx,
      'year_rate' => xxx,
      'start_date' => xxx,
      'money' => xxx,
      'time_length' => xxx,
      'time_length_unit' => xxx,
      'description' => 'xxx'
    ),
    array( ... ),
 	);
 	All accounts of this user and some column values for this page.

 */
?>

    <div style="display:none;">
    	<a id="alert_show" href="#alert_window" style="display:none;" >#</a>
    	<div id="alert_window">
            <div class='page-outer' style='width: 250px; height: 95px;'>
                <div class='normal-inner'>
                	<p id="alert_msg"></p>
                </div>
                <div id="primary-action">
                    <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="確 定"></input>
                </div>
            </div>
        </div>

    	<a id="delete_show" href="#delete_window" style="display:none;" >#</a>
    	<div id="delete_window">
            <div class='page-outer' style='width: 250px; height: 95px;'>
                <div class='normal-inner'>
                	請確認是否要刪除?
                </div>
                <div id="primary-action">
                	<input id="delete_function" class="btn func-btn" type="button" onclick="ajax_delete()" value="確 定"></input>
                    <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="取 消"></input>
                </div>
            </div>
        </div>

        <a id="0_edit_show" href="#0_ac_edit" style="display:none;" >#</a>
    	<div id="0_ac_edit">
            <div class='page-outer' style='width: 320px; height: 140px;'>
                <div class='normal-inner'>
                	<form>
                    <table class='distance-table' style="height:90px;">
                    <input id="ac_id_0" type="hidden" value="">
                    <tr>
                        <td>
                            <div class="fancy_input_name">銀行帳戶</div>
                            <input class="input-numbers" type="text" value="" id="0_ac_edit_name" name="0_ac_edit_name"></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">說　　明</div>
                            <input class="input-numbers" type="text" value="" id="0_ac_edit_description" name="0_ac_edit_description"></input>
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <div id="primary-action">
                	<input class="btn func-btn" type="button" onclick="delete_show(0)" style="width: 85px;" value="刪除帳戶"></input>
                    <input class="btn func-btn" type="button" onclick="ajax_update(0,0)" value="確 定"></input>
                </div>
            </div>
        </div>

        <a id="2_edit_show" href="#2_ac_edit" style="display:none;" >#</a>
    	<div id="2_ac_edit">
            <div class='page-outer' style='width: 320px; height: 140px;'>
                <div class='normal-inner'>
                	<form>
                    <table class='distance-table' style="height:90px;">
                    <input id="ac_id_2" type="hidden" value="">
                    <tr>
                        <td>
                            <div class="fancy_input_name">投資帳戶</div>
                            <input class="input-numbers" type="text" value="" id="2_ac_edit_name" name="2_ac_edit_name"></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">說　　明</div>
                            <input class="input-numbers" type="text" value="" id="2_ac_edit_description" name="2_ac_edit_description"></input>
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <div id="primary-action">
                	<input class="btn func-btn" type="button" onclick="delete_show(2)" style="width: 85px;" value="刪除帳戶"></input>
                    <input class="btn func-btn" type="button" onclick="ajax_update(0,2)" value="確 定"></input>
                </div>
            </div>
        </div>

        <a id="3_edit_show" href="#3_ac_edit" style="display:none;" >#</a>
    	<div id="3_ac_edit">
            <div class='page-outer' style='width: 320px; height: 140px;'>
                <div class='normal-inner'>
                	<form>
                    <table class='distance-table' style="height:90px;">
                    <input id="ac_id_3" type="hidden" value="">
                    <tr>
                        <td>
                            <div class="fancy_input_name">資產名稱</div>
                            <input class="input-numbers" type="text" value="" id="3_ac_edit_name" name="3_ac_edit_name"></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">說　　明</div>
                            <input class="input-numbers" type="text" value="" id="3_ac_edit_description" name="3_ac_edit_description"></input>
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <div id="primary-action">
                	<input class="btn func-btn" type="button" onclick="delete_show(3)" style="width: 85px;" value="刪除帳戶"></input>
                    <input class="btn func-btn" type="button" onclick="ajax_update(0,3)" value="確 定"></input>
                </div>
            </div>
        </div>

        <a id="1_edit_show" href="#1_ac_edit" style="display:none;" >#</a>
    	<div id="1_ac_edit">
            <div class='page-outer' style='width: 320px; height: 180px;'>
                <div class='normal-inner'>
                	<form>
                    <table class='distance-table' style="height:90px;">
                    <input id="ac_id_1" type="hidden" value="">
                    <tr>
                        <td>
                            <div class="fancy_input_name" style="width:45px;">信用卡</div>
                            <input class="input-numbers" type="text" value="" id="1_ac_edit_name" name="1_ac_edit_name"></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name" style="width:45px;">年利率</div>
                            <input class="input-numbers" type="text" value="" id="1_ac_edit_yrate" name="1_ac_edit_yrate" style="width:100px;"></input>
                            <span style="width:90px;">%</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name" style="width:45px;">說　明</div>
                            <input class="input-numbers" type="text" value="" id="1_ac_edit_description" name="1_ac_edit_description"></input>
                        </td>
                    </tr>

                    </table>
                    </form>
                </div>
                <div id="primary-action">
                	<input class="btn func-btn" type="button" onclick="delete_show(1)" style="width: 85px;" value="刪除帳戶"></input>
                    <input class="btn func-btn" type="button" onclick="ajax_update(4,1)" value="確 定"></input>
                </div>
            </div>
        </div>

        <a id="4_edit_show" href="#4_ac_edit" style="display:none;" >#</a>
    	<div id="4_ac_edit">
            <div class='page-outer' style='width: 330px; height: 290px;'>
                <div class='normal-inner'>
                	<form>
                    <table class='distance-table' style="height:90px;">
                    <input id="ac_id_4" type="hidden" value="">
                    <tr>
                        <td>
                            <div class="fancy_input_name">貸款帳戶</div>
                            <input class="input-numbers" type="text" value="" id="4_ac_edit_name" name="4_ac_edit_name"></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">開始時間</div>
                            <span id="4_ac_edit_start_date"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">貸款金額</div>
                            <span id="4_ac_edit_money"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">貸款長度</div>
                            <span id="4_ac_edit_length_and_unit"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">年 利 率</div>
                            <input class="input-numbers" type="text" value="" id="4_ac_edit_yrate" name="4_ac_edit_yrate" style="width:85px;"></input>%
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">付款週期</div>
                            <span id="4_ac_edit_pay_period">每月</span>
                        </td>
                    </tr>
                    <tr style="display: none;">
                        <td>
                            <div class="fancy_input_name">說　　明</div>
                            <input class="input-numbers" type="text" value="" id="4_ac_edit_description" name="4_ac_edit_description"></input>
                        </td>
                    </tr>

                    </table>
                    </form>
                </div>
                <div id="primary-action">
                	<input class="btn func-btn" type="button" onclick="delete_show(4)" style="width: 85px;" value="刪除帳戶"></input>
                    <input class="btn func-btn" type="button" onclick="ajax_update(4,4)" value="確 定"></input>
                </div>
            </div>
        </div>

        <div id="inline_0">
            <div class='page-outer' style='width: 320px; height: 140px;'>
                <div class='normal-inner'>
                	<form id="add_form_0">
                    <table class='distance-table' style="height:90px;">
                    <tr>
                        <td>
                            <div class="fancy_input_name">帳戶名稱</div>
                            <input class="input-numbers" type="text" value="" id="normal_ac_name" name="normal_ac_name" required></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">帳戶餘額</div>
                            <input class="input-numbers" type="text" value="" id="normal_ac_balance" name="normal_ac_balance" required></input>
                        </td>
                    </tr>

                    </table>
                    </form>
                </div>
                <div id="primary-action">
                    <input class="btn func-btn" type="button" onclick="check_form('0')" value="確 定"></input>
                </div>
            </div>
        </div>
        <div id="inline_1">
            <div class='page-outer' style='width: 320px; height: 140px;'>
                <div class='normal-inner'>
                	<form id="add_form_1">
                    <table class='distance-table' style="height:90px;">
                    <tr>
                        <td>
                            <div class="fancy_input_name">帳戶名稱</div>
                            <input class="input-numbers" type="text" value="" id="credit_ac_name" name="credit_ac_name" required></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">已刷金額</div>
                            <input class="input-numbers" type="text" value="" id="credit_ac_balance" name="credit_ac_balance" required></input>
                        </td>
                    </tr>

                    </table>
                    </form>
                </div>
                <div id="primary-action">
                    <input class="btn func-btn" type="button" onclick="check_form('1')" value="確 定"></input>
                </div>
            </div>
        </div>
        <div id="inline_2">
            <div class='page-outer' style='width: 320px; height: 140px;'>
                <div class='normal-inner'>
                	<form id="add_form_2">
                    <table class='distance-table' style="height:90px;">
                    <tr>
                        <td>
                            <div class="fancy_input_name">帳戶名稱</div>
                            <input class="input-numbers" type="text" value="" id="invest_ac_name" name="invest_ac_name" required></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">帳戶餘額</div>
                            <input class="input-numbers" type="text" value="" id="invest_ac_balance" name="invest_ac_balance" required></input>
                        </td>
                    </tr>

                    </table>
                    </form>
                </div>
                <div id="primary-action">
                    <input class="btn func-btn" type="button" onclick="check_form('2')" value="確 定"></input>
                	<a id="accounts_2_1" href="#inline_2_2" style="display:none;"></a>
                </div>
            </div>
        </div>
        <div id="inline_2_2">
            <div class='page-outer' style='width: 700px; height: 300px;'>
                <div class='normal-inner' style="overflow: scroll; overflow-x: hidden; height:210px;">
                	<form id="add_form_2_2">
                    <table class='invest-table'>
                    <tr>
                    	<th style="text-align:center;">投資名稱</th>
                    	<th style="text-align:center;">種　　類</th>
                    	<th style="text-align:center;">數　　量</th>
                    	<th style="text-align:center;">買進價格</th>
                    </tr>
                    <input id="invest_num" type="hidden" value="0">
                    <tr class="invest_item">
                        <td>
                            <input class="input-numbers input-nones" onkeydown="add_invest_row_detect($(this))" type="text" value="" id="invest_item_name_0" name="invest_item_name_0" placeholder=" + 新增投資" required></input>
                        </td>
                        <td>
                            <select id="invest_item_type_0" name="invest_item_type_0" width="95" style="width: 95px;">
	                            <option value="0">股票</option>
	                            <option value="1">基金</option>
	                            <option value="2">期貨</option>
	                            <option value="3">債券</option>
	                            <option value="4">其它</option>
                            </select>
                        </td>
                        <td>
                            <input class="input-numbers input-nones" type="text" value="" id="invest_item_quantity_0" name="invest_item_quantity_0" style="width:95px;" required></input>
                        </td>
                        <td>
                            <input class="input-numbers input-nones" type="text" value="" id="invest_item_price_0" name="invest_item_price_0" required></input>
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <div id="primary-action" style="right:35px;">
                	<a id="accounts_2_2" href="#inline_2" class="btn func-btn" >< 返回</a>
                    <input class="btn func-btn" type="button" onclick="check_form('2_2')" value="確 定"></input>
                    <input class="btn func-btn" type="button" onclick="ajax_add(2)" value="略 過"></input>
                </div>
            </div>
        </div>
        <div id="inline_3">
            <div class='page-outer' style='width: 320px; height: 340px;'>
                <div class='normal-inner'>
                    <form id="add_form_3">
                    <table class='distance-table'>
                    <tr>
                        <td>
                            <div class="fancy_input_name">資產名稱</div>
                            <input class="input-numbers" type="text" value="" id="asset_ac_name" name="asset_ac_name" required></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">購買時間</div>
                            <input class="input-numbers pick-Date" type="text" value="" id="asset_ac_date" name="asset_ac_date" required></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">購買金額</div>
                            <input class="input-numbers" type="text" value="" id="asset_ac_balance" name="asset_ac_balance" required></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name" style="width:100px;">目前市值(預估) </div>
                            <input class="input-numbers" type="text" value="" id="asset_ac_money" name="asset_ac_money" style="width:150px;" required></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>此資產是否有貸款</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="asset_loan" value="yes" checked> 是
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="asset_loan" value="no"> 否
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <div id="primary-action">
                    <input class="btn func-btn" type="button" onclick="check_form('3')" value="確 定"></input>
                    <a id="accounts_3_1" href="#inline_3_2" style="display:none;"></a>
                </div>
            </div>
        </div>
        <div id="inline_3_2">
            <div class='page-outer' style='width: 320px; height: 415px;'>
                <div class='normal-inner'>
                    <form id="add_form_3_2">
                    <table class='distance-table'>
                    <tr>
                        <td>
                            <div class="fancy_input_name">貸款帳戶</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="asset_loan_select" value="yes" checked> 現有貸款帳戶
                            <select id="asset_loan_exist_ac" style="width: 150px;">
                                <option value="test">test</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="asset_loan_select" value="no"> 新貸款帳戶
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">帳戶名稱</div>
                            <input class="input-numbers need_disabled" disabled="" required="" type="text" value="" id="asset_loan_ac_name" name="asset_loan_ac_name"></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">開始時間</div>
                            <input class="input-numbers pick-Date need_disabled" disabled="" required="" type="text" value="" id="asset_loan_ac_date" name="asset_loan_ac_date"></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">貸款金額</div>
                            <input class="input-numbers need_disabled" disabled="" required="" type="text" value="" id="asset_loan_ac_balance" name="asset_loan_ac_balance"></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">貸款長度 </div>
                            <input class="input-numbers need_disabled" disabled="" required="" type="text" value="" id="asset_loan_ac_length" name="asset_loan_ac_length" style="width:80px;"></input>
                            <select id="asset_loan_ac_unit" name="asset_loan_ac_unit" style="width:80px;" class="need_disabled" disabled="" required="">
                                <option value="0">年</option>
                                <option value="1">月</option>
                                <option value="2">周</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">年 利 率</div>
                            <input class="input-numbers need_disabled" disabled="" required="" type="text" value="" id="asset_loan_ac_yrate" name="asset_loan_ac_yrate" style="width:80px;"></input>
                            %
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">付款週期</div>
                            <input type="hidden" id="asset_loan_ac_period" name="asset_loan_ac_period" class="need_disabled" disabled="" required="" value="0"><span style="margin: -3px 0 0 10px;">每月</span>
                            <!--
                            <select id="asset_loan_ac_period" name="asset_loan_ac_period" class="need_disabled" disabled="" required="">
                                <option value="0">每月</option>
                                <option value="1">每季</option>
                                <option value="2">每年</option>
                            </select>
                            -->
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <div id="primary-action">
                    <a id="accounts_3_2" href="#inline_3" class="btn func-btn" >< 返回</a>
                    <input class="btn func-btn" type="button" onclick="check_form('3_2')" value="確 定"></input>
                    <a id="accounts_3_2_1" href="#inline_3_3" style="display:none;">確 定</a>
                </div>
            </div>
        </div>
        <div id="inline_3_3">
            <div class='page-outer' style='width: 240px; height: 240px;'>
                <div class='normal-inner'>
                    <form id="add_form_3_3">
                    <table class='distance-table'>
                    <tr>
                        <td>
                            <div class="fancy_input_name" style="width:180px;">是否開始償還部分貸款金額</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="asset_loan_repay_yn" value="yes" checked> 是
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="asset_loan_repay_yn" value="no"> 否
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name" style="width:180px;">目前貸款餘額</div><br>
                            <input class="input-numbers need_disabled" type="text" value="" id="asset_loan_ac_repay_bal" name="asset_loan_ac_repay_bal" style="margin-left:0px; width:90px;"></input>
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <div id="primary-action">
                    <a id="accounts_3_3" href="#inline_3_2" class="btn func-btn" >< 返回</a>
                    <input class="btn func-btn" type="button" onclick="check_form('3_3')" value="確 定"></input>
                </div>
            </div>
        </div>
        <div id="inline_4">
            <div class='page-outer' style='width: 320px; height: 290px;'>
                <div class='normal-inner'>
                    <form id="add_form_4">
                    <table class='distance-table'>
                    <tr>
                        <td>
                            <div class="fancy_input_name">貸款帳戶</div>
                            <input class="input-numbers" type="text" value="" id="loan_ac_name" name="loan_ac_name" required></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">開始時間</div>
                            <input class="input-numbers pick-Date" type="text" value="" id="loan_ac_date" name="loan_ac_date" required></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">貸款金額</div>
                            <input class="input-numbers" type="text" value="" id="loan_ac_balance" name="loan_ac_balance" required></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">貸款長度 </div>
                            <input class="input-numbers" type="text" value="" id="loan_ac_length" name="loan_ac_length" style="width:80px;" required></input>
                            <select id="loan_ac_unit" name="loan_ac_unit" style="width:80px;">
                                <option value="0">年</option>
                                <option value="1">月</option>
                                <option value="2">周</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">年 利 率</div>
                            <input class="input-numbers" type="text" value="" id="loan_ac_yrate" name="loan_ac_yrate" style="width:80px;" required></input>
                            %
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">付款週期</div>
                            <input type="hidden" id="loan_ac_period" name="loan_ac_period" value="0"><span style="margin: -3px 0 0 10px;">每月</span>
                            <!--
                            <select id="loan_ac_period" name="loan_ac_period">
                                <option value="0">每月</option>
                                <option value="1">每季</option>
                                <option value="2">每年</option>
                            </select>
                            -->
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <div id="primary-action">
                    <input class="btn func-btn" type="button" onclick="check_form('4')" value="確 定"></input>
                    <a id="accounts_4_1" href="#inline_4_2" style="display:none;"></a>
                </div>
            </div>
        </div>

        <div id="inline_4_2">
            <div class='page-outer' style='width: 240px; height: 240px;'>
                <div class='normal-inner'>
                    <form id="add_form_4_2">
                    <table class='distance-table'>
                    <tr>
                        <td>
                            <div class="fancy_input_name" style="width:180px;">是否開始償還部分貸款金額</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="loan_repay_yn" value="yes" checked> 是
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="loan_repay_yn" value="no"> 否
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name" style="width:180px;">目前貸款餘額</div><br>
                            <input class="input-numbers need_disabled" type="text" value="" id="loan_ac_repay_bal" name="loan_ac_repay_bal" style="margin-left:0px; width:90px;"></input>
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <div id="primary-action">
                    <a id="accounts_4_2" href="#inline_4" class="btn func-btn" >< 返回</a>
                    <input class="btn func-btn" type="button" onclick="check_form('4_2')" value="確 定"></input>
                    <a id="accounts_4_2_1" href="#inline_4_3" style="display:none;">確 定</a>
                </div>
            </div>
        </div>

        <div id="inline_4_3">
            <div class='page-outer' style='width: 320px; height: 250px;'>
                <div class='normal-inner'>
                    <form id="add_form_4_3">
                    <table class='distance-table'>
                    <tr>
                        <td>
                            <div class="fancy_input_name" style="width:200px;">此筆貸款是否有相對應的資產</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="loan_asset_yn" value="yes" checked> 是
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="radio" name="loan_asset_yn" value="no"> 否
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name">資產名稱</div>
                            <input class="input-numbers need_disabled" type="text" value="" id="loan_ac_asset_name" name="loan_ac_asset_name" style="margin-left:0px; width:90px;"></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="fancy_input_name" style="width:125px;">目前資產餘額(預估)</div>
                            <input class="input-numbers need_disabled" type="text" value="" id="loan_ac_asset_bal" name="loan_ac_asset_bal" style="margin-left:0px; width:90px;"></input>
                        </td>
                    </tr>
                    </table>
                    </form>
                </div>
                <div id="primary-action">
                    <a id="accounts_4_3" href="#inline_4_2" class="btn func-btn" >< 返回</a>
                    <input class="btn func-btn" type="button" onclick="ajax_add(4)" value="確 定"></input>
                </div>
            </div>
        </div>


        <div id="accounts_notice_window">
            <div class='page-outer repayment_page-outer' style='width: 350px; height: 130px;'>
                <div class='normal-inner'>
                  <p id="repayment_notice_msg">
                     1. 請先在帳戶管理新增相關帳戶資訊<br />
                     2. 然後在每日記帳、存錢計畫與投資計畫選取相關帳戶做紀錄與分析
                  </p>
                </div>
                <div id="primary-action">
                    <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="確 定" />
                </div>
            </div>
        </div>

    </div>

<?php /* Links of sub item pages of this parent item */ ?>
<div class='log-inner'>
    <div class='log-switch'>
        <ul class='menu'>
        	<?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
        		<li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=finance&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
        	<?php endforeach; ?>
        </ul>
    </div>


<?php /* Account list */ ?>
<?php $sum = 0; ?>
<?php foreach ( $account_types as $type_index => $account_type ): ?>
	<?php $subtotal = 0; ?>
<div class="account_list">
	<h3 class="account_title"><?=$account_type?><?=($type_index == 0)?'<span style="float:right;">結餘</span>':'';?></h3> <?php // Account type ?>
		<div id="block_<?=$type_index?>">
	<?php if ( isset($all_accounts[ $type_index ]) && count($all_accounts[ $type_index ]) ): ?>
		<?php foreach ( $all_accounts[ $type_index ] as $account ): ?>
		<div class="list_row" id="<?=$account['account_id']?>">
			<span class="list_name"><a href="javascript:edit('#<?=$account['account_id'].'\','.$type_index?>)"><?=$account['account_name']?></a></span>
      <?php if (($type_index == 1)||($type_index == 4)) { $account['account_balance'] = 0-$account['account_balance']; } ?>
      <span class="list_balance<?php if ($account['account_balance']<0) echo ' negative'; ?>"><?=number_format($account['account_balance'])?></span>
			<span class="list_description" style="display:none;"><?=$account['description']?></span>
			<?php if ( in_array( $type_index, array( 1, 4 ) ) ): ?>
		   <span class="list_yrate" style="display:none;"><?=$account['year_rate']?></span><?php // Should be hidden, only for credit or loan ?>
			<?php endif; ?>

			<?php if(in_array( $type_index, array( 4 )))
			{
		  ?>
        <span class="list_money" style="display:none;"><?= number_format($account['money']) ?></span>
        <span class="list_start_date" style="display:none;"><?= str_replace('-', '/', $account['start_date']) ?></span>
        <span class="list_time_length" style="display:none;"><?=$account['time_length']?></span>
        <span class="list_time_length_unit" style="display:none;"><?=$account['time_length_unit']?></span>
      <?php
			}
      ?>


		</div>
			<?php $subtotal += $account['account_balance']; ?>
		<?php endforeach; ?>
		</div>
		<?php $sum = $sum+$subtotal; ?>
	<?php else: ?>
		</div>
	<?php endif; ?>
		<div class="list_subtotal">
			<span style="margin-right:30px;">小計</span><span id="subtotal_<?=$type_index?>" class="subtotal_num<?php if (($type_index == 1)||($type_index == 4)) echo ' negative'; ?>"><?=number_format($subtotal)?></span>
		</div>
</div>
<?php endforeach; ?>

<div class="list_total"><span style="margin-right:30px;">淨值</span><span class="total_num"><?=number_format($sum)?></span></div>

<script type="text/javascript" src="finance/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="finance/js/additional-methods.min.js"></script>
<script type="text/javascript" src="finance/js/number_format.js"></script>
<script type="text/javascript" src="js/datePicker/date.js"></script>
<script type="text/javascript" src="js/datePicker/jquery.datePicker.js"></script>
<link href="js/datePicker/datePicker.css" rel="stylesheet" />
<script type="text/javascript">

    $(document).mouseup(function (e)
    {
        var container = $("#add_account");

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            if (container.hasClass("active")) {
                $("#add_ac_menu").hide();
                container.toggleClass("active");
            }
        } else {
            if (container.hasClass("active")) {
                $("#add_ac_menu").hide();
            } else {
                $("#add_ac_menu").show();
            };
            container.toggleClass("active");
        }
    });

	$(document).ready(function() {

        check_color($('.total_num'));
        $("form").validate();
        jQuery.validator.messages.required = "";

        $("input:radio[name=asset_loan_select]").change(function(){
            var asset_loan = $("input:radio[name=asset_loan_select]:checked").val();
            if (asset_loan == "yes") {
                $('#add_form_3_2').find('.need_disabled').each(function(){
                    $(this).attr('disabled', true);
                    $(this).attr('required', false);
                });
            } else {
                $('#add_form_3_2').find('.need_disabled').each(function(){
                    $(this).attr('disabled', false);
                    $(this).attr('required', true);
                });
            }
        });

        $("input:radio[name=asset_loan_repay_yn]").change(function(){
            var asset_loan = $("input:radio[name=asset_loan_repay_yn]:checked").val();
            if (asset_loan == "yes") {
                $('#add_form_3_3').find('.need_disabled').each(function(){
                    $(this).attr('disabled', false);
                });
            } else {
                $('#add_form_3_3').find('.need_disabled').each(function(){
                    $(this).attr('disabled', true);
                });
            }
        });

        $("input:radio[name=loan_repay_yn]").change(function(){
            var asset_loan = $("input:radio[name=loan_repay_yn]:checked").val();
            if (asset_loan == "yes") {
                $('#add_form_4_2').find('.need_disabled').each(function(){
                    $(this).attr('disabled', false);
                });
            } else {
                $('#add_form_4_2').find('.need_disabled').each(function(){
                    $(this).attr('disabled', true);
                });
            }
        });

        $("input:radio[name=loan_asset_yn]").change(function(){
            var asset_loan = $("input:radio[name=loan_asset_yn]:checked").val();
            if (asset_loan == "yes") {
                $('#add_form_4_3').find('.need_disabled').each(function(){
                    $(this).attr('disabled', false);
                });
            } else {
                $('#add_form_4_3').find('.need_disabled').each(function(){
                    $(this).attr('disabled', true);
                });
            }
        });

        $('.pick-Date').datePicker({
            startDate: '1991/01/01',
            endDate: (new Date()).asString(),
            clickInput:true,
            createButton: false,
            showYearNavigation: false,
            verticalOffset: -1,
            horizontalOffset: 165
        }).bind(
            'click',
            function()
            {
                $('.pick-Date').dpSetSelected((new Date()).asString());
                $(this).dpDisplay();
                return false;
            }
        );

        $("#0_edit_show").fancybox({
	        'type': 'inline',
	        'title': '編輯帳戶',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#1_edit_show").fancybox({
	        'type': 'inline',
	        'title': '編輯帳戶',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#2_edit_show").fancybox({
	        'type': 'inline',
	        'title': '編輯帳戶',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#3_edit_show").fancybox({
	        'type': 'inline',
	        'title': '編輯帳戶',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#4_edit_show").fancybox({
	        'type': 'inline',
	        'title': '編輯帳戶',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#alert_show").fancybox({
	        'type': 'inline',
	        'title': '',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#delete_show").fancybox({
	        'type': 'inline',
	        'title': '',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#accounts_0").fancybox({
	        'type': 'inline',
	        'title': '一般帳戶',
	        'padding' : 0,
            'onStart' : function() {
                $('#normal_ac_name').closest('form').find("input[type=text], textarea").val("");
            },
            'onComplete' : function() {
                $('#normal_ac_name').focus();
            },
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#accounts_1").fancybox({
	        'type': 'inline',
	        'title': '信用卡',
	        'padding' : 0,
            'onStart' : function() {
                $('#credit_ac_name').closest('form').find("input[type=text], textarea").val("");
            },
            'onComplete' : function() {
                $('#credit_ac_name').focus();
            },
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#accounts_2").fancybox({
	        'type': 'inline',
	        'title': '投資帳戶',
	        'padding' : 0,
            'onStart' : function() {
                $('#invest_ac_name').closest('form').find("input[type=text], textarea").val("");
                $('#invest_num').val(0);
                $('#invest_item_name_0').closest('form').find("input[type=text], textarea").val("");
                $('#invest_item_name_0').closest('form').find("tr.invest_item_addition").remove();
            },
            'onComplete' : function() {
                $('#invest_ac_name').focus();
            },
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#accounts_2_1").fancybox({
	        'type': 'inline',
	        'title': '',
	        'padding' : 0,
            'onComplete' : function() {
                $('#invest_item_name_0').focus();
            },
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#accounts_2_2").fancybox({
	        'type': 'inline',
	        'title': '投資帳戶',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

        $("#accounts_3").fancybox({
            'type': 'inline',
            'title': '資產帳戶(房子、車子、其它)',
            'padding' : 0,
            'onStart' : function() {
                $('#add_form_3').find("input[type=text], textarea").val("");
                $('#add_form_3_2').find("input[type=text], textarea").val("");
                var option = '';
                var tempstr;
                $('#asset_loan_exist_ac').children().remove();
                $('#block_4').find('div.list_row').each(function(index){
                    tempstr = '<option value="'+$(this).attr('id')+'">'+$(this).children('.list_name').children().text()+'</option>';
                    option += tempstr;
                });
                $('#asset_loan_exist_ac').html(option);
            },
            'onComplete' : function() {
                $('#asset_ac_name').focus();
            },
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        $("#accounts_3_1").fancybox({
            'type': 'inline',
            'title': '貸款資料',
            'padding' : 0,
            'onStart' : function() {
                $('#add_form_3_2').find("input[type=text], textarea").val("");
            },
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        $("#accounts_3_2").fancybox({
            'type': 'inline',
            'title': '資產帳戶(房子、車子、其它)',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        $("#accounts_3_2_1").fancybox({
            'type': 'inline',
            'title': '',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        $("#accounts_3_3").fancybox({
            'type': 'inline',
            'title': '貸款資料',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        $("#accounts_4").fancybox({
            'type': 'inline',
            'title': '貸款資料',
            'padding' : 0,
            'onStart' : function() {
                $('#loan_ac_name').closest('form').find("input[type=text], textarea").val("");
                $('#loan_ac_repay_bal').closest('form').find("input[type=text], textarea").val("");
                $('#loan_ac_asset_name').closest('form').find("input[type=text], textarea").val("");
            },
            'onComplete' : function() {
                $('#loan_ac_name').focus();
            },
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        $("#accounts_4_1").fancybox({
            'type': 'inline',
            'title': '',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        $("#accounts_4_2").fancybox({
            'type': 'inline',
            'title': '貸款資料',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        $("#accounts_4_2_1").fancybox({
            'type': 'inline',
            'title': '',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        $("#accounts_4_3").fancybox({
            'type': 'inline',
            'title': '',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        // accounts_notice_show
        $("#accounts_notice_show").fancybox({
            'type': 'inline',
            'title': '使用說明',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false,
        });

	});

    function check_form(name){
        var check_form = $(('#add_form_'+name));
        if (check_form.valid() == false) {
            ara_alert("資料填寫未完整, 請重新輸入");
        } else {
            switch (name) {
                case '2':
                    $('#accounts_2_1').trigger('click');
                    break;
                case '2_2':
                    ajax_add(22);
                    break;
                case '3':
                    asset_loan();
                    break;
                case '3_2':
                    var v_asset_loan = $("input:radio[name=asset_loan_select]:checked").val();
                    if (v_asset_loan == "yes") {
                        ajax_add(3);
                    } else {
                        $('#accounts_3_2_1').trigger('click');
                    }
                    break;
                case '3_3':
                    var v_asset_loan = $("input:radio[name=asset_loan_repay_yn]:checked").val();
                    if (v_asset_loan == "yes") {
                        if ($("#asset_loan_ac_repay_bal").val()!="") {
                            ajax_add(3);
                        }
                        else {
                            ara_alert("資料填寫未完整, 請重新輸入");
                        };
                    } else {
                        ajax_add(3);
                    }
                    break;
                case '4':
                    $('#accounts_4_1').trigger('click');
                    break;
                case '4_2':
                    var v_asset_loan = $("input:radio[name=loan_repay_yn]:checked").val();
                    if (v_asset_loan == "yes") {
                        if ($("#loan_ac_repay_bal").val()!="") {
                            $('#accounts_4_2_1').trigger('click');
                        }
                        else {
                            ara_alert("資料填寫未完整, 請重新輸入");
                        };
                    } else {
                        $('#accounts_4_2_1').trigger('click');
                    }
                    break;
                default:
                    ajax_add(parseInt(name.charAt(0)));
            }
        };
    }

    function check_color(obj) {
        var nega_num = parseFloat(($(obj).text().replace(/,/g,"")));
        if (nega_num < 0) {
            if ($(obj).hasClass("negative")) {
            } else {
                $(obj).toggleClass("negative");
            }
        } else {
            if ($(obj).hasClass("negative")) {
                $(obj).toggleClass("negative");
            }
        };
    }

    function total_num_update() {
        var sum = 0;
        total_num = $('.total_num');
        $('.subtotal_num').each(function(){
            sum += parseFloat(($(this).text().replace(/,/g,"")));
        });

        total_num.text(number_format(sum));
        check_color(total_num);
    }

	function ara_alert(msg) {
		$('#alert_msg').html(msg);
		$("#alert_show").trigger('click');
	}

    function add_invest_row_detect(obj) {
        var num = $('#invest_num').val();
        if ($(obj).attr('id') == ('invest_item_name_'+num)) {
            $('#invest_num').val(parseFloat(num)+1);
            add_invest_row(num);
        };
    }

    function add_invest_row(num) {
        num = parseFloat(num) + 1;
        var newIn = '<tr class="invest_item invest_item_addition"><td><input class="input-numbers input-nones" onkeydown="add_invest_row_detect($(this))" type="text" value="" id="invest_item_name_'+num+'" name="invest_item_name_'+num+'" placeholder=" + 新增投資"></input></td><td><select id="invest_item_type_'+num+'" name="invest_item_type_'+num+'" width="95" style="width: 95px;"><option value="0">股票</option><option value="1">基金</option><option value="2">期貨</option><option value="3">債券</option><option value="4">其它</option></select></td><td><input class="input-numbers input-nones" type="text" value="" id="invest_item_quantity_'+num+'" name="invest_item_quantity_'+num+'" style="width:95px;"></input></td><td><input class="input-numbers input-nones" type="text" value="" id="invest_item_price_'+num+'" name="invest_item_price_'+num+'"></input></td></tr>';
        var newInput = $(newIn);
        $('tr.invest_item').last().after(newInput);
    }

    function asset_loan() {
        var select = $("input:radio[name=asset_loan]:checked").val();
        if (select == 'yes') {
            $("#accounts_3_1").trigger('click');
        } else {
            ajax_add(3);
        };

    }

	function delete_show (ac_type) {
		var temp_id = '#ac_id_'+ac_type;
		var str = 'ajax_delete('+ $(temp_id).val() + ',' + ac_type + ')';
		$("#delete_function").attr( "onclick", str );
		$("#delete_show").trigger('click');
	}

	function edit(ac_id , ac_type) {
	  if (ac_type == 4)
	  {
      var loan_length_unit = ['年', '月', '周'];

      var temp_start_date = '#'+ac_type+'_ac_edit_start_date';
      var temp_money = '#'+ac_type+'_ac_edit_money';
      var temp_length_and_unit = '#'+ac_type+'_ac_edit_length_and_unit';

      var start_date = $(ac_id).children(".list_start_date").text();
      var money = $(ac_id).children(".list_money").text();
      var time_length_and_unit = $(ac_id).children(".list_time_length").text() + loan_length_unit[$(ac_id).children(".list_time_length_unit").text()];

      $(temp_start_date).text($(ac_id).children(".list_start_date").text());
      $(temp_money).text($(ac_id).children(".list_money").text());
      $(temp_length_and_unit).text(time_length_and_unit);
	  }

		if (ac_type == 0 || ac_type == 2 || ac_type == 3) {
			var ac_real_id = '#ac_id_'+ac_type;
			var temp_name = '#'+ac_type+'_ac_edit_name';
			var temp_description = '#'+ac_type+'_ac_edit_description';
			var temp_show = '#'+ac_type+'_edit_show';
			$(ac_real_id).val(ac_id.slice(1));
			$(temp_name).val($(ac_id).children(".list_name").children().text());
			$(temp_description).val($(ac_id).children(".list_description").text());
			$(temp_show).trigger('click');
		} else if (ac_type == 1 || ac_type == 4) {
			var ac_real_id = '#ac_id_'+ac_type;
			var temp_name = '#'+ac_type+'_ac_edit_name';
			var temp_description = '#'+ac_type+'_ac_edit_description';
			var temp_yrate = '#'+ac_type+'_ac_edit_yrate';
			var temp_show = '#'+ac_type+'_edit_show';
			$(ac_real_id).val(ac_id.slice(1));
			$(temp_name).val($(ac_id).children(".list_name").children().text());
			$(temp_description).val($(ac_id).children(".list_description").text());
			$(temp_yrate).val($(ac_id).children(".list_yrate").text());
			$(temp_show).trigger('click');
		} else {

		};




	}

	function ajax_delete(delete_id, delete_type) {
		var jsonObj = {
			id: delete_id,
			atype: delete_type
		};
		var jsonStr = JSON.stringify(jsonObj);
		$.ajax({
		    type: "POST",
		    url: "finance/accounts/accounts_functions/list/delete.php",
		    data: {
		    	data: jsonStr
		    },
		    success: function(data){
		        if (data.status) {
		        	var ac_real_id = '#' + delete_id;
		        	var subtotal = '#subtotal_' + delete_type;
		        	var num = parseFloat($(subtotal).text().replace(/,/g,""));
		        	var num2 = parseFloat($(ac_real_id).children('.list_balance').text().replace(/,/g,""));
		        	num = num - num2;
		        	$(subtotal).text(number_format(num));
		        	$(ac_real_id).remove();
                    total_num_update();
                    $.fancybox.close();
		        } else {
		        	ara_alert(data.emsg);
		        };
		    }
		});
	}

	function ajax_add(account_type) {

		if (account_type == 0) {
			var jsonObj = {
				atype: 0,
				aname: $('#normal_ac_name').val(),
				money: $('#normal_ac_balance').val()
			};
			var jsonStr = JSON.stringify(jsonObj);
			$.ajax({
			    type: "POST",
			    url: "finance/accounts/accounts_functions/list/new.php",
			    data: {
			    	data: jsonStr
			    },
			    success: function(data){
			        if (data.status) {
			        	var newIn = '<div class="list_row slideInDown animated" id="'+data.id+'"><span class="list_name"><a href="javascript:edit(\'#'+data.id+'\',0)">'+jsonObj.aname+'</a></span><span class="list_balance">'+number_format(jsonObj.money)+'</span><span class="list_description" style="display:none;"></span></div>';
			        	var newInput = $(newIn);
			        	$('#block_0').append(newInput);
			        	var num = parseFloat($('#subtotal_0').text().replace(/,/g,""));
			        	var num2 = parseFloat(jsonObj.money);
			        	num += num2;
			        	$('#subtotal_0').text(number_format(num));
			        	$.fancybox.close();
                        total_num_update();
			        } else {
			        	ara_alert(data.emsg);
			        };
			    }
			});
		} else if(account_type == 1){
			var jsonObj = {
				atype: 1,
				aname: $('#credit_ac_name').val(),
				money: $('#credit_ac_balance').val(),
				yrate: 1.5
			};
			var jsonStr = JSON.stringify(jsonObj);
			$.ajax({
			    type: "POST",
			    url: "finance/accounts/accounts_functions/list/new.php",
			    data: {
			    	data: jsonStr
			    },
			    success: function(data){
			        if (data.status) {
			        	var newIn = '<div class="list_row slideInDown animated" id="'+data.id+'"><span class="list_name"><a href="javascript:edit(\'#'+data.id+'\',1)">'+jsonObj.aname+'</a></span><span class="list_balance negative">-'+number_format(jsonObj.money)+'</span><span class="list_description" style="display:none;"></span><span class="list_yrate" style="display:none;">'+jsonObj.yrate+'</span></div>';
			        	var newInput = $(newIn);
			        	$('#block_1').append(newInput);
			        	var num = parseFloat($('#subtotal_1').text().replace(/,/g,""));
			        	var num2 = 0-parseFloat(jsonObj.money);
			        	num += num2;
			        	$('#subtotal_1').text(number_format(num));
			        	$.fancybox.close();
                        total_num_update();
			        } else {
			        	ara_alert(data.emsg);
			        };
			    }
			});
		} else if(account_type == 2){

			var jsonObj = {
                    atype: 2,
                    aname: $('#invest_ac_name').val(),
                    money: $('#invest_ac_balance').val()
            };

			var jsonStr = JSON.stringify(jsonObj);
			$.ajax({
			    type: "POST",
			    url: "finance/accounts/accounts_functions/list/new.php",
			    data: {
			    	data: jsonStr
			    },
			    success: function(data){
			        if (data.status) {
			        	var newIn = '<div class="list_row slideInDown animated" id="'+data.id+'"><span class="list_name"><a href="javascript:edit(\'#'+data.id+'\',2)">'+jsonObj.aname+'</a></span><span class="list_balance">'+number_format(jsonObj.money)+'</span><span class="list_description" style="display:none;"></span></div>';
                        var newInput = $(newIn);
                        $('#block_2').append(newInput);
                        var num = parseFloat($('#subtotal_2').text().replace(/,/g,""));
                        var num2 = parseFloat(jsonObj.money);
                        num += num2;
                        $('#subtotal_2').text(number_format(num));
                        $.fancybox.close();
                        total_num_update();
			        } else {
			        	ara_alert(data.emsg);
			        };
			    }
			});

		} else if(account_type == 22){
            var investsArr = [];
            $( ".invest_item" ).each(function(index) {
                iname = "#invest_item_name_"+index;
                itype = "#invest_item_type_"+index;
                iquantity = "#invest_item_quantity_"+index;
                iprice = "#invest_item_price_"+index;
                if ($(iname).val() != '') {
                    investsArr.push({ 'iname':$(iname).val(),'itype':$(itype).val(),'iquantity':$(iquantity).val(), 'iprice':$(iprice).val() });
                };

            });
            var jsonObj = {
                atype: 2,
                aname: $('#invest_ac_name').val(),
                money: $('#invest_ac_balance').val(),
                invests: investsArr
            };

            var jsonStr = JSON.stringify(jsonObj);
            $.ajax({
                type: "POST",
                url: "finance/accounts/accounts_functions/list/new.php",
                data: {
                    data: jsonStr
                },
                success: function(data){
                    if (data.status) {
                        var newIn = '<div class="list_row slideInDown animated" id="'+data.id+'"><span class="list_name"><a href="javascript:edit(\'#'+data.id+'\',2)">'+jsonObj.aname+'</a></span><span class="list_balance">'+number_format(jsonObj.money)+'</span><span class="list_description" style="display:none;"></span></div>';
                        var newInput = $(newIn);
                        $('#block_2').append(newInput);
                        var num = parseFloat($('#subtotal_2').text().replace(/,/g,""));
                        var num2 = parseFloat(jsonObj.money);
                        num += num2;
                        $('#subtotal_2').text(number_format(num));
                        $.fancybox.close();
                        total_num_update();
                    } else {
                        ara_alert(data.emsg);
                    };
                }
            });

        } else if(account_type == 3){

            var loanyn = $("input:radio[name=asset_loan]:checked").val();

            if (loanyn == "yes") {
                var asset_loan = $("input:radio[name=asset_loan_select]:checked").val();
                if (asset_loan == "yes") {
                    var jsonObj = {
                        atype: 3,
                        aname: $('#asset_ac_name').val(),
                        money: $('#asset_ac_money').val(),
                        bdate: $('#asset_ac_date').val(),
                        bprice: $('#asset_ac_balance').val(),
                        loan: {
                            id: $('#asset_loan_exist_ac').val()
                        }
                    };
                } else if (asset_loan == "no") {
                    var repay = $("input:radio[name=asset_loan_repay_yn]:checked").val();
                    var money = 0;
                    if (repay == 'yes') {
                        money = $('#asset_loan_ac_repay_bal').val();
                    } else {
                        money = $('#asset_loan_ac_balance').val();
                    };
                    var jsonObj = {
                        atype: 3,
                        aname: $('#asset_ac_name').val(),
                        money: $('#asset_ac_money').val(),
                        bdate: $('#asset_ac_date').val(),
                        bprice: $('#asset_ac_balance').val(),
                        loan: {
                            atype: 4,
                            aname: $('#asset_loan_ac_name').val(),
                            money: money,
                            sdate: $('#asset_loan_ac_date').val(),
                            lmoney: $('#asset_loan_ac_balance').val(),
                            tlength: $('#asset_loan_ac_length').val(),
                            tunit: $('#asset_loan_ac_unit').val(),
                            yrate: $('#asset_loan_ac_yrate').val(),
                            period: $('#asset_loan_ac_period').val()
                        }
                    };
                };
            } else {
                var jsonObj = {
                    atype: 3,
                    aname: $('#asset_ac_name').val(),
                    money: $('#asset_ac_money').val(),
                    bdate: $('#asset_ac_date').val(),
                    bprice: $('#asset_ac_balance').val()
                };
            };

            var jsonStr = JSON.stringify(jsonObj);
            $.ajax({
                type: "POST",
                url: "finance/accounts/accounts_functions/list/new.php",
                data: {
                    data: jsonStr
                },
                success: function(data){
                    if (data.status) {
                        var newIn = '<div class="list_row slideInDown animated" id="'+data.id+'"><span class="list_name"><a href="javascript:edit(\'#'+data.id+'\',3)">'+jsonObj.aname+'</a></span><span class="list_balance">'+number_format(jsonObj.money)+'</span><span class="list_description" style="display:none;"></span><span class="list_yrate" style="display:none;">'+jsonObj.yrate+'</span></div>';
                        var newInput = $(newIn);
                        $('#block_3').append(newInput);
                        var num = parseFloat($('#subtotal_3').text().replace(/,/g,""));
                        var num2 = parseFloat(jsonObj.money);
                        num += num2;
                        $('#subtotal_3').text(number_format(num));
                        if (data.lid != false) {
                            var newIn = '<div class="list_row slideInDown animated" id="'+data.lid+'"><span class="list_name"><a href="javascript:edit(\'#'+data.lid+'\',4)">'+jsonObj.loan.aname+'</a></span><span class="list_balance negative">-'+number_format(jsonObj.loan.money)+'</span><span class="list_description" style="display:none;"></span><span class="list_yrate" style="display:none;">'+jsonObj.loan.yrate+'</span></div>';
                            var newInput = $(newIn);
                            $('#block_4').append(newInput);
                            var num = parseFloat($('#subtotal_4').text().replace(/,/g,""));
                            var num2 = 0-parseFloat(jsonObj.loan.money);
                            num += num2;
                            $('#subtotal_4').text(number_format(num));
                        }
                        $.fancybox.close();
                        total_num_update();
                    } else {
                        ara_alert(data.emsg);
                    };
                }
            });
        } else if(account_type == 4){
            var asset_yn = $("input:radio[name=loan_asset_yn]:checked").val();
            var repay = $("input:radio[name=loan_repay_yn]:checked").val();
            if (asset_yn == "yes") {
                var money = 0;
                if (repay == 'yes') {
                    money = $('#loan_ac_repay_bal').val();
                } else {
                    money = $('#loan_ac_balance').val();
                };
                var jsonObj = {
                    atype: 4,
                    aname: $('#loan_ac_name').val(),
                    money: money,
                    sdate: $('#loan_ac_date').val(),
                    lmoney: $('#loan_ac_balance').val(),
                    tlength: $('#loan_ac_length').val(),
                    tunit: $('#loan_ac_unit').val(),
                    yrate: $('#loan_ac_yrate').val(),
                    period: $('#loan_ac_period').val(),
                    asset: {
                        atype: 3,
                        aname: $('#loan_ac_asset_name').val(),
                        money: $('#loan_ac_asset_bal').val()
                    }
                };
            } else if (asset_yn == "no") {
                var money = 0;
                if (repay == 'yes') {
                    money = $('#loan_ac_repay_bal').val();
                } else {
                    money = $('#loan_ac_balance').val();
                };
                var jsonObj = {
                    atype: 4,
                    aname: $('#loan_ac_name').val(),
                    money: money,
                    sdate: $('#loan_ac_date').val(),
                    lmoney: $('#loan_ac_balance').val(),
                    tlength: $('#loan_ac_length').val(),
                    tunit: $('#loan_ac_unit').val(),
                    yrate: $('#loan_ac_yrate').val(),
                    period: $('#loan_ac_period').val()
                };
            };
            var jsonStr = JSON.stringify(jsonObj);
            $.ajax({
                type: "POST",
                url: "finance/accounts/accounts_functions/list/new.php",
                data: {
                    data: jsonStr
                },
                success: function(data){
                    if (data.status) {
                        var newIn = '<div class="list_row slideInDown animated" id="'+data.id+'"><span class="list_name"><a href="javascript:edit(\'#'+data.id+'\',4)">'+jsonObj.aname+'</a></span><span class="list_balance negative">-'+number_format(jsonObj.money)+'</span><span class="list_description" style="display:none;"></span><span class="list_yrate" style="display:none;">'+jsonObj.yrate+'</span></div>';
                        var newInput = $(newIn);
                        $('#block_4').append(newInput);
                        var num = parseFloat($('#subtotal_4').text().replace(/,/g,""));
                        var num2 = 0-parseFloat(jsonObj.money);
                        num += num2;
                        $('#subtotal_4').text(number_format(num));
                        if (data.aid != false) {
                            var newIn = '<div class="list_row slideInDown animated" id="'+data.aid+'"><span class="list_name"><a href="javascript:edit(\'#'+data.aid+'\',3)">'+jsonObj.asset.aname+'</a></span><span class="list_balance">'+number_format(jsonObj.asset.money)+'</span><span class="list_description" style="display:none;"></span><span class="list_yrate" style="display:none;">'+jsonObj.asset.yrate+'</span></div>';
                            var newInput = $(newIn);
                            $('#block_3').append(newInput);
                            var num = parseFloat($('#subtotal_3').text().replace(/,/g,""));
                            var num2 = parseFloat(jsonObj.asset.money);
                            num += num2;
                            $('#subtotal_3').text(number_format(num));
                        }
                        $.fancybox.close();
                        total_num_update();
                    } else {
                        ara_alert(data.emsg);
                    };
                }
            });
        };
	}

	function ajax_update(account_type,ac_second) {
		var ac_id = '#ac_id_'+ac_second;
		var ac_real_id = $(ac_id).val();
		if (account_type == 0) {
			var temp_name = '#'+ac_second+'_ac_edit_name';
			var temp_description = '#'+ac_second+'_ac_edit_description';
			var jsonObj = {
				id: ac_real_id,
				atype: ac_second,
				aname: $(temp_name).val(),
				description: $(temp_description).val()
			};
			var jsonStr = JSON.stringify(jsonObj);
			$.ajax({
			    type: "POST",
			    url: "finance/accounts/accounts_functions/list/update.php",
			    data: {
			    	data: jsonStr
			    },
			    success: function(data){
			        if (data.status) {
			        	ac_real_id = '#'+ ac_real_id;
			        	$(ac_real_id).children(".list_name").children().text(jsonObj.aname);
			        	$(ac_real_id).children(".list_description").text(jsonObj.description);
			        	$.fancybox.close();
			        } else {
			        	ara_alert(data.emsg);
			        };
			    }
			});
		} else if(account_type == 4){
			var temp_name = '#'+ac_second+'_ac_edit_name';
			var temp_yrate = '#'+ac_second+'_ac_edit_yrate';
			var temp_description = '#'+ac_second+'_ac_edit_description';
			var jsonObj = {
				id: ac_real_id,
				atype: ac_second,
				aname: $(temp_name).val(),
				yrate: $(temp_yrate).val(),
				description: $(temp_description).val()
			};
			var jsonStr = JSON.stringify(jsonObj);
			$.ajax({
			    type: "POST",
			    url: "finance/accounts/accounts_functions/list/update.php",
			    data: {
			    	data: jsonStr
			    },
			    success: function(data){
			        if (data.status) {
			        	ac_real_id = '#'+ ac_real_id;
			        	$(ac_real_id).children(".list_name").children().text(jsonObj.aname);
			        	$(ac_real_id).children(".list_description").text(jsonObj.description);
			        	$(ac_real_id).children(".list_yrate").text(jsonObj.yrate);
			        	$.fancybox.close();
			        } else {
			        	ara_alert(data.emsg);
			        };
			    }
			});
		}
	}
</script>

</div>
