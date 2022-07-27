<?php
require "_load.php";
auth_require();
$reports=get_today_report_activity($user['id']);
print_r($reports);
//exit();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>
<body>
<div style="padding-left: 80%;padding-top:20px; ">
    user_active <select class="btn btn-outline-success">
        <option class="btn btn-outline-success"
                value="<? $_SESSION['user_id'] ?>"><?php echo $_SESSION['user']['user_name'] ?> </option>

    </select>
    <a href="logout.php" type="button" class="btn btn-outline-danger">Danger</a>
</div>
<div name="table" class="table">
    <table style="text-align: center">
<thead>
        <tr>
            <td>_کد محصول</td>
            <td>_کد پروژه</td>
            <td>_جمع کارکرد عادی</td>
            <td>_جمع کارکرد اضافه</td>

        </tr>
</thead>

        <tbody>
        <?php
        foreach ($reports as $id=>$report){
        ?>
        <tr>
            <td><?= $reports[$id]["product_id"] ?></td>
            <td><?= $reports[$id]["project_id"] ?></td>
            <td><?= $reports[$id]["h_sum_normal"].":".$reports[$id]["m_sum_normal"] ?></td>
            <td><?= $reports[$id]["h_sum_extra"].":".$reports[$id]["m_sum_extra"] ?></td>


            <!--            <td>njnj</td>-->
<!--            <td>njnj</td>-->

        </tr>
        <?php } ?>
        </tbody>
    </table>

</div>
</body>
</html>
