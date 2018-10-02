<div class="top_block">
  <div id="edit_area" class="spec-outer">
    <div class="spec-inner clear">
      <form id="newRecordForm">
        <input type="text" id="newMoodDate" name="newMoodDate" class="date-view pick-Date" style="width:95px; margin: 0px 0px 5px 0px;" value="<?php echo date("Y/m/d"); ?>">
        <div class="spec-content">
          <div class="setting">
            <div class="row">
              <div class="item">心情指數</div>
              <div class="extreme">很差</div>
              <div class="level">
                <div class="layout-slider" style="width: 100%">
                  <span style="display: inline-block; width: 400px; padding: 0 5px;"><input id="newMoodValue" type="slider" name="newMoodValue" value="5" /></span>
                </div>
              </div>
              <div class="extreme">很好</div>
            </div>
            <div class="row">
              <div class="item">應對表現</div>
              <div class="extreme">不好</div>
              <div class="level">
                <div class="layout-slider" style="width: 100%">
                  <span style="display: inline-block; width: 400px; padding: 0 5px;"><input id="newPerformance" type="slider" name="newPerformance" value="5" /></span>
                </div>
              </div>
              <div class="extreme">得宜</div>
            </div>
          </div>
        </div>
        <input type="button" class="btn search-btn right" value="確定" onclick="new_record()">
      </form>
    </div>
  </div>
</div>

<div style="margin-top: 110px;">
  <div class='log-switch' style="">
    <ul class="period">
      <li class="odd">
        <input id='recordRangeValue' type="hidden" value="<?php echo $_SESSION['moodDuringDays'] ?>" />
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
          <th class="thead" style="width:334px;"><div>心情指數</div></th>
          <th class="thead" style="width:334px;"><div>應對表現</div></th>
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


    $("#newMoodValue").slider({
        from: 0,
        to: 10,
        step: 1,
        scale: [0,1,2,3,4,5,6,7,8,9,10],
        limits: false,
        smooth: false,
        round: 0,
        skin: "plastic"
    });

    $("#newPerformance").slider({
        from: 0,
        to: 10,
        step: 1,
        scale: [0,1,2,3,4,5,6,7,8,9,10],
        limits: false,
        smooth: false,
        round: 0,
        skin: "plastic"
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
    $.post("health/mood/functions/record/new.php", $("#newRecordForm").serialize()).success(function(data){
      if (data.success)
      {
        $('#newMoodValue').slider("value", 5);
        $('#newPerformance').slider("value", 5);
        recordReflash();
      }
    });
  }

  function update_record(id)
  {
    var mood_value = parseInt($("#record_td_" + id + "_mood_value").val());
    var performance = parseInt($("#record_td_" + id + "_performance").val());
    var params = {
      id: id,
      mood_value: mood_value ? mood_value : 5,
      performance: performance ? performance : 5
    };

    $.post("health/mood/functions/record/update.php", params).success(function(data){
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

    $.post("health/mood/functions/record/delete.php", params).success(function(data){
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

    $.get("health/mood/record_tbody_refresh.php", params).success(function(html) {
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

  function keep_table_space_row()
  {
    var count_rows = $('#record_tbody > tr').length;

    for(var i = count_rows; i < 12; i++)
    {
      $('#record_tbody').append("<tr><td></td><td></td><td></td><td></td></tr>");
    }
  }

  function integer_alert(value)
  {
    if(value.match(/[^\d]/g))
    {
      alert('請輸入 0~10 之間的整數');
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
















