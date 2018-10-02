<script src="js/charts/highstock.js"></script>
<script src="js/charts/chartslib.js?20170706"></script>

<div class='log-switch'>
  <ul class='menu'>
    <?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
      <li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=health&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="log-desc">
    <div class="note">
        <span><a id="weight_notice_show" style="z-index: 50; position: relative; width: 74px; color: #2C5DC3;" href="#weight_notice_window">注意事項</a></span>
    </div>
    <div class="draw">
        <div id="weightPlanChart"></div>
        <table class="weight-show">
            <tbody>
                <tr>
                    <td>起始體重<span id="today_plan_weight"><?php echo $today_plan['weight'] ?></span></td>
                    <td>今天體重<span id="today_plan_today_weight"><?php echo $today_plan['today_weight'] ?></span></td>
                    <td>理想體重<span id="today_plan_would_weight"><?php echo $today_plan['would_weight'] ?></span> Kg</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="count">
        <div class="calories">
            <div class="row">
                <div class="kcal-count">
                    <span>今日卡路里預算</span>
                    <span id="today_plan_today_calory"><?php echo $today_plan['today_calory'] ?></span>
                </div>
                <div class="opt">-</div>
                <div class="count">飲食<span id="today_plan_calory_diet"><?php echo $today_plan['today_calory_diet'] ?></span></div>
                <div class="opt">+</div>
                <div class="count">運動<span id="today_plan_calory_exercise"><?php echo $today_plan['today_calory_exercise'] ?></span></div>
                <div class="opt">=</div>
                <div class="count" style="padding-left: 40px;">
                  <span style="text-align: left;">剩餘</span>
                  <span id="today_plan_calory_left" style="width: 100px; text-align: left;"><?php echo $today_plan['today_calory_left'] ?> Kcal</span>
                </div>
            </div>
            <div class="row">
                <div class="kcal-count">
                    <span align="center">基礎代謝率</span>
                    <span id="today_plan_today_bmr"><?php echo $today_plan['today_bmr'] ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    <?php if($today_plan['bExist']){ ?>
      //var weight_date_arr = ['2017/05/23','2017/05/24','2017/05/25','2017/05/26','2017/05/27','2017/05/28','2017/05/29','2017/05/30','2017/05/31'];
      var weight_arr = [<?php echo implode(',', $weight_value_arr); ?>];
      var chartDivId = 'weightPlanChart';
      var datasetName = '實際體重';
      var dataset = weight_arr;
      //var xAxisNames = strip_year(weight_date_arr);
      var yAxisTitle = '體重(kg)';
      var expectedTitle = '理想體重';
      var expectedWeight = <?php echo $today_plan['would_weight'];?>;
      var lastEndWeight = -1;
      var startDate = { year: <?php echo $dt_created_date->format('Y'); ?>, month: <?php echo $dt_created_date->format('m'); ?>, date: <?php echo $dt_created_date->format('d'); ?> };
      var targetDate = { year: <?php echo $dt_would_date->format('Y'); ?>, month: <?php echo $dt_would_date->format('m'); ?>, date: <?php echo $dt_would_date->format('d'); ?> };
      weightchart( chartDivId, datasetName, dataset, yAxisTitle, expectedTitle, expectedWeight, lastEndWeight, startDate, targetDate );
    <?php } ?>
  });
</script>

