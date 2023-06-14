<?php
session_start();
require_once '../class/user.php';
$user = new User();

if (!$user->is_loggedin()) {
    $user->redirect('profile.php');
}

if ($user->logout()) {
    $user->redirect('login.php');
}
?>
