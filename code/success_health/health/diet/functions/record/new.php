<?php

header( "Content-Type: application/json", true );
session_start();
require "../../../config_health_conn.php";

$meal_date = isset($_POST['newMealDate']) ? $_POST['newMealDate'] : false;
$meal_food_id = isset($_POST['newMealFoodId']) ? $_POST['newMealFoodId'] : false;
$meal_units = isset($_POST['newMealUnit']) ? $_POST['newMealUnit'] : false;
$meal_grams = isset($_POST['newMealGram']) ? $_POST['newMealGram'] : false;
$meal_energ_kcal = isset($_POST['newMealEnergKcal']) ? $_POST['newMealEnergKcal'] : false;
$meal_protein = isset($_POST['newMealProtein']) ? $_POST['newMealProtein'] : false;
$meal_lipid_tot = isset($_POST['newMealLipidTot']) ? $_POST['newMealLipidTot'] : false;
$meal_carbohydrt = isset($_POST['newMealCarbohydrt']) ? $_POST['newMealCarbohydrt'] : false;
$meal_eng = isset($_POST['newMealEng']) ? $_POST['newMealEng'] : false;
$uid = $_SESSION['userid'];

//error_log($meal_date . ', ' . $meal_food_id . ', ' . $meal_units . ', ' . $meal_grams . ', ' . $meal_energ_kcal . ', ' . $meal_protein . ', ' . $meal_lipid_tot . ', ' . $meal_carbohydrt);

function new_record($dbh, $user_id, $meal_date, $meal_food_id, $meal_units, $meal_grams, $meal_energ_kcal, $meal_protein, $meal_lipid_tot, $meal_carbohydrt, $meal_eng)
{
    $insert_query_string = "INSERT INTO `meals`(`user_id`, `date`, `food_id`, `unit`, `gram`, `energ_kcal`, `protein`, `lipid_tot`, `carbohydrt`, `created_at`, `eng`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $insert_query = $dbh->prepare($insert_query_string);
    $insert_query->execute(array(
        $user_id,
        $meal_date,
        $meal_food_id,
        $meal_units,
        $meal_grams,
        $meal_energ_kcal,
        $meal_protein,
        $meal_lipid_tot,
        $meal_carbohydrt,
        date("Y-m-d H:i:s"),
        $meal_eng
    ));

    return ($insert_query->rowCount() == 1);
}

$dbh = null;
$b_success = false;
$s_err_message = '';

if (!empty($meal_date) && !empty($meal_food_id) && is_numeric($meal_units) && is_numeric($meal_grams) && is_numeric($meal_energ_kcal) && is_numeric($meal_protein) && is_numeric($meal_lipid_tot) && is_numeric($meal_carbohydrt))
{
    if (is_int($uid) )
    {
        $dbh = connect_success_db('health');

        if ($dbh)
        {
            if (new_record($dbh, $uid, $meal_date, $meal_food_id, $meal_units, $meal_grams, $meal_energ_kcal, $meal_protein, $meal_lipid_tot, $meal_carbohydrt, $meal_eng))
            {
                $b_success = true;
            }
            else
            {
                $s_err_message = "Error: Can't insert data to database.";
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