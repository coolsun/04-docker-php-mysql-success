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

<div id="sleepchart" class="log-desc" style="top:40px; left:25px"></div>

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
  var chartDivId = '';
  var datasetNames = [];
  var datasets = [[], []];
  var xAxisNames = [];
  var yAxisTitles = [];
  var chartTitle = '';
  var barMaxNum = 0;
  var rightTitleMargin = 0;

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

    init_chart();
  });

  function init_chart()
  {
    chartDivId = 'sleepchart';
    datasetNames = ['睡眠時間', '睡眠品質'];
    datasets = [[<?php echo join(', ', $chart_hours) ?>], [<?php echo join(', ', $chart_quality) ?>]];
    xAxisNames = [<?php echo join(', ', $chart_dates) ?>];
    yAxisTitles = ['( 時間 hours )', '( 品質 )'];
    chartTitle = '';
    barMaxNum = 8;
    rightTitleMargin = 70;

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

    $.getJSON("health/sleep/functions/analytic/analytic_chart_refresh.php", params).success(function(data) {
      $.fancybox.close();
      datasets = eval("[[" + data.chart_hours + "], [" + data.chart_quality + "]]");
      xAxisNames = eval("[" + data.chart_dates + "]");
      linebarchart( chartDivId, datasetNames, datasets, xAxisNames, yAxisTitles, chartTitle, barMaxNum, rightTitleMargin );
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