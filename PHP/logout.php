<?php
session_start();
require_once '../../class/user.php';
$user = new User();

if (!$user->is_loggedin()) {
    $user->redirect('index.php');
}

if ($user->logout()) {
    $user->redirect('index.php');
}
?>
