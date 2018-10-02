<?php // modify file ?>
<?php
/**

$all_accounts : list of invest type accounts

$selected_account : selected account

$invests_list: invests of this selected account
 */
?>
<link href="finance/css/invests.css?20170119" rel="stylesheet" />
<link href="js/datePicker/datePicker.css" rel="stylesheet" />

<script type="text/javascript" src="js/datePicker/date.js"></script>
<script type="text/javascript" src="js/datePicker/jquery.datePicker.js"></script>
<script type="text/javascript" src="finance/js/number_format.js"></script>

<form id="post_form" method="post" action="?dept=finance&ma=invests&sa=list">
  <div class="top_block">
    <select id="account" name="account" class="form_select" style="width:95px; margin: 0px 0px 5px 0px;">
    <?php foreach ( $all_accounts as $account ): ?>
        <option value="<?=$account['account_id']?>"  <?=( $account['account_id'] == $selected_aid ) ? 'selected' : '' ?>><?=$account['account_name']?></option>
    <?php endforeach; ?>
    </select>

    <table class="invests_table" style="width:640px; border-bottom:1px solid #C3C3C3; ">
      <thead>
        <tr>
          <th class="thead" style="width:100px;">日期</th>
          <th class="thead" style="width:90px;">交易</th>
          <th class="thead" style="width:150px;">名稱</th>
          <th class="thead" style="width:80px;">數量</th>
          <th class="thead" style="width:80px;">單價</th>
          <th class="thead" style="width:80px;">手續費</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="text-align: center;"><input id="add_date" name="add_date" class="input-numbers input-table pick-Date" type="text"  style="text-align: center; width:95px;" value="<?php echo date("Y/m/d"); ?>" /></td>
          <td style="text-align: center;">
            <select id="add_action" name="add_action" class="input_no_border_margin" style="width:65px;" >
              <?php
                  for ($i = 0; $i < count($action_options); $i++)
                  {
                      echo "<option value='$i'>{$action_options[$i]}</option>";
                  }
              ?>
            </select>
          </td>
          <td style="text-align: center;"><input type="text" id="add_name" name="add_name" class="input_no_border_margin" style="text-align: center; width:200px;" /></td>
          <td id="cal_trigger_amount" class="cal_trigger" style="text-align: center;"></td>
          <td id="cal_trigger_price" class="cal_trigger" style="text-align: center;"></td>
          <td id="cal_trigger_fee" class="cal_trigger" style="text-align: center;"></td>
        </tr>
      </tbody>
    </table>

    <div id="calculator" class="calculator" style="display:none;">
      <div class="keytable">
        <button type="button" id="key_C" class="key">C</button>
        <button type="button" id="key_back" class="key">←</button>
        <button type="button" id="key_off" class="key" style="padding-left: 2px">OFF</button>
        <button type="button" id="key_7" class="key">7</button>
        <button type="button" id="key_8" class="key">8</button>
        <button type="button" id="key_9" class="key">9</button>
        <button type="button" id="key_4" class="key">4</button>
        <button type="button" id="key_5" class="key">5</button>
        <button type="button" id="key_6" class="key">6</button>
        <button type="button" id="key_1" class="key">1</button>
        <button type="button" id="key_2" class="key">2</button>
        <button type="button" id="key_3" class="key">3</button>
        <button type="button" id="key_0" class="key" style="width:74px">0</button>
        <button type="button" id="key_dot" class="key">.</button>
        <button type="button" id="key_enter" class="key" style="width:114px">Enter</button>
      </div>
    </div>
    <div style="float:right; padding: 5px 6px;">
      <input class="btn func-btn" type="button" onclick="add_invest()" value="確 定" style="font-size:16px; height:28px; width:68px;"></input>
    </div>
  </div>

  <div class='log-switch' style="border-bottom-width: 0px; border-right-width: 2px;">
    <ul class="period" style="left:0px;">
      <?php /* Select element of during */ ?>
      <?php
        if(isset($_POST['selfLastDate']) && preg_match('/^\d{4}\/[0-1]\d\/[0-3]\d$/', $_POST['selfLastDate']) )
        {
            echo "<li>{$_POST['selfLastDate']}</li>";
        }
      ?>
      <li>
        <select id="selectedDuring" name="selectedDuring" class="form_select" style="width:80px;">
        <?php foreach ( $durings as $index => $during ): ?>
          <option value="<?=$index?>" <?=($index==$selectedDuring) ? 'selected' : '' ?>><?=$during?></option>
        <?php endforeach; ?>
          <option value="user_time">自訂</option>
        </select>
        <input type="hidden" id="post_user_selfLastDate" name="selfLastDate" value="">
      </li>
    </ul>
    <ul class='menu' style="right: 70px;">
      <?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
        <li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=finance&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</form>

