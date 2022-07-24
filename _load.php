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

if (isset($_SESSION['user_id'])){
    $query="SELECT * FROM user WHERE id= :id";
    $stm=$db->prepare($query);
    $stm->bindParam(':id',$_SESSION['user_id']);
    $stm->execute();
    $user=$stm->fetch();
    $_SESSION['user']=$user;
    if ($user === false){
        unset($_SESSION['user_id']);
        redirect("login.php");
    }

}