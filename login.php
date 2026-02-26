<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['name']);
    $password = $_POST['password'];
    // check empty 
    if(empty($username)|| empty($password)){
        $error = 'All fields are required.';
    }
    //get user from database

    $db = db_connect();
    $stmt = $db->prepare("SELECT * FROM users WHERE name= ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $user = $result->fetch_assoc()) {
        // verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = htmlspecialchars($user['name']);
            $_SESSION['roles'] = explode(',', $user['roles']);
            //role base redirection
            if (isstaff()){
                header('Location: admin/dashboard.php');
                exit();
            }
           //when click  checkout page 
            
        } else {
            $redirect=$_GET['redirect'] ?? 'customer/dashboard.php';
            header("Location: ".$redirect);
            exit();
        }
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Melody Masters</title>
    <link rel="stylesheet" href="style/auth.css">
</head>
<body>
    <div class="login-container">
<h2>Login to Your Account</h2>
<?php if ($error): ?>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<div class="login-form">

<form method="post" action="">
    <div>
        <label for="name">Username:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Login</button>
</form>
</div>
</div>
</body>
</html>