<?php
//require_once __DIR__.'/config.php';
//logEDany one 
function isloggedin(){
    return isset($_SESSION['user_id']);
}
 //user an admin
function isadmin()
{
    return isloggedin() && in_array('admin', $_SESSION['roles']);
}
// user an admin or staff
function isstaff()
{
    return isloggedin() && in_array(($_SESSION['roles']), ['admin', 'staff']);
}

//Acess control
function require_login(){
    if(!isloggedin()){
        header('Location: login.php');
        exit();
    }
}
//Acess control for admin only
function require_admin(){
    require_login();
    if(!isadmin()){
        header('Location: index.php');
        exit();
    }
}
//Acess control for  
function require_staff(){
    require_login();
    if(!isstaff()){
        header('Location: index.php');
        exit();
    }
}

// curent user info
function current_user()
{
    if (!isloggedin()) {
        return null;

    }
    $db = db_connect();
    $id = (int) $_SESSION['user_id'];
   $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
//purchased products

function hasPurchased($user_id, $product_id) {
    $db  = db_connect();
    $uid = (int) $user_id;
    $pid = (int) $product_id;
    $res = $db->query("
        SELECT oi.id
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.id
        WHERE o.user_id    = $uid
          AND oi.product_id = $pid
          AND o.status     != 'cancelled'
        LIMIT 1
    ");
    return $res && $res->num_rows > 0;
}

function cart(){
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
}

?>