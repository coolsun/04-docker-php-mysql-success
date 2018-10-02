<link href="js/datePicker/datePicker.css" rel="stylesheet" />

<script type="text/javascript" src="js/datePicker/date.js"></script>
<script type="text/javascript" src="js/datePicker/jquery.datePicker.js"></script>

<div class="top_block">
  <div id="edit_area" class="spec-outer">
    <div class="spec-inner clear">
      <form id="newRecordForm">
        <input type="text" id="newPressureDate" name="newPressureDate" class="date-view pick-Date" style="width:95px; margin: 0px 0px 5px 0px;" value="<?php echo date("Y/m/d"); ?>">
        <div class="spec-content">
          <div class="setting">
            <div class="row">
              <div class="item">壓力指數</div>
              <div class="extreme">低</div>
              <div class="level">
                <div class="layout-slider" style="width: 100%">
                  <span style="display: inline-block; width: 400px; padding: 0 5px;"><input id="newPressureValue" type="slider" name="newPressureValue" value="5" /></span>
                </div>
              </div>
              <div class="extreme">高</div>
            </div>
          </div>
        </div>
        <input type="hidden" id="newReasonIds" name="newReasonIds" />
        <input type="button" class="btn search-btn right" value="確定" onclick="select_pressure_reasons_alert()">
      </form>
    </div>
  </div>
</div>


<div style="margin-top: 50px;">
  <div class='log-switch' style="">
    <ul class="period">
      <li class="odd">
        <input id='recordRangeValue' type="hidden" value="<?php echo $_SESSION['pressureDuringDays'] ?>" />
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
          <th class="thead" style="width:334px;"><div>壓力指數</div></th>
          <th class="thead" style="width:334px;"><div>壓力來源</div></th>
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

  <a id="rewriteDefaultPressureReasonsShow" href="#rewriteDefaultPressureReasonsWindow" style="display:none;">#</a>
  <div id="rewriteDefaultPressureReasonsWindow">
      <div class='page-outer' style='width: 250px; height: 95px;'>
          <div class='normal-inner'>
            <div>請確認是否要還原預設值?</div>
          </div>
          <div id="primary-action">
              <input class="btn func-btn" type="button" value="確 定" onclick="rewriteDefaultActive();" />
              <input class="btn func-btn" type="button" onclick="$('#selectPressureReasonsShow').trigger('click');" value="取 消" />
          </div>
      </div>
  </div>

  <a id="selectPressureReasonsShow" href="#selectPressureReasonsWindow" style="display:none;">#</a>
  <div id="selectPressureReasonsWindow">
      <div class='page-outer' style='width: 710px;'>
          <div class='normal-inner'>
              <div class="content">
                  <table class="pressure-menu">
                    <tbody id="select_reasons_tbody"></tbody>
                  </table>
              </div>
              <div class="function">
                  <input type="button" class="btn func-btn" value="編 輯" onclick="edit_pressure_reasons_alert()">
              </div>
          </div>
          <div id="primary-action">
              <input class="btn func-btn" type="button" value="回復預設值" onclick="rewriteDefaultAlert();" style="width: 81px;" />
              <input id="selectPressureReasonsAction" class="btn func-btn" type="button" value="確 定" onclick="selectPressureReasonsAction()" />
          </div>
      </div>
  </div>


  <a id="editPressureReasonsShow" href="#editPressureReasonsWindow" style="display:none;">#</a>
  <div id="editPressureReasonsWindow">
      <div class='page-outer' style='width: 350px;'>
          <div id="near-inner">
              <input id="newReasonInput" type="text" placeholder="新增項目......" style="width: 258px;margin: 0 0 12px 0;" />
              <ul class="pressure-edit" id="edit_reasons_ul"></ul>
              <div class="pressure-func">
                  <input type="button" class="btn func-btn" value="新 增" onclick="new_reason()">
                  <input type="button" class="btn func-btn" value="刪 除" onclick="delete_reason()">
                  <input type="button" class="btn func-btn" value="往上移" onclick="reason_move(1)">
                  <input type="button" class="btn func-btn" value="往下移" onclick="reason_move(0)">
                  <!-- <input type="button" class="btn func-btn" value="預設值" onclick="edit_reasons_restore()"> -->
              </div>
          </div>

          <div id="primary-action">
              <input type="button" value="確定" class="btn func-btn" onclick="select_pressure_reasons_alert()">
          </div>
      </div>
  </div>
</div>

