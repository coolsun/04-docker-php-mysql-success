<link href="js/datePicker/datePicker.css" rel="stylesheet" />

<script type="text/javascript" src="js/datePicker/date.js"></script>
<script type="text/javascript" src="js/datePicker/jquery.datePicker.js"></script>

<div class="top_block">
  <div id="edit_area" class="spec-outer">
    <div class="spec-inner-srch clear">
      <form id="newRecordForm">
        <input type="text" id="newExerciseDate" name="newExerciseDate" class="date-view pick-Date" style="width:95px; margin: 0px 0px 5px 0px;" value="<?php echo date("Y/m/d"); ?>" onchange="check_weight()">
        <div class="spec-content">
          <div class="search">
            <input type="text" id="newExerciseSport" placeholder="做了什麼運動......" onclick="check_weight_and_alert_sport();">
            <input type="hidden" id="newSportId" name="newSportId" />
            <input type="hidden" id="newMins" name="newMins" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div style="line-height: 30px;">
  <div id="inputTodayWeightDiv" class="right" style="display: <?php echo $last_weight ? 'none' : 'blank' ?>;">今日體重: <input type="text" id="todayWeight" value="<?php echo $last_weight; ?>" style="width: 50px; text-align: right; text-align: center;" />&nbsp;kg<input type="button" class="btn search-btn right" value="確定" onclick="update_weight();" /></div>
  <div id="showTodayWeightDiv" class="right" style="display: <?php echo $last_weight ? 'blank' : 'none' ?>;">今日體重: <span id="showWeight"><?php echo $last_weight; ?></span>&nbsp;kg<svg class="right" onclick="showHideTodayWeight(false);" style="cursor: pointer; margin: 7px 0 0 10px;" width="16" height="16" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><defs><style>.cls-1,.cls-2{fill:#8e8e8e;}.cls-2{fill-rule:evenodd;}</style></defs><title/><g><g id="Layer_2"><g id="Layer_1-2"><rect id="svg_1" y="13.83" x="-1.94" width="11.44" transform="rotate(-45 -3.769999980926517,7.809999942779539) " height="4.86" class="cls-1"/><path id="svg_2" d="m15.73,2.4l-2.13,-2.13a0.93,0.93 0 0 0 -1.31,0l-1.18,1.18l3.44,3.43l1.18,-1.18a0.93,0.93 0 0 0 0,-1.3z" class="cls-2"/><path id="svg_3" d="m0,15.28a0.61,0.61 0 0 0 0.72,0.72l3.28,-0.55l-3.45,-3.45l-0.55,3.28z" class="cls-2"/></g></g></g></svg></div>
</div>

<div style="margin-top: 30px;">
  <div class='log-switch' style="">
    <ul class="period">
      <li class="odd">
        <input id='recordRangeValue' type="hidden" value="<?php echo $_SESSION['exerciseDuringDays'] ?>" />
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

  <div style="max-height: 500px; overflow-y:auto;">
    <table class="general_table div_data_table" style="border-bottom:1px solid #C3C3C3; ">
      <thead>
        <tr class="tblTitleTr">
          <th class="thead" style="width:114px;"><div>日期</div></th>
          <th class="thead" style="width:334px;"><div>運動項目</div></th>
          <th class="thead" style="width:180px;"><div>時間(min)</div></th>
          <th class="thead" style="width:142px;"><div>熱量(kcal)</div></th>
          <th class="thead action" style="width:85px;"><div></div></th>
        </tr>
      </thead>
      <tbody id="record_tbody" class="record_table_tbody twoColorRow">
        <?php include("_partial_record_tbody.php"); ?>
      </tbody>
    </table>
  </div>
</div>

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

  <a id="recordDeleteShow" href="#deleteWindow" style="display:none;">#</a>
  <div id="deleteWindow">
      <div class='page-outer' style='width: 250px; height: 95px;'>
          <div class='normal-inner'>
            <div>請確認是否要刪除?</div>
          </div>
          <div id="primary-action">
              <input id="deleteAction" class="btn func-btn" type="button" value="確 定" />
              <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="取 消" />
          </div>
      </div>
  </div>

  <a id="selectSportsShow" href="#selectSportsWindow" style="display:none;">#</a>
  <div id="selectSportsWindow">
      <div class='page-outer' style='width: 605px;'>
        <div class="sport-type">
          <ul>
            <?php
              foreach ($sport_categories as $key => $value) {
                echo "<li id='category_$key' class='category_li' onclick='switch_category($key)' style='cursor: pointer'>$value</li>";
              }
            ?>
          </ul>
        </div>

        <?php
          foreach ($sport_categories as $category_key => $category_value) {
            echo "<ul class='sport-list' id='item_$category_key' style='display: none;'>";
            foreach ($sports as $sport_key => $sport_value) {
              if ($category_value == $sport_value['category'])
              {
                echo "<li style='cursor: pointer;' onclick='select_sport_action({$sport_value['id']});'>{$sport_value['cht_descriptions']}</li>";
              }
            }
            echo "</ul>";
          }
        ?>
      </div>
  </div>

  <a id="newSetMinsShow" href="#newSetMinsWindow" style="display:none;">#</a>
  <div id="newSetMinsWindow">
      <div class='page-outer' style='width: 250px; height: 90px;'>
          <div class='normal-inner'>
            <input type="text" id="newSetMins" value="" size="4" maxlength="4" data-min="0" onkeyup="value=value.replace(/[^\d]/g,'');">分鐘
          </div>
          <div id="primary-action">
              <input id="newAction" class="btn func-btn" type="button" value="確 定" onclick="new_exercise_action()" />
          </div>
      </div>
  </div>

  <a id="weight_update_show" href="#weight_update_window"></a>
  <div id="weight_update_window">
      <div class="page-outer" style="width: 305px; height: 100px;">
        <form onsubmit="return update_weight_by_date(this);">
          <div id="normal-inner" style="padding: 20px;">
              <table>
                <tbody>
                  <tr>
                    <td style="width: 80px;">當日體重</td>
                    <td style="width: 110px;"><input type="text" id="inputUpdateWeight" name="weight" class="input-numbers" value="" maxlength="6" style="width: inherit;text-align: center;"></td>
                    <td>kg</td>
                  </tr>
                </tbody>
              </table>
          </div>
          <div id="primary-action">
              <input type="button" name="" class="btn func-btn" value="確 定" onclick="update_weight_by_date(this.form)">
          </div>
        </form>
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

    $("#recordDeleteShow").fancybox({
      'type': 'inline',
      'title': '',
      'padding' : 0,
      'titlePosition'     : 'outside',
      'transitionIn'      : 'none',
      'transitionOut'     : 'none',
      'overlayShow'       : false,
    });

    $("#selectSportsShow").fancybox({
      'type': 'inline',
      'title': '運動項目',
      'padding' : 0,
      'titlePosition'     : 'outside',
      'transitionIn'      : 'none',
      'transitionOut'     : 'none',
      'overlayShow'       : false,
    });

    $("#newSetMinsShow").fancybox({
      'type': 'inline',
      'title': '運動時間',
      'padding' : 0,
      'titlePosition'     : 'outside',
      'transitionIn'      : 'none',
      'transitionOut'     : 'none',
      'overlayShow'       : false,
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

    $("#weight_update_show").fancybox({
      'type': 'inline',
      'title': '更新體重',
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

    record_edit_td_init();
  });

  function record_edit_td_init()
  {
    $(".record_edit_label")
    .click(function(){
      input_id = "#" + $(this).prop("id").replace('_label', '');
      $(this).hide();
      $(input_id).show();
    });

    $(".record_edit_input")
    .blur(function() {
      if($(this).data("max") && $(this).data("max") < $(this).val())
      {
        $(this).val($(this).data("max"));
      }

      if($(this).data("min") && $(this).data("min") > $(this).val())
      {
        $(this).val($(this).data("min"));
      }

      label_id = "#" + $(this).prop("id") + '_label';
      $(label_id).text($(this).val());
      $(this).hide();
      $(label_id).show();
    });
  }

  function set_custom_date(sStart, sEnd)
  {
    var info = sStart +' ~ ' + sEnd;
    $('#custom_date').html(info);
  }

  function new_record()
  {
    $.post("health/exercise/functions/record/new.php", $("#newRecordForm").serialize()).success(function(data){
      if (data.success)
      {
        recordReflash();
      }
    });
  }

  function update_record(id)
  {
    var sport_id = parseInt($("#record_td_" + id + "_sport_id").val());
    var exercise_mins = parseInt($("#record_td_" + id + "_mins").val());
    var params = {
      id: id,
      sport_id: sport_id,
      exercise_mins: exercise_mins ? exercise_mins : 0
    };

    $.post("health/exercise/functions/record/update.php", params).success(function(data){
      recordReflash();
    });
  }

  function delete_alert(id)
  {
    $("#deleteAction").attr('onclick',"delete_record(" + id + ")");
    $("#recordDeleteShow").trigger('click');
  }

  function delete_record(id)
  {
    params = {
      id: id
    };

    $.post("health/exercise/functions/record/delete.php", params).success(function(data){
      $("#record_tr_" + id).remove();
      keep_table_space_row();
      $.fancybox.close();
    });
  }

  function recordReflash()
  {
    var params = {
      range: $('#recordRangeValue').val(),
      recordSelect: $('#recordSelect').val(),
      recordStartDate: $('#recordStartDate').val()
    };

    $.get("health/exercise/record_tbody_refresh.php", params).success(function(html) {
      $.fancybox.close();
      $("#record_tbody").html(html);
      record_edit_td_init();
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

  function check_weight()
  {
    var params = {
      date: $('#newExerciseDate').val()
    };

    $.get("health/exercise/functions/record/get_last_date_weight.php", params).success(function(data) {
      if (!data || 0 == data.length || data[0] && (0 == data[0].weight))
      {
        $('#weight_update_show').trigger('click');
        $('#inputUpdateWeight').val('');
      }
      else
      {
        change_today_weight(data[0].weight);
      }
    });
  }


  function check_weight_and_alert_sport()
  {
    var params = {
      date: $('#newExerciseDate').val()
    };

    $.get("health/exercise/functions/record/get_last_date_weight.php", params).success(function(data) {
      if (!data || 0 == data.length || data[0] && (0 == data[0].weight))
      {
        $('#weight_update_show').trigger('click');
        $('#inputUpdateWeight').val('');
      }
      else
      {
        change_today_weight(data[0].weight);
        select_sport_alert();
      }
    });
  }

  function change_today_weight(value)
  {
    $('#todayWeight').val(value);
    $('#showWeight').text(value);
  }


  function update_weight_by_date(fObj)
  {
    var params = {
      weight: fObj.weight.value,
      date: $('#newExerciseDate').val()
    };

    $.post("health/weight/functions/plan/update_weight.php", params).success(function(data){
      if (data.success)
      {
        select_sport_alert();
      }
    });

    return false;
  }

  function select_sport_alert()
  {
    switch_category(0);
    $("#selectSportsShow").trigger('click');
  }

  function select_sport_action(id)
  {
    $('#newSportId').val(id);
    $('#newSetMins').val('');
    $("#newSetMinsShow").trigger('click');
  }

  function new_exercise_action()
  {
    $('#newMins').val($('#newSetMins').val());
    new_record();
    $.fancybox.close();
  }

  function switch_category(i)
  {
    $('.sport-list').hide();
    $('#item_' + i).show();
    $('.category_li').css("background-color", '#d9d9d9');
    $('#category_' + i).css("background-color", 'white');
  }

  function keep_table_space_row()
  {
    var count_rows = $('#record_tbody > tr').length;

    for(var i = count_rows; i < 12; i++)
    {
      $('#record_tbody').append("<tr><td></td><td></td><td></td><td></td><td></td></tr>");
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

  function showHideTodayWeight(bShow)
  {
    if (bShow)
    {
      $('#inputTodayWeightDiv').hide();
      $('#showTodayWeightDiv').show();
    }
    else
    {
      $('#inputTodayWeightDiv').show();
      $('#showTodayWeightDiv').hide();
    }
  }

  function update_weight()
  {
    var weight = $('#todayWeight').val();

    $('#showWeight').text(weight);

    //var newDate = new Date();
    //var sDate = newDate.getFullYear().toString() + '-' + (newDate.getMonth() + 1).toString() + '-' + newDate.getDate();

    var params = {
      weight: weight,
      date: $('#newExerciseDate').val()
    };

    $.post("health/weight/functions/plan/update_weight.php", params).success(function(data){
      showHideTodayWeight(true);
    });
  }

</script>




