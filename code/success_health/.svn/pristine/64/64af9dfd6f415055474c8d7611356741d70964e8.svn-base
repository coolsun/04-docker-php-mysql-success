<script src="js/charts/highstock.js"></script>
<script src="js/charts/chartslib.js?20170706"></script>

<div class='log-switch'>
  <ul class="period">
    <li class="odd">
      <input id='recordRangeValue' type="hidden" value="7" />
      <input id='recordStartDate' type="hidden" value="now" />
      <select id='recordSelect' onchange="change_range('select', this.value)">
        <?php
          foreach ($record_select_options as $option)
          {
        ?>
            <option value="<?= $option['value'] ?>" <?= $option['value'] == $record_select ? 'selected' : '' ?>><?= $option['name'] ?></option>
        <?php
          }
        ?>
        <option value="c" <?= 'c' == $record_select ? 'selected' : '' ?>>自 訂</option>
      </select>
      <span id="custom_date" onclick="$('#recordCustomerRangeShow').trigger('click');" style="cursor: pointer;"></span>
    </li>
  </ul>

  <ul class='menu'>
    <?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
      <li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=health&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
    <?php endforeach; ?>
  </ul>
</div>

<div id="piechart" class="log-desc" style="top:40px; left:25px"></div>
<div id="exercisechart" class="log-desc" style="top:40px; left:25px"></div>
<div id="sleepchart" class="log-desc" style="top:40px; left:25px"></div>
<div id="moodchart" class="log-desc" style="top:40px; left:25px"></div>


