<?php
require "_load.php";
auth_require();

if (isset($_GET['project_id'])) {
    $check_project=chek_project($_GET['project_id']);
    $products = get_products($_GET['project_id']);
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
    user_active <select name="cars" id="cars">
        <option value="<? $_SESSION['user_id'] ?>"><?php echo $_SESSION['user']['user_name'] ?> </option>

    </select>
</div>
<div name="projectAndProduct">
    <div class="dropdown">
        <br>
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
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

    <?php if (isset($_GET['project_id'])&&$check_project) { ?>
        <div class="dropdown" style="padding-left: 200px;padding-bottom: 150px">
            <br>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                محصول
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php
                echo "<form method='get' action='_product.php'>";
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
