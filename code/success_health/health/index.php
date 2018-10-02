<?php
// link mysql
require "config_health_conn.php";

if ( 0 )
{
    ini_set('display_errors',1);
    error_reporting(E_ALL);
}

/* Include configs */
include ( 'configs.php' );

/* User id */
$uid = $_SESSION['userid'];

/* Route */
$mas = array(
    'diet' => '飲&nbsp;食',
    'exercise' => '運&nbsp;動',
    'sleep' => '睡&nbsp;眠',
    'mood' => '心&nbsp;情',
    'weight' => '減重計畫',
    'pressure' => '壓力管理'
);

$sas = array(
    'diet' => array(
        'record'    => '飲食紀錄',
        'analytic' => '營養分析'
    ),
    'exercise' => array(
        'record'    => '運動紀錄',
        'analytic' => '熱量分析'
    ),
    'sleep' => array(
        'record'    => '睡眠紀錄',
        'analytic' => '品質分析'
    ),
    'mood' => array(
        'record'    => '心情紀錄',
        'analytic' => '曲線分析',
        'complex' => '綜合分析'
    ),
    'weight' => array(
        'plan'    => '計畫',
        'bmi' => 'BMI',
        'bmr' => '基礎代謝率'
    ),
    'pressure' => array(
        'record'    => '壓力紀錄',
        'analytic' => '壓力曲線'
    )
);

$default_ma = 'diet';

$default_sas = array(
    'diet' => 'record',
    'exercise' => 'record',
    'sleep' => 'record',
    'mood' => 'record',
    'weight' => 'plan',
    'pressure' => 'record',
);

if( !( isset( $_GET['ma'] ) && trim( $_GET['ma'] ) != '' ) )
{
    $_GET['ma'] = $default_ma;
}
if( !isset( $mas[ $_GET['ma'] ] ) )
{
    $_GET['ma'] = $default_ma;
}
$ma = $_GET['ma'];

if( isset( $_GET['sa'] ) && isset( $sas[ $ma ][ $_GET['sa'] ] ) )
{
    $sa = $_GET['sa'];
}
else
{
    $sa = $default_sas[ $ma ];
}
?>

<script type='text/javascript' src='js/jquery-1.9.1.min.js'></script>
<script type='text/javascript' src='js/jquery-migrate-1.2.1.min.js'></script>

<script type="text/javascript" src='js/fancybox/jquery.fancybox-1.3.4.js'></script>
<link type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" >

<script type="text/javascript" src="js/egorkhmelev-jslider/bin/jquery.slider.min.js"></script>

<script type="text/javascript" src="js/datePicker/date.js"></script>
<script type="text/javascript" src="js/datePicker/jquery.datePicker.js"></script>
<script type="text/javascript" src="js/custom2.js"></script>

<link href="css/pop.css" rel="stylesheet" />
<link href="css/health_general.css?201708-1" rel="stylesheet" />
<link href="js/datePicker/datePicker.css" rel="stylesheet" />
<link rel="stylesheet" href="js/egorkhmelev-jslider/bin/jquery.slider.min.css" type="text/css">

<style type="text/css">
li.left_menu_li {
　text-align: justify;
　text-justify: inter-ideograph;
　-ms-text-justify: inter-ideograph; /*IE9*/
　-moz-text-align-last:justify; /*Firefox*/
　-webkit-text-align-last:justify; /*Chrome*/
}
li.left_menu_li:after {
　content: '';
　display: inline-block;
　width: 100%;
}
</style>

<div id='left-content'>
    <ul class='menu'>
        <?php
            foreach( $mas as $action => $action_name ) {
        ?>
            <li class="left_menu_li <?php if( $_GET['ma'] == $action ) echo 'current';  ?>">
                <a href="?dept=health&ma=<?php echo $action; ?>" title="<?php echo $action_name; ?>"><?php echo $action_name; ?></a>
            </li>
        <?php
            }
        ?>
    </ul>
</div>
<div id='top-content'>
    <?php if ($ma=="weight") { ?>
      <input type="button" class="btn" value="新增" onclick="weight_plan_update_alert();">
      <input type="button" class="btn" value="更新體重" onclick="weight_update_alert();">
    <?php } ?>
</div>

