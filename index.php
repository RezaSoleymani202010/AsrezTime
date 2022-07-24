<?php
require "_load.php";
if (isset($_SESSION['user_id'])){
    redirect("panel.php");
}
else{
    redirect("login.php");
}
?>
