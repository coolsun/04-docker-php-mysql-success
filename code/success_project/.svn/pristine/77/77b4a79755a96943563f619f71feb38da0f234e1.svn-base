<?php
/*
 Some variables you can use.

 1. (PHP) $all_accounts = array(
 		0 => array(
 			'account_id' => 2,
 			'account_name' => 'xx銀行'
 		),
 		...
 	)

 2. (PHP) $bill_types = array(
		0 => array( 0 => '支出', 1 => '收入'),
		1 => array( 0 => '刷卡', 1 => '繳款' ),
		3 => array( 0 => '減少', 1 => '增加' ),
		4 => array( 0 => '增加', 1 => '減少' ),
	)

 3. (PHP) $bills_list = array(
 		array(
 			'bill_id' => 10,
 			'bill_date' => '2014-08-20',
 			'payee' => 'guy',
 			'mn' => 'main class name',
 			'sn' => 'sub class name',
 			'description' => 'xxxxxx',
 			'bill_type' => 0,
 			'money' => 5000,
 			'balance' => 15000
 		),
 		...
 	)

 4. (Javascript) bills_class = [
 		{
 			'0-0' => { 'mn': '帳單', 'sn': '電費' },
 			'0-1' => { 'mn': '帳單', 'sn': '自來水' },
 			...
		},
		{
			'0-0' => { 'mn': '薪水', 'sn': '電費' },
 			'1-0' => { 'mn': '績效獎金', 'sn': '自來水' },
 			...
		}
 	]

 */
 	$today = date("Y/m/d");
?>

<link href="finance/css/bills.css?20170119" rel="stylesheet" />
<link href="finance/css/bills_itembox.css" rel="stylesheet" />
<link href="js/datePicker/datePicker.css" rel="stylesheet" />

<form id="post_form" method="post" action="?dept=finance&ma=bills&sa=records">
<div class="top_block">
<?php /* Account list */ ?>
<select id="account" name="account" class="form_select" style="width:130px; margin: 0px 0px 5px 0px;">
<?php foreach ( $all_accounts as $atype => $accounts ): ?>
	<optgroup label="<?=$account_types[$atype]?>">
	<?php foreach ( $accounts as $account ): ?>
		<option value="<?=$atype .'-'. $account['account_id']?>"  <?=( $atype == $selected_atype && $account['account_id'] == $selected_aid ) ? 'selected' : '' ?>><?=$account['account_name']?></option>
	<?php endforeach; ?>
	</optgroup>
<?php endforeach; ?>
</select>


<a id="item_selector" href="#item_list" style="display:none"></a>
<table class="bills_table" style="width:455px; border-bottom:1px solid #C3C3C3; ">
	<thead>
		<tr>
			<th class="thead" style="width:95px;">日期</th>
			<th class="thead" style="width:200px;">項目</th>
			<th class="thead" style="width:80px;"><?=$bill_types[$selected_atype][0]?></th>
			<th class="thead" style="width:80px;"><?=$bill_types[$selected_atype][1]?></th>
		</tr>
	</thead>
	<tbody class="">
		<tr>
			<td style="vertical-align: top;"><input id="add_date" class="input-numbers input-table pick-Date" type="text" value="<?=$today?>"></input></td>
			<td id="item_class"></td>
			<td id="cal_trigger_1" class="cal_trigger"></td>
			<td id="cal_trigger_2" class="cal_trigger"></td>
		</tr>
	</tbody>
</table>
<div id="calculator" class="calculator" style="display:none;">
	<div class="keytable">
    <button type="button" id="key_C" class="key">C</button>
    <button type="button" id="key_back" class="key">←</button>
    <button type="button" id="key_off" class="key" style="padding-left: 2px">OFF</button>
    <button type="button" id="key_7" class="key">7</button>
    <button type="button" id="key_8" class="key">8</button>
    <button type="button" id="key_9" class="key">9</button>
    <button type="button" id="key_4" class="key">4</button>
    <button type="button" id="key_5" class="key">5</button>
    <button type="button" id="key_6" class="key">6</button>
    <button type="button" id="key_1" class="key">1</button>
    <button type="button" id="key_2" class="key">2</button>
    <button type="button" id="key_3" class="key">3</button>
    <button type="button" id="key_0" class="key" style="width:74px">0</button>
    <button type="button" id="key_dot" class="key">.</button>
    <button type="button" id="key_enter" class="key" style="width:114px">Enter</button>
	</div>
