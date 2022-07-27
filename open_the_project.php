<?php
require "_load.php";
auth_require();
//    $a=get_product($_GET['product_id']);
//    var_dump($a['name']);
if (isset($_GET['product_id'])) {
    $check_product = chek_product($_GET['product_id']);
}
if ($check_product) {
    $product = get_product($_GET['product_id']);
//    var_dump($product);
} else {
    redirect("panel.php");
}
$project_id=$product['project_id'];
//print_r($_POST);
if ($_POST) {
    $values = $_POST['values'];

    foreach ($values as $activity_id => $value) {
        $normal = $value['normal'];
        $extra = $value['extra'];
        $normal_value = explode(":", $normal);
        $extra_value = explode(":", $extra);
        $time = time();
        $created_at = time();
    if (count($normal_value) == 2 && count($extra_value) == 2) {
        save_activity_report($time, $user['id'], intval($project_id), intval($product['id']), intval($activity_id), intval($normal_value[0]), intval($normal_value[1]), intval($extra_value[0]), intval($extra_value[1]), intval($created_at));

    }
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
    user_active <select name="cars" id="cars">
        <option value="<? $_SESSION['user_id'] ?>"><?php echo $user['user_name'] ?> </option>

    </select>
</div>
<div style="background-color: #acacb6;text-align: center;">
    <?= get_project($project_id)['name'] . "_" . get_product($_GET['product_id'])['name'] ?>
</div>
<div style="text-align: center">
    <form method="post" action="">

        <ul class="list-group">
            <?php
            $activities = get_activities();
            foreach ($activities as $activity) {
                ?>
                <li class="list-group-item disabled"><input name="values[<?= $activity['id'] ?>][extra]"
                                                            style="margin-left: 20px;margin-right: 20px"
                                                            placeholder="ساعت کاری اضافه" type="text"/>
                    <?= $activity['name'] ?>

                    <input name="values[<?= $activity['id'] ?>][normal]" style="margin-left: 20px;margin-right: 20px"
                           placeholder="ساعت کاری عادی" type="text"/>
                </li>
            <?php } ?>
        </ul>
        <br>
        <input type="submit" name="submit" value="ذخیره"/>
    </form>
</div>
</body>
</html>