<div style="max-height: 500px; overflow-y:auto;">
  <table class="invests_table div_data_table" style="border-bottom:1px solid #C3C3C3; ">
    <thead>
      <tr class="tblTitleTr">
        <th class="thead" style="width:90px;"><div>日期 </div></th>
        <th class="thead" style="width:50px;"><div>交易</div></th>
        <th class="thead" style="width:200px;"><div>名稱</div></th>
        <th class="thead" colspan="3" style="width:250px;"><div>說明</div></th>
        <th class="thead" style="width:100px;"><div>交易金額</div></th>
        <th class="thead" style="width:100px;"><div>結餘</div></th>
        <th class="thead" style="width: 75px;"><div></div></th>
      </tr>
    </thead>
    <tbody class="invest_table_tbody twoColorRow">
      <?php for ($i = 0; $i < count($invests_list); $i++){ ?>
        <?php $invest_id = $invests_list[$i]['id']; ?>
        <tr id="invest_tr_<?php echo $invest_id ?>">
          <td style="text-align: center;" class="buytime"><?php echo $invests_list[$i]["buytime"] ?></td>
          <td style="text-align: center;" class="action_select"><?php echo $action_options[$invests_list[$i]["action"]] ?></td>
          <td style="text-align: center;" class="objname"><?php echo $invests_list[$i]["name"] ?></td>
          <td style="text-align: center; width: 80px;" class="price">
            <label id="invest_td_<?php echo $invest_id ?>_price_label" for="invest_td_<?php echo $invest_id ?>_price" class="invest_edit_label"><?php echo number_format($invests_list[$i]["price"]) ?></label>
            <input id="invest_td_<?php echo $invest_id ?>_price" type="text" class="input_no_border_margin invest_edit_input" value="<?php echo $invests_list[$i]["price"] ?>" style="text-align: center; display: none;" />
            <br /><div>價格</div>
          </td>
          <td style="text-align: center; width: 80px;" class="quantity">
            <label id="invest_td_<?php echo $invest_id ?>_quantity_label" for="invest_td_<?php echo $invest_id ?>_quantity" class="invest_edit_label"><?php echo number_format($invests_list[$i]["quantity"]) ?></label>
            <input id="invest_td_<?php echo $invest_id ?>_quantity" type="text" class="input_no_border_margin invest_edit_input" value="<?php echo $invests_list[$i]["quantity"] ?>" style="text-align: center; display: none;" onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
            <br /><div>數量</div>
          </td>
          <td style="text-align: center; width: 80px;" class="fee">
            <label id="invest_td_<?php echo $invest_id ?>_fee_label" for="invest_td_<?php echo $invest_id ?>_fee" class="invest_edit_label"><?php echo number_format($invests_list[$i]["fee"]) ?></label>
            <input id="invest_td_<?php echo $invest_id ?>_fee" type="text" class="input_no_border_margin invest_edit_input" value="<?php echo $invests_list[$i]["fee"] ?>" style="text-align: center; display: none;" />
            <br /><div>手續費</div>
          </td>
          <td class="money" style='text-align: center;'><?php echo number_format($invests_list[$i]["money"]) ?></td>
          <td class="balance" style='text-align: center;'><?php echo number_format($invests_list[$i]["balance"]) ?></td>
          <td class="operation">
            <input class="btn" type="button" onclick="update_invest(<?php echo $invest_id ?>, <?php echo $selected_aid ?>)" value="確定"></input>
            <input class="btn" type="button" onclick="delete_check(<?php echo $invest_id ?>, <?php echo $selected_aid ?>)" value="刪除"></input>
          </td>
        </tr>
      <?php } ?>

      <?php
        $more_rows = 12 - count($invests_list);
        while(0 < $more_rows)
        {
      ?>
          <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
      <?php
          $more_rows--;
        }
      ?>
    </tbody>
  </table>
</div>

<div class="data_table_tail center"></div>