</div>
<div style="float:right; padding: 5px 6px;">
	<input class="btn func-btn" type="button" onclick="add_bills()" value="確 定" style="font-size:16px; height:28px; width:68px;"></input>
</div>
</div>

<div class='log-inner'>
    <div class='log-switch' style="border-bottom-width: 0px; border-right-width: 2px;">
    	<ul class="period" style="left:0px;">
    		<?php /* Select element of during */ ?>
    		<li>
	        <select name="selectedDuring" class="form_select" style="width:80px;">
	        <?php foreach ( $durings as $index => $during ): ?>
	        	<option value="<?=$index?>" <?=($index==$selectedDuring) ? 'selected' : '' ?>><?=$during?></option>
	        <?php endforeach; ?>
	        </select>
	        </li>
	        <li>
	        <?php /* Select element of during */ ?>
	        <select name="selectedBillType" class="form_select" style="width:80px;">
	        	<option value="-1">全部</option>
	        <?php foreach ( $bill_types[ $selected_atype ] as $index => $btype ): ?>
	        	<option value="<?=$index?>" <?=($index==$selectedBillType) ? 'selected' : '' ?>><?=$btype?></option>
	        <?php endforeach; ?>
	        </select>
	        </li>
    	</ul>
        <ul class='menu' style="right: 70px;">
        	<?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
        		<li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=finance&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
        	<?php endforeach; ?>
        </ul>
    </div>

</form>


<table id="bills_table" class="bills_table">
	<thead>
		<tr>
			<th class="thead" width="70px">日期</th>
			<th class="thead" width="105px">收款人</th>
			<th class="thead" width="190px">項目</th>
			<th class="thead">說明</th>
			<th class="thead" width="65px"><?=$bill_types[$selected_atype][0]?></th>
			<th class="thead" width="65px"><?=$bill_types[$selected_atype][1]?></th>
			<th class="thead" width="75px">結餘</th>
			<th class="thead" width="70px"></th>
		</tr>
	</thead>
	<tbody id="bills_tableblcok" class="twoColorRow">
<?php
$odd = 1;
foreach ( $bills_list as $index => $bill ){
		$odd++;
?>
		<tr id="<?=$bill['bill_id']?>"<?=($odd&1)?' class="grayLine"':""?>>
			<td style="font-size:12px; text-align:center; padding:0px;" ><?= str_replace('-', '/', $bill['bill_date'])?></td>
			<td><input class="input-table bills_payee" value="<?=$bill['payee']?>"></input></td>
			<td><?=$bill['mn']?> - <?=$bill['sn']?></td>
			<td><input class="input-table bills_description" value="<?=$bill['description']?>" style="width: 100%;"></input></td>
<?php if ($bill['bill_type']=='1') { ?>
			<td style="text-align:right;"></td>
			<td style="text-align:right;" class="bills_money"><?=number_format($bill['money'])?></td>
<?php } else { ?>
			<td style="text-align:right;" class="bills_money"><?=number_format($bill['money'])?></td>
			<td style="text-align:right;"></td>
<?php }

$count_balance = ((($selected_atype==1)||($selected_atype==4))?number_format((0-$bill['balance'])):number_format($bill['balance']));

?>
			<td style="text-align:right;" class="<?=($count_balance<0)?"negative":""?>"><?=$count_balance?></td>
			<td class="operation">
				<input class="btn" type="button" onclick="update_bills('<?=$bill['bill_id']?>')" value="確定"></input>
				<input class="btn" type="button" onclick="delete_check('<?=$bill['bill_id']?>')" value="刪除"></input>
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
			<td></td>
		</tr>
<?php
}
?>
	</tbody>
