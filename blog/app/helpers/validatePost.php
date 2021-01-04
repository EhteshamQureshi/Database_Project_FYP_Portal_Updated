<?php
function validatePost($post)
{
    $errors = array();

    if (empty($_POST['title'])) {
        array_push($errors, "Title is required");
    }
    if (empty($_POST['body'])) {
        array_push($errors, "Body is required");
    }
    if (empty($_POST['topic_id'])) {
        array_push($errors, "Please select a topic");
    }
    if (empty($_POST['institute_id'])) {
        array_push($errors, "Please select a institute");
    }
    // Using the resuable database fucntion to check if title already exists or not.
    $existingPost = selectOne('projects', ['title' => $post['title']]); //fetch post from datbase using the title
    if ($existingPost) {
        // We are passing the super global variable $_POST to validate method 
        // Therefore the post varaible is accessible here
        // THe below if check tell us if user is updating the project
        if (isset($post['update-post']) && $existingPost['id'] != $post['id']) { //Title is changed to title that already esits
            array_push($errors, 'Project with this title already exists');
        }
        // When creating post
        if (isset($post['add-post'])) {
            array_push($errors, 'Project with this title already exists');
        }
    }
    return $errors;
}
