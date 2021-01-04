<?php
function validateInstitute($institute)
{
    $errors = array();

    if (empty($institute['name'])) {
        array_push($errors, "Name is required");
    }

    // Using the resuable database fucntion to check if topic already exists or not.
    // $existingTopic = selectOne('topics', ['name' => $topic['name']]);
    // if ($existingTopic) {
    //     array_push($errors, 'Name already exists');
    // }

    $existingInstitute = selectOne('institutes', ['name' => $institute['name']]); //fetch post from datbase using the title
    if ($existingInstitute) {
        // We are passing the super global variable $_POST to validate method 
        // Therefore the post varaible is accessible here
        // THe below if check tell us if user is updating the project
        if (isset($post['update-institute']) && $existingInstitute['id'] != $post['id']) { //Title is changed to title that already esits
            array_push($errors, 'Name already exists');
        }
        // When creating post
        if (isset($post['add-institute'])) {
            array_push($errors, 'Name already exists');
        }
    }
    return $errors;
}
