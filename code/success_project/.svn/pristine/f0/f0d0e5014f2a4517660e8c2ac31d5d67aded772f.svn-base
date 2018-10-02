<?php
/*
 Some variables you can use.
 1. (PHP) $all_accounts = array(
 	array(
 		'id' => 1,
 		'name' => 'xx帳戶'
 	)
 )
 2. (PHP) $savings_items = array(
 		0 => array(
	 		'sid' 	=> 0,
			'aid' 	=> 1,
			'type'	=> 0, // 0:支出, 1:收入
			'date'	=> '2015/05/05',
			'aname'	=> '帳戶名稱',
			'sname' => '收款/支付人',
			'iname'	=> '品項',
			'money'	=> 1000,
			'balance' => 99999,
			'period'	=> 1 // 0:週, 1:月, 2:季, 3:年
		),
		...
 	)

 */
// if (isset($_COOKIE["account"])&& !isset($_POST['account'])) {
//     $selected_aid = $_COOKIE["account"];
// }
?>
<link href="finance/css/saving.css" rel="stylesheet" />
<link href="js/datePicker/datePicker.css" rel="stylesheet" />

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

    <div id="inline_saving_add_1">
        <div class='page-outer' style='width: 320px; height: 340px;'>
            <div class='normal-inner'>
                <form id="form_saving_add_1">
                <table class='distance-table'>
                <tr>
                    <td>
                        <div class="fancy_input_name" style="width: 80px;">誰付錢給您</div>
                        <input class="input-numbers" type="text" value="" id="sf_add_1_sname" name="sf_add_1_sname" required style="width: 170px;"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">金額</div>
                        <input class="input-numbers" type="text" value="" id="sf_add_1_money" name="sf_add_1_money" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">品項</div>
                        <input class="input-numbers" type="text" value="" id="sf_add_1_iname" name="sf_add_1_iname" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">收入帳戶</div>
                        <select id="sf_add_1_aid" name="sf_add_1_aid" style="width: 150px;">
                        <?php foreach ( $all_accounts[0] as $account ): ?>
							<option value="<?=$account['account_id']?>"><?=$account['account_name']?></option>
						<?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">入帳日期</div>
                        <input class="input-numbers pick-Date" type="text" value="" id="sf_add_1_date" name="sf_add_1_date" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name" style="width: 100px;">多久入帳一次</div>
                        <select id="sf_add_1_period" name="sf_add_1_period" style="width: 150px;">
                            <option value="0">每週</option>
                            <option value="1" selected>每月</option>
                            <option value="2">每季</option>
                            <option value="3">每年</option>
                        </select>
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

    <div id="inline_saving_add_0">
        <div class='page-outer' style='width: 320px; height: 340px;'>
            <div class='normal-inner'>
                <form id="form_saving_add_0">
                <table class='distance-table'>
                <tr>
                    <td>
                        <div class="fancy_input_name">支出給誰</div>
                        <input class="input-numbers" type="text" value="" id="sf_add_0_sname" name="sf_add_0_sname" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">金額</div>
                        <input class="input-numbers" type="text" value="" id="sf_add_0_money" name="sf_add_0_money" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">品項</div>
                        <input class="input-numbers" type="text" value="" id="sf_add_0_iname" name="sf_add_0_iname" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">支出帳戶</div>
                        <select id="sf_add_0_aid" name="sf_add_0_aid" style="width: 150px;">
                        <?php foreach ( $all_accounts[0] as $account ): ?>
							<option value="<?=$account['account_id']?>"><?=$account['account_name']?></option>
						<?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">支出日期</div>
                        <input class="input-numbers pick-Date" type="text" value="" id="sf_add_0_date" name="sf_add_0_date" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name" style="width: 100px;">多久支出一次</div>
                        <select id="sf_add_0_period" name="sf_add_0_period" style="width: 150px;">
                            <option value="0">每週</option>
                            <option value="1" selected>每月</option>
                            <option value="2">每季</option>
                            <option value="3">每年</option>
                        </select>
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

    <div id="inline_rem_0">
        <div class='page-outer' style='width: 320px; height: 240px;'>
            <div class='normal-inner'>
                <form id="form_rem_0">
                <table class='distance-table'>
                <tr>
                    <td>
                        <div class="fancy_input_name rem_type rem_type_1" style="width: 80px;">誰付錢給您</div>
                        <div class="fancy_input_name rem_type rem_type_0">支出給誰</div>
                        <input class="input-numbers" type="text" value="" id="rem_0_sname" name="rem_0_sname" required style="width: 170px;"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">金額</div>
                        <input class="input-numbers" type="text" value="" id="rem_0_money" name="rem_0_money" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">品項</div>
                        <input class="input-numbers" type="text" value="" id="rem_0_iname" name="rem_0_iname" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name rem_type rem_type_1">入帳日期</div>
                        <div class="fancy_input_name rem_type rem_type_0">支出日期</div>
                        <input class="input-numbers pick-Date" type="text" value="" id="rem_0_date" name="rem_0_date" required></input>
                    </td>
                </tr>
                </table>
                </form>
            </div>
            <div id="primary-action">
                <input id="rem_fun_btn_0" class="btn func-btn" type="button" onclick="" value="確 定"></input>
            </div>
        </div>
    </div>

    <div id="inline_rem_1">
        <div class='page-outer' style='width: 320px; height: 300px;'>
            <div class='normal-inner'>
                <form id="form_rem_1">
                <table class='distance-table'>
                <tr>
                    <td>
                        <div class="fancy_input_name rem_type rem_type_1" style="width: 80px;">誰付錢給您</div>
                        <div class="fancy_input_name rem_type rem_type_0">支出給誰</div>
                        <input class="input-numbers" type="text" value="" id="rem_1_sname" name="rem_1_sname" required style="width: 170px;"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">金額</div>
                        <input class="input-numbers" type="text" value="" id="rem_1_money" name="rem_1_money" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">品項</div>
                        <input class="input-numbers" type="text" value="" id="rem_1_iname" name="rem_1_iname" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name rem_type rem_type_1">入帳日期</div>
                        <div class="fancy_input_name rem_type rem_type_0">支出日期</div>
                        <input class="input-numbers pick-Date" type="text" value="" id="rem_1_date" name="rem_1_date" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                    	<div class="fancy_input_name rem_type rem_type_1" style="width: 100px;">多久入帳一次</div>
                        <div class="fancy_input_name rem_type rem_type_0" style="width: 100px;">多久支出一次</div>
                        <select id="rem_1_period" name="rem_1_period" style="width: 150px;">
                            <option value="0">每週</option>
                            <option value="1" selected>每月</option>
                            <option value="2">每季</option>
                            <option value="3">每年</option>
                        </select>
                    </td>
                </tr>
                </table>
                </form>
            </div>
            <div id="primary-action">
                <input id="rem_fun_btn_1" class="btn func-btn" type="button" onclick="" value="確 定"></input>
            </div>
        </div>
    </div>

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
</div>
<div class='log-inner'>
	<form id="post_form" method="post" action="?dept=finance&ma=saving">
    <div class='log-switch' style="border-bottom-width: 0px; border-right-width: 2px;">
    	<ul class="period" style="left:0px;">
    		<?php /* Select element of during */ ?>
    		<li>
	        <select id="all_accounts" class="form_select" name="account">
			<?php foreach ( $all_accounts as $atype => $accounts ): ?>
				<optgroup label="<?=$account_types[$atype]?>">
				<?php foreach ( $accounts as $account ): ?>
					<option value="<?=$atype.'-'.$account['account_id']?>"  <?=( $atype == $selected_atype && $account['account_id'] == $selected_aid ) ? 'selected' : '' ?>><?=$account['account_name']?></option>
				<?php endforeach; ?>
                <?php setcookie("account", $selected_aid);?>
				</optgroup>
			<?php endforeach; ?>
			</select>
	        </li>
	        <li>
	        <?php /* Select element of during */ ?>
			<select id="selectedDuring" class="form_select" name="selectedDuring">
			<?php foreach ( $durings as $index => $during ): ?>
				<option value="<?=$index?>" <?=($index==$selectedDuring) ? 'selected' : '' ?>><?=$during?></option>
			<?php endforeach; ?>
			</select>
	        </li>
    	</ul>
        <ul id='function_menu' class='menu' style="right: 70px;">
        	<?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
        		<li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=finance&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
        	<?php endforeach; ?>
        </ul>
    </div>
