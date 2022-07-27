<?php
require "_secret.php";

session_start();

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER_NAME, DB_PSW);
} catch (PDOException $e) {
    echo "error: " . $e->getMessage();
    exit();
}

function redirect($path)
{
    header("Location:" . $path);
    exit();
}

function auth_require()
{
    if (!isset($_SESSION["user_id"])) {
        redirect("login.php");
    }
}

function get_user($id)
{
    global $db;
    $query = "SELECT * FROM user WHERE id= :id";
    $stm = $db->prepare($query);
    $stm->bindParam(':id', $id);
    $stm->execute();
    $user = $stm->fetch();
    return $user;
}

function get_projects()
{
    global $db;
    $query = "select * from project";
    $stm = $db->prepare($query);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_project($id)
{
    global $db;
    $query = "select * from project where id=?";
    $stm = $db->prepare($query);
    $stm->bindParam(1, $id);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_product($id)
{
    global $db;
    $query = "select id,name,code,project_id from product where id=?";
    $stm = $db->prepare($query);
    $stm->bindParam(1, $id);
    $stm->execute();
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_products($id)
{
    global $db;
    $stm = $db->prepare("select `id`,`name` from product where `project_id` =?");
    $stm->bindParam(1, $id);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function get_project_by_product()
{
    global $db;
    $query = "SELECT  project.name
FROM project
INNER JOIN product where product.id=1";
//    $query="SELECT name FROM `product` where product.id = ?";

    $stm = $db->prepare($query);
//    $stm->bindParam(1,$product_id);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function chek_project($id)
{
    global $db;
    $query = "select * from project where id=?";
    $stm = $db->prepare($query);
    $stm->bindParam(1, $id);
    $stm->execute();
    $a = $stm->fetchColumn();
    if ($a > 0) {
        return true;
    } else {
        return false;
    }
}

function chek_product($id)
{
    global $db;
    $query = "select * from product where id=?";
    $stm = $db->prepare($query);
    $stm->bindParam(1, $id);
    $stm->execute();
    $a = $stm->fetchColumn();
    if ($a > 0) {
        return true;
    } else {
        return false;
    }
}

function get_activities()
{
    global $db;
    $query = "select `name` , `id` from activity";
    $stm = $db->prepare($query);
    $stm->execute();
    $activities = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $activities;
}

function get_activity($id)
{
    global $db;
    $query = "select * from activity where id=?";
    $stm = $db->prepare($query);
    $stm->bindParam(1, $id);
    $stm->execute();
    $result = $stm->fetch();
    return $result;
}


function save_activity_report($time, $user_id, $project_id, $product_id, $activity_id, $normal_hours, $normal_minutes, $extra_hours, $extra_minutes, $created_at)
{
    global $db;
  $query = "INSERT INTO `report` ( `user_id`, `project_id`, `product_id`, `activity_id`, `hours_normal`, `minutes_normal`, `hours_extra`, `minutes_extra`, `created_at`, `time`) VALUES ( ?, ?, ?,?,?, ?,?, ?, ?,  ?); ";
    $stm = $db->prepare($query);
    $stm->bindParam(1, $user_id);
    $stm->bindParam(2, $project_id);
    $stm->bindParam(3, $product_id);
    $stm->bindParam(4, $activity_id);
    $stm->bindParam(5, $normal_hours);
    $stm->bindParam(6, $normal_minutes);
    $stm->bindParam(7, $extra_hours);
    $stm->bindParam(8, $extra_minutes);
    $stm->bindParam(9, $created_at);
    $stm->bindParam(10, $time);
    $stm->execute();
}

function get_report($user_id)
{
    global $db;
    $time2 = time() - 86400;
    $query = "select project_id , product_id , activity_id , hours_normal ,minutes_normal , hours_extra , minutes_extra , time from report  where user_id= ?   order by created_at desc ";
    $stm = $db->prepare($query);
    $stm->bindParam(1, $user_id);
//    $stm->bindParam(2, $time2);
    $stm->execute();
    $reports = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($reports as $id=>$report)
    {
        $reports[$id]['project']=get_project($reports[$id]['project_id']);
        $reports[$id]['product']=get_product($reports[$id]['product_id']);
        $reports[$id]['activity']=get_activity($reports[$id]['activity_id']);

        unset($reports[$id]["project_id"]);
        unset($reports[$id]["product_id"]);
        unset($reports[$id]["activity_id"]);

    }
    return $reports;
}
function get_today_report_activity($user_id){
    global $db;
    $query="SELECT  product_id ,project_id,hours_normal,minutes_normal,hours_extra,minutes_extra, SUM(hours_normal),SUM(minutes_normal),SUM(hours_extra),SUM(minutes_extra) FROM report where user_id= ? GROUP BY(product_id)";
    $stmt=$db->prepare($query);
    $stmt->bindParam(1,$user_id);
    $stmt->execute();
    $reports=$stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($reports as $id=>$report){
//        $reports[$id]["count"]=
       $h_n= $reports[$id]["SUM(hours_normal)"]+($reports[$id]["SUM(minutes_normal)"])/60;
        $reports[$id]["h_sum_normal"]=intval($h_n);
        $reports[$id]["m_sum_normal"]=($reports[$id]["SUM(minutes_normal)"])%60;
        $h_e= $reports[$id]["SUM(hours_extra)"]+($reports[$id]["SUM(minutes_extra)"])/60;
        $reports[$id]["h_sum_extra"]=intval($h_e);
        $reports[$id]["m_sum_extra"]=($reports[$id]["SUM(minutes_extra)"])%60;

    }
    return $reports;
}

//_____________________________________________________command_FILE
if (isset($_SESSION['user_id'])) {
    $user = get_user($_SESSION['user_id']);
    $_SESSION['user'] = $user;
    if ($user === false) {
        unset($_SESSION['user_id']);
        redirect("login.php");
    }

}
