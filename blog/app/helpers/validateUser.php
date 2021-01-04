<?php
function validateUser($user)
{
    $errors = array();

    if (empty($_POST['username'])) {
        array_push($errors, "Username is required");
    }
    if (empty($_POST['email'])) {
        array_push($errors, "Email is required");
    }
    if (empty($_POST['password'])) {
        array_push($errors, "Password is required");
    }
    if ($_POST['passwordConf'] !== $_POST['password']) {
        array_push($errors, "Password do not match");
    }
    // Using the resuable database fucntion to check if email already exists or not.
    // $existingUser = selectOne('users', ['email' => $user['email']]);
    // if ($existingUser) {
    //     array_push($errors, 'Email already exists');
    // }

    $existingUser = selectOne('users', ['email' => $user['email']]); //fetch post from datbase using the title
    if ($existingUser) {
        // We are passing the super global variable $_POST to validate method 
        // Therefore the post varaible is accessible here
        // THe below if check tell us if user is updating the project
        if (isset($user['update-user']) && $existingUser['id'] != $user['id']) { //Title is changed to title that already esits
            array_push($errors, 'Email already exists');
        }
        // When creating post
        if (isset($user['add-topic'])) {
            array_push($errors, 'Email already exists');
        }
    }
    return $errors;
}
// This function is for login
function validateLogin($user)
{
    $errors = array();
    if (empty($_POST['username'])) {
        array_push($errors, "Username is required");
    }
    if (empty($_POST['password'])) {
        array_push($errors, "Password is required");
    }
    return $errors;
}
// This function is for login
function validateReset($user)
{
    $errors = array();
    if (empty($_POST['username'])) {
        array_push($errors, "Username is required");
    }
    if (empty($_POST['email'])) {
        array_push($errors, "Email is required");
    }
    return $errors;
}
