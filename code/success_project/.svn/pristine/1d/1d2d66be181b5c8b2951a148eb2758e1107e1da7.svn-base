<?php
/*
 Please don't edit above code.

 Some variables you can use.

 1. (PHP) $bills_out_class['subclass'] = array(
		array(
			'name' => '帳單',
			'subclass' => array(
				array(
					'name' => '電費',
					'budget' => 1000  // if this sub class has budget, this would be set
				),
				...
			)
		),
		...
 	)
 */

$sa_link = 'budgets';
?>
<form id="change_form" method="post" action=".?dept=finance&ma=bills&sa=budgets&ssa=edit">
	<input id="change_tu" type="hidden" name="tu">
</form>
<form id="post_form" method="post" action=".?dept=finance&ma=bills&sa=budgets">

	<?php // this field is necessary ?>
	<input type="hidden" name="version" value="<?=$bills_class_version?>" />
<div class='log-inner'>
    <div class='log-switch'>
    	<ul class="period">
    		<?php /* Select element of during */ ?>
    		<li>
			<select id="select_tu" name="tu" >
			<?php foreach ( $time_units as $index => $tn ): ?>
				<option value="<?=$index?>" <?=($index == $time_unit) ? 'selected': ''?>><?=$tn?></option>
			<?php endforeach; ?>
			</select>
	        </li>
    	</ul>
        <ul class='menu'>
        	<?php foreach ( $sas[ $ma ] as $sa => $sa_name ): ?>
        		<li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=finance&ma=<?=$ma?>&sa=<?=$sa?>"><?=$sa_name?></a></li>
        	<?php endforeach; ?>
        </ul>
		<?php // time unit ?>
	</div>

	<div class="budgets_block">
	<?php // budgets list ?>
	<?php $sum = 0; ?>
	<?php foreach ( $bills_out_class['subclass'] as $mi => $mclass ): ?>
		<div class="budgets_subclass">
		<div class="budgets_name">
			<span><?=$mclass['name']?></span>
			<span class="budgets_sum"></span>
		</div>
		<?php foreach ($mclass['subclass'] as $si => $sclass ): ?>
			<div class="budgets_tr">
			<span><?=$sclass['name']?></span> <?php // sub class name ?>
			<input type="text" class="input-numbers budget_input" name="<?=$mi.'-'.$si?>" value="<?=( isset( $sclass['budget'] ) ) ? $sclass['budget'] : ''?>" /> <?php // sub class budget ?>
			<input type="hidden" name="<?=$mi.'-'.$si.':name'?>" value="<?=$sclass['name']?>" /> <?php // this field is necessary ?>
			</div>
			<?php $sum += ( isset( $sclass['budget'] ) ) ? $sclass['budget'] : 0; ?>
		<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
	<div class="budgets_name">
	<span style="display:inline-block; width:185px;"> 總計 </span>
	<span style="display:inline-block;">$ <?=number_format($sum)?></span>
	</div>
	</div>
	<input class="btn func-btn" type="submit" value="確 定" style="margin-left:355px;"></input>
</div>
</form>
<link href="finance/css/bills.css" rel="stylesheet" />
<script type="text/javascript" src="finance/js/number_format.js"></script>
<script type="text/javascript">
	$("#select_tu").on("change",function(){
		$('#change_tu').val($("#select_tu").val());
		$("#change_form").submit();
	});

	$('.budget_input').on("change",function(){
		var sum = 0;
		$(this).parent().parent('.budgets_subclass').children('.budgets_tr').each(function (tr_index, value) {
			if ($(value).children('.budget_input').val()!='') {
				sum += parseInt($(value).children('.budget_input').val());
			};
		})
		$(this).parent().parent('.budgets_subclass').find('.budgets_sum').text(sum);
	});

	$(document).ready(function() {
		$('.budgets_subclass').each(function (index, subclass) {
			var sum = 0;
			$(subclass).children('.budgets_tr').each(function (tr_index, value) {
				if ($(value).children('.budget_input').val()!='') {
					sum += parseInt($(value).children('.budget_input').val());
				};
			})
			$(subclass).find('.budgets_sum').text(number_format(sum));
		});
	});



</script>