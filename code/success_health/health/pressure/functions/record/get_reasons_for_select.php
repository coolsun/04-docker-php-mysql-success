<?php

session_start();
require "../../../config_health_conn.php";

$uid = $_SESSION['userid'];

$dbh = connect_success_db('health');
$records = Array();
$s_reasons = '';
$date = $_GET['date'];

if ($dbh)
{
  $query_string = 'SELECT `id`, `reason`, `sequence` FROM `pressure_reasons` WHERE `user_id` = ? ORDER BY `sequence`';
  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  if (0 == count($records))
  {
    $insert_query_string = "INSERT INTO `pressure_reasons` (`reason`, `user_id`, `sequence`)
                            VALUES
                            ('健康', ?, 1),
                            ('工作', ?, 2),
                            ('家庭', ?, 3),
                            ('人際關係', ?, 4),
                            ('學校課業', ?, 5),
                            ('升學考試', ?, 6),
                            ('睡眠不足', ?, 7),
                            ('缺乏運動', ?, 8),
                            ('缺乏休閒娛樂', ?, 9),
                            ('太多事情要處理', ?, 10),
                            ('肥胖', ?, 11),
                            ('爭吵', ?, 12),
                            ('節食', ?, 13),
                            ('焦慮', ?, 14),
                            ('生病', ?, 15),
                            ('失戀', ?, 16),
                            ('負債', ?, 17),
                            ('生理期', ?, 18),
                            ('感情因素', ?, 19),
                            ('擔心煩惱', ?, 20),
                            ('心情不好', ?, 21),
                            ('太忙沒時間', ?, 22),
                            ('想太多', ?, 23),
                            ('處理事情', ?, 24)";

    $insert_query = $dbh->prepare($insert_query_string);
    $insert_query->execute(array($uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid, $uid));

    $query_string = 'SELECT `id`, `reason`, `sequence` FROM `pressure_reasons` WHERE `user_id` = ? ORDER BY `sequence`';
    $query = $dbh->prepare( $query_string );
    $query->execute( array( $uid ) );
    $records = $query->fetchAll( PDO::FETCH_ASSOC );
  }

  if (!empty($date))
  {
    $query_string = 'SELECT `pressure_reasons` FROM `pressures` WHERE `user_id`=? AND `date` = ? ORDER BY `date` desc';
    $query = $dbh->prepare( $query_string );
    $query->execute( array( $uid, "$date" ) );
    $record_select_reasons = $query->fetchAll( PDO::FETCH_ASSOC );
    if (1 == count($record_select_reasons))
    {
      $s_reasons = $record_select_reasons[0]['pressure_reasons'];
    }
  }
}

$tbody_html = '';
$num_of_td_for_tr = 4;

$reasons = preg_split("/(, )/", $s_reasons, -1, PREG_SPLIT_NO_EMPTY);

foreach ($records as $key => $value) {
  if (0 == (int)$key % $num_of_td_for_tr)
  {
    $tbody_html .= '<tr>';
  }

  $b_checked = false;
  for ($i = 0; $i < count($reasons); $i++)
  {
    if ($reasons[$i] == $value['reason'])
    {
      $b_checked = true;
      $tbody_html .= '<td><input type="checkbox" name="arr_pressure_select[]" value="' . $value['id'] . '" checked><span>' . $value['reason'] . '</span></td>';
      break;
    }
  }

  if (!$b_checked)
  {
    $tbody_html .= '<td><input type="checkbox" name="arr_pressure_select[]" value="' . $value['id'] . '"><span>' . $value['reason'] . '</span></td>';
  }

  if (($num_of_td_for_tr - 1) == (int)$key % $num_of_td_for_tr)
  {
    $tbody_html .= '</tr>';
  }
}

echo $tbody_html;



?>