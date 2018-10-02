<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$exercise_id = isset($_POST['id']) ? $_POST['id'] : false;
$exercise_sport_id = isset($_POST['sport_id']) ? $_POST['sport_id'] : false;
$exercise_mins = isset($_POST['exercise_mins']) ? $_POST['exercise_mins'] : false;
$uid = $_SESSION['userid'];

function record_update($dbh, $id, $user_id, $exercise_mins, $kcal)
{
    $kcal = round($kcal, 2);
    $update_query_string = "UPDATE `exercises` SET `mins`=?, `kcal`=? WHERE `id`=? AND `user_id`=?";
    $update_query = $dbh->prepare($update_query_string);
    $b_success = $update_query->execute(array(
        $exercise_mins,
        $kcal,
        $id,
        $user_id,
    ));

    return ($b_success);
}

function get_sport_mets($dbh, $sport_id)
{
  $query_string = 'SELECT  `id`, mets, `category`, `cht_descriptions` FROM `sports` where(id=?)';
  $query = $dbh->prepare( $query_string );
  $query->execute(array($sport_id));
  $sports = $query->fetchAll( PDO::FETCH_ASSOC );
  $mets = isset($sports[0]) ? $sports[0]['mets'] : 0;
  return($mets);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if ($exercise_id && $exercise_sport_id && $exercise_mins)
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            $last_weight = 0;
            $query_string = 'SELECT `exercises`.`id`, `exercises`.`user_id`, `exercises`.`date` FROM `exercises` WHERE `id`=? AND `user_id`=? ORDER BY `date` desc limit 1';
            $query = $dbh->prepare( $query_string );
            $query->execute( array($exercise_id, $uid ) );
            $exercise = $query->fetchAll( PDO::FETCH_ASSOC );

            if (1 == count($exercise))
            {
              $exercise_date = $exercise[0]['date'];
              $query_string = 'SELECT `weight` FROM `user_weights` WHERE `user_id` = ? AND `date` <= ? ORDER BY `date` desc limit 1';
              $query = $dbh->prepare( $query_string );
              $query->execute( array( $uid, $exercise_date ) );
              $weights = $query->fetchAll( PDO::FETCH_ASSOC );

              if (1 == count($weights))
              {
                $last_weight = $weights[0]['weight'];
              }
            }

            $kcal = get_sport_mets($dbh, $exercise_sport_id) * $last_weight * ($exercise_mins / 60);
            if (record_update($dbh, $exercise_id, $uid, $exercise_mins, $kcal))
            {
                $b_success = true;
            }
            else
            {
                $s_err_message = "Error: Can't update data to database.";
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

$data = array('success' => $b_success, 'msg' => $s_err_message);
echo json_encode($data);

?>