<div style="display:none;">
  <a id="alert_show" href="#alert_window" style="display:none;" >#</a>
  <div id="alert_window">
      <div class='page-outer' style='width: 270px; height: 120px;'>
          <div class='normal-inner'>
            <p id="alert_msg"></p>
          </div>
          <div id="primary-action">
              <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="確 定"></input>
          </div>
      </div>
  </div>

  <a id="delete_show" href="#delete_window" style="display:none;" >#</a>
  <div id="delete_window">
      <div class='page-outer' style='width: 250px; height: 95px;'>
          <div class='normal-inner'>
            請確認是否要刪除?
          </div>
          <div id="primary-action">
            <input id="delete_function" class="btn func-btn" type="button" value="確 定"></input>
              <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="取 消"></input>
          </div>
      </div>
  </div>

  <a id="selfLastDate_trigger" href="#selfLastDate_dialog" style="display:none;" >#</a>
  <div id="selfLastDate_dialog">
      <div class='page-outer' style='width: 250px; height: 120px; overflow: hidden;'>
          <div class='normal-inner'>
              <table class='distance-table' style="height:90px;">
              <input id="ac_id_0" type="hidden" value="">
              <tr>
                  <td>
                      <div class="fancy_input_name">開始日期</div>
                      <input class="input-numbers pick-Date" type="text" value="" id="user_selfLastDate" style="width: 85px;"></input>
                  </td>
              </tr>
              <tr>
                  <td>
                      <div class="fancy_input_name">往前返回</div>
                      <select id="user_selectedDuring" style="width: 85px;">
                          <?php foreach ( $durings as $index => $during ): ?>
                            <option value="<?=$index?>"><?=$during?></option>
                          <?php endforeach; ?>
                      </select>
                  </td>
              </tr>
              </table>
          </div>
          <div id="primary-action">
              <input class="btn func-btn" type="button" onclick="update_select_during_time()" value="確 定"></input>
          </div>
      </div>
  </div>

</div>