</table>
<div class="data_table_tail center"></div>

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

	<a id="alert_ok_show" href="#alert_ok_window" style="display:none;" >#</a>
	<div id="alert_ok_window">
        <div class='page-outer' style='width: 250px; height: 95px;'>
            <div class='normal-inner'>
            	<p id="alert_ok_msg"></p>
            </div>
            <div id="primary-action">
                <input class="btn func-btn" type="button" onclick="$('#post_form').submit()" value="確 定"></input>
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
            	<input id="delete_function" class="btn func-btn" type="button" onclick="delete_bills()" value="確 定"></input>
                <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="取 消"></input>
            </div>
        </div>
    </div>
	<a id="delete_item_show" href="#delete_item_window" style="display:none;" >#</a>
	<div id="delete_item_window">
        <div class='page-outer' style='width: 250px; height: 95px;'>
            <div class='normal-inner'>
            	請確認是否要刪除?
            </div>
            <div id="primary-action">
            	<input id="delete_item_function" class="btn func-btn" type="button" onclick="delete_item()" value="確 定"></input>
                <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="取 消"></input>
            </div>
        </div>
    </div>
	<div id="default_item_window">
        <div class='page-outer' style='width: 250px; height: 95px;'>
            <div class='normal-inner'>
            	請確認是否要還原預設值?
            </div>
            <div id="primary-action">
            	<input id="delete_item_function" class="btn func-btn" type="button" onclick="default_item()" value="確 定"></input>
                <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="取 消"></input>
            </div>
        </div>
    </div>
    <div id="list_item_add">
        <div class='page-outer' style='width: 320px; height: 370px;'>
            <div class='normal-inner'>
            	<form id="list_item_add_form">
                <table class='distance-table' style="height:90px;">
                <input id="bills_class_version" type="hidden" value="<?=$bills_class_version?>">
                <tr>
                    <td>
                        <div class="fancy_input_name">項目名稱</div>
                        <input class="input-numbers" type="text" value="" id="list_item_name" name="list_item_name" required></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="radio" name="list_item_type" value="0" checked>  支出
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="radio" name="list_item_type" value="1">  收入
                    </td>
                </tr>
                <tr>
                    <td>
                    	<div class="fancy_input_name" style="width: 100px; padding-left: 20px;">屬於哪個主項目</div>
                        <select id="list_item_select_0" style="width: 120px;">
                        	<option value="">新增主項目</option>
<?php
$main_menu = "";
foreach ($bills_class[0]['subclass'] as $key => $value) {
?>
			        		<option value="<?=$key?>"><?=$value['name']?></option>
<?php
}
?>
                        </select>
                        <select id="list_item_select_1" style="width: 120px; display:none;">
                        	<option value="">新增主項目</option>
<?php
$main_menu = "";
foreach ($bills_class[1]['subclass'] as $key => $value) {
?>
			        		<option value="<?=$key?>"><?=$value['name']?></option>
<?php
}
?>
                        </select>
                    </td>
                </tr>
                </table>
                </form>
            </div>
            <div id="primary-action">
                <input class="btn func-btn" type="button" onclick="add_list_item()" value="確 定"></input>
            </div>
        </div>
    </div>
        <div id="list_item_edit">
        <div class='page-outer' style='width: 320px; height: 240px;'>
            <div class='normal-inner' style="padding:0px;">
            	<form id="list_item_edit_form">
			        <div id="" class="bills_block" style="display: block; max-height: 200px;">
			        	<div class="list_menu" style="width:95px; height:170px;">
			        		<ul>
			        			<li id="list_item_edit_tri_0" class="editmenu active"><?=$bill_types[$selected_atype][0]?></li>
			        			<li id="list_item_edit_tri_1" class="editmenu"><?=$bill_types[$selected_atype][1]?></li>
			        		</ul>
			        	</div>
			        	<div class="list_select" style="width:225px; height:170px;">
			        		<div id="list_item_edit_0">
<?php

foreach ($bills_class[0]['subclass'] as $key => $value) {
?>
							<ul id="edit_0_<?=$key?>">
								<li class="edit_list" style="padding-left: 5px;"><?=$value['name']?></li>
<?php
	foreach ($value['subclass'] as $sub_key => $sub_value) {
?>
	        					<li id="edit_0_<?=$key?>-<?=$sub_key?>" class="edit_list<?=($sub_key&1)?' gray':''; ?>"><span><?=$sub_value['name']?></span><input class="btn del_item_btn" type="button" onclick="delete_item_check('0-<?=$key?>-<?=$sub_key?>')" value="刪除"></input></li>
<?php
	}
?>
							</ul>
<?php
}
?>
			        		</div>
			        		<div id="list_item_edit_1" style="display:none;">
<?php

