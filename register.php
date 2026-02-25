<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// check the user is loged in or not
$user = current_user(); 
if ($user) {
    header('Location: index.php');
    exit();
}

$error = '';

//get the form data and validate
if($_SERVER['REQUEST METHOD']===  'POST'){
    $name= trim($_POST['name']);
    $email= trim($_POST['email']);
    $password= $_POST['password'];
    $phone= trim($_POST['phone']);
    $address= trim($_POST['address']);
    $code= trim($_POST['code']);
    $city= trim($_POST['city']);

    //check if empty and validate email
    if(empty($name) || empty($email) || empty($password) || empty($phone) || empty($address) || empty($code) || empty($city)){
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        //check if email already exists
        $db = db_connect();
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $error = 'Email is already registered.';
        } else {
            //hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //check password strength
            if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
                $error = 'Password must be at least 8 characters long and include uppercase letters, lowercase letters, and numbers.';
            } else {
                //insert the user into database
                $stmt = $db->prepare("INSERT INTO users (name, email, password, phone, address, code, city, roles) VALUES (?, ?, ?, ?, ?, ?, ?, 'customer')");
                $stmt->bind_param("sssssss", $name, $email, $hashed_password, $phone, $address, $code, $city);
                
                if ($stmt->execute()) {
                    header('Location: login.php');
                    exit();
                } else {
                    $error = 'Error occurred during registration. Please try again.';
                }
            }

            
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Melody Masters</title>
    <link rel="stylesheet" href="style/auth.css">
</head>
<body>
    <div class="register-container">
<h2>Create a New Account</h2>
<?php if ($error): ?>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<div class="register-form">
<form method="post" action="register.php">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
    </div>
    <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
    </div>
    <div class="form-group">
        <label for="code">Postal Code:</label>
        <input type="text" id="code" name="code" required>
    </div>
    <div class="form-group">
        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>
    </div>

</form>
</div>
    </div>

