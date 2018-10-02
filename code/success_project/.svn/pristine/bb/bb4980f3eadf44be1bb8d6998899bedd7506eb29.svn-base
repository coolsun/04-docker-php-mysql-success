<script src="js/charts/highstock.js"></script>
<script src="js/charts/chartslib.js"></script>
<script src="js/charts/accounting.min.js"></script>

<script type="text/javascript">
$(function() {
	var asset = <?=json_encode($p_subtotal_monthly)?>;
	var loan = [<?php foreach ($n_subtotal_monthly as $b ) { echo "-".$b.","; } ?>];
	var xnames = [<?php foreach ($months_last_dates as $date ) { echo "'".date('Y/m', $date)."',"; } ?>];
	assetsbarchart( 'chart', ['資產', '負債', '淨值'], [asset, loan], xnames, '(單位:千元)', '', 12, true );
});
</script>

<div style="display:none;">
	<a id="selfLastDate_trigger" href="#selfLastDate_dialog" style="display:none;" >#</a>
	<div id="selfLastDate_dialog">
        <div class='page-outer' style='width: 250px; height: 120px; overflow: hidden;'>
            <div class='normal-inner'>
            	<form id="user_form" actino="?dept=finance&ma=accounts&sa=details" method="post">
                <table class='distance-table' style="height:90px;">
                <input id="ac_id_0" type="hidden" value="">
                <tr>
                    <td>
                        <div class="fancy_input_name">開始日期</div>
                        <input class="input-numbers pick-Date" type="text" value="" id="user_selfLastDate" name="selfLastDate" style="width: 85px;"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fancy_input_name">往前返回</div>
                        <select id="user_selectedDuring" name="selectedDuring" style="width: 85px;">
                            <option value="2">一年</option>
                            <option value="3">半年</option>
                        </select>
                    </td>
                </tr>
                </table>
                <input type="hidden" id="user_interval" name="interval" value="">
                </form>
            </div>
            <div id="primary-action">
                <input class="btn func-btn" type="button" onclick="update()" value="確 定"></input>
            </div>
        </div>
    </div>
</div>
<div class='log-inner'>
    <div class='log-switch'>
        <ul class='period'>
        <form id="select_form" action="?dept=finance&ma=accounts&sa=statics" method="post">
            <li>
            	<?php /* Select element of during */ ?>
            	<select id="selectedDuring" name="selectedDuring">
            		<?php foreach ( $durings as $index => $during ): ?>
            			<option value="<?=$index?>" <?=($index==$selectedDuring) ? 'selected' : '' ?>><?=$during?></option>
            		<?php endforeach; ?>
            		<option value="user_time">自訂</option>
            	</select>
            </li>
            <li>
            	<?php /* Select element of interval */ ?>
            	<select id="interval" name="interval">
            		<?php foreach ( $intervals as $index => $interval ): ?>
            			<option value="<?=$index?>" <?=($index==$selectedInterval) ? 'selected' : '' ?>><?=$interval?></option>
            		<?php endforeach; ?>
            	</select>
            </li>
        </form>
        </ul>
        <ul class='menu'>
        	<?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
        		<li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=finance&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
        	<?php endforeach; ?>
        </ul>
    </div>

<div id="chart" style="padding-top: 100px;"></div>

</div>
<!--
<div>
	<span>資產</span>
	<?php foreach ( $p_subtotal_monthly as $b ): ?>
	<span><?=$b?></span>
	<?php endforeach; ?>
</div>

<div>
	<span>負債</span>
	<?php foreach ( $n_subtotal_monthly as $b ): ?>
	<span><?=$b?></span>
	<?php endforeach; ?>
</div>

<div>
	<span>淨值</span>
	<?php foreach ( $sum_monthly as $b ): ?>
	<span><?=$b?></span>
	<?php endforeach; ?>
</div>
-->
<script type="text/javascript" src="finance/js/number_format.js"></script>
<script type="text/javascript" src="js/datePicker/date.js"></script>
<script type="text/javascript" src="js/datePicker/jquery.datePicker.js"></script>
<link href="js/datePicker/datePicker.css" rel="stylesheet" />
<script type="text/javascript">
	$(document).ready(function() {
    $('.pick-Date').datePicker({
        startDate: '1991/01/01',
        endDate: (new Date()).asString(),
        clickInput: true,
        createButton: false,
        showYearNavigation: false,
        verticalOffset: -1,
        horizontalOffset: 165
    });

		$("#selectedDuring").on("change",function(){
			if ($(this).val()=='user_time') {
				$("#selfLastDate_trigger").click();
			} else {
				$("#select_form").submit();
			};
		});

		$("#interval").on("change",function(){
			if ($(this).val()=='user_time') {
				$("#selfLastDate_trigger").click();
			} else {
				$("#select_form").submit();
			};
		});

		$("#selfLastDate_trigger").fancybox({
	        'type': 'inline',
	        'title': '期間',
	        'padding' : 0,
	        'titlePosition'     : 'outside',
	        'transitionIn'      : 'none',
	        'transitionOut'     : 'none',
	        'overlayShow'       : false
	    });
	});
	function update(){
		$.fancybox.close();
		$('#user_interval').val($('#interval').val());
		$("#user_form").submit();
	};
</script>