foreach ($bills_class[1]['subclass'] as $key => $value) {
?>
							<ul id="edit_1_<?=$key?>">
								<li class="edit_list" style="padding-left: 5px;"><?=$value['name']?></li>
<?php
	foreach ($value['subclass'] as $sub_key => $sub_value) {
?>
	        					<li id="edit_1_<?=$key?>-<?=$sub_key?>" class="edit_list<?=($sub_key&1)?' gray':''; ?>"><span><?=$sub_value['name']?></span><input class="btn del_item_btn" type="button" onclick="delete_item_check('1-<?=$key?>-<?=$sub_key?>')" value="刪除"></input></li>
<?php
	}
?>
							</ul>
<?php
}
?>
			        		</div>
			        	</div>
			        </div>
                </form>
            </div>
            <div id="primary-action" style="height:40px; position: relative;background-color: #E5E5E5; right:0px; bottom:0px;">
            	<input class="btn func-btn" type="button" onclick="add_list_item()" value="確 定" style="top: 10px; position: relative; right: 10px; float: right;"></input>
            	<a id="default_item_show" href="#default_item_window" class="btn func-btn" style="width: 80px; top: 10px; position: relative; right: 10px; float: right;">回復預設值</a>
            </div>
        </div>
    </div>
</div>

<div id="bills_list-wrap" style="width: 360px; height: auto; top: 110px; left: 601px; display: none;">
	<div id="bills_list-outer">
		<div id="bills_list-bg-n" class="bills_list-bg"></div>
		<div id="bills_list-bg-ne" class="bills_list-bg"></div>
		<div id="bills_list-bg-e" class="bills_list-bg"></div>
		<div id="bills_list-bg-se" class="bills_list-bg"></div>
		<div id="bills_list-bg-s" class="bills_list-bg"></div>
		<div id="bills_list-bg-sw" class="bills_list-bg"></div>
		<div id="bills_list-bg-w" class="bills_list-bg"></div>
		<div id="bills_list-bg-nw" class="bills_list-bg"></div>
		<div id="bills_list-content" style="border-width: 0px; width: 360px; height: auto;">
			<div id="item_list">
			    <div class='page-outer' style='width: 360px; height: 515px;'>
			    	<div class="list_select_menu">
		        		<a class="btn func-btn" id="list_item_add_trigger" href="#list_item_add" style="right: 65px;">新 增</a>
		        		<a class="btn func-btn" id="list_item_edit_trigger" href="#list_item_edit" >編 輯</a>
		        	</div>
			        <div id="bills_0" class="bills_block" style="display: block;">
			        	<div class="list_menu">
			        		<ul>
<?php

foreach ($bills_class[0]['subclass'] as $key => $value) {
?>
			        			<li id="0_<?=$key?>" class="menu<?=($key=='0')?' active':''; ?>"><?=$value['name']?></li>
<?php
}
?>
			        		</ul>
			        	</div>
			        	<div class="list_select">
<?php
$main_menu = "";
$first_main = 1;
foreach ($bills_class[0]['subclass'] as $key => $value) {
?>
			        		<ul id="ul_class_0_<?=$key?>" class="select_list<?=($key=='0')?' active':''; ?>">
<?php
	foreach ($value['subclass'] as $sub_key => $sub_value) {
?>
	        					<li id="0_<?=$key?>-<?=$sub_key?>" class="select_item<?=($sub_key&1)?' gray':''; ?>"><?=$sub_value['name']?></li>
<?php
	}
?>
			        		</ul>
<?php
}
?>
			        	</div>
			        </div>
			        <div id="bills_1" class="bills_block">
			        	<div class="list_menu">
			        		<ul>
<?php

foreach ($bills_class[1]['subclass'] as $key => $value) {
?>
			        			<li id="1_<?=$key?>" class="menu<?=($key=='0')?' active':''; ?>"><?=$value['name']?></li>
<?php
}
?>
			        		</ul>
			        	</div>
			        	<div class="list_select">