</form>

<div id="row_edit_menu" class="saving_fc_menu" style="display: none;">
	<input id="rem_type" type="hidden" style="display:none;">
    <a id="rem_0" href="#inline_rem_0" class="add_ac_menu_item" style="">僅此一項</a>
    <a id="rem_1" href="#inline_rem_1" class="add_ac_menu_item" style="">此項及未來所有項目</a>
</div>

<div id="row_delete_menu" class="saving_fc_menu" style="display: none;">
    <a id="rem_delete_0" href="javascrit:ajax_delete('0')" class="add_ac_menu_item" style="">僅此一項</a>
    <a id="rem_delete_1" href="javascrit:ajax_delete('1')" class="add_ac_menu_item" style="">此項及未來所有項目</a>
</div>
<table id="saving_table" class="saving_table">
	<thead>
		<tr>
			<th class="thead" width="70px">種類</th>
			<th class="thead" width="105px">日期</th>
			<th class="thead">收款/放款人</th>
			<th class="thead">品項</th>
			<th class="thead" width="65px">金額</th>
			<th class="thead" width="75px">結餘</th>
			<th class="thead" width="70px"></th>
		</tr>
	</thead>
	<tbody id="saving_tableblcok" class="twoColorRow">
<?php
$odd = 1;
foreach ( $savings_items as $saving_item ){
		$odd++;
?>
		<tr id="<?=$saving_item['sid'].'_'.$saving_item['dateInt']?>"<?=($odd&1)?' class="grayLine"':""?> data-json = '<?=json_encode($saving_item)?>'>
			<td><?=$saving_types[ $saving_item['type'] ]?></td>
			<td style="font-size:12px; text-align:center; padding:0px;" ><?= str_replace('-', '/', $saving_item['date'])?></td>
			<td><?=$saving_item['sname']?></td>
			<td><?=$saving_item['iname']?></td>
			<td style="text-align:right;" class="saving_money"><?=($saving_item['type']==0)?'-':''?><?=number_format($saving_item['money'])?></td>
			<td style="text-align:right;" class="<?=($saving_item['balance']<0)?"negative":""?>"><?=number_format($saving_item['balance'])?></td>
			<td class="operation">
				<input class="btn rem_edit" type="button" onclick="show_edit($(this),'<?=$saving_item['type']?>','<?=$saving_item['sid'].'_'.$saving_item['dateInt']?>')" value="編輯"></input>
				<input class="btn rem_delete" type="button" onclick="show_delete($(this),'<?=$saving_item['sid'].'_'.$saving_item['dateInt']?>')" value="刪除"></input>
			</td>
		</tr>
<?php
}
for ($i = 0; $i<12;$i++) {
?>
		<tr<?=($odd+$i+1&1)?' class="grayLine"':""?> <?=(($odd+$i)>12)?" style='display:none;'":"" ?>>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
<?php
}
?>
	</tbody>
