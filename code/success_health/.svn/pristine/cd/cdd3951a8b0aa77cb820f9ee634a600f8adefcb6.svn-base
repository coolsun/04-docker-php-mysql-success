<script src="js/charts/highstock.js"></script>
<script src="js/charts/chartslib.js?20170706"></script>

<div class='log-switch'>
  <ul class="period">
    <li class="odd">
      <input id="selectDate" name="selectDate" class="pick-Date date-view" type="text" value="<?php echo date("Y/m/d", strtotime($start_date)); ?>" onchange="change_date(this.value);" onfocus="set_old_date(this.value);" />
    </li>
  </ul>

  <ul class='menu'>
    <?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
      <li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=health&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
    <?php endforeach; ?>
  </ul>
</div>

<a id="daily_diet_notice_show" class="right" style="z-index: 50; position: relative; width: 107px; color: #2C5DC3; margin-top: 12px;" href="#daily_diet_notice_window">每日建議攝取量</a>
<a id="diet_notice_show" class="right" style="z-index: 50; position: relative; width: 65px; color: #2C5DC3; margin-top: 12px;" href="#diet_notice_window">注意事項</a>

<div id="piechart" class="log-desc" style="top:40px; left:25px"></div>
<div id="vitaminchart" class="log-desc" style="top:40px; left:25px"></div>
<div id="metalpiechart" class="log-desc" style="top:40px; left:25px"></div>

<div class="log-desc" style="top:40px; margin-bottom: 70px;">
  <div class="detail">
    <h3><span class="line-caption">攝取量明細</span></h3>
    <div class="nutrient left">
        <div class="head">
            <div class="caption">維他命</div>
            <div class="unit">%RDV</div>
        </div>
        <div class="body" id="vitamin_table">
            <div class="row">
                <div class="item">維他命 C</div>
                <div class="amount"><?php echo $vitamin_c; ?> mg</div>
                <div class="percent"><?php echo $rdv_vitamin_c; ?>%</div>
            </div>
            <div class="row">
                <div class="item">維他命 B6</div>
                <div class="amount"><?php echo $vitamin_b6; ?> mg</div>
                <div class="percent"><?php echo $rdv_vitamin_b6; ?>%</div>
            </div>
            <div class="row">
                <div class="item">維他命 B12</div>
                <div class="amount"><?php echo $vitamin_b12; ?> μg</div>
                <div class="percent"><?php echo $rdv_vitamin_b12; ?>%</div>
            </div>
            <div class="row">
                <div class="item">維他命 A</div>
                <div class="amount"><?php echo $vitamin_a_iu; ?> IU</div>
                <div class="percent"><?php echo $rdv_vitamin_a_iu; ?>%</div>
            </div>
            <div class="row">
                <div class="item">維他命 E</div>
                <div class="amount"><?php echo $vitamin_e; ?> mg</div>
                <div class="percent"><?php echo $rdv_vitamin_e; ?>%</div>
            </div>
            <div class="row">
                <div class="item">維他命 D</div>
                <div class="amount"><?php echo $vitamin_d; ?> IU</div>
                <div class="percent"><?php echo $rdv_vitamin_d; ?>%</div>
            </div>
            <div class="row">
                <div class="item">維他命 K</div>
                <div class="amount"><?php echo $vitamin_k; ?> μg</div>
                <div class="percent"><?php echo $rdv_vitamin_k; ?>%</div>
            </div>
        </div>
    </div>
    <div class="nutrient right">
        <div class="head">
            <div class="caption">礦物質</div>
            <div class="unit">%RDV</div>
        </div>
        <div class="body" id="mineral_table">
            <div class="row">
                <div class="item">鈣</div>
                <div class="amount"><?php echo $meta_calcium; ?> mg</div>
                <div class="percent"><?php echo $rdv_meta_calcium; ?>%</div>
            </div>
            <div class="row">
                <div class="item">鐵</div>
                <div class="amount"><?php echo $meta_iron; ?> mg</div>
                <div class="percent"><?php echo $rdv_meta_iron; ?>%</div>
            </div>
            <div class="row">
                <div class="item">鎂</div>
                <div class="amount"><?php echo $meta_magnesium; ?> mg</div>
                <div class="percent"><?php echo $rdv_meta_magnesium; ?>%</div>
            </div>
            <div class="row">
                <div class="item">磷</div>
                <div class="amount"><?php echo $meta_phosphorus; ?> mg</div>
                <div class="percent"><?php echo $rdv_meta_phosphorus; ?>%</div>
            </div>
            <div class="row">
                <div class="item">鉀</div>
                <div class="amount"><?php echo $meta_potassium; ?> mg</div>
                <div class="percent"><?php echo $rdv_meta_potassium; ?>%</div>
            </div>
            <div class="row">
                <div class="item">鈉</div>
                <div class="amount"><?php echo $meta_sodium; ?> mg</div>
                <div class="percent"><?php echo $rdv_meta_sodium; ?>%</div>
            </div>
            <div class="row">
                <div class="item">鋅</div>
                <div class="amount"><?php echo $meta_zinc; ?> mg</div>
                <div class="percent"><?php echo $rdv_meta_zinc; ?>%</div>
            </div>
            <div class="row">
                <div class="item">銅</div>
                <div class="amount"><?php echo $meta_copper; ?> mg</div>
                <div class="percent"><?php echo $rdv_meta_copper; ?>%</div>
            </div>
            <div class="row">
                <div class="item">錳</div>
                <div class="amount"><?php echo $meta_manganese; ?> mg</div>
                <div class="percent"><?php echo $rdv_meta_manganese; ?>%</div>
            </div>
            <div class="row">
                <div class="item">硒</div>
                <div class="amount"><?php echo $meta_selenium; ?> μg</div>
                <div class="percent"><?php echo $rdv_meta_selenium; ?>%</div>
            </div>
        </div>
    </div>
    <h2>RDV( Recommend Daily Value ) 每日建議攝取量</h2>
  </div>
