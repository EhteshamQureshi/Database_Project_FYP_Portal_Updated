<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validatePost.php");


$table = 'projects';
// Fecting for the check box on the add project page
$topics = selectAll('topics');
$institutes = selectAll('institutes');
// Fecting project data form projects table
$posts = selectAll($table);

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
    $institute_id = $post['topic_id'];
    $published = $post['published'];
}
// Now accessing the deleteid variable we recieve form edit.php
if (isset($_GET['deleteid'])) { //recieving parameter form url
    adminOnly(); // Restricting adming ot delete only
    $post = delete($table, $_GET['deleteid']);
    // dd($post);
    $_SESSION['message'] = "Project Deleted Successfully";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/posts/index.php");
    exit();
}

// Implementing publish post
if (isset($_GET['published']) & isset($_GET['p_id'])) {
    adminOnly(); // Allowing only admin to  publish
    $published = $_GET['published'];
    $p_id = $_GET['p_id'];
    // Update published
    $count = update($table, $p_id, ['published' => $published]);
    // dd($count);
    // Message
    $_SESSION['message'] = "Published Status Changed!!";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/posts/index.php");
    exit();
}

// Creating post form submit method
if (isset($_POST['add-post'])) {
    adminOnly(); // Allowing only admin to  post projects
    // dd($_POST);
    $errors = validatePost($_POST);
    // Dealing with images so validation will be different
    // dd($_FILES); //This is php function responsible for files
    // This above funciton returns array of file containing information regarding that file
    // dd($_FILES['image']['name']); //gives the name of the file 'name'
    // Now uploading image selected by user

    if (!empty($_FILES['image']['name'])) { //This means if image is selected
        // Upload the image
        $image_name = time() . '_' . $_FILES['image']['name']; //To make the image name unique
        $destination = ROOT_PATH . "/assets/images/" . $image_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        // Now checking if the upload is successful or not
        if ($result) {
            // Saving the name of image in database
            $_POST['image'] = $image_name;
        } else {
            // Error maessage as image is failed to upload
            array_push($errors, "Failed to upload image");
        }
    } else { //This means no image is selected
        array_push($errors, "Project Image Required");
    }
    // Applying form validation
    if (count($errors) === 0) {

        // unset($_POST['add-post'], $_POST['topic_id']);
        unset($_POST['add-post']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0; //Short form of if else
        $_POST['body'] = htmlentities($_POST['body']); //not storing elements in database will make is secure preventing cross side scritping
        // dd($_POST);

        // Now calling the create method
        $post_id = create($table, $_POST); //create method returns id of any record it creates
        // Showing message
        $_SESSION['message'] = 'Project created Successfully';
        $_SESSION['type'] = 'success';
        // Now redirecting to the manage post page
        header("location: " . BASE_URL . "/admin/posts/index.php");
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $institute_id = $_POST['institute_id'];
        // If we set the value of like we are setting the other varables value then it will not work
        // becuase if we will not select the check box its variable will not exist
        // it will give undefined index
        // $published = $_POST['published'];
        $published = isset($_POST['published']) ? 1 : 0; //Short form of if else
    }
}

// Updating Project
if (isset($_POST['update-project'])) {
    adminOnly(); // Allowing only admin to update projects
    // First validate Topic then add to database
    $errors = validatePost($_POST);

    // Now uploading image selected by user
    if (!empty($_FILES['image']['name'])) { //This means if image is selected
        // Upload the image
        $image_name = time() . '_' . $_FILES['image']['name']; //To make the image name unique
        $destination = ROOT_PATH . "/assets/images/" . $image_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        // Now checking if the upload is successful or not
        if ($result) {
            // Saving the name of image in database
            $_POST['image'] = $image_name;
        } else {
            // Error maessage as image is failed to upload
            array_push($errors, "Failed to upload image");
        }
    } else { //This means no image is selected
        array_push($errors, "Project Image Required");
    }

    // Applying form validation
    if (count($errors) === 0) {

        $id = $_POST['id'];
        // unset($_POST['add-post'], $_POST['topic_id']);
        unset($_POST['update-project'], $_POST['id']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0; //Short form of if else
        $_POST['body'] = htmlentities($_POST['body']); //not storing elements in database will make is secure preventing cross side scritping
        // dd($_POST);

        // Now calling the create method
        $post_id = update($table, $id, $_POST); //create method returns id of any record it creates
        // Showing message
        $_SESSION['message'] = 'Project updated Successfully';
        $_SESSION['type'] = 'success';
        // Now redirecting to the manage post page
        header("location: " . BASE_URL . "/admin/posts/index.php");
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
