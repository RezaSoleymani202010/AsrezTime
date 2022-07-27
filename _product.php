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
}else{
    redirect("panel.php");
}