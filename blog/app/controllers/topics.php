<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateTopic.php");

// Fetching topics from database
$table = 'topics';
$table2 = 'institutes';
$errors = array();
$id = '';
$name = '';
$description = '';

$topics = selectAll($table);
$institutes = selectAll($table2); //This is for fetching institutes on home page


// Addding topics in database
if (isset($_POST['add-topic'])) {
    adminOnly(); //Allowing only admin to add topic
    // First validate Topic then add to database
    $errors = validateTopic($_POST);

    if (count($errors) === 0) {
        unset($_POST['add-topic']); //delete additional field
        $topic_id = create($table, $_POST); //Add to database table
        // Store messages in session varaiable
        $_SESSION['message'] = 'Topic created Successfully';
        $_SESSION['type'] = 'success';
        // go to index page of the catagory and show the success message stored in session variable.
        header('location: ' . BASE_URL . '/admin/topics/index.php');
        exit();
    } else {
        $name = $_POST['name'];
        $description = $_POST['description'];
    }
}
// Fecthin particular record with id 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $topic = selectOne($table, ['id' => $id]);
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['description'];
}
// Deleting fuctionality
if (isset($_GET['del_id'])) {
    adminOnly(); //Allowing only admin to delete topic
    $id = $_GET['del_id'];
    $count = delete($table, $id);
    // Store messages in session varaiable
    $_SESSION['message'] = 'Topic deleted Successfully';
    $_SESSION['type'] = 'success';
    // go to index page of the catagory and show the success message stored in session variable.
    header('location: ' . BASE_URL . '/admin/topics/index.php');
    exit();
}
// For updating the topic
if (isset($_POST['update-topic'])) {
    adminOnly(); //Allowing only admin to update topic
    // First validate Topic then add to database
    $errors = validateTopic($_POST);

    if (count($errors) === 0) {
        $id = $_POST['id'];
        unset($_POST['update-topic'], $_POST['id']);
        $topic_id = update($table, $id, $_POST);
        // Store messages in session varaiable
        $_SESSION['message'] = 'Topic updated Successfully';
        $_SESSION['type'] = 'success';
        // go to index page of the catagory and show the success message stored in session variable.
        header('location: ' . BASE_URL . '/admin/topics/index.php');
        exit();
    } else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
    }
}
