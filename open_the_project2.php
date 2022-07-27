<?php
require "_load.php";
auth_require();

if (isset($_GET['product_id'])) {
    $check_product = chek_product($_GET['product_id']);
}
if ($check_product) {
    $product = get_product($_GET['product_id']);
//    var_dump($product);
} else {
    redirect("panel.php");
}
$project_id = $product['project_id'];
$product_id = $_GET['product_id'];

////print_r($_POST);
//if ($_POST) {
//    $values = $_POST['values'];
//
//    foreach ($values as $activity_id => $value) {
//        $normal = $value['normal'];
//        $extra = $value['extra'];
//        $normal_value = explode(":", $normal);
//        $extra_value = explode(":", $extra);
//        $time = time();
//        $created_at = time();
//        if (count($normal_value) == 2 && count($extra_value) == 2) {
//            save_activity_report($time, $user['id'], intval($project_id), intval($product['id']), intval($activity_id), intval($normal_value[0]), intval($normal_value[1]), intval($extra_value[0]), intval($extra_value[1]), intval($created_at));
//
//        }
//    }
//    redirect("panel.php");
//}
//var_dump($_POST['values']);
if ($_POST){
    $values=$_POST['values'];
    foreach ($values as $activity_id => $value){
    $normal_hours=    $value['normal_hours'];
        $normal_minutes=    $value["normal_minutes"];
        $extra_hours=    $value["extra_hours"];
        $extra_minutes=    $value["extra_minutes"];
        $time=time();
        $created_at=$time;
        save_activity_report($time,$user['id'],$project_id,$product_id,$activity_id,$normal_hours,$normal_minutes,$extra_hours,$extra_minutes,$created_at);
    }
    redirect("panel.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"

</head>
<body>

<div style="padding-left: 80%;padding-top:20px; ">
    user_active <select class="btn btn-outline-success">
        <option class="btn btn-outline-success"
                value="<? $_SESSION['user_id'] ?>"><?php echo $_SESSION['user']['user_name'] ?> </option>

    </select>
    <a href="logout.php" type="button" class="btn btn-outline-danger">خروج</a>
</div>

<div style="background-color: #acacb6;text-align: center;">
    <?= get_project($project_id)['name'] . "_" . get_product($_GET['product_id'])['name'] ?>
</div>

<div style="text-align: center">
    <form method="post" action="">
            <span>
                 زمان عادی
                __________________________________________________________________
                    زمان اضافی
                </span><br><br>

        <?php
        $activities = get_activities();

        foreach ($activities as $activity) {
            ?>

            <span>

        <select style="margin-right: 50px" name="values[<?=$activity['id']?>][extra_hours]" id="">
           <?php for ($i = 0; $i < 13; $i++) {
               ?>}
               <option value="<?=$i ?>"><?= $i . " h" ?></option>
           <?php } ?>

        </select>
                  <select style="margin-right: 50px" name="values[<?=$activity['id']?>][extra_minutes]" id="">
            <?php for ($i = 0; $i < 60; $i += 5) { ?>
                <option value="<?=$i?>"><?= $i . " m" ?></option>
            <?php } ?>
        </select>
           <label style="background-color: darkorange;width:150px"> <?= $activity["name"] ?></label>
            <select style="margin-right: 50px;margin-left: 50px" name="values[<?=$activity['id']?>][normal_hours]" id="">
                   <?php for ($i = 0; $i < 13; $i++) {
                       ?>}
                       <option value="<?=$i?>"><?= $i . " h" ?></option>
                   <?php } ?>
        </select>
                  <select style="margin-right: 50px" name="values[<?=$activity['id']?>][normal_minutes]" id="">
             <?php for ($i = 0; $i < 60; $i += 5) { ?>
                 <option value="<?=$i?>"><?= $i . " m" ?></option>
             <?php } ?>
        </select>
    </span><br>
        <?php } ?>
        <input type="submit"/>
    </form>
</div>

</body>
</html>

