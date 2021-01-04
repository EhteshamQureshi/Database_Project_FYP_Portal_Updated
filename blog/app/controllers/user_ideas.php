<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateIdea.php");


$table = 'ideas';
// Fecting for the check box on the add project page
$topics = selectAll('topics');
$institutes = selectAll('institutes');
// Fecting project data form projects table
$published_value = 1;
$ideas = selectAll($table, ['published' => $published_value]);
$user_ideas = selectAll($table, ['user_id' => $_SESSION['id']]);
// dd($ideas);

// For Validation
$errors = array();

// Refilling the form if validation fails
$title = "";
$id = "";
$body = "";
$topic_id = "";
$published = "";

// Now accessing the id variable we recieve form edit.php
if (isset($_GET['id'])) { //recieving parameter form url
    $post = selectOne($table, ['id' => $_GET['id']]);
    // dd($post);
    // Now after query we will set the variables and put then in edit form so that user and modify then
    // All the fields are returned in post variable.
    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];
    $topic_id = $post['topic_id'];
    $published = $post['published'];
}
// Now accessing the deleteid variable we recieve form edit.php
if (isset($_GET['deleteid'])) { //recieving parameter form url
    // adminOnly(); // Restricting adming ot delete only
    userOnly();
    $post = delete($table, $_GET['deleteid']);
    // dd($post);
    $_SESSION['message'] = "Idea Deleted Successfully";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/users/ideas/index.php");
    exit();
}

// Implementing publish post
if (isset($_GET['published']) & isset($_GET['p_id'])) {
    // adminOnly(); // Allowing only admin to  publish
    userOnly();
    $published = $_GET['published'];
    $p_id = $_GET['p_id'];
    // Update published
    $count = update($table, $p_id, ['published' => $published]);
    // dd($count);
    // Message
    $_SESSION['message'] = "Published Status Changed!!";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/users/ideas/index.php");
    exit();
}

// Creating post form submit method
if (isset($_POST['add-idea'])) {
    // adminOnly(); // Allowing only admin to  post projects
    userOnly();
    // dd($_POST);
    $errors = validateIdea($_POST);
    // Dealing with images so validation will be different
    // dd($_FILES); //This is php function responsible for files
    // This above funciton returns array of file containing information regarding that file
    // dd($_FILES['image']['name']); //gives the name of the file 'name'

    // Applying form validation
    if (count($errors) === 0) {

        // unset($_POST['add-post'], $_POST['topic_id']);
        unset($_POST['add-idea']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0; //Short form of if else
        $_POST['body'] = htmlentities($_POST['body']); //not storing elements in database will make is secure preventing cross side scritping
        // dd($_POST);

        // Now calling the create method
        $idea_id = create($table, $_POST); //create method returns id of any record it creates
        // Showing message
        $_SESSION['message'] = 'Idea created Successfully';
        $_SESSION['type'] = 'success';
        // Now redirecting to the manage post page
        header("location: " . BASE_URL . "/users/ideas/index.php");
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        // $institute_id = $_POST['institute_id'];
        // If we set the value of like we are setting the other varables value then it will not work
        // becuase if we will not select the check box its variable will not exist
        // it will give undefined index
        // $published = $_POST['published'];
        $published = isset($_POST['published']) ? 1 : 0; //Short form of if else
    }
}

// Updating Project
if (isset($_POST['update-idea'])) {
    // adminOnly(); // Allowing only admin to update projects
    userOnly();
    // First validate Topic then add to database
    $errors = validateIdea($_POST);

    // Applying form validation
    if (count($errors) === 0) {

        $id = $_POST['id'];
        // unset($_POST['add-post'], $_POST['topic_id']);
        unset($_POST['update-idea'], $_POST['id']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0; //Short form of if else
        $_POST['body'] = htmlentities($_POST['body']); //not storing elements in database will make is secure preventing cross side scritping
        // dd($_POST);

        // Now calling the create method
        $post_id = update($table, $id, $_POST); //create method returns id of any record it creates
        // Showing message
        $_SESSION['message'] = 'Idea updated Successfully';
        $_SESSION['type'] = 'success';
        // Now redirecting to the manage post page
        header("location: " . BASE_URL . "/users/ideas/index.php");
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        // If we set the value of like we are setting the other varables value then it will not work
        // becuase if we will not select the check box its variable will not exist
        // it will give undefined index
        // $published = $_POST['published'];
        $published = isset($_POST['published']) ? 1 : 0; //Short form of if else
    }
}
