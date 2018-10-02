<?php
/*
 Some variables you can use.

 1. $display_item_num : numbers of visible item in chart window

 */

 $display_item_num = 5;
 $sa_link = 'budgets';
?>
<link href="finance/css/bills.css" rel="stylesheet" />
<script src="js/charts/highstock.js"></script>
<script src="js/charts/chartslib.js"></script>
<script src="js/charts/accounting.min.js"></script>

<script type="text/javascript">
$(function() {
	var dataset = <?=json_encode($dataset)?>;
	var xnames  = <?=$names?>;
	twicebarchart( 'chart', ['預算', '實際'], dataset, xnames, '(單位:千元)', '', <?=$display_item_num?>, false );
});
</script>
<div class='log-inner'>
    <div class='log-switch'>
    	<ul class="period">
    		<?php /* Select element of during */ ?>
    		<li>
			<?php /* Select element of during */ ?>
			<select name="selectedDuring">
			<?php foreach ( $durings as $index => $during ): ?>
				<option value="<?=$index?>" <?=($index==$selectedDuring) ? 'selected' : '' ?>><?=$during?></option>
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

<div id="chart" style="padding-top:50px;"></div>