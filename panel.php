<?php
require "_load.php";
auth_require();

if (isset($_GET['project_id'])) {
    $check_project = chek_project($_GET['project_id']);
    $products = get_products($_GET['project_id']);
    $flag = 0;
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div style="padding-left: 80%;padding-top:20px; ">
    user_active <select class="btn btn-outline-success">
        <option class="btn btn-outline-success"
                value="<? $_SESSION['user_id'] ?>"><?php echo $_SESSION['user']['user_name'] ?> </option>

    </select>
    <a href="logout.php" type="button" class="btn btn-outline-danger">خروج</a>
</div>
<div name="projectAndProduct">
    <?php if (!isset($flag)) { ?>
        <div class="dropdown" style="text-align: center">
            <br>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                کد پروژه
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php
                echo "<form method='get' action=''>";
                foreach (get_projects() as $project) {

                    $id = $project['id'];
                    $n = $project['name'];

                    echo "<button   name='project_id' value='$id'  type='submit' >$n</button><br>";
                }
                echo "</form>";
                ?>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($_GET['project_id']) && $check_project) { ?>
        <div class="dropdown" style="text-align: center">
            <br>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                محصولات پروژه ی
                <?php echo get_project($_GET['project_id'])['name'] ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php
                $e = $_GET['project_id'];
                echo "<form method='get' action='open_the_project2.php'>";
                foreach ($products as $product) {

                    $id = $product['id'];
                    $n = $product['name'];

                    echo "<button   name='product_id' value='$id'  type='submit' >$n</button><br>";

                }
                echo "</form>";
                ?>

            </div>


        </div>

    <?php } ?>
    <h2 style="direction: rtl">جدول فعالیت های روزانه </h2>
    <table dir="rtl" style="margin-top: 100px;margin-right:25px;margin-left: 25px" class="table table-dark">
        <thead>
        <tr>
            <th scope="col">پروژه</th>
            <th scope="col">محصول</th>
            <th scope="col">فعالیت</th>
            <th scope="col">زمان عادی</th>
            <th scope="col">زمان اضافه</th>
            <th scope="col">تاریخ ثبت</th>


        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            $reports = get_report($user['id']);
            foreach ($reports

            as $id => $report){
            ?>

            <td><?php echo $reports[$id]["project"]["name"] ?></td>
            <td><?php echo $reports[$id]["product"]["name"] ?></td>
            <td><?php echo $reports[$id]["activity"]["name"] ?></td>
            <td><?php echo $reports[$id]['hours_normal'] . ":" . $reports[$id]["minutes_normal"] ?></td>
            <td><?php echo $reports[$id]['hours_extra'] . ":" . $reports[$id]["minutes_extra"] ?></td>
            <td><?php
                $t = $reports[$id]["time"];
                echo date("y/m/d", $t);


                ?></td>


        </tr>
        <?php } ?>


        </tbody>
    </table>

</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>
