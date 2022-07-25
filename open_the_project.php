
<?php
require "_load.php";
auth_require();

if (!isset($_GET['product_id'])){
    exit("error: product_id is not set");
}
else{
    $products=get_product($_GET['product_id']);
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
</head>
<body>
<div style="padding-left: 80%;padding-top:20px; ">
    user_active   <select name="cars" id="cars" >
        <option value="<? $_SESSION['user_id'] ?>"><?php echo $_SESSION['user']['user_name'] ?> </option>

    </select>
</div>
<div style="background-color: blue;text-align: center;width: 80%;height: 80%">

</div>

</div>
</body>
</html>
