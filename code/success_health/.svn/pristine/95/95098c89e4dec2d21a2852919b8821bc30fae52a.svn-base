<?php

header('Content-Type:text/html; charset=utf-8');
//header( "Content-Type: application/json", true );

session_start();
require "../../../config_health_conn.php";

$search_keyword = isset($_POST['searchKeyword']) ? $_POST['searchKeyword'] : false;

$uid = $_SESSION['userid'];

function get_foods($dbh, $search_words, $b_eng)
{
  $key_word = implode('|', $search_words);
  $query_string = '';
  if ($b_eng)
  {
    $query_string = 'SELECT `id`, `shrt_desc` as `desc`, `unit_name`, `gram_per_unit`, `energ_kcal`, `protein`, `lipid_tot`, `carbohydrt` FROM `foods` WHERE `shrt_desc` REGEXP ?';
  }
  else
  {
    $query_string = 'SELECT `id`, `long_desc` as `desc`, `unit_name`, `gram_per_unit`, `energ_kcal`, `protein`, `lipid_tot`, `carbohydrt` FROM `foods` WHERE `long_desc` REGEXP ?';
  }

  $query = $dbh->prepare( $query_string );

  $query->execute(array(
    $key_word
  ));

  $foods = $query->fetchAll( PDO::FETCH_ASSOC );
  return($foods);
}

function split_search_word($search_keyword)
{
  $words = preg_split("/[^A-Za-z0-9]/", $search_keyword, -1, PREG_SPLIT_NO_EMPTY);

  $strlen = mb_strlen($search_keyword, 'UTF-8');
  for ($i = 0; $i < $strlen; $i++) {
      $s = mb_substr($search_keyword, $i, 1, 'UTF-8');
      if (strlen($s) > 1 && '' != $s) {
        array_push($words, $s);
      }
  }

  return $words;
}

function split_search_dual_word($search_keyword)
{
  $words = preg_split("/[^A-Za-z0-9]/", $search_keyword, -1, PREG_SPLIT_NO_EMPTY);

  $strlen = mb_strlen($search_keyword, 'UTF-8');
  $now_word = '';
  for ($i = 0; $i < $strlen; $i++) {
      $s = mb_substr($search_keyword, $i, 1, 'UTF-8');
      if (1 == strlen($s) && !empty($now_word))
      {
        array_push($words, $now_word);
        $now_word = '';
      }
      if (1 < strlen($s) && !empty($s))
      {
        $now_word .= $s;
      }
  }

  if (0 < strlen($now_word))
  {
    array_push($words, $now_word);
    $now_word = '';
  }

  return $words;
}

function sort_match_sequence($foods, $search_words)
{
  $key_word = implode('|', $search_words);
  $matches = array();

  $max_count = 0;
  $group_foods = array();
  $merge_foods = array();

  foreach ($foods as $key => $value) {
    preg_match_all("/$key_word/", $value['desc'], $matches, PREG_SET_ORDER);
    $i_match_count = count($matches);

    if ($i_match_count > $max_count)
    {
      $max_count = $i_match_count;
    }

    if (!isset($group_foods[$i_match_count]))
    {
      $group_foods[$i_match_count] = array();
    }

    array_push($group_foods[$i_match_count], $value);
  }

  for ($i = $max_count; 0 <= $i; $i--)
  {
    if (isset($group_foods[$i]) && !empty($group_foods[$i]))
    {
      foreach ($group_foods[$i] as $group_value) {
        array_push($merge_foods, $group_value);
      }
    }
  }

  return $merge_foods;
}


$dbh = null;
$b_success = false;
$s_err_message = '';
$foods = array();

$b_eng = false;
if ($search_keyword)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            $b_eng = mb_strlen($search_keyword, mb_detect_encoding($search_keyword)) == strlen($search_keyword);
            $search_words = array();

            if ($b_eng)
            {
              $search_words = split_search_word($search_keyword);
              $foods = get_foods($dbh, $search_words, $b_eng);
            }
            else
            {
              $search_words = split_search_dual_word($search_keyword);
              $foods = get_foods($dbh, $search_words, $b_eng);
            }

            if (0 == count($foods))
            {
              $search_words = split_search_word($search_keyword);
              $foods = get_foods($dbh, $search_words, $b_eng);
            }

            if (0 < count($foods))
            {
              $foods = sort_match_sequence($foods, $search_words);
            }
        }
        else
        {
            $s_err_message = "Error: Can't connect the database.";
        }
    }
    else
    {
        $s_err_message = "Error: Can't find the user.";
    }
}
else
{
    $s_err_message = "Error: Loss some params.";
}

if ($s_err_message)
{
  error_log($s_err_message);
}

$html = '';

$i_eng = $b_eng ? 1 : 0;

if (0 < count($foods))
{
  $objects = array();
  foreach ($foods as $e) {
    $id = $e['id'];
    $unit_name = $e['unit_name'];
    $gram_per_unit = $e['gram_per_unit'];
    $energ_kcal = $e['energ_kcal'];
    $protein = $e['protein'];
    $lipid_tot = $e['lipid_tot'];
    $carbohydrt = $e['carbohydrt'];
    $desc = $e['desc'];
    //$unit_name = str_replace('"', '&#92;"', $unit_name);

    #$html .= '<li style="cursor: pointer;" onclick="select_meal_action(' . $id . ", '" . $unit_name . "', " . $gram_per_unit . ', ' . $energ_kcal . ', ' . $protein . ', ' . $lipid_tot . ', ' . $carbohydrt . ', ' . $i_eng . ')">' . $desc . '</li>';

    array_push($objects, array(
      'id' => $id,
      'unit_name' => $unit_name,
      'gram_per_unit' => $gram_per_unit,
      'energ_kcal' => $energ_kcal,
      'protein' => $protein,
      'lipid_tot' => $lipid_tot,
      'carbohydrt' => $carbohydrt,
      'desc' => $desc,
      'b_eng' => $i_eng
    ));
  }

  $html = json_encode($objects);
}
else
{
  $html = json_encode(array());
  //$html = '<li>無搜尋結果</li>';
}

echo $html;
?>
















