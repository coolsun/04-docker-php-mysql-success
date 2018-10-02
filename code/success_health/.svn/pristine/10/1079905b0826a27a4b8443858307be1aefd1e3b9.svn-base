<script type="text/javascript" src="js/number_format.js"></script>
<div class='log-switch'>
  <ul class='menu'>
    <?php foreach ( $sas[ $ma ] as $sa_link => $sa_name ): ?>
      <li <?php if($sa_link==$sa) echo "class='current'"?>><a href="?dept=health&ma=<?=$ma?>&sa=<?=$sa_link?>"><?=$sa_name?></a></li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="log-desc">
  <div class="note">
    <span><a id="weight_notice_show" style="z-index: 50; position: relative; width: 74px; color: #2C5DC3;" href="#weight_notice_window">注意事項</a><span>
  </div>
  <div class="body-count">
    <h1></h1>
    <form>
      <table class="formula">
          <caption>基礎代謝率〈 Basal Metabolic Rate 簡稱BMR 〉</caption>
          <tbody>
          <tr>
              <td class="item">性別</td>
              <td class="operands">
                <select name="sex">
                  <option value="M" <?php if('M' == $user_bmr_sex){echo 'selected="selected"';} ?>>男</option>
                  <option value="F" <?php if('F' == $user_bmr_sex){echo 'selected="selected"';} ?>>女</option>
                </select>
              </td>
              <td class="item">出生年份</td>
              <td class="operands">
                <select name="year">
                  <?php
                    $now_year = date("Y");

                    for ($year = 1920; $year <= $now_year; $year++)
                    {
                      if(isset($user_bmr_year) && $user_bmr_year == $year)
                      {
                        echo "<option value='$year' selected='selected'>$year</option>";
                      }
                      else
                      {
                        echo "<option value='$year'>$year</option>";
                      }
                    }
                  ?>
                </select>
              </td>
              <td></td>
          </tr>
          <tr>
              <td class="item">體重</td>
              <td class="operands"><input type="text" name="user_weight" value="<?php echo $user_bmr_weight; ?>" class="input-number">kg</td>
              <td class="item">身高</td>
              <td class="operands"><input type="text" name="user_height" value="<?php echo $user_bmr_height; ?>" class="input-number">cm</td>
              <td class="count"><input type="button" class="btn" value="開始計算" onclick="submit_check(this.form)"></td>
          </tr>
          </tbody>
          <tfoot>
          <tr>
              <td colspan="5" class="result">BMR：<input type="text" id="bmr" value="<?php echo $user_bmr_value; ?>" class="input-underline">Kcal</td>
          </tr>
          </tfoot>
      </table>
    </form>
  </div>
  <div class="body-spec">
      <h2>基礎代謝率的定義</h2>
      <p>基礎代謝率是指在靜臥狀態下，維持人體器官運作所需的最低熱量。
      <br>舉例來說，如果你的基礎代謝率是1300kcal，而你整天都處於靜臥狀態的睡眠當中，沒有任何活動，這天便會消耗1300kcal的熱量。</p>
      <p>計算公式　（根據美國運動醫學協會所提供）
      <br>BMR(男) = （13.7×體重(kg)) ＋（5.0×身高(cm)）－（6.8×年齡）＋ 66
      <br>BMR(女) = （9.6×體重(kg)) ＋（1.8×身高(cm)）－（4.7×年齡）＋ 655
      </p>
  </div>
</div>

<script type="text/javascript">
  function submit_check(fObj) {
      if ( fObj.user_weight.value == '' ) {
          alert('請輸入體重!');
          fObj.user_weight.focus();
          return false;
      }
      if ( fObj.user_height.value == '' ) {
          alert('請輸入身高!');
          fObj.user_height.focus();
          return false;
      }
      var sex = fObj.sex.value;
      var user_weight = fObj.user_weight.value;
      var user_height = fObj.user_height.value;
      var year = fObj.year.value;
      var user_age = new Date().getFullYear() - year;
      var bmr = 0;

      if ('M' == sex) {
          bmr = number_format(13.7*user_weight + 5.0*user_height - 6.8*user_age + 66);
          $('#bmr').val(bmr);
      }
      else {
          bmr = number_format(9.6*user_weight + 1.8*user_height - 4.7*user_age + 655);
          $('#bmr').val(bmr);
      }

      var params = {
        sex: sex,
        year: year,
        weight: user_weight,
        height: user_height,
        bmr: bmr
      };

      $.post("health/weight/functions/bmr/update.php", params).success(function(data){ });

  }
</script>