<script>
  var default_select_reasons_html = '';
  var original_pressure_reasons;
  var new_reason_ids = [];

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

    $("#newPressureValue").slider({
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

    $("#selectPressureReasonsShow").fancybox({
      'type': 'inline',
      'title': '壓力來源',
      'padding' : 0,
      'titlePosition'     : 'outside',
      'transitionIn'      : 'none',
      'transitionOut'     : 'none',
      'overlayShow'       : false,
    });

    $("#editPressureReasonsShow").fancybox({
      'type': 'inline',
      'title': '編輯',
      'padding' : 0,
      'titlePosition'     : 'outside',
      'transitionIn'      : 'none',
      'transitionOut'     : 'none',
      'overlayShow'       : false,
    });

    $("#rewriteDefaultPressureReasonsShow").fancybox({
      'type': 'inline',
      'title': '',
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
    select_reasons = $("input[name='arr_pressure_select[]']:checked");

    if (select_reasons.length)
    {
      reason_ids = [];
      reason_ids = select_reasons.map(function(){
        return ($(this).val());
      });

      $('#newReasonIds').val(reason_ids.get().join());

      $.post("health/pressure/functions/record/new.php", $("#newRecordForm").serialize()).success(function(data){
        if (data.success)
        {
          $('#newPressureValue').slider("value", 5);
          recordReflash();
          $.fancybox.close();
        }
      });
    }
    else
    {
      alert('請選擇壓力來源');
    }
  }

  function update_record(id)
  {
    var pressure_value = parseInt($("#record_td_" + id + "_pressure_value").val());
    var params = {
      id: id,
      pressure_value: pressure_value ? pressure_value : 5
    };

    $.post("health/pressure/functions/record/update.php", params).success(function(data){
    });
  }

  function delete_alert(id)
  {
    $("#deleteAction").attr('onclick',"delete_record(" + id + ")");
    $("#recordDeleteShow").trigger('click');
  }

  function delete_record(id)
  {
    var params = {
      id: id
    };

    $.post("health/pressure/functions/record/delete.php", params).success(function(data){
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

    $.get("health/pressure/record_tbody_refresh.php", params).success(function(html) {
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

  function select_pressure_reasons_alert()
  {
    get_reasons_for_select();
  }


  function selectPressureReasonsAction()
  {
    new_record();
    //$.fancybox.close();
  }

  function get_reasons_for_select()
  {
    var params = {
      date: $('#newPressureDate').val()
    };

    $('#select_reasons_tbody').html('');
    $.get("health/pressure/functions/record/get_reasons_for_select.php", params).success(function(html){
      $("#selectPressureReasonsShow").trigger('click');
      $('#select_reasons_tbody').html(html);
      default_select_reasons_html = html;
    });
  }

  function delete_all_reasons()
  {
    $.get("health/pressure/functions/record/delete_all_reason.php").success(function(){
      get_reasons_for_select();
    });
  }

  function rewriteDefaultAlert()
  {
    $("#rewriteDefaultPressureReasonsShow").trigger('click');
  }

  function rewriteDefaultActive()
  {
    delete_all_reasons();
    $("#selectPressureReasonsShow").trigger('click');
  }

  function edit_pressure_reasons_alert()
  {

    get_reasons_for_edit();
    $('#newReasonInput').val('');
    $("#editPressureReasonsShow").trigger('click');
  }

  function get_reasons_for_edit()
  {
    $.get("health/pressure/functions/record/get_reasons_for_edit.php", function(data){
      original_pressure_reasons = jQuery.parseJSON(data);
      edit_reasons_restore();
    });
  }

  function append_edit_reasons_ul(id, reason)
  {
    $('#edit_reasons_ul').append('<li id="edit_reason_li_' + id + '" class="edit_reason_li"><input type="checkbox" name="arr_pressure_edit[]" value="' + id + '"><span>' + reason + '</span></li>');
  }

  function edit_reasons_restore()
  {
    $('#edit_reasons_ul').html('');
    original_pressure_reasons.forEach(function(reason){
      append_edit_reasons_ul(reason.id, reason.reason)
    });
  }

  function new_reason()
  {
    var s_reason = $('#newReasonInput').val();

    if (s_reason)
    {
      var jsonObj = {
        reason: s_reason
      };

      var jsonStr = JSON.stringify(jsonObj);
      $.ajax({
          type: "POST",
          url: "health/pressure/functions/record/new_reason.php",
          data: {
            data: jsonStr
          },
          success: function(data){
            if (data.success)
            {
              $('#newReasonInput').val('');
              append_edit_reasons_ul(data.id, s_reason)
            }
          }
      });
    }
    else
    {
      alert('請填上項目');
    }
  }

  function delete_reason()
  {
    var selected_reasons = $("input[name='arr_pressure_edit[]']:checked");

    var deleted_ids = $.map(selected_reasons, (function(reason){
      return $(reason).val();
    }));

    var params = {
      ids: deleted_ids
    };

    $.post("health/pressure/functions/record/delete_reason.php", params).success(function(data){
      if (data.success)
      {
        deleted_ids.forEach(function(id){
          $("#edit_reason_li_" + id).remove();
        });
      }
    });
  }

  function reason_move(forward)
  {
    var selected_reasons = $("input[name='arr_pressure_edit[]']:checked");
    if (selected_reasons.length)
    {
      if(forward)
      {
        selected_reasons.get().forEach(function(e){
          $checkbox = $(e);
          var $li = $checkbox.parent();
          var index = $(".edit_reason_li").index($li);
          var target_index = index - 1;

          if (0 <= target_index)
          {
            $target_li = $(".edit_reason_li").eq(target_index);
            $target_checkbox = $($target_li.children("input:checkbox")[0]);
            if (!$target_checkbox.attr('checked'))
            {
              $li.insertBefore($(".edit_reason_li").eq(target_index));
            }
          }
        });
      }
      else
      {
        li_length = $(".edit_reason_li").length;
        selected_reasons.get().reverse().forEach(function(e){
          $checkbox = $(e);
          var $li = $checkbox.parent();
          var index = $(".edit_reason_li").index($li);
          var target_index = index + 1;

          if (li_length > target_index)
          {
            $target_li = $(".edit_reason_li").eq(target_index);
            $target_checkbox = $($target_li.children("input:checkbox")[0]);
            if (!$target_checkbox.attr('checked'))
            {
              $li.insertAfter($(".edit_reason_li").eq(target_index));
            }
          }
        });
      }

      update_reason_seq();
    }
  }

  function update_reason_seq()
  {
    var reasons = $("input[name='arr_pressure_edit[]']");

    var ids = $.map(reasons, (function(reason){
      return $(reason).val();
    }));

    var params = {
      ids: ids
    };

    $.post("health/pressure/functions/record/update_reason_seq.php", params).success(function(data){});
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




