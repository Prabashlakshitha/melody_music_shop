<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// session destory
session_start();
session_unset();
session_destroy();
header('Location: login.php');
exit(); 
?>