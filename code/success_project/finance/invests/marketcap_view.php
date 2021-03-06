<?php // modify file ?>
<?php
/**

$all_accounts : list of invest type accounts

$selected_account : selected account

$invests_list: invests of this selected account
 */

/*
<pre><?php print_r($all_accounts); ?></pre>
<pre><?php print_r($selected_account); ?></pre>
<pre><?php print_r($lastInvests); ?></pre>
 *
 */
?>

<link href="finance/css/invests.css" rel="stylesheet" />
<script type="text/javascript" src="finance/js/number_format.js"></script>

<div class='log-switch' style="border-bottom-width: 0px; border-right-width: 2px; clear:right;">
  <ul class="period" style="left:5px;">
    <li>
      <form id="post_form" method="post" action="?dept=finance&ma=invests&sa=marketcap" style="margin-top: -3px;">
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

<div style="max-height: 330px; overflow-y:auto;">
  <table class="invests_table div_data_table" style="border-bottom:1px solid #C3C3C3; ">
    <thead>
      <tr class="tblTitleTr">
        <th class="thead" style="width:200px;"><div>名稱</div></th>
        <th class="thead" style="width:100px;"><div style="border: 1px red solid;">目前價格</div></th>
        <th class="thead" style="width:100px;"><div style="border-left: 1px red solid;">剩餘數量</div></th>
        <th class="thead" style="width:100px;"><div>總值</div></th>
        <th class="thead" style="width:100px;"><div>成本</div></th>
        <th class="thead" style="width:100px;"><div>淨利</div></th>
        <th class="thead" style="width:100px;"><div>報酬率%</div></th>
        <th class="thead" style="width: 73px;"><div></div></th>
      </tr>
    </thead>
    <tbody class="invest_table_tbody twoColorRow">
      <?php for ($row = 0; $row < count($lastInvests); $row++){ ?>
        <tr id="invest_tr_<?php echo $row ?>">
          <td style="text-align: center;" class="objname"><?php echo $lastInvests[$row]["name"] ?></td>
          <td style="text-align: center;" class="marketcap">
            <label id="invest_td_<?php echo $row ?>_marketcap_label" for="invest_td_<?php echo $row ?>_marketcap" class="invest_edit_label"><?php echo number_format($lastInvests[$row]["marketcap"]) ?></label>
            <input id="invest_td_<?php echo $row ?>_marketcap" type="text" class="input_no_border_margin invest_edit_input" value="<?php echo $lastInvests[$row]["marketcap"] ?>" style="text-align: center; display: none;" />
          </td>
          <td style="text-align: center;" class="quantity"><?php echo number_format($lastInvests[$row]["quantity"]) ?></td>
          <td style="text-align: center;" class="total_value"><?php echo number_format($lastInvests[$row]["total_value"]) ?></td>
          <td style="text-align: center;" class="cost"><?php echo number_format($lastInvests[$row]["cost"]) ?></td>
          <td style="text-align: center;" class="net_profit"><?php echo number_format($lastInvests[$row]["net_profit"]) ?></td>
          <td style="text-align: center;" class="percent"><?php echo $lastInvests[$row]["percent"] ?></td>
          <td class="operation">
            <input class="btn" type="button" onclick="update_marketcap(<?php echo $row ?>)" value="確定"></input>
            <input class="btn" type="button" onclick="delete_check(<?php echo $row ?>)" value="刪除"></input>
          </td>
        </tr>
      <?php } ?>


      <?php
        $more_rows = 12 - count($lastInvests);
        while(0 < $more_rows)
        {
      ?>
          <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
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
      <div class='page-outer' style='width: 250px; height: 95px;'>
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


  <div id="marketcap_notice_window">
      <div class='page-outer repayment_page-outer' style='width: 430px; height: 130px;'>
          <div class='normal-inner'>
            <p id="marketcap_notice_msg">1. 請隨時更新目前價格,才能顯示最新的淨利與分析圖表<br />2. 此表乃針對剩餘的數量做淨利分析,不包含過去已交易的數量</p>
          </div>
          <div id="primary-action">
              <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="確 定" />
          </div>
      </div>
  </div>
</div>

<script>
    function delete_check(row) {
      $("#delete_function").attr('onclick',"delete_marketcap(" + row + ")");
      $("#delete_show").trigger('click');
    }

    function delete_marketcap(row) {
      var tr_row = "#invest_tr_" + row;
      var jsonObj = {
        aid: <?php echo $selected_aid; ?>,
        iname: $(tr_row).children("td").filter(".objname").text(),
      };

      var jsonStr = JSON.stringify(jsonObj);
      $.ajax({
          type: "POST",
          url: "finance/invests/invests_functions/marketcap/delete.php",
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

    function update_marketcap(row) {

      var tr_row = "#invest_tr_" + row;
      var jsonObj = {
        aid: <?php echo $selected_aid; ?>,
        iname: $(tr_row).children("td").filter(".objname").text(),
        marketcap: parseFloat($(tr_row).children("td").filter(".marketcap").children("input")[0].value)
      };

      var jsonStr = JSON.stringify(jsonObj);
      $.ajax({
          type: "POST",
          url: "finance/invests/invests_functions/marketcap/replace.php",
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


    $( "a.key" ).on( "click", function() {
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
        $( "#cal_trigger_price" ).on( "click", function() {
          if(!$("#cal_trigger_price").hasClass('disable')) {
            $("#calculator").removeClass("cal_trigger_amount");
            $("#calculator").removeClass("cal_trigger_fee");
            $("#calculator").addClass("cal_trigger_price");
            $("#calculator").css({'margin-left':'454px'});
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

        $(".form_select").on("change",function(a){
          if('user_time' != $(this).val())
          {
            $("#post_form").submit();
          }
        });

        $(".invest_edit_label").click(function(){
          input_id = "#" + $(this).prop("id").replace('_label', '');
          $(this).hide();
          $(input_id).show();
        });

        $(".invest_edit_input").blur(function() {
          label_id = "#" + $(this).prop("id") + '_label';
          $(label_id).text(number_format($(this).val()));
          $(this).hide();
          $(label_id).show();
        });

        // marketcap_notice_show
        $("#marketcap_notice_show").fancybox({
            'type': 'inline',
            'title': '注意事項',
            'padding' : 0,
            'titlePosition'     : 'outside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'overlayShow'       : false,
        });

    });

    function ara_alert(msg) {
      $('#alert_msg').html(msg);
      $("#alert_show").trigger('click');
    }


</script>