<div id='main-content'>
    <?php include( $ma.'/'.$sa.'.php' ) ?>
</div>

<?php if ($ma=="weight") { ?>
  <div style="display:none;">
    <div id="weight_notice_window">
        <div class='page-outer' style='width: 570px;'>
            <div class='normal-inner' style="height: 265px; padding: 30px;">
              <ul class="list-numb">
                  <li>請至”每日記錄”裡，紀錄您每天的飲食與運動狀況，若在減重期間有中斷紀錄，系統會自動維持您上次的體重紀錄。</li>
                  <li>每日的卡路里預算會根據當天的體重及預計達成日期而調整改變，減重期間每天飲食攝取熱量不宜低於1200大卡，每周減重0.5公斤為宜。</li>
                  <li>卡路里銀行結餘如果是正數值，表示您有機會提早達成理想體重，如果是負數值，表示您應該節制飲食並多做運動，以達成理想體重。</li>
              </ul>
              <p>減重期間您應該諮詢專業的營養師或內科醫生的意見，並注意每日的飲食營養均衡比例，以免影響健康，本網站數值僅供參考並無絕對，亦沒有任何醫療行為，若您有健康上的問題，仍應尋求專業醫師治療。</p>
            </div>
        </div>
    </div>

    <a id="weight_update_show" href="#weight_update_window"></a>
    <div id="weight_update_window">
        <div class="page-outer" style="width: 305px; height: 100px;">
          <form onsubmit="update_weight(this); return false;" accept-charset="UTF-8">
            <div id="normal-inner" style="padding: 20px;">
                <table>
                  <tbody>
                    <tr>
                      <td style="width: 80px;">今日體重</td>
                      <td style="width: 110px;"><input type="text" id="inputUpdateWeight" name="weight" class="input-numbers" value="" maxlength="6" style="width: 94px;text-align: center; margin-left: 0;"></td>
                      <td>kg</td>
                    </tr>
                  </tbody>
                </table>
            </div>
            <div id="primary-action">
                <input type="button" name="" class="btn func-btn" value="確 定" onclick="update_weight(this.form)">
            </div>
          </form>
        </div>
    </div>

    <a id="weight_plan_update_show" href="#weight_plan_update_window"></a>
    <div id="weight_plan_update_window">
        <div class="page-outer" style="width: 450px; height: 380px;">
          <form>
            <div id="normal-inner" style="padding: 20px;">
                <table class="distance-table">
                <tbody>
                  <tr>
                    <td>性　　別
                      <select name="plan_gender" id="plan_gender" width="80" style="width: 80px">
                        <option value="">請選擇</option>
                        <option value="M" selected="selected">男</option>
                        <option value="F">女</option>
                      </select>
                    </td>
                </tr>
                <tr>
                  <td>出生年份
                    <select name="plan_birthday_year" id="plan_birthday_year" width="80" style="width: 80px">
                      <?php
                        $now_year = date("Y");
                        for ($year = 1920; $year <= $now_year; $year++)
                        {
                          echo "<option value='$year'>$year</option>";
                        }
                      ?>
                    </select> 年
                    <div style="display: none;">
                      <select name="plan_birthday_month" id="plan_birthday_month" width="50" style="width: 50px">
                        <?php for($i = 1; $i <= 12; $i++) {
                          echo "<option value='$i'>$i</option>";
                        } ?>
                      </select> 月
                      <select name="plan_birthday_date" id="plan_birthday_date" width="50" style="width: 50px">
                        <?php for($i = 1; $i <= 31; $i++) {
                          echo "<option value='$i'>$i</option>";
                        } ?>
                      </select> 日
                    </div>
                  </td>
                </tr>
                <tr>
                    <td>目前身高
                      <input type="text" name="plan_height" id="plan_height" class="input-numbers" value="" style="width: 100px;text-align: center;"><span>cm</span></td>
                </tr>
                <tr>
                    <td>目前體重
                      <input type="text" name="plan_weight" id="plan_weight" class="input-numbers" value="" style="width: 100px;text-align: center;"><span>kg</span></td>
                </tr>
                <tr>
                  <td>工作生活型態
                    <select name="plan_life_type" id="plan_life_type" width="280" style="width: 280px">
                      <option value="1">躺著不動一整天</option>
                      <option value="2">久坐辦公室（幾乎很少運動）</option>
                      <option value="3">輕度活動（每週運動1-2次）</option>
                      <option value="4">中度活動（每週運動3-5次）</option>
                      <option value="5">重度運動（每週運動6-7次）</option>
                      <option value="6">體力勞動（每天重度運動或勞力工作者）</option>
                    </select>
                  </td>
                </tr>
                </tbody></table>
                <hr>
                <table class="distance-table">
                  <tbody>
                    <tr>
                      <td>理想體重
                        <input type="text" name="plan_target_weight" id="plan_target_weight" class="input-numbers" value="" style="width: 100px;text-align: center;"><span>kg</span></td>
                    </tr>
                    <tr>
                        <td>預計達成日期
                          <input type="text" name="plan_target_date" id="plan_target_date" class="feature-pick-Date" readonly="readonly" style="width: 100px;text-align: center;">
                        </td>
                    </tr>
                  </tbody>
                </table>
            </div>
            <div id="primary-action">
                <input type="button" class="btn func-btn" value="確 定" onclick="check_weight_plan(this.form)">
            </div>
          </form>
        </div>
    </div>

    <a id="calculate_weight_plan_show" href="#calculate_weight_plan_update_window"></a>
    <div id="calculate_weight_plan_update_window">
        <div class="page-outer" style="width: 300px; height: 215px;">
          <form>
            <div id="normal-inner" style="padding: 20px;">
              <table class="simple-table">
                  <tbody>
                      <tr>
                          <td>您一天的熱量消耗約：<span id="cal_daily_cal_cost" style="color: blue;"></span>Kcal</td>
                      </tr>
                      <tr>
                          <td>( 基礎代謝率 X 每天平均活動量係數 )</td>
                      </tr>
                      <tr>
                          <td>每日卡路里預算：<span id="cal_daily_cal_budget" style="color: blue;"></span>Kcal<span class="cal_weight_is_danger">(太低)</span></td>
                      </tr>
                  </tbody>
              </table>

              <div class="cal_weight_is_ok" style="display: none;">
                <p>預計 <span id="cal_would_date_span"></span> 達成理想體重</p>
              </div>
              <div class="cal_weight_is_danger" style="display: none;">
                <h2 style="color: red;"><span>◆</span> 此減重計畫過於嚴苛!</h2>
                <p>建議重新設定理想體重或將預計達成日往後延，以免影響健康。</p>
              </div>
            </div>
            <div id="primary-action">
              <div class="cal_weight_is_ok" style="display: none;">
                <input type="button" class="btn func-btn" value="確 定" onclick="update_weight_plan();">
              </div>
              <div class="cal_weight_is_danger" style="display: none;">
                <input class="btn func-btn" type="button" onclick="$.fancybox.close();" value="確 定" />
              </div>
            </div>
          </form>
        </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.feature-pick-Date').datePicker({
        startDate: (new Date()).asString(),
        clickInput:true,
        createButton: false,
        showYearNavigation: false,
        verticalOffset: 20,
        //horizontalOffset: 165
      });

      $("#weight_notice_show").fancybox({
        'type': 'inline',
        'title': '注意事項',
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

      $("#weight_plan_update_show").fancybox({
        'type': 'inline',
        'title': '減重計畫',
        'padding' : 0,
        'titlePosition'     : 'outside',
        'transitionIn'      : 'none',
        'transitionOut'     : 'none',
        'overlayShow'       : false,
      });

      $("#calculate_weight_plan_show").fancybox({
        'type': 'inline',
        'title': '減重計畫',
        'padding' : 0,
        'titlePosition'     : 'outside',
        'transitionIn'      : 'none',
        'transitionOut'     : 'none',
        'overlayShow'       : false,
      });
    });


    function weight_update_alert()
    {
      get_last_weight();
      $('#weight_update_show').trigger('click');
    }

    function get_last_weight()
    {
      $.getJSON("health/weight/functions/plan/get_last_weight.php").success(function(data) {
        if (data[0])
        {
          $('#inputUpdateWeight').val(data[0]['weight']);
        }
      });
    }

    function update_weight(fObj)
    {
      if ( fObj.weight.value == '' ) {
          alert('請輸入體重!');
          fObj.weight.focus();
          return false;
      }

      var newDate = new Date();
      var sDate = newDate.getFullYear().toString() + '-' + (newDate.getMonth() + 1).toString() + '-' + newDate.getDate();

      var params = {
        weight: fObj.weight.value,
        date: sDate
      };

      $.post("health/weight/functions/plan/update_weight.php", params).success(function(data){
        $.fancybox.close();
        <?php
          if ('weight' == $ma && 'plan' == $sa)
          {
            echo "refresh_plan();";
          }
        ?>
      });
    }

    var bPlanExsit = false;
    function weight_plan_update_alert()
    {
      $('#plan_life_type').val("2");
      get_last_weight_plan();
      $('#weight_plan_update_show').trigger('click');
    }


    function get_last_weight_plan()
    {

      $.getJSON("health/weight/functions/plan/get_last_weight_plan.php").success(function(data) {
        if (data[0])
        {
          var record = data[0];
          bPlanExsit = true;
          var birthday = new Date(record.birthdate);
          var birthday_year = birthday.getFullYear().toString();
          var birthday_month = (birthday.getMonth() + 1).toString();
          var birthday_date = birthday.getDate().toString();

          $("#plan_gender").val(record.sex);
          $("#plan_birthday_year").val(birthday_year);
          $("#plan_birthday_month").val(birthday_month);
          $("#plan_birthday_date").val(birthday_date);
          $("#plan_height").val(record.height);
          $("#plan_weight").val(record.weight);
          $("#plan_life_type").val(record.work_type);
          $("#plan_target_weight").val(record.would_weight);
          $("#plan_target_date").val(record.would_date.replace(/-/g, '/'));
        }
      });
    }


    var tmp_weight_plan = {};
    function check_weight_plan(fObj)
    {
      console.log(fObj.plan_gender.value);
      if ('' == fObj.plan_gender.value) {
          alert('請選擇性別');
          fObj.plan_gender.focus();
          return false;
      }
      if ('' == fObj.plan_height.value || !check_string(fObj.plan_height.value, 'nonnegative') ) {
          alert('請輸入目前身高');
          fObj.plan_height.focus();
          return false;
      }
      if ('' == fObj.plan_weight.value || !check_string(fObj.plan_weight.value, 'nonnegative') ) {
          alert('請輸入目前體重');
          fObj.plan_weight.focus();
          return false;
      }
      if ('' == fObj.plan_target_weight.value || !check_string(fObj.plan_target_weight.value, 'nonnegative') ) {
          alert('請輸入理想體重');
          fObj.plan_target_weight.focus();
          return false;
      }
      if ( fObj.plan_target_date.value == '' ) {
          alert('請輸入預計達成日期');
          fObj.plan_target_date.focus();
          return false;
      }
      var confirm_text = '';
      if ( bPlanExsit ) {
          confirm_text = '您已建立過減重計畫, 若新建立減重計畫, 原計畫及體重紀錄將被清除. 確定新增減重計畫?';
      }
      if ( confirm_text == '' || confirm(confirm_text) ){

        tmp_weight_plan.sex = fObj.plan_gender.value;
        tmp_weight_plan.birthdate = fObj.plan_birthday_year.value + '-' + fObj.plan_birthday_month.value + '-' + fObj.plan_birthday_date.value;
        tmp_weight_plan.birthday_year = fObj.plan_birthday_year.value;
        tmp_weight_plan.birthday_month = fObj.plan_birthday_month.value;
        tmp_weight_plan.birthday_date = fObj.plan_birthday_date.value;
        tmp_weight_plan.height = fObj.plan_height.value;
        tmp_weight_plan.weight = fObj.plan_weight.value;
        tmp_weight_plan.work_type = fObj.plan_life_type.value;
        tmp_weight_plan.would_weight = fObj.plan_target_weight.value;
        tmp_weight_plan.would_date = $('#plan_target_date').val();

        calculate_weight_plan_alert();
      }
    }

    function calculate_weight_plan_alert()
    {
      calculate_weight_plan_info();
      $('#calculate_weight_plan_show').trigger('click');
    }

    function calculate_weight_plan_info()
    {
      var sex = tmp_weight_plan.sex;
      var user_weight = tmp_weight_plan.weight;
      var user_height = tmp_weight_plan.height;
      var year = tmp_weight_plan.birthday_year;
      var now_year = new Date().getFullYear();
      var user_age = now_year - year;
      var bmr = 0;

      if ('M' == sex) {
          bmr = Math.round(13.7*user_weight + 5.0*user_height - 6.8*user_age + 66);
      }
      else {
          bmr = Math.round(9.6*user_weight + 1.0*user_height - 4.7*user_age + 655);
      }

      tmp_weight_plan.bmr = bmr;

      var coefficient = 0;

      switch(tmp_weight_plan.work_type)
      {
        case "1":
          coefficient = 1;
          break;
        case "2":
          coefficient = 1.2;
          break;
        case "3":
          coefficient = 1.375;
          break;
        case "4":
          coefficient = 1.55;
          break;
        case "5":
          coefficient = 1.725;
          break;
        case "6":
          coefficient = 1.9;
          break;
      }

      var would_weight = tmp_weight_plan.would_weight;

      var date1 = new Date();
      var date2 = new Date(tmp_weight_plan.would_date);
      var timeDiff = Math.abs(date2.getTime() - date1.getTime());
      var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

      tmp_weight_plan.daily_cal_cost = Math.round(bmr * coefficient);
      tmp_weight_plan.daily_cal_budget = Math.round(tmp_weight_plan.daily_cal_cost - (((user_weight - would_weight) / diffDays) * 7700));

      $('#cal_daily_cal_cost').html(tmp_weight_plan.daily_cal_cost);
      $('#cal_daily_cal_budget').html(tmp_weight_plan.daily_cal_budget);
      $('#cal_would_date_span').text(tmp_weight_plan.would_date);

      if (1200 > tmp_weight_plan.daily_cal_budget)
      {
        $('.cal_weight_is_ok').hide();
        $('.cal_weight_is_danger').show();
      }
      else
      {
        $('.cal_weight_is_ok').show();
        $('.cal_weight_is_danger').hide();
      }
    }

    function update_weight_plan()
    {
      var newDate = new Date();
      var sDate = newDate.getFullYear().toString() + '-' + (newDate.getMonth() + 1).toString() + '-' + newDate.getDate();
      tmp_weight_plan.date = sDate;

      $.post("health/weight/functions/plan/update_weight_plan.php", tmp_weight_plan).success(function(data){
        $.fancybox.close();
        <?php
          if ('weight' == $ma && 'plan' == $sa)
          {
            echo "refresh_plan();";
          }
        ?>
      });
    }

    function refresh_plan()
    {
      $.getJSON("health/weight/functions/plan/refresh_plan.php").success(function(data) {
        var weight_arr = data['weight_value_arr'];
        var chartDivId = 'weightPlanChart';
        var datasetName = '實際體重';
        var dataset = weight_arr;
        //var xAxisNames = strip_year(weight_date_arr);
        var yAxisTitle = '體重(kg)';
        var expectedTitle = '理想體重';
        var expectedWeight = data['today_plan']['would_weight'];
        var lastEndWeight = -1;
        var startDate = { year: data['dt_created_date_y'], month: data['dt_created_date_m'], date: data['dt_created_date_d'] };
        var targetDate = { year: data['dt_would_date_y'], month: data['dt_would_date_m'], date: data['dt_would_date_d'] };

        weightchart( chartDivId, datasetName, dataset, yAxisTitle, expectedTitle, expectedWeight, lastEndWeight, startDate, targetDate ) ;

        $('#today_plan_weight').text(data['today_plan']['weight']);
        $('#today_plan_today_weight').text(data['today_plan']['today_weight']);
        $('#today_plan_would_weight').text(data['today_plan']['would_weight']);
        $('#today_plan_today_calory').text(data['today_plan']['today_calory']);
        $('#today_plan_calory_diet').text(data['today_plan']['today_calory_diet']);
        $('#today_plan_calory_exercise').text(data['today_plan']['today_calory_exercise']);
        $('#today_plan_calory_left').text(data['today_plan']['today_calory_left'] + " Kcal");
        $('#today_plan_today_bmr').text(data['today_plan']['today_bmr']);
      });
    }

  </script>
<?php } ?>
<?php
/*
 Please don't edit above code.
 */
?>