</div>

<div style="display:none;">
  <div id="diet_notice_window">
      <div class='page-outer' style='width: 600px;'>
          <div class='normal-inner' style="height: 170px; overflow: auto; padding: 25px 30px;">
            <p>本網站數值僅供參考並無絕對，亦沒有任何醫療行為，長條圖可以看出您當日攝取的各項營養成分佔每日建議攝取量的百分比%RDV( Recommend Daily Value )，請注意! 每日建議攝取量之數值並非適用於每個人，建議您使用前請先依自己的健康狀況諮詢營養師或專業醫師的意見。</p>
            <p>本網站食物營養成份資料引用來源: 美國農業部</p>
            <p>每日建議攝取量資料引用來源: 美國食品藥物管理局</p>
          </div>
      </div>
  </div>

  <div id="daily_diet_notice_window">
      <div class='page-outer' style='width: 634px;'>
          <div class='normal-inner' style="height: 500px; overflow: auto; padding: 30px 27px 0 30px;">
            <div style="line-height: 28px;">下列表格資料是給攝取2000卡路里熱量的成年人或四歲以上孩童之每日建議攝取量參考，</div>
            <div style="line-height: 28px;">每日建議攝取量僅供參考並無絕對，亦沒有任何醫療行為，此數值並非適用於每個人，建議</div>
            <div style="line-height: 28px;">您使用前請先依自己的健康狀況諮詢營養師或專業醫師的意見。</div>
            <div style="margin: 10px 0;line-height: 28px;">每日建議攝取量資料引用來源: 美國食品藥物管理局</div>
            <table class="diet_notice_table">
              <thead>
                <tr><th style="padding: 0 30px;">Food Component</th><th style="padding: 0 50px;">食物成分</th><th style="padding: 0 42px;">DV (每日建議攝取量)</th></tr>
              </thead>
              <tbody>
                <tr><td>Total Fat</td><td>總脂肪</td><td>65 grams (g)</td></tr>
                <tr><td>Saturated Fat</td><td>飽和脂肪</td><td>20 g</td></tr>
                <tr><td>Cholesterol</td><td>膽固醇</td><td>300 milligrams (mg)</td></tr>
                <tr><td>Sodium</td><td>鈉</td><td>2,400 mg</td></tr>
                <tr><td>Potassium</td><td>鉀</td><td>3,500 mg</td></tr>
                <tr><td>Total Carbohydrate</td><td>總碳水化合物</td><td>300 g</td></tr>
                <tr><td>Dietary Fiber</td><td>膳食纖維</td><td>25 g</td></tr>
                <tr><td>Protein</td><td>蛋白質</td><td>50 g</td></tr>
                <tr><td>Vitamin A</td><td>維生素 A</td><td>5,000 International Units (IU)</td></tr>
                <tr><td>Vitamin C</td><td>維生素 C</td><td>60 mg</td></tr>
                <tr><td>Calcium</td><td>鈣</td><td>1,000 mg</td></tr>
                <tr><td>Iron</td><td>鐵</td><td>18 mg</td></tr>
                <tr><td>Vitamin D</td><td>維生素 D</td><td>400 IU</td></tr>
                <tr><td>Vitamin E</td><td>維生素 E</td><td>30 IU</td></tr>
                <tr><td>Vitamin K</td><td>維生素 K</td><td>80 micrograms (µg)</td></tr>
                <tr><td>Thiamin</td><td>硫胺素 (維生素 B1)</td><td>1.5 mg</td></tr>
                <tr><td>Riboflavin</td><td>核黃素 (維生素 B2)</td><td>1.7 mg</td></tr>
                <tr><td>Niacin</td><td>菸鹼酸</td><td>20 mg</td></tr>
                <tr><td>Vitamin B6</td><td>維生素 B6</td><td>2 mg</td></tr>
                <tr><td>Folate</td><td>葉酸</td><td>400 µg</td></tr>
                <tr><td>Vitamin B12</td><td>維生素 B12</td><td>6 µg</td></tr>
                <tr><td>Biotin</td><td>生物素 (維生素 B7)</td><td>300 µg</td></tr>
                <tr><td>Pantothenic acid</td><td>泛酸 (維生素 B5)</td><td>10 mg</td></tr>
                <tr><td>Phosphorus</td><td>磷</td><td>1,000 mg</td></tr>
                <tr><td>Iodine</td><td>碘</td><td>150 µg</td></tr>
                <tr><td>Magnesium</td><td>鎂</td><td>400 mg</td></tr>
                <tr><td>Zinc</td><td>鋅</td><td>15 mg</td></tr>
                <tr><td>Selenium</td><td>硒</td><td>70 µg</td></tr>
                <tr><td>Copper</td><td>銅</td><td>2 mg</td></tr>
                <tr><td>Manganese</td><td>錳</td><td>2 mg</td></tr>
                <tr><td>Chromium</td><td>鉻</td><td>120 µg</td></tr>
                <tr><td>Molybdenum</td><td>鉬</td><td>75 µg</td></tr>
                <tr><td>Chloride</td><td>氯化物</td><td>3,400 mg</td></tr>
              </tbody>
            </table>
            <br />
          </div>
      </div>
  </div>
