<?php

$uid = $_SESSION['userid'];

$start_date = isset($_SESSION['dietStartDate']) ? $_SESSION['dietStartDate'] : '';

if (empty($start_date))
{
  $start_date = date('Y/m/d');
}

$start_date = str_replace('/' , '-', $start_date);
$_SESSION['dietStartDate'] = $start_date;

$dbh = connect_success_db('health');

$pie_carbohydrt = 0;
$pie_lipid_tot = 0;
$pie_protein = 0;

$vitamin_c = 0;
$vitamin_b6 = 0;
$vitamin_b12 = 0;
$vitamin_a_iu = 0;
$vitamin_e = 0;
$vitamin_d = 0;
$vitamin_k = 0;

$meta_calcium = 0;
$meta_iron = 0;
$meta_magnesium = 0;
$meta_phosphorus = 0;
$meta_potassium = 0;
$meta_sodium = 0;
$meta_zinc = 0;
$meta_copper = 0;
$meta_manganese = 0;
$meta_selenium = 0;

if ($dbh)
{
  $query_string = 'SELECT `meals`.`unit`, `meals`.`gram`, `meals`.`energ_kcal`, `meals`.`protein`, `meals`.`lipid_tot`, `meals`.`carbohydrt`,
                          `foods`.`gram_per_unit` as `food_gram_per_unit`,
                          `foods`.`energ_kcal` as `food_energ_kcal`,
                          `foods`.`protein` as `food_protein`,
                          `foods`.`lipid_tot` as `food_lipid_tot`,
                          `foods`.`carbohydrt` as `food_carbohydrt`,
                          `foods`.`vit_c` as `food_vit_c`,
                          `foods`.`vit_b6` as `food_vit_b6`,
                          `foods`.`vit_b12` as `food_vit_b12`,
                          `foods`.`vit_a_iu` as `food_vit_a_iu`,
                          `foods`.`vit_e` as `food_vit_e`,
                          `foods`.`vivit_d_iu` as `food_vit_d`,
                          `foods`.`vit_k` as `food_vit_k`,
                          `foods`.`calcium` as `food_calcium`,
                          `foods`.`iron` as `food_iron`,
                          `foods`.`magnesium` as `food_magnesium`,
                          `foods`.`phosphorus` as `food_phosphorus`,
                          `foods`.`potassium` as `food_potassium`,
                          `foods`.`sodium` as `food_sodium`,
                          `foods`.`zinc` as `food_zinc`,
                          `foods`.`copper` as `food_copper`,
                          `foods`.`manganese` as `food_manganese`,
                          `foods`.`selenium` as `food_selenium`
                  FROM `meals` LEFT JOIN `foods` ON `meals`.`food_id` = `foods`.`id` WHERE `user_id`=? AND `date` = ?';


  $query = $dbh->prepare( $query_string );
  $query->execute( array( $uid, $start_date ) );
  $records = $query->fetchAll( PDO::FETCH_ASSOC );

  foreach ($records as $key => $value) {
    $pie_carbohydrt += $value['carbohydrt'];
    $pie_lipid_tot += $value['lipid_tot'];
    $pie_protein += $value['protein'];

    $value['food_gram_per_unit'] = 0 < $value['food_gram_per_unit'] ? $value['food_gram_per_unit'] : 1;

    $vitamin_c += round(($value['food_vit_c'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $vitamin_b6 += round(($value['food_vit_b6'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $vitamin_b12 += round(($value['food_vit_b12'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $vitamin_a_iu += round(($value['food_vit_a_iu'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $vitamin_e += round(($value['food_vit_e'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $vitamin_d += round(($value['food_vit_d'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $vitamin_k += round(($value['food_vit_k'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);

    $meta_calcium += round(($value['food_calcium'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $meta_iron += round(($value['food_iron'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $meta_magnesium += round(($value['food_magnesium'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $meta_phosphorus += round(($value['food_phosphorus'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $meta_potassium += round(($value['food_potassium'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $meta_sodium += round(($value['food_sodium'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $meta_zinc += round(($value['food_zinc'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $meta_copper += round(($value['food_copper'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $meta_manganese += round(($value['food_manganese'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
    $meta_selenium += round(($value['food_selenium'] / 100) * $value['food_gram_per_unit'] * $value['unit'], 2);
  }
}


$recommendation_pie_carbohydrt = 300;
$recommendation_pie_lipid_tot = 65;
$recommendation_pie_protein = 50;

$recommendation_vitamin_c = 60;
$recommendation_vitamin_b6 = 2;
$recommendation_vitamin_b12 = 6;
$recommendation_vitamin_a_iu = 5000;
$recommendation_vitamin_e = 20;
$recommendation_vitamin_d = 400;
$recommendation_vitamin_k = 80;

$recommendation_meta_calcium = 1000;
$recommendation_meta_iron = 18;
$recommendation_meta_magnesium = 400;
$recommendation_meta_phosphorus = 1000;
$recommendation_meta_potassium = 3500;
$recommendation_meta_sodium = 2400;
$recommendation_meta_zinc = 15;
$recommendation_meta_copper = 2;
$recommendation_meta_manganese = 2;
$recommendation_meta_selenium = 70;

$rdv_vitamin_c = round($vitamin_c * 100 / $recommendation_vitamin_c, 2);
$rdv_vitamin_b6 = round($vitamin_b6 * 100 / $recommendation_vitamin_b6, 2);
$rdv_vitamin_b12 = round($vitamin_b12 * 100 / $recommendation_vitamin_b12, 2);
$rdv_vitamin_a_iu = round($vitamin_a_iu * 100 / $recommendation_vitamin_a_iu, 2);
$rdv_vitamin_e = round($vitamin_e * 100 / $recommendation_vitamin_e, 2);
$rdv_vitamin_d = round($vitamin_d * 100 / $recommendation_vitamin_d, 2);
$rdv_vitamin_k = round($vitamin_k * 100 / $recommendation_vitamin_k, 2);

$rdv_meta_calcium = round($meta_calcium * 100 / $recommendation_meta_calcium, 2);
$rdv_meta_iron = round($meta_iron * 100 / $recommendation_meta_iron, 2);
$rdv_meta_magnesium = round($meta_magnesium * 100 / $recommendation_meta_magnesium, 2);
$rdv_meta_phosphorus = round($meta_phosphorus * 100 / $recommendation_meta_phosphorus, 2);
$rdv_meta_potassium = round($meta_potassium * 100 / $recommendation_meta_potassium, 2);
$rdv_meta_sodium = round($meta_sodium * 100 / $recommendation_meta_sodium, 2);
$rdv_meta_zinc = round($meta_zinc * 100 / $recommendation_meta_zinc, 2);
$rdv_meta_copper = round($meta_copper * 100 / $recommendation_meta_copper, 2);
$rdv_meta_manganese = round($meta_manganese * 100 / $recommendation_meta_manganese, 2);
$rdv_meta_selenium = round($meta_selenium * 100 / $recommendation_meta_selenium, 2);


include('analytic_view.php');


?>