</table>
<div class="data_table_tail center"></div>

</div>

<script type="text/javascript" src="finance/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="finance/js/additional-methods.min.js"></script>
<script type="text/javascript" src="finance/js/number_format.js"></script>
<script type="text/javascript" src="js/datePicker/date.js"></script>
<script type="text/javascript" src="js/datePicker/jquery.datePicker.js"></script>
<link href="js/datePicker/datePicker.css" rel="stylesheet" />
<script type="text/javascript">

	$(document).mouseup(function (e)
    {
        var container = $("#saving_menu");

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            if (container.hasClass("active")) {
                $("#saving_fc_menu").hide();
                container.toggleClass("active");
            }
        } else {
            if (container.hasClass("active")) {
                $("#saving_fc_menu").hide();
            } else {
                $("#saving_fc_menu").show();
            };
            container.toggleClass("active");
        }

        var container_rem = $(".rem_edit");

        if (!container_rem.is(e.target) // if the target of the click isn't the container_rem...
            && container_rem.has(e.target).length === 0) // ... nor a descendant of the container_rem
        {
            if ($("#row_edit_menu").hasClass("active")) {
                $("#row_edit_menu").hide();
                $("#row_edit_menu").toggleClass("active");
            }
        } else {
            if ($("#row_edit_menu").hasClass("active")) {
                $("#row_edit_menu").hide();
            } else {
                $("#row_edit_menu").show();
            };
            $("#row_edit_menu").toggleClass("active");
        }

        var container_rem = $(".rem_delete");

        if (!container_rem.is(e.target) // if the target of the click isn't the container_rem...
            && container_rem.has(e.target).length === 0) // ... nor a descendant of the container_rem
        {
            if ($("#row_delete_menu").hasClass("active")) {
                $("#row_delete_menu").hide();
                $("#row_delete_menu").toggleClass("active");
            }
        } else {
            if ($("#row_delete_menu").hasClass("active")) {
                $("#row_delete_menu").hide();
            } else {
                $("#row_delete_menu").show();
            };
            $("#row_delete_menu").toggleClass("active");
        }
    });

	$(function(){

		$(".form_select").on("change",function(){
			$("#post_form").submit();
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

		$("#saving_add_0").fancybox({
	        'type': 'inline',
	        'title': '支出資訊',
	        'padding' : 0,
	        'onStart' : function() {
                $('#sf_add_0_sname').find("input[type=text], textarea").val("");
                $('#sf_add_0_period').val(1);
            },
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#saving_add_1").fancybox({
	        'type': 'inline',
	        'title': '收入資訊',
	        'padding' : 0,
	        'onStart' : function() {
                $('#sf_add_1_sname').find("input[type=text], textarea").val("");
                $('#sf_add_1_period').val(1);
            },
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $('.pick-Date').datePicker({
            startDate: (new Date()).asString(),
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

		$( "#cal_trigger_1" ).on( "click", function() {
			if(!$("#cal_trigger_1").hasClass('disable')) {
				$("#cal_trigger_2").text("");
				$("#calculator").removeClass("cal_trigger_2");
				$("#calculator").addClass("cal_trigger_1");
				$("#calculator").css({'margin-left':'292px'});
				$("#calculator").show();
			}
		});
	});

//================================================================================
//
//
//          #####        #    #        ##   #        #####
//          #            #    #        # #  #        #
//          #####        #    #        #  # #        #
//          #            #    #        #   ##        #
//          #            ######        #    #        #####
//
//
//================================================================================
	function ara_alert(msg) {
		$('#alert_msg').html(msg);
		$("#alert_show").trigger('click');
	}

	function check_form(name){
        var check_form = $(('#form_saving_add_'+name));
        if (check_form.valid() == false) {
            ara_alert("資料填寫未完整, 請重新輸入");
        } else {
            switch (name) {
                case '0':
                    ajax_add(0);
                    break;
                case '1':
                    ajax_add(1);
                    break;
                default:
                    ajax_add(parseInt(name.charAt(0)));
            }
        };
    }

    function check_edit_form(type,rowID){
        var check_form = $(('#form_rem_'+type));
        if (check_form.valid() == false) {
            ara_alert("資料填寫未完整, 請重新輸入");
        } else {
            switch (type) {
                case '0':
                    ajax_edit(rowID,0);
                    break;
                case '1':
                    ajax_edit(rowID,1);
                    break;
                default:
                    ajax_edit(rowID,parseInt(name.charAt(0)));
            }
        };
    }

    function ajax_add(account_type) {

		var json_str = JSON.stringify({
			"aid": $('#sf_add_'+account_type+'_aid').val(),
			"date": $('#sf_add_'+account_type+'_date').val(),
			"type": account_type,
			"money": $('#sf_add_'+account_type+'_money').val(),
			"sname": $('#sf_add_'+account_type+'_sname').val(),
			"iname": $('#sf_add_'+account_type+'_iname').val(),
			"period": $('#sf_add_'+account_type+'_period').val()
		});
		$.ajax({
			url: 'finance/saving/saving_functions/strategies/new.php',
			data: { "data": json_str },
			type: 'post',
			dataType: "json",
			success: function(data) {
				console.log(data);
				if (data.status == false) {
					ara_alert(data.emsg);
				} else {
                    $("#all_accounts").val('0-'+$('#sf_add_'+account_type+'_aid').val());
					$("#post_form").submit();
				};
			},
			error: function() {
				console.log('error');
			}
		});
	}

	function ajax_edit(rowID,utype) {

		var json_data = $('#'+rowID).data('json');
		console.log(json_data);
		var period = (utype==1) ? $('#rem_1_period').val() : json_data.period ;

		var json_str = JSON.stringify({
			'aid': json_data.aid, // 帳戶id,
			'sid': json_data.sid, // 項目id
			'date': $('#rem_'+utype+'_date').val(), // 更新日期
			'originDate': json_data.date, // 原始日期
			'type': json_data.type, // 支出(0)/收入(1)
			'money': $('#rem_'+utype+'_money').val(), // 金額
			'sname': $('#rem_'+utype+'_sname').val(),
			'iname': $('#rem_'+utype+'_iname').val(),
			'period': period, // 參考支付週期索引
			'utype': utype
		});

		$.ajax({
			url: 'finance/saving/saving_functions/strategies/update.php',
			data: { "data": json_str },
			type: 'post',
			dataType: "json",
			success: function(data) {
				console.log(data);
				if (data.status == false) {
					ara_alert(data.emsg);
				} else {
					$("#post_form").submit();
				};
			},
			error: function() {
				console.log('error');
			}
		});
	}

	function show_edit(button,type,rowID) {
		var offset = button.offset();
		
		var Edit_row = $("#"+rowID);
		var sn_width = [190,170];
		var rem_type_name = (type==0) ? '支出資訊' : '收入資訊' ;
		var json_data = Edit_row.data('json');
        $.fancybox.close();
		$("#rem_0").fancybox({
	        'type': 'inline',
	        'title': rem_type_name,
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

		$("#rem_0_sname").css("width",sn_width[type]);

	    $("#rem_0_sname").val(Edit_row.find('td:eq(2)').text().trim());
	    $("#rem_0_money").val(json_data.money);
	    $("#rem_0_iname").val(Edit_row.find('td:eq(3)').text().trim());
	    $("#rem_0_date").val(Edit_row.find('td:eq(1)').text().trim());

	    $("#rem_1").fancybox({
	        'type': 'inline',
	        'title': rem_type_name,
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

		$("#rem_1_sname").css("width",sn_width[type]);

	    $("#rem_1_sname").val(Edit_row.find('td:eq(2)').text().trim());
	    $("#rem_1_money").val(json_data.money);
	    $("#rem_1_iname").val(Edit_row.find('td:eq(3)').text().trim());
	    $("#rem_1_date").val(Edit_row.find('td:eq(1)').text().trim());
	    $("#rem_1_period ").val(json_data.period);

	    $("#rem_fun_btn_0").attr("onClick","check_edit_form('0','"+rowID+"')");
	    $("#rem_fun_btn_1").attr("onClick","check_edit_form('1','"+rowID+"')");
		
		$(".rem_type").hide();
		$(".rem_type_"+type).show();
		$("#row_edit_menu").offset({ top: offset.top+20});
		
	}

	function show_delete(button,rowID) {
		var offset = button.offset();
		
		$("#row_delete_menu").offset({ top: offset.top+20});
		$('#rem_delete_0').attr('href',"javascript:ajax_delete('0','"+rowID+"')");
		$('#rem_delete_1').attr('href',"javascript:ajax_delete('1','"+rowID+"')");
	}

	function ajax_delete(type,rowID) {

		var Edit_row = $("#"+rowID);
		var json_data = Edit_row.data('json');
		console.log(json_data.date);
		console.log(json_data.date.replace(/\-/g, "/"));
		var json_str = JSON.stringify({
			"aid": json_data.aid,
			"sid": json_data.sid,
			"date": json_data.date.replace(/\-/g, "/"),
			"dtype": type,
		});
		$.ajax({
			url: 'finance/saving/saving_functions/strategies/delete.php',
			data: { "data": json_str },
			type: 'post',
			dataType: "json",
			success: function(data) {
				console.log(data);
				if (data.status == false) {
					ara_alert(data.emsg);
				} else {
					$("#post_form").submit();
				};
			},
			error: function() {
				console.log('error');
			}
		});
	}
</script>