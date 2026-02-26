<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/function.php';

// session destory
session_start();
session_unset();
session_destroy();
header('Location: index.php');
exit(); 
?>