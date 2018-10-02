<?php // modify file ?>

<script src="js/charts/highstock.js"></script>
<script src="js/charts/chartslib.js"></script>

<div class='log-switch' style="border-bottom-width: 0px; border-right-width: 2px;">
  <ul class="period" style="left:5px;">
    <li>
      <form id="post_form" method="post" action="?dept=finance&ma=invests&sa=profit" style="margin-top: -3px;">
        <div>
          <select id="account" name="account" class="form_select" style="width:95px; margin: 0px 0px 5px 0px;">
            <?php foreach ( $all_accounts as $account ): ?>
                <option value="<?=$account['account_id']?>"  <?=( $account['account_id'] == $selected_aid ) ? 'selected' : '' ?>><?=$account['account_name']?></option>
            <?php endforeach; ?>
          </select>

        </div>
      </form>
    </li>
  </ul>

  <ul class='menu' style="right: 70px;">
    <?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
      <li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=finance&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
    <?php endforeach; ?>
  </ul>
</div>

<div id="chart"></div>

<script>
$(function() {
  <?php if(0 < count($lastInvests)){ ?>
    profitchart(
      'chart',
      ['成本', '市值', '淨利'],
      [[<?php echo implode(',',$profitchart_cost_data); ?>], [<?php echo implode(',',$profitchart_total_value_data); ?>], [<?php echo implode(',',$profitchart_net_profit_data); ?>]],
      [<?php echo implode(',',$profitchart_names); ?>],
      '(單位: 千元)',
      '獲利分析',
      3
    );
  <?php } ?>

  $(".form_select").on("change",function(a){
    if('user_time' != $(this).val())
    {
      $("#post_form").submit();
    }
  });

});
</script>
