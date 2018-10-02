<link href="js/datePicker/datePicker.css" rel="stylesheet" />
<script type="text/javascript" src="js/datePicker/date.js"></script>
<script type="text/javascript" src="js/datePicker/jquery.datePicker.js"></script>

<div class="top_block">
  <div id="edit_area" class="spec-outer">
    <div class="spec-inner-srch clear">
      <form id="newRecordForm">
        <input type="text" id="newMealDate" name="newMealDate" class="pick-Date" style="text-align: center; width:95px; margin: 0px 0px 5px 0px;" value="<?php echo date("Y/m/d", strtotime($start_date)); ?>" onchange="change_date(this.value);">
        <div class="spec-content" style="display: none;">
          <div class="search">
            <input type="hidden" id="newMealFoodId" name="newMealFoodId" />
            <input type="hidden" id="newMealUnit" name="newMealUnit" />
            <input type="hidden" id="newMealGram" name="newMealGram" />
            <input type="hidden" id="newMealEnergKcal" name="newMealEnergKcal" />
            <input type="hidden" id="newMealProtein" name="newMealProtein" />
            <input type="hidden" id="newMealLipidTot" name="newMealLipidTot" />
            <input type="hidden" id="newMealCarbohydrt" name="newMealCarbohydrt" />
            <input type="hidden" id="newMealEng" name="newMealEng" />
          </div>
        </div>
      </form>
      <form id="searchFoodsForm" onsubmit="return false;">
        <div class="spec-content">
          <div class="search">
            <input type="text" id="searchKeyword" name="searchKeyword" placeholder="吃了什麼......" onkeypress="if (13 == event.keyCode){search_foods();}">
          </div>
        </div>
        <input type="button" class="btn search-btn right" value="確定" onclick="search_foods();">
      </form>
    </div>
  </div>
</div>

<div class='log-switch' style="margin-top: 45px;">
  <ul class="period">
    <li class="odd">
      <input id="selectDate" name="selectDate" class="pick-Date date-view" type="text" value="<?php echo date("Y/m/d", strtotime($start_date)); ?>" onchange="change_date(this.value);" />
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
        <th class="thead" style="width:364px;"><div>飲食項目</div></th>
        <th class="thead" style="width:70px;"><div>用量(g)</div></th>
        <th class="thead" style="width:90px;"><div>熱量(kcal)</div></th>
        <th class="thead" style="width:110px;"><div>碳水化合物(g)</div></th>
        <th class="thead" style="width:70px;"><div>脂肪(g)</div></th>
        <th class="thead" style="width:75px;"><div>蛋白質(g)</div></th>
        <th class="thead action" style="width:85px;"><div></div></th>
      </tr>
    </thead>
      <tbody id="record_tbody" class="record_table_tbody twoColorRow">
        <?php include("_partial_record_tbody.php"); ?>
      </tbody>
  </table>
</div>


  <table style="margin-top: 10px;">
      <tr>
          <td style="width:364px;"></td>
          <td style="width:70px; text-align: center;">總熱量</td>
          <td style="width:90px; text-align: center;"><span id="diet_kcal_subtotal">0</span></td>
          <td style="width:110px;"><div style="padding: 0 17px;">kcal</div></td>
          <td style="width:70px;"></td>
          <td style="width:75px;"></td>
          <td style="width:85px;"></td>
      </tr>
  </table>


<div style="display:none;">
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

  <a id="selectFoodsShow" href="#selectFoodsWindow" style="display:none;">#</a>
  <div id="selectFoodsWindow">
      <div class='page-outer' style='width: 665px; height: 400px;'>
        <ul class="search-list" id="selectFoodsSearchList">
        </ul>
      </div>
  </div>

  <a id="setIntakeShow" href="#setIntakeWindow" style="display:none;">#</a>
  <div id="setIntakeWindow">
      <div class='page-outer' style='width: 400px; height: 150px;'>
          <div id="normal-inner" style="padding: 20px;">
              <table class="distance-table">
              <tbody><tr>
                  <td style="width: 1px"><input type="text" id="setIntakeAmount" size="5" onkeyup="calculate_diet(0, this.value)"></td>
                  <td style="width: 1px" style="padding: 0;"><span>x</span></td>
                  <td><span id="setIntakeUnitName"></span></td>
              </tr>
              <tr>
                  <td></td>
                  <td></td>
                  <td>
                    <input type="text" id="setIntakeWeight" size="4" onkeyup="calculate_diet(1, this.value)">克
                  </td>
              </tr>
              </tbody></table>
          </div>
          <div id="primary-action">
              <input id="set_intake_action" class="btn func-btn" type="button" value="確 定" onclick="set_intake_action();" />
          </div>
      </div>
  </div>