<div style="display:none;">
  <a id="recordCustomerRangeShow" href="#recordCustomerRangeWindow" style="display:none;">#</a>
  <div id="recordCustomerRangeWindow">
      <div class='page-outer' style='width: 220px; height: 140px;'>
          <div class='normal-inner'>
            <table>
              <tbody style="line-height: 35px;">
                <tr>
                  <td style="width: 70px;">開始日期</td>
                  <td style="width: 75px;">
                    <input id="recordCustomerRangeDatePicker" class="pick-Date" type="text" style="width: inherit;" />
                  </td>
                </tr>
                <tr>
                  <td style="width: 70px;">往前返回</td>
                  <td style="width: 75px;">
                    <select id='recordCustomerSelect' style="width: 79px;">
                      <?php
                        foreach ($record_select_options as $option)
                        {
                      ?>
                          <option value="<?= $option['value'] ?>" <?= $option['value'] == $record_select ? 'selected' : '' ?>><?= $option['name'] ?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="primary-action">
              <input id="customerRangeAction" class="btn func-btn" type="button" value="確 定" onclick="customer_range_action();" />
          </div>
      </div>
  </div>
</div>


<script>
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

    $("#recordCustomerRangeShow").fancybox({
      'type': 'inline',
      'title': '期間',
      'padding' : 0,
      'titlePosition'     : 'outside',
      'transitionIn'      : 'none',
      'transitionOut'     : 'none',
      'overlayShow'       : false,
    });

    <?php
      if ('c' == $record_select)
      {
        echo "set_custom_date('". str_replace('-' , '/', $target_date) . "', '". str_replace('-' , '/', $start_date) . "');";
      }
    ?>

    reflash_exercise_chart('<?php echo $all_chart_data['exercises']['chart_mins'] ?>', '<?php echo $all_chart_data['exercises']['chart_kcal'] ?>', "<?php echo $all_chart_data['exercises']['chart_dates'] ?>");
    reflash_sleep_chart('<?php echo $all_chart_data['sleepings']['chart_hours'] ?>', '<?php echo $all_chart_data['sleepings']['chart_quality'] ?>', "<?php echo $all_chart_data['sleepings']['chart_dates'] ?>");
    reflash_mood_chart('<?php echo $all_chart_data['moods']['chart_values'] ?>', '<?php echo $all_chart_data['moods']['chart_performance'] ?>', "<?php echo $all_chart_data['moods']['chart_dates'] ?>");
    reflash_diet_pie(<?php echo $pie_carbohydrt; ?>, <?php echo $pie_lipid_tot; ?>, <?php echo $pie_protein; ?>);
  });

  function reflash_diet_pie(carbohydrt, lipid_tot, protein)
  {
    var piechartSet = {
      chartDivId: 'piechart',
      datasetName: '熱量比例',
      datasets: [],
      sumName: '總計'
    };

    Highcharts.setOptions({
        chart: {
            width: 600
        }
    });

    piechartSet.datasets = [['蛋白質', Math.round(protein*400)/100], ['脂肪', Math.round(lipid_tot*900)/100], ['碳水化合物', Math.round(carbohydrt*400)/100]];
    piechart(piechartSet.chartDivId, piechartSet.datasetName, piechartSet.datasets, piechartSet.sumName, false ) ;
  }

  function reflash_exercise_chart(chart_mins, chart_kcal, chart_dates)
  {
    chartDivId = 'exercisechart';
    datasetNames = ['運動時間', '消耗熱量'];
    datasets = eval("[[" + chart_mins + "], [" + chart_kcal + "]]");
    xAxisNames = eval("[" + chart_dates + "]");
    yAxisTitles = ['( 時間 min )', '( 消耗熱量 kcal )'];
    chartTitle = '運動消耗熱量';
    barMaxNum = 8;
    rightTitleMargin = 100;

    Highcharts.setOptions({
        chart: {
            width: 800
        }
    });

    linebarchart( chartDivId, datasetNames, datasets, xAxisNames, yAxisTitles, chartTitle, barMaxNum, rightTitleMargin );
  }

  function reflash_sleep_chart(chart_hours, chart_quality, chart_dates)
  {
    chartDivId = 'sleepchart';
    datasetNames = ['睡眠時間', '睡眠品質'];
    datasets = eval("[[" + chart_hours + "], [" + chart_quality + "]]");
    xAxisNames = eval("[" + chart_dates + "]");
    yAxisTitles = ['( 時間 hours )', '( 品質 )'];
    chartTitle = '睡眠品質';
    barMaxNum = 8;
    rightTitleMargin = 70;

    Highcharts.setOptions({
        chart: {
            width: 800
        }
    });

    linebarchart( chartDivId, datasetNames, datasets, xAxisNames, yAxisTitles, chartTitle, barMaxNum, rightTitleMargin );
  }

  function reflash_mood_chart(chart_values, chart_performance, chart_dates)
  {
    var chartDivId = 'moodchart';
    var datasetNames = ['心情指數', '應對表現'];
    var datasets = eval("[[" + chart_values + "], [" + chart_performance + "]]");
    var xAxisNames = eval("[" + chart_dates + "]");
    var yAxisTitles = ['( 心情指數 )', '( 應對表現 )'];
    var chartTitle = '心情指數';
    var barMaxNum = 8;
    var rightTitleMargin = 70;

    Highcharts.setOptions({
        chart: {
            width: 800
        }
    });

    linebarchart( chartDivId, datasetNames, datasets, xAxisNames, yAxisTitles, chartTitle, barMaxNum, rightTitleMargin );
  }

  function set_custom_date(sStart, sEnd)
  {
    var info = sStart +' ~ ' + sEnd;
    $('#custom_date').html(info);
  }


  function recordReflash()
  {
    var params = {
      range: $('#recordRangeValue').val(),
      recordSelect: $('#recordSelect').val(),
      recordStartDate: $('#recordStartDate').val()
    };

    $.getJSON("health/mood/functions/complex/complex_chart_refresh.php", params).success(function(data) {
      $.fancybox.close();
      reflash_diet_pie(data.diet.carbohydrt, data.diet.lipid_tot, data.diet.protein);
      reflash_exercise_chart(data.exercises.chart_mins, data.exercises.chart_kcal, data.exercises.chart_dates);
      reflash_sleep_chart(data.sleepings.chart_hours, data.sleepings.chart_quality, data.sleepings.chart_dates);
      reflash_mood_chart(data.moods.chart_values, data.moods.chart_performance, data.moods.chart_dates);
    });
  }

  function change_range(from, value){
    if ('c' == value)
    {
      $("#recordCustomerRangeShow").trigger('click');
    }
    else
    {
      $.fancybox.close();
      $('#recordRangeValue').val(value);
      $('#recordStartDate').val('now');
      recordReflash();
      $('#custom_date').html('');
    }
  }

  function customer_range_action()
  {
      var sEnd = $('#recordCustomerRangeDatePicker').val();
      var duringDays = $('#recordCustomerSelect').val();
      var dStart = new Date(sEnd);
      dStart.setDate(dStart.getDate() - duringDays);
      var sStart = dStart.getFullYear().toString() + '/' + (dStart.getMonth() + 1).toString() + '/' + dStart.getDate();

      $('#recordRangeValue').val(duringDays);
      $('#recordStartDate').val(sEnd);
      recordReflash();
      set_custom_date(sStart, sEnd);
  }
</script>