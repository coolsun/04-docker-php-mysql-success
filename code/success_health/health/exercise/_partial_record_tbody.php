<?php
for ($i = 0; $i < count($records); $i++){
$record_tr_id = $records[$i]['id'];
?>
  <tr id="record_tr_<?php echo $record_tr_id ?>">
    <td><?php echo $records[$i]['date'] ?></td>
    <td>
      <?php echo $records[$i]['cht_descriptions'] ?>
      <input id="record_td_<?php echo $record_tr_id ?>_sport_id" type="hidden" value="<?php echo $records[$i]['sport_id'] ?>" />
    </td>
    <td>
      <label id="record_td_<?php echo $record_tr_id ?>_mins_label" for="record_td_<?php echo $record_tr_id ?>_mins" class="record_edit_label"><?php echo $records[$i]['mins'] ?></label>
      <input id="record_td_<?php echo $record_tr_id ?>_mins" type="text" class="input_no_border_margin record_edit_input" value="<?php echo $records[$i]['mins'] ?>" style="text-align: center; display: none;" onkeyup="value=value.replace(/[^\d]/g,'');" data-min="0" maxlength="4" />
    </td>
    <td><?php echo $records[$i]['kcal'] ?></td>
    <td class="operation">
      <input class="btn" type="button" onclick="update_record(<?php echo $record_tr_id ?>)" value="確定" />
      <input class="btn" type="button" onclick="delete_alert(<?php echo $record_tr_id ?>)" value="刪除" />
    </td>
  </tr>
<?php

}

$more_rows = 12 - count($records);
while(0 < $more_rows)
{
  echo "<tr><td></td><td></td><td></td><td></td><td></td></tr>";
  $more_rows--;
}
?>