</div>


<script type="text/javascript">
  var selected_food = {};
  var found_foods = [];

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

    $("#selectFoodsShow").fancybox({
      'type': 'inline',
      'title': '飲食項目',
      'padding' : 0,
      'titlePosition'     : 'outside',
      'transitionIn'      : 'none',
      'transitionOut'     : 'none',
      'overlayShow'       : false,
    });

    $("#setIntakeShow").fancybox({
      'type': 'inline',
      'title': '用量',
      'padding' : 0,
      'titlePosition'     : 'outside',
      'transitionIn'      : 'none',
      'transitionOut'     : 'none',
      'overlayShow'       : false,
    });

    $("#editRecordShow").fancybox({
      'type': 'inline',
      'title': '用量',
      'padding' : 0,
      'titlePosition'     : 'outside',
      'transitionIn'      : 'none',
      'transitionOut'     : 'none',
      'overlayShow'       : false,
    });

    record_edit_td_init();
    calculate_total_kcal();
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

  function select_meal_alert()
  {
    $.fancybox.close();
    $('#selectFoodsShow').trigger('click');
  }

  //function select_meal_action(id, unit_name, gram_per_unit, energ_kcal, protein, lipid_tot, carbohydrt, b_eng)
  function select_meal_action(id)
  {
    found_food = {};

    found_foods.forEach(function(e){
      if (e.id == id)
      {
        found_food = e;
      }
    });


    selected_food = {
      id: id,
      unit_name: found_food.unit_name,
      gram_per_unit: 0 < found_food.gram_per_unit ? found_food.gram_per_unit : 1,
      energ_kcal: found_food.energ_kcal,
      protein: found_food.protein,
      lipid_tot: found_food.lipid_tot,
      carbohydrt: found_food.carbohydrt,
      newMealUnit: 1,
      newMealGram: found_food.gram_per_unit,
      newMealEnergKcal: found_food.energ_kcal,
      newMealProtein: found_food.protein,
      newMealLipidTot: found_food.lipid_tot,
      newMealCarbohydrt: found_food.carbohydrt,
      newMealEng: found_food.b_eng
    }

    console.log(selected_food);

    $('#setIntakeAmount').val(1);
    $('#setIntakeWeight').val(selected_food.gram_per_unit);
    $('#setIntakePerUnit').text(selected_food.gram_per_unit);
    $('#setIntakeUnitName').text(selected_food.unit_name);

    do_calculate_diet();

    $("#set_intake_action").attr('onclick',"set_intake_action(false)");
    set_intake_alert();
  }

  function set_intake_alert()
  {
    $('#setIntakeShow').trigger('click');
  }

  function set_intake_action(id)
  {
    if (id)
    {
      update_record(id);
    }
    else
    {
      new_record();
    }
  }

  function calculate_diet(type, value)
  {
    if (value && '.' == value[value.length -1])
    {
      return false;
    }

    value = parseFloat(value);

    switch (type){
      case 0:
        unit = Math.round(value * 100) / 100;

        var gram = Math.round(unit * selected_food.gram_per_unit * 100) / 100;
        $('#setIntakeAmount').val(unit);
        $('#setIntakeWeight').val(gram);
        selected_food.newMealUnit = unit;
        selected_food.newMealGram = gram;
        break;
      case 1:
        gram = Math.round(value * 100) / 100;
        var unit = Math.round(gram * 100 / selected_food.gram_per_unit) / 100;
        $('#setIntakeAmount').val(unit);
        $('#setIntakeWeight').val(gram);
        selected_food.newMealUnit = unit;
        selected_food.newMealGram = gram;
        break;
    }

    do_calculate_diet();

    if (!value)
    {
        $('#setIntakeAmount').val('');
        $('#setIntakeWeight').val('');
    }
  }

  function do_calculate_diet()
  {
    selected_food.newMealEnergKcal = Math.round(selected_food.energ_kcal * selected_food.newMealUnit * (selected_food.gram_per_unit / 100) * 100) / 100;
    selected_food.newMealProtein = Math.round(selected_food.protein * selected_food.newMealUnit * (selected_food.gram_per_unit / 100) * 100) / 100;
    selected_food.newMealLipidTot = Math.round(selected_food.lipid_tot * selected_food.newMealUnit * (selected_food.gram_per_unit / 100) * 100) / 100;
    selected_food.newMealCarbohydrt = Math.round(selected_food.carbohydrt * selected_food.newMealUnit * (selected_food.gram_per_unit / 100) * 100) / 100;
  }

  function search_foods()
  {
    if ('' != $('#searchKeyword').val())
    {
      $.post("health/diet/functions/record/search_foods.php", $("#searchFoodsForm").serialize()).success(function(data){
        found_foods = JSON.parse(data);

        select_meal_alert();
        set_search_foods_list();

        //$('#selectFoodsSearchList').html(data);
        $('#searchKeyword').val('');
      });
    }
  }

  function set_search_foods_list()
  {
    var s_html = '';
    found_foods.forEach(function(e){
      s_html += '<li style="cursor: pointer;" onclick="select_meal_action(' + e.id + ')">' + e.desc + '</li>';
    });

    $('#selectFoodsSearchList').html(s_html);
  }

  function new_record()
  {
    if (!(selected_food.newMealUnit && selected_food.newMealGram))
    {
      alert('請輸入攝取份量');
      return false;
    }

    $("#newMealFoodId").val(selected_food.id);
    $("#newMealUnit").val(selected_food.newMealUnit);
    $("#newMealGram").val(selected_food.newMealGram);
    $("#newMealEnergKcal").val(selected_food.newMealEnergKcal);
    $("#newMealProtein").val(selected_food.newMealProtein);
    $("#newMealLipidTot").val(selected_food.newMealLipidTot);
    $("#newMealCarbohydrt").val(selected_food.newMealCarbohydrt);
    $("#newMealEng").val(selected_food.newMealEng);

    $.post("health/diet/functions/record/new.php", $("#newRecordForm").serialize()).success(function(data){
      if (data.success)
      {
        recordReflash();
        $.fancybox.close();
      }
    });
  }

  function edit_record_alert(id, food_id, unit, gram, unit_name, gram_per_unit, energ_kcal, protein, lipid_tot, carbohydrt)
  {
    selected_food = {
      id: food_id,
      unit_name: unit_name,
      gram_per_unit:  0 < gram_per_unit ? gram_per_unit : 1,
      energ_kcal: energ_kcal,
      protein: protein,
      lipid_tot: lipid_tot,
      carbohydrt: carbohydrt,
      newMealUnit: unit,
      newMealGram: gram,
      newMealEnergKcal: 0,
      newMealProtein: 0,
      newMealLipidTot: 0,
      newMealCarbohydrt: 0
    }

    do_calculate_diet();

    $('#setIntakeAmount').val(selected_food.newMealUnit);
    $('#setIntakeWeight').val(selected_food.newMealGram);
    $('#setIntakePerUnit').text(selected_food.gram_per_unit);
    $('#setIntakeUnitName').text(selected_food.unit_name);

    $("#set_intake_action").attr('onclick',"set_intake_action(" + id + ")");
    set_intake_alert();
  }

  function update_record(id)
  {
    if (!(selected_food.newMealUnit && selected_food.newMealGram))
    {
      alert('請輸入攝取份量');
      return false;
    }

    var params = {
      id: id,
      newMealUnit: selected_food.newMealUnit,
      newMealGram: selected_food.newMealGram,
      newMealEnergKcal: selected_food.newMealEnergKcal,
      newMealProtein: selected_food.newMealProtein,
      newMealLipidTot: selected_food.newMealLipidTot,
      newMealCarbohydrt: selected_food.newMealCarbohydrt
    };

    console.log(params);

    $.post("health/diet/functions/record/update.php", params).success(function(data){
      recordReflash();
      $.fancybox.close();
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

    $.post("health/diet/functions/record/delete.php", params).success(function(data){
      $("#record_tr_" + id).remove();
      keep_table_space_row();
      calculate_total_kcal();
      $.fancybox.close();
    });
  }

  function recordReflash()
  {
    var params = {
      selectDate: $('#selectDate').val()
    };

    $.get("health/diet/record_tbody_refresh.php", params).success(function(html) {
      $("#record_tbody").html(html);
      record_edit_td_init();
      calculate_total_kcal();
    });
  }

  function calculate_total_kcal()
  {
    var total = 0.0;
    var value = 0.0;
    $('#record_tbody').children().each(function(){
      value = parseFloat($($(this).children()[2]).text());
      if (value)
      {
        total += value;
      }
    });

    $('#diet_kcal_subtotal').text(total.toFixed(2));
  }

  function change_date(value)
  {
    $('#selectDate').val(value);
    $('#newMealDate').val(value);
    recordReflash();
  }

  function keep_table_space_row()
  {
    var count_rows = $('#record_tbody > tr').length;

    for(var i = count_rows; i < 12; i++)
    {
      $('#record_tbody').append("<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>");
    }
  }

</script>



