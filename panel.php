<?php
require "_load.php";
auth_require();

echo "
<h3><a href='logout.php'> logout</a> </h3>";

echo "this is panel";
var_dump($_SESSION['user']);