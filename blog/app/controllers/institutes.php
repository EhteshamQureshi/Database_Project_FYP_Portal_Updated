<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateInstitute.php");

// Fetching institutes from database
$table = 'institutes';
$errors = array();
$id = '';
$name = '';
$description = '';

$institutes = selectAll($table);

// Addding topics in database
if (isset($_POST['add-institute'])) {
    adminOnly(); //Allowing only admin to add topic
    // First validate Topic then add to database
    $errors = validateInstitute($_POST);

    if (count($errors) === 0) {
        unset($_POST['add-institute']); //delete additional field
        $institute_id = create($table, $_POST); //Add to database table
        // Store messages in session varaiable
        $_SESSION['message'] = 'Institute created Successfully';
        $_SESSION['type'] = 'success';
        // go to index page of the catagory and show the success message stored in session variable.
        header('location: ' . BASE_URL . '/admin/institutions/index.php');
        exit();
    } else {
        $name = $_POST['name'];
        $description = $_POST['description'];
    }
}
// Fecthin particular record with id 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $institute = selectOne($table, ['id' => $id]);
    $id = $institute['id'];
    $name = $institute['name'];
    $description = $institute['description'];
}
// Deleting fuctionality
if (isset($_GET['del_id'])) {
    adminOnly(); //Allowing only admin to delete Institute
    $id = $_GET['del_id'];
    $count = delete($table, $id);
    // Store messages in session varaiable
    $_SESSION['message'] = 'Institute deleted Successfully';
    $_SESSION['type'] = 'success';
    // go to index page of the catagory and show the success message stored in session variable.
    header('location: ' . BASE_URL . '/admin/institutions/index.php');
    exit();
}
// For updating the Institute
if (isset($_POST['update-institute'])) {
    adminOnly(); //Allowing only admin to update Institute
    // First validate Institute then add to database
    $errors = validateInstitute($_POST);

    if (count($errors) === 0) {
        $id = $_POST['id'];
        unset($_POST['update-institute'], $_POST['id']);
        $institute_id = update($table, $id, $_POST);
        // Store messages in session varaiable
        $_SESSION['message'] = 'Institute updated Successfully';
        $_SESSION['type'] = 'success';
        // go to index page of the catagory and show the success message stored in session variable.
        header('location: ' . BASE_URL . '/admin/institutions/index.php');
        exit();
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
    }
}
