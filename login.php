<?php
require "_load.php";
global $db;
if (isset($_POST['user_name'],$_POST['password'],$_POST['login'])){
    $username=$_POST['user_name'];
    $password=$_POST['password'];
    $query="SELECT id FROM user WHERE user_name= :user_name AND password = :password";
    $stm=$db->prepare($query);
    $stm->bindParam(":user_name",$username);
    $stm->bindParam(":password",$password);
    $result=$stm->execute();
   $user_id=$stm->fetch();
   if ($user_id===false){
       $error="مشخصات وارد شده صحیح نیست";
   }
   else{
       $_SESSION['user_id']=$user_id['id'];
       redirect("index.php");
   }
//    var_dump($user);

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
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="wrapper fadeInDown">
    <div id="formContent" style="text-align: center;padding-top: 150px">
        <!-- Tabs Titles -->
<h3 style="text-align: center">فرم ورود به سامانه</h3>
        <!-- Icon -->
        <div class="fadeIn first">
            <img src="asset/image/images.png" id="icon" alt="User Icon" />
        </div>

        <!-- Login Form -->
        <form style="text-align: center" method="POST" action="">
            <input type="text" id="login" class="fadeIn second" name="user_name" placeholder="کد پرسنلی"><br><br>
            <input type="text" id="password" class="fadeIn third" name="password" placeholder="رمز عبور"><br><br>
            <div name="errorMsg">
                <p class="alert alert-warning"><?php
                    if (isset($error)){
                        echo $error;
                    }
                    ?></p>
            </div>
            <input name="login" type="submit" class="fadeIn fourth" value="ورود">
        </form>
    </div>
</div>

</body>
</html>
