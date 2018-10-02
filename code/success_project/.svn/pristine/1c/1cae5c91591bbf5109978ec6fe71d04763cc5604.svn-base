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

 2. (Javascript: in function 'get_bills' ) bs = [
 		{
			'atype': 0,
			'class': '帳單:室內電話',
			'money': 500,
			'balance': 32500,
			'date': '2014/09/09',
			'payee': '收款人',
			'description': '說明'
 		},
 		...
 	]

 */
?>

function get_bills( bs )
{
	/*
	 * When slice of pie is clicked, will pass 'bs' to here.
	 */
	$("#bills_tableblcok").html("");
	console.log(bs);
	$.each( bs, function( i, val ) {
		add_row(val);
	});

	$('#bills_pop').show();
}

function setPosition (Posx,Posy) {
	$("#bills_pop").css("left",Posx+200).css("top",Posy+200);
}
</script>
<script type="text/javascript" src="finance/js/number_format.js"></script>

<?php /* Account list */ ?>
<form id="select_form" action="?dept=finance&ma=bills&sa=statics" method="post">
<div class='log-inner'>
    <div class='log-switch'>
    	<ul class="period">
    		<?php /* Select element of during */ ?>
    		<li>
    		<select name="account" class="form_select">
<?php foreach ( $all_accounts as $atype => $accounts ): ?>
			<optgroup label="<?=$account_types[$atype]?>">
<?php foreach ( $accounts as $account ): ?>
				<option value="<?=$atype.'-'.$account['account_id']?>"  <?=( $atype == $selected_atype && $account['account_id'] == $selected_aid ) ? 'selected' : '' ?>><?=$account['account_name']?></option>
<?php endforeach; ?>
			</optgroup>
<?php endforeach; ?>
			</select>
	        <select name="selectedDuring" class="form_select">
	        <?php foreach ( $durings as $index => $during ): ?>
	        	<option value="<?=$index?>" <?=($index==$selectedDuring) ? 'selected' : '' ?>><?=$during?></option>
	        <?php endforeach; ?>
	        </select>
	        <?php /* Select element of during */ ?>
	        <select name="selectedBillType" class="form_select">
	        <?php foreach ( $bill_types[ $selected_atype ] as $index => $btype ): ?>
	        	<option value="<?=$index?>" <?=($index==$selectedBillType) ? 'selected' : '' ?>><?=$btype?></option>
	        <?php endforeach; ?>
	        </select>
	        </li>
    	</ul>
        <ul class='menu'>
        	<?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
        		<li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=finance&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
        	<?php endforeach; ?>
        </ul>
    </div>
</form>

<?php if( $bills_list ): ?>
<?php /* Charts container */ ?>
<div id="pie" style="width:700px;"></div>
<div id="bar" style="width:600px;"></div>
<div id="bills_pop" class="bills_table_pop" style="display:none;">
	<table class="bills_table" width="550px">
		<thead>
			<tr>
				<th class="thead" width="85px">日期</th>
				<th class="thead" width="105px">收款人</th>
				<th class="thead" width="105px">項目</th>
				<th class="thead">說明</th>
				<th class="thead"><?=$bill_types[$selected_atype][0]?></th>
				<th class="thead"><?=$bill_types[$selected_atype][1]?></th>
				<th class="thead">結餘</th>
			</tr>
		</thead>
		<tbody id="bills_tableblcok" class="basic_row">

		</tbody>
	</table>
	<div style="border-bottom: 1px solid #C3C3C3; width:550px;"></div>
</div>
<?php else: ?>
沒有資料
<div style="display:none;">
	<div id="pie" style="width:700px;"></div>
	<div id="bar" style="width:600px;"></div>
</div>
<?php endif;?>

</div>



<link href="finance/css/bills.css" rel="stylesheet" />

<script type="text/javascript">

	$(document).mouseup(function (e)
	{
	    var container = $("#bills_pop");

	    if (!container.is(e.target) // if the target of the click isn't the container...
	        && container.has(e.target).length === 0) // ... nor a descendant of the container
	    {
	        $("#bills_pop").hide();
	    }
	});

	$(document).ready(function() {
		$(".form_select").on("change",function(){
			$("#select_form").submit();
		});
	});

	function add_row(obj) {
		if (obj.balance < 0) {
			var neg = ' class="negative"';
		} else {
			var neg = '';
		};

		if (obj.atype == 0) {
			var newIn = '<tr><td align="center">'+obj.date+'</td><td>'+obj.payee+'</td><td align="center">'+obj.class+'</td><td>'+obj.description+'</td><td>'+obj.money+'</td><td></td><td'+neg+'>'+number_format(obj.balance)+'</td></tr>';
		} else {
			var newIn = '<tr><td align="center">'+obj.date+'</td><td>'+obj.payee+'</td><td align="center">'+obj.class+'</td><td>'+obj.description+'</td><td></td><td>'+obj.money+'</td><td'+neg+'>'+number_format(obj.balance)+'</td></tr>';
		};
		var newInput = $(newIn);
		$('#bills_tableblcok').prepend(newInput);
	}

	function check_numcolor (obj) {
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

</script>