</div>

<script>
  var piechartSet = {
    chartDivId: 'piechart',
    datasetName: '熱量比例',
    datasets: [],
    sumName: '總計'
  };

  var vitaminchartSet = {
    chartDivId: 'vitaminchart',
    datasetName: '維他命',
    dataset: [<?php echo $rdv_vitamin_c; ?>,<?php echo $rdv_vitamin_b6; ?>,<?php echo $rdv_vitamin_b12; ?>,<?php echo $rdv_vitamin_a_iu; ?>,<?php echo $rdv_vitamin_e; ?>,<?php echo $rdv_vitamin_d; ?>,<?php echo $rdv_vitamin_k; ?>],
    xAxisNames: ['C','B6','B12','A','E','D','K'],
    yAxisTitle: '每日建議攝取量(%)',
    chartTitle: '維他命',
    costName: '百分比',
    proportionName: '百分比',
    barMaxNum: 12
  }

  var metalpiechartSet = {
    chartDivId: 'metalpiechart',
    datasetName: '礦物質',
    dataset: [<?php echo $rdv_meta_calcium; ?>,<?php echo $rdv_meta_iron; ?>,<?php echo $rdv_meta_magnesium; ?>,<?php echo $rdv_meta_phosphorus; ?>,<?php echo $rdv_meta_potassium; ?>,<?php echo $rdv_meta_sodium; ?>,<?php echo $rdv_meta_zinc; ?>,<?php echo $rdv_meta_copper; ?>,<?php echo $rdv_meta_manganese; ?>,<?php echo $rdv_meta_selenium; ?>],
    xAxisNames: ['鈣','鐵','鎂','磷','鉀','鈉','鋅','銅','錳','硒'],
    yAxisTitle: '每日建議攝取量(%)',
    chartTitle: '礦物質',
    costName: '百分比',
    proportionName: '百分比',
    barMaxNum: 12
  }

  $(document).ready(function() {
    $('.pick-Date').datePicker({
      startDate: '1991/01/01',
      endDate: (new Date()).asString(),
      clickInput:true,
      createButton: false,
      showYearNavigation: false,
      verticalOffset: 20,
      //horizontalOffset: 165
    });

    $("#diet_notice_show").fancybox({
      'type': 'inline',
      'title': '注意事項',
      'padding' : 0,
      'titlePosition'     : 'outside',
      'transitionIn'      : 'none',
      'transitionOut'     : 'none',
      'overlayShow'       : false,
    });

    $("#daily_diet_notice_show").fancybox({
      'type': 'inline',
      'title': '每日建議攝取量',
      'padding' : 0,
      'titlePosition'     : 'outside',
      'transitionIn'      : 'none',
      'transitionOut'     : 'none',
      'overlayShow'       : false,
    });

    init_chart();
  });

  function init_chart()
  {
    Highcharts.setOptions({
        chart: {
            width: 600
        }
    });

    piechartSet.datasets = [['蛋白質', Math.round(<?php echo $pie_protein; ?>*400)/100], ['脂肪', Math.round(<?php echo $pie_lipid_tot; ?>*900)/100], ['碳水化合物', Math.round(<?php echo $pie_carbohydrt; ?>*400)/100]];
    piechart(piechartSet.chartDivId, piechartSet.datasetName, piechartSet.datasets, piechartSet.sumName, false ) ;

    costbarchart(vitaminchartSet.chartDivId, vitaminchartSet.datasetName, vitaminchartSet.dataset, vitaminchartSet.xAxisNames, vitaminchartSet.yAxisTitle, vitaminchartSet.chartTitle, vitaminchartSet.costName, vitaminchartSet.proportionName, vitaminchartSet.barMaxNum, false);

    costbarchart(metalpiechartSet.chartDivId, metalpiechartSet.datasetName, metalpiechartSet.dataset, metalpiechartSet.xAxisNames, metalpiechartSet.yAxisTitle, metalpiechartSet.chartTitle, metalpiechartSet.costName, metalpiechartSet.proportionName, metalpiechartSet.barMaxNum, false);
  }

  function recordReflash()
  {
    var params = {
      selectDate: $('#selectDate').val()
    };

    $.getJSON("health/diet/functions/analytic/analytic_chart_refresh.php", params).success(function(data) {
      piechartSet.datasets = [['蛋白質', Math.round(data.pie_protein*400)/100], ['脂肪', Math.round(data.pie_lipid_tot*900)/100], ['碳水化合物', Math.round(data.pie_carbohydrt*400)/100]];
      piechart(piechartSet.chartDivId, piechartSet.datasetName, piechartSet.datasets, piechartSet.sumName, false ) ;

      costbarchart(vitaminchartSet.chartDivId, vitaminchartSet.datasetName, data.vitaminchartDataSet, vitaminchartSet.xAxisNames, vitaminchartSet.yAxisTitle, vitaminchartSet.chartTitle, vitaminchartSet.costName, vitaminchartSet.proportionName, vitaminchartSet.barMaxNum, false);

      costbarchart(metalpiechartSet.chartDivId, metalpiechartSet.datasetName, data.metalpiechartDataSet, metalpiechartSet.xAxisNames, metalpiechartSet.yAxisTitle, metalpiechartSet.chartTitle, metalpiechartSet.costName, metalpiechartSet.proportionName, metalpiechartSet.barMaxNum, false);
    });
  }

  var old_date = '';
  function set_old_date(value)
  {
    old_date = value;
  }

  function change_date(value)
  {
    if (old_date != value)
    {
      recordReflash();
    }
  }

</script>