<script>

    function add_invest() {
        var aid = $("#account").val();
        var action = $("#add_action").val();
        var date = $("#add_date").val();
        var add_name = $("#add_name").val();
        var cal_trigger_amount = $("#cal_trigger_amount").text();
        var cal_trigger_price = $("#cal_trigger_price").text();
        var cal_trigger_fee = $("#cal_trigger_fee").text();


        <?php if(isset($selected_aid)){ ?>
          if (!(aid && action && date && add_name && cal_trigger_amount && cal_trigger_price && cal_trigger_fee))
          {
              ara_alert("資料填寫未完整, 請重新輸入");
          }
          else
          {
              var jsonObj = {
                  aid: <?php echo $selected_aid; ?>,
                  iname: add_name, // 名稱
                  marketcap: parseFloat(cal_trigger_price) // 市值
              };

              var jsonStr = JSON.stringify(jsonObj);
              $.ajax({
                  type: "POST",
                  url: "finance/invests/invests_functions/marketcap/replace.php",
                  data: {
                    data: jsonStr
                  },
                  success: function(data){
                  }
              });

              var jsonObj = {
                  'aid': aid, // 帳戶 id
                  'date': date, // 日期
                  'iname': add_name, // 名稱
                  'action': action, // 0:買進, 1: 賣出
                  'price': cal_trigger_price, // 價格
                  'quantity': cal_trigger_amount, // 數量
                  'fee': cal_trigger_fee // 手續費
              };

              var jsonStr = JSON.stringify(jsonObj);
              $.ajax({
                  type: "POST",
                  url: "finance/invests/invests_functions/list/new.php",
                  data: {
                    data: jsonStr
                  },
                  success: function(data){
                      if (data.status) {
                        $('#post_form').submit();
                      } else {
                        ara_alert(data.emsg);
                      };
                  }
              });
          }
        <?php } ?>
    }

    function delete_check(iid, aid) {
      $("#delete_function").attr('onclick',"delete_invest(" + iid + "," + aid +")");
      $("#delete_show").trigger('click');
    }

    function delete_invest(iid, aid) {
      var jsonObj = {
        aid: aid,
        iid: iid
      };
      var jsonStr = JSON.stringify(jsonObj);
      $.ajax({
          type: "POST",
          url: "finance/invests/invests_functions/list/delete.php",
          data: {
            data: jsonStr
          },
          success: function(data){
              if (data.status) {
                $.fancybox.close();
                $('#post_form').submit();
              } else {
                ara_alert(data.emsg);
              };
          }
      });
    }

    function update_invest(iid, aid) {
      var tr_id = "#invest_tr_" + iid;
      var jsonObj = {
        aid: aid,
        iid: iid,
        price: $(tr_id).children("td").filter(".price").children("input")[0].value,
        quantity: $(tr_id).children("td").filter(".quantity").children("input")[0].value,
        fee: $(tr_id).children("td").filter(".fee").children("input")[0].value,
      };
      var jsonStr = JSON.stringify(jsonObj);

      $.ajax({
          type: "POST",
          url: "finance/invests/invests_functions/list/update.php",
          data: {
            data: jsonStr
          },
          success: function(data){
            if (data.status) {
              $('#post_form').submit();
            } else {
              ara_alert(data.emsg);
            };
          }
      });
    }


    $( "button.key" ).on( "click", function() {
        cal_input($(this).attr('id').substr(4));
      });


    function cal_input(num) {
      var position = null;

      if ($('#calculator').hasClass('cal_trigger_amount'))
      {
        position = $('#cal_trigger_amount');
      }
      else if ($('#calculator').hasClass('cal_trigger_price'))
      {
        position = $('#cal_trigger_price');
      }
      else if ($('#calculator').hasClass('cal_trigger_fee'))
      {
        position = $('#cal_trigger_fee');
      }

      if (num == 'C') {
        position.text("");
      } else if (num == 'back') {
        position.text(position.text().substr(0,position.text().length-1))
      } else if (num == 'dot') {
        if (position.text().indexOf('.') == -1) {
          position.text(position.text()+'\.')
        }
      } else if (num == 'enter') {
        $("#calculator").hide();
      } else if (num == 'off') {
        position.text("");
        $("#calculator").hide();
      } else {
        position.text(position.text()+num)
      };
    }


    $(document).ready(function() {
        $('.pick-Date').datePicker({startDate: '1991/01/01', endDate: (new Date()).asString(), clickInput:true, createButton: false, showYearNavigation: false, verticalOffset: -1, horizontalOffset: 165 });

        $( "#cal_trigger_amount" ).on( "click", function() {
          if(!$("#cal_trigger_amount").hasClass('disable')) {
            $("#calculator").removeClass("cal_trigger_price");
            $("#calculator").removeClass("cal_trigger_fee");
            $("#calculator").addClass("cal_trigger_amount");
            $("#calculator").css({'margin-left':'377px'});
            $("#calculator").show();
          }
        });

        $( "#cal_trigger_price" ).on( "click", function() {
          if(!$("#cal_trigger_price").hasClass('disable')) {
            $("#calculator").removeClass("cal_trigger_amount");
            $("#calculator").removeClass("cal_trigger_fee");
            $("#calculator").addClass("cal_trigger_price");
            $("#calculator").css({'margin-left':'454px'});
            $("#calculator").show();
          }
        });

        $( "#cal_trigger_fee" ).on( "click", function() {
          if(!$("#cal_trigger_fee").hasClass('disable')) {
            $("#calculator").removeClass("cal_trigger_amount");
            $("#calculator").removeClass("cal_trigger_price");
            $("#calculator").addClass("cal_trigger_fee");
            $("#calculator").css({'margin-left':'534px'});
            $("#calculator").show();
          }
        });

        $("#alert_show").fancybox({
            'type': 'inline',
            'title': '',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
        });

        $("#delete_show").fancybox({
            'type': 'inline',
            'title': '',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false
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

        $("#selectedDuring").on("change",function(){
          if ($(this).val()=='user_time') {
            $("#selfLastDate_trigger").click();
          }
        });

        $(".form_select").on("change",function(a){
          if('user_time' != $(this).val())
          {
            $("#post_form").submit();
          }
        });

        <?php
          if(!isset($selected_aid))
          {
        ?>
            $('#alert_msg').html('請至"帳戶管理"新增一個投資帳戶');
            $("#alert_show").trigger('click');
        <?php
          }
        ?>


        $(".invest_edit_label")
          .click(function(){
            input_id = "#" + $(this).prop("id").replace('_label', '');
            $(this).hide();
            $(input_id).show();

          });



        $(".invest_edit_input")
          .blur(function() {
            label_id = "#" + $(this).prop("id") + '_label';

            if (label_id.match("quantity"))
            {
              $(label_id).text(number_format($(this).val()));
            }
            else
            {
              $(label_id).text(number_format($(this).val()));
            }

            $(this).hide();
            $(label_id).show();
          });
    });

    function update_select_during_time()
    {
        $('#selectedDuring').val($('#user_selectedDuring').val());
        $('#post_user_selfLastDate').val($('#user_selfLastDate').val());
        $("#post_form").submit();
    }

    function ara_alert(msg) {
      $('#alert_msg').html(msg);
      $("#alert_show").trigger('click');
    }


</script>











