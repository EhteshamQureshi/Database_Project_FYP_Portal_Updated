<?php
// <!-- This file is for restricting and managing access and functionality-->
// This function is for restricting funcitonality to login users
function userOnly($redirect = '/index.php')
{
    // I will use this fuction to provide functionality that is specific only to users like commenting
    // Not Logged in
    if (empty($_SESSION['id'])) {
        $_SESSION['message'] = 'You need to login first!!!';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}
// This function is for restricting funcitonality to admin users
function adminOnly($redirect = '/index.php')
{
    // Not Logged in
    if (empty($_SESSION['id']) || empty($_SESSION['admin'])) {
        $_SESSION['message'] = 'You are not authorized!!!';
        $_SESSION['type'] = 'error';
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}
// This function is used to restrict access to pages like register when already logged
function guestOnly($redirect = '/index.php')
{
    // User is Logged in
    if (isset($_SESSION['id'])) {
        header('location: ' . BASE_URL . $redirect);
        exit(0);
    }
}
