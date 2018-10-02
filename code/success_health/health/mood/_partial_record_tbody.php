<?php
for ($i = 0; $i < count($records); $i++){
$record_tr_id = $records[$i]['id'];
?>
  <tr id="record_tr_<?php echo $record_tr_id ?>">
    <td><?php echo $records[$i]['date'] ?></td>
    <td>
      <label id="record_td_<?php echo $record_tr_id ?>_mood_value_label" for="record_td_<?php echo $record_tr_id ?>_mood_value" class="record_edit_label"><?php echo $records[$i]['mood_value'] ?></label>
      <input id="record_td_<?php echo $record_tr_id ?>_mood_value" type="text" class="input_no_border_margin record_edit_input" value="<?php echo $records[$i]['mood_value'] ?>" style="text-align: center; display: none;" onkeyup="integer_alert(value)" data-min="0" data-max="10" />
    </td>
    <td>
      <label id="record_td_<?php echo $record_tr_id ?>_performance_label" for="record_td_<?php echo $record_tr_id ?>_performance" class="record_edit_label"><?php echo $records[$i]['performance'] ?></label>
      <input id="record_td_<?php echo $record_tr_id ?>_performance" type="text" class="input_no_border_margin record_edit_input" value="<?php echo $records[$i]['performance'] ?>" style="text-align: center; display: none;" onkeyup="integer_alert(value)" data-min="0" data-max="10" />
    </td>
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
  echo "<tr><td></td><td></td><td></td><td></td></tr>";
  $more_rows--;
}
?>