<?php
$main_menu = "";
$first_main = 1;
foreach ($bills_class[1]['subclass'] as $key => $value) {
?>
			        		<ul id="ul_class_1_<?=$key?>" class="select_list<?=($key=='0')?' active':''; ?>">
<?php
	foreach ($value['subclass'] as $sub_key => $sub_value) {
?>
	        					<li id="1_<?=$key?>-<?=$sub_key?>" class="select_item<?=($sub_key&1)?' gray':''; ?>"><?=$sub_value['name']?></li>
<?php
	}
?>
			        		</ul>
<?php
}
?>
			        	</div>
			        </div>
			    </div>
			</div>
		</div>
		<a id="bills_list-close" style="display: inline;"></a>
	</div>
	<div id="bills_list-title" class="bills_list-title-outside" style="width: 360px; padding-left: 0px; padding-right: 0px; display: block;">
	    <div class="list_tab">
	        <ul>
	            <li id="tab_0" class="tab_menu active"><?=$bill_types[$selected_atype][0]?></li>
				<li id="tab_1" class="tab_menu"><?=$bill_types[$selected_atype][1]?></li>
	        </ul>
	    </div>

	</div>
</div>

<script type="text/javascript" src="finance/js/jquery.jeditable.mini.js"></script>
<script type="text/javascript" src="finance/js/number_format.js"></script>
<script type="text/javascript" src="finance/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/datePicker/date.js"></script>
<script type="text/javascript" src="js/datePicker/jquery.datePicker.js"></script>
<script type="text/javascript">

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

	$( "#item_class" ).on( "click", function() {
		$("#bills_list-wrap").show();
	});

	$( "#bills_list-close" ).on( "click", function() {
		$("#bills_list-wrap").hide();
	});

	$( "#cal_trigger_1" ).on( "click", function() {
		if(!$("#cal_trigger_1").hasClass('disable')) {
			$("#cal_trigger_2").text("");
			$("#calculator").removeClass("cal_trigger_2");
			$("#calculator").addClass("cal_trigger_1");
			$("#calculator").css({'margin-left':'292px'});
			$("#calculator").show();
		}
	});

	$( "#cal_trigger_2" ).on( "click", function() {
		if(!$("#cal_trigger_2").hasClass('disable')) {
			$("#cal_trigger_1").text("");
			$("#calculator").removeClass("cal_trigger_1");
			$("#calculator").addClass("cal_trigger_2");
			$("#calculator").css({'margin-left':'372px'});
			$("#calculator").show();
		}
	});

	$('body').on( "click","li.menu", function() {
		$("li.menu.active").removeClass('active');
		$("ul.select_list.active").removeClass('active');
		$(this).addClass('active');
		var select_id = $(this).attr('id');
		$('#ul_class_'+select_id).addClass('active');
	})
	.on( "click","li.select_item", function() {
		var select_id = $(this).attr('id').split('_');
		select_itemlist(select_id[1],$(this).text(),select_id[0]);
		$("#bills_list-wrap").hide();
	})
	.on( "click","li.tab_menu", function() {
		if ($(this).attr("id")=="tab_0") {
			$("#bills_1").hide();
			$("#bills_0").show();
			$('#0_0').trigger('click');
		} else {
			$("#bills_0").hide();
			$("#bills_1").show();
			$('#1_0').trigger('click');
		}
		$("li.tab_menu.active").removeClass('active');
		$(this).addClass('active');
	})
	.on( "click","li.editmenu", function() {
		$("li.editmenu.active").removeClass('active');
		$(this).addClass('active');
		if ($(this).attr("id")=="list_item_edit_tri_0") {
			$("#list_item_edit_0").show();
			$("#list_item_edit_1").hide();
		} else {
			$("#list_item_edit_1").show();
			$("#list_item_edit_0").hide();
		};
	});

	$(document).mouseup(function (e)
    {
        var container = $("#calculator");

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
                $("#calculator").hide();
        }
    });

	function ara_alert(msg) {
		$('#alert_msg').html(msg);
		$("#alert_show").trigger('click');
	}

	function add_list_item() {
        if ($('#list_item_add_form').valid() == false) {
            ara_alert("資料填寫未完整, 請重新輸入");
        } else {
	        var select = $("input:radio[name=list_item_type]:checked").val();
	        var type = 0;
	        if (select == "0") {
	        	type = 0;
	        	mid = $("#list_item_select_0").val();
	        } else {
	            type = 1;
	            mid = $("#list_item_select_1").val();
	        }


	        if (mid == "") {
	        	var jsonObj = {
	        		'name': $('#list_item_name').val(),
	        		'type': type,
	        		'ver': $('#bills_class_version').val()
	        	};
	        } else {
	        	var jsonObj = {
	        		'name': $('#list_item_name').val(),
	        		'type': type,
	        		'mid' : mid,
	        		'ver': $('#bills_class_version').val()
	        	};
	        };


			var jsonStr = JSON.stringify(jsonObj);
			$.ajax({
			    type: "POST",
			    url: "finance/bills/bills_functions/records/new_class.php",
			    data: {
			    	data: jsonStr
			    },
			    success: function(data){
			        if (data.status != false) {
			        	$.fancybox.close();
			        	$('#bills_class_version').val(data.ver);
			        	if (data.mid) {
							var newIn = '<li id="'+jsonObj.type+'_'+data.mid+'" class="menu">'+jsonObj.name+'</li>';
				        	var newInput = $(newIn);
				        	$('#bills_'+jsonObj.type+' .list_menu').children().append(newInput);
				        	var newIn = '<option value="'+data.mid+'">'+jsonObj.name+'</option>';
				        	var newInput = $(newIn);
				        	$('#list_item_select_'+jsonObj.type).append(newInput);
				        	var newIn = '<ul id="ul_class_'+jsonObj.type+'_'+data.mid+'" class="select_list"></ul>';
				        	var newInput = $(newIn);
				        	$('#bills_'+jsonObj.type+' .list_select').append(newInput);
			        	} else {
			        		var newIn = '<li id="'+jsonObj.type+'_'+jsonObj.mid+'-'+data.sid+'" class="select_item'+((data.sid%2==0)?"":" gray")+'">'+jsonObj.name+'</li>';
				        	var newInput = $(newIn);
				        	$('#ul_class_'+jsonObj.type+'_'+jsonObj.mid).append(newInput);
				        	var newIn = '<li id="edit_'+jsonObj.type+'_'+jsonObj.mid+'-'+data.sid+'" class="edit_list'+((data.sid%2==0)?"":" gray")+'"><span>'+jsonObj.name+'</span><input class="btn del_item_btn" onclick="delete_item_check(\''+jsonObj.type+'-'+jsonObj.mid+'-'+data.sid+'\')" value="刪除" type="button"></li>';
				        	var newInput = $(newIn);
				        	$('#edit_'+jsonObj.type+'_'+jsonObj.mid).append(newInput);
			        	};
			        } else {
			        	ara_alert(data.emsg);
			        };
			    }
			});
        }
	}

	function delete_item_check(rowID) {
		$("#delete_item_function").attr('onclick',"delete_item('"+rowID+"')");
		$("#delete_item_show").trigger('click');
	}

	function delete_item(rowID) {
		var id = rowID.split('-');
		var jsonObj = {
			type: id[0],
			mid: id[1],
			sid: id[2],
			ver: $('#bills_class_version').val()
		};
		var jsonStr = JSON.stringify(jsonObj);
		$.ajax({
		    type: "POST",
		    url: "finance/bills/bills_functions/records/delete_class.php",
		    data: {
		    	data: jsonStr
		    },
		    success: function(data){
		        if (data.status) {
		        	$.fancybox.close();
			        $('#bills_class_version').val(data.ver);
					var count = 0;
					if ($('#'+id[0]+'_'+id[1]+'-'+id[2]+' ~ .select_item').length==0) {
						$('#'+id[0]+'_'+id[1]+'-'+id[2]).remove();
					} else {
						$('#'+id[0]+'_'+id[1]+'-'+id[2]+' ~ .select_item').each(function(){
							if(count == 0) {
								$('#'+id[0]+'_'+id[1]+'-'+id[2]).remove();
							}
							$(this).toggleClass('gray');
							$(this).attr('id',id[0]+'_'+id[1]+'-'+(parseInt(id[2])+count));
							count++;
						});
					};
					var count = 0;
					if ($('#edit_'+id[0]+'_'+id[1]+'-'+id[2]+' ~ .edit_list').length==0) {
						$('#edit_'+id[0]+'_'+id[1]+'-'+id[2]).remove();
					} else {
						$('#edit_'+id[0]+'_'+id[1]+'-'+id[2]+' ~ .edit_list').each(function(){
							if(count == 0) {
								$('#edit_'+id[0]+'_'+id[1]+'-'+id[2]).remove();
							}
							$(this).toggleClass('gray');
							$(this).attr('id','edit_'+id[0]+'_'+id[1]+'-'+(parseInt(id[2])+count));
							count++;
						});
					};
		        } else {
		        	ara_alert(data.emsg);
		        };
		    }
		});
	}

	function default_item() {
		var jsonObj = {
			ver: $('#bills_class_version').val()
		};
		var jsonStr = JSON.stringify(jsonObj);
		$.ajax({
		    type: "POST",
		    url: "finance/bills/bills_functions/records/default_class.php",
		    data: {
		    	data: jsonStr
		    },
		    success: function(data){
		        if (data.status) {
		        	location.reload(true);
		        } else {
		        	ara_alert(data.emsg);
		        };
		    }
		});
	}

	function add_bills() {
		var money = 0;

		if (($('#cal_trigger_1').text()=="")) {
			money = $('#cal_trigger_2').text();
		} else {
			money = $('#cal_trigger_1').text();
		};

		var account = $('#account').val().split('-');

        if (($('#item_class').text()=="")||money=="") {
            ara_alert("資料填寫未完整, 請重新輸入");
        } else {
			var jsonObj = {
				'aid': account[1],
				'date': $('#add_date').val(),
				'class': $('#item_class').attr('class'),
				'type': ($('#cal_trigger_1').text()=="")?'1':'0',
				'money': money
			};
			var jsonStr = JSON.stringify(jsonObj);
			$.ajax({
			    type: "POST",
			    url: "finance/bills/bills_functions/records/new.php",
			    data: {
			    	data: jsonStr
			    },
			    success: function(data){
			        if (data.status) {
			        	$.fancybox.close();
			        	if(data.msg != undefined) {
			        		$('#alert_ok_msg').html(data.msg);
			        		$("#alert_ok_show").trigger('click');
			        	} else {
			        		$('#post_form').submit();
			        	}
<?php /*
			        	var list_class = jsonObj.class.split('-');
			        	var class_name_main = $('#'+jsonObj.type+'_'+list_class[0]).text();
			        	var class_name_sub = $('#'+jsonObj.type+'_'+jsonObj.class).text();
			        	var nowmoney = parseFloat($('#bills_tableblcok tr:first-child').children('td:eq(6)').text().replace(/,/g,""));
			        	var sign = (jsonObj.type=='0')?-1:1;
			        	if (jsonObj.type=='0') {
			        		var moneystr = '<td style="text-align:right;" class="bills_money">'+number_format(jsonObj.money)+'</td><td style="text-align:right;"></td>';
			        	} else {
			        		var moneystr = '<td style="text-align:right;"></td><td style="text-align:right;" class="bills_money">'+number_format(jsonObj.money)+'</td>';
			        	};

			        	var newIn = '<tr id=""><td style="font-size:12px; text-align:center; padding:0px;" >'+jsonObj.date+'</td><td><input class="input-table bills_payee" value=""></input></td><td>'+class_name_main+' - '+class_name_sub+'</td><td><input class="input-table bills_description" value="" style="width: 100%;"></input></td>'+moneystr+'<td style="text-align:right;" class="bills_money">'+number_format(nowmoney+(sign*jsonObj.money))+'</td><td class="operation"><input class="btn" type="button" onclick="update_bills(\''+jsonObj.aid+'\')" value="確定"></input><input class="btn" type="button" onclick="delete_check(\''+jsonObj.aid+'\')" value="刪除"></input></td></tr>';
			        	var newInput = $(newIn);
			        	$('#bills_tableblcok').children('tr').toggleClass('grayLine');
			        	$('#bills_tableblcok').prepend(newInput);
*/ ?>
			        } else {
			        	ara_alert(data.emsg);
			        };
			    }
			});
		}
	}

	function delete_check(rowID) {
		$("#delete_function").attr('onclick',"delete_bills('"+rowID+"')");
		$("#delete_show").trigger('click');
	}

	function delete_bills(rowID) {
		var account = $('#account').val().split('-');
		var jsonObj = {
			aid: account[1],
			bid: rowID
		};
		var jsonStr = JSON.stringify(jsonObj);
		$.ajax({
		    type: "POST",
		    url: "finance/bills/bills_functions/records/delete.php",
		    data: {
		    	data: jsonStr
		    },
		    success: function(data){
		        if (data.status) {
		        	var num = parseFloat($('#'+rowID).children('td.bills_money').text().replace(/,/g,""));
		        	var sign = ($('#'+rowID+' td').index($('#'+rowID+' td.bills_money'))==4)?-1:1;
		        	num *= sign;
		        	$.fancybox.close();
		        	var divider = false;
		        	$('#bills_tableblcok tr').each(function(){
					    if($(this).attr('id') == rowID) {
					        $(this).remove();
					        divider = true;
					    } else {
					        if (!divider) {
						        var num2 = parseFloat($(this).children('td:eq(6)').text().replace(/,/g,""));
					        	num2 -= num;
					        	$(this).children('td:eq(6)').text(number_format(num2));
					        } else {
					        	$(this).toggleClass('grayLine');
					        };
					    }
					});
					$('#bills_tableblcok tr:eq(11)').show();
		        } else {
		        	ara_alert(data.emsg);
		        };
		    }
		});
	}

	function update_bills(rowID) {
		var account = $('#account').val().split('-');
		var jsonObj = {
			aid: account[1],
			bid: rowID,
			payee:$("#"+rowID).children('td:eq(1)').children().val(),
			description:$("#"+rowID).children('td:eq(3)').children().val(),
			money: $("#"+rowID).children(".bills_money").text().replace(/,/g,"")

		};
		var jsonStr = JSON.stringify(jsonObj);
		$.ajax({
		    type: "POST",
		    url: "finance/bills/bills_functions/records/update.php",
		    data: {
		    	data: jsonStr
		    },
		    success: function(data){
		        if (data.status) {
		        	console.log('update row:'+rowID);
		        } else {
		        	ara_alert(data.emsg);
		        };
		    }
		});
	}

	$( "button.key" ).on( "click", function() {
		cal_input($(this).attr('id').substr(4));
	});

	function cal_input(num) {
		if ($('#calculator').hasClass('cal_trigger_1')) {
			position = $('#cal_trigger_1')
		} else {
			position = $('#cal_trigger_2')
		};
		if (num == 'C') {
			position.text("");
		} else if (num == 'back') {
			position.text(position.text().substr(0,position.text().length-1))
		} else if (num == 'dot') {
			if (position.text().indexOf('.') == -1) {
				position.text(position.text()+'\.')
			}
		} else if (num == 'enter') {
			$("#calculator").hide();
		} else if (num == 'off') {
			position.text("");
			$("#calculator").hide();
		} else {
			position.text(position.text()+num)
		};
	}

	function select_itemlist(id,name,type) {
		$("#item_class").text(name);
		$("#item_class").attr('class',id);
		if (type=='0') {
			$('#cal_trigger_2').addClass('disable');
			$('#cal_trigger_2').text('');
			$('#cal_trigger_1').removeClass('disable');
		} else {
			$('#cal_trigger_1').addClass('disable');
			$('#cal_trigger_1').text('');
			$('#cal_trigger_2').removeClass('disable');
		};
	}

	$(document).ready(function() {
        $("form").validate();
        jQuery.validator.messages.required = "";
		$('.pick-Date').datePicker({startDate: '1991/01/01', endDate: (new Date()).asString(), clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: -1, horizontalOffset: 165 });
		$('#add_date').dpSetSelected('<?=$today?>');
		$(".form_select").on("change",function(){
			$("#post_form").submit();
		});

		$('#list_item_add_form').submit(function() {
			return false;
		});

		$('#list_item_edit_form').submit(function() {
			return false;
		});

        $("input:radio[name=list_item_type]").change(function(){
            var select = $("input:radio[name=list_item_type]:checked").val();
            if (select == "0") {
            	$('#list_item_select_1').hide();
                $('#list_item_select_0').show();
            } else {
                $('#list_item_select_0').hide();
                $('#list_item_select_1').show();
            }
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

	    $("#delete_item_show").fancybox({
	        'type': 'inline',
	        'title': '',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#default_item_show").fancybox({
	        'type': 'inline',
	        'title': '',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#list_item_add_trigger").fancybox({
	        'type': 'inline',
	        'title': '新增項目',
	        'padding' : 0,
            'onStart' : function() {
                $('#list_item_name').closest('form').find("input[type=text], textarea").val("");
            },
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });

	    $("#list_item_edit_trigger").fancybox({
	        'type': 'inline',
	        'title': '刪除項目',
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

	    $("#alert_ok_show").fancybox({
	        'type': 'inline',
	        'title': '',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });
	});
</script>