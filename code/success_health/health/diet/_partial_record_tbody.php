<?php
for ($i = 0; $i < count($records); $i++){
$record_tr_id = $records[$i]['id'];
?>
  <tr id="record_tr_<?php echo $record_tr_id ?>">
    <td style="text-align: left;"><?php echo $records[$i]['eng'] ? $records[$i]['shrt_desc'] : $records[$i]['long_desc']; ?></td>
    <td><?php echo $records[$i]['gram'] ?></td>
    <td><?php echo $records[$i]['energ_kcal'] ?></td>
    <td><?php echo $records[$i]['carbohydrt'] ?></td>
    <td><?php echo $records[$i]['lipid_tot'] ?></td>
    <td><?php echo $records[$i]['protein'] ?></td>
    <td class="operation">
      <input class="btn" type="button" onclick="
      edit_record_alert(
        <?php echo $records[$i]['id'] ?>,
        <?php echo $records[$i]['food_id'] ?>,
        <?php echo $records[$i]['unit'] ?>,
        <?php echo $records[$i]['gram'] ?>,
        <?php echo "'{$records[$i]['unit_name']}'" ?>,
        <?php echo $records[$i]['food_gram_per_unit'] ?>,
        <?php echo $records[$i]['food_energ_kcal'] ?>,
        <?php echo $records[$i]['food_protein'] ?>,
        <?php echo $records[$i]['food_lipid_tot'] ?>,
        <?php echo $records[$i]['food_carbohydrt'] ?>
      )" value="編輯" />
      <input class="btn" type="button" onclick="delete_alert(<?php echo $record_tr_id ?>)" value="刪除" />
    </td>
  </tr>
<?php

}

$more_rows = 12 - count($records);
while(0 < $more_rows)
{
  echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
  $more_rows--;
}
?>