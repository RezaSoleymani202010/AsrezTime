<?php
require "_secret.php";
session_start();

try{
   $db=new PDO("mysql:host=" .DB_HOST .";dbname=".DB_NAME , DB_USER_NAME ,DB_PSW);
}catch (PDOException $e){
    echo "error: " .$e->getMessage();
    exit();
}
function redirect( $path)
{
header("Location:" . $path);
exit();
}
function auth_require(){
    if (!isset($_SESSION["user_id"])){
        redirect("login.php");
    }
}
 function get_user($id){
    global $db;
    $query="SELECT * FROM user WHERE id= :id";
    $stm=$db->prepare($query);
    $stm->bindParam(':id',$id);
    $stm->execute();
    $user=$stm->fetch();
    return $user;
}
function get_projects(){
    global $db;
    $query="select * from project";
    $stm=$db->prepare($query);
    $stm->execute();
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function get_project($id){
    global $db;
    $query="select name from project where id=?";
    $stm=$db->prepare($query);
    $stm->bindParam(1,$id);
    $stm->execute();
    $result=$stm->fetch(PDO::FETCH_ASSOC);
    return $result;
}
function get_product($id){
    global $db;
    $query="select id,name,code from product where id=?";
    $stm=$db->prepare($query);
    $stm->bindParam(1,$id);
    $stm->execute();
    $result=$stm->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_products($id){
    global $db;
    $stm=$db->prepare("select `id`,`name` from product where `project_id` =?");
    $stm->bindParam(1,$id);
    $stm->execute();
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function get_project_by_product($product_id){
    global $db;
    $query="SELECT project.name FROM `project` INNER JOIN `product` ON product.id = ?";
//    $query="SELECT name FROM `product` where product.id = ?";

    $stm=$db->prepare($query);
    $stm->bindParam(1,$product_id);
    $stm->execute();
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function chek_project($id){
    global $db;
    $query="select * from project where id=?";
    $stm=$db->prepare($query);
    $stm->bindParam(1,$id);
    $stm->execute();
    $a=$stm->fetchColumn();
if ($a>0){
    return true;
}else{
    return false;
}
}
function chek_product($id){
    global $db;
    $query="select * from product where id=?";
    $stm=$db->prepare($query);
    $stm->bindParam(1,$id);
    $stm->execute();
    $a=$stm->fetchColumn();
    if ($a>0){
        return true;
    }else{
        return false;
    }
}
if (isset($_SESSION['user_id'])){
//    $query="SELECT * FROM user WHERE id= :id";
//    $stm=$db->prepare($query);
//    $stm->bindParam(':id',$_SESSION['user_id']);
//    $stm->execute();
//    $user=$stm->fetch();
 $user= get_user($_SESSION['user_id']);
    $_SESSION['user']=$user;
    if ($user === false){
        unset($_SESSION['user_id']);
        redirect("login.php");
    }

}
