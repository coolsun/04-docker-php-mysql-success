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
          <caption>身體質量指數 〈 Body Mass Index 簡稱BMI 〉</caption>
          <tbody>
              <tr>
                  <td class="item">體重</td>
                  <td>
                  </td>
                  <td class="operands"><input type="text" name="user_weight" value="<?php echo $user_bmi_weight; ?>" class="input-number">kg</td>
                  <td>
                  </td>
                  <td class="item">身高</td>
                  <td>
                  </td>
                  <td class="operands"><input type="text" name="user_height" value="<?php echo $user_bmi_height; ?>" class="input-number">cm</td>
                  <td>
                  </td>
                  <td class="count"><input type="button" class="btn" value="開始計算" onclick="submit_check(this.form)"></td>
                  <td>
                  </td>
              </tr>
          </tbody>
          <tfoot>
              <tr>
                  <td colspan="5" class="result">BMI指數：<input type="text" id="bmi" value="<?php echo $user_bmi_value; ?>" class="input-underline"></td>
                  <td>
                  </td>
              </tr>
          </tfoot>
      </table>
    </form>
  </div>
  <div class="body-spec">
      <h2>BMI值的標準範圍</h2>
      <p>BMI值 = 體重(kg) / 身高²(cm²)
          <br>一般成年人的體重標準可以根據BMI的範圍來衡量</p>
      <table class="range">
          <tbody>
              <tr>
                  <th>BMI</th>
                  <th>＜18.5</th>
                  <th>18.5～24</th>
                  <th>24～27</th>
                  <th>27～30</th>
                  <th>30～35</th>
                  <th>≧ 35</th>
              </tr>
              <tr>
                  <td>體重分類</td>
                  <td>過輕</td>
                  <td>正常體重</td>
                  <td>過重</td>
                  <td>輕度肥胖</td>
                  <td>中度肥胖</td>
                  <td>重度肥胖</td>
              </tr>
          </tbody>
      </table>
      <small>資料來源：行政院衛生署<br>注意：此標準不適用於未成年、懷孕或哺乳中的女性、身體虛弱或行動不便的老年人</small>
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
      var user_weight = fObj.user_weight.value;
      var user_height = fObj.user_height.value;
      var bmi = number_format(user_weight / (user_height/100) / (user_height/100), 2);
      $('#bmi').val(bmi);

      var params = {
        weight: user_weight,
        height: user_height,
        bmi: bmi
      };

      $.post("health/weight/functions/bmi/update.php", params).success(function(data){ });
  }
</script>