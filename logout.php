<?php
require "_load.php";
unset($_SESSION['user_id']);
redirect("login.php");