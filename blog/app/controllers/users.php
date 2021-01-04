 <?php

    include(ROOT_PATH . "/app/database/db.php"); //#1
    include(ROOT_PATH . "/app/helpers/validateUser.php");
    include(ROOT_PATH . "/app/helpers/middleware.php");

    $tableName = 'users'; //WE are using the table name again and again to call function like create selectOne
    // So we are creating a table name variable above

    // $admin_users = selectAll($tableName, ['admin' => 1]); //Select with filder
    $admin_users = selectAll($tableName); //It will select all users

    $errors = array();
    $id = ''; //Specially used for updating
    $username = '';
    $admin = '';
    $email = '';
    $password = '';
    $passwordConf = '';



    function loginUser($user)
    {
        // user info in session variable
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['admin'] = $user['admin'];
        // Message for the user 
        $_SESSION['message'] = 'You are now logged in';
        $_SESSION['type'] = 'success';
        if ($_SESSION['admin']) {
            header('location: ' . BASE_URL . '/admin/dashboard.php');
        } else {
            header('location: ' . BASE_URL . '/index.php');
        }
        exit();
    }
    // Reset Password
    function resetUserPass($user)
    {
        // user info in session variable
        // $_SESSION['id'] = $user['id'];
        // $_SESSION['username'] = $user['username'];
        // $_SESSION['admin'] = $user['admin'];
        // Message for the user 
        $_SESSION['message'] = 'You are now log                                                                                                                                                                                                                         ged in';
        $_SESSION['type'] = 'success';
        if ($_SESSION['admin']) {
            header('location: ' . BASE_URL . '/admin/dashboard.php');
        } else {
            header('location: ' . BASE_URL . '/index.php');
        }
        exit();
    }
    // isset() mean if i click btn that have form method post
    if (isset($_POST['register-btn']) || isset($_POST['create-admin'])) {

        $errors = validateUser($_POST);

        if (count($errors) === 0) {
            unset($_POST['register-btn'], $_POST['passwordConf'], $_POST['create-admin']);
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            // Checking if the values are coming from admin user
            if ($_POST['admin']) {
                $_POST['admin'] = 1; //Making the user admin
                $user_id = create($tableName, $_POST); //Inserting data into the users table
                // Flash messages ot show that admin is created
                $_SESSION['message'] = "Admin user created Successfully";
                $_SESSION['type'] = "success";
                // Redirecting to the same page
                header('location: ' . BASE_URL . '/admin/users/index.php');
                exit();
            } else {
                $_POST['admin'] = 0; //Creating normal user
                $user_id = create($tableName, $_POST); //Inserting data into the users table
                // data in a table it means create users with the all above values that we get after submittion registration form.
                // Now the select one function take the id that is created when record is inserted in above function
                // And we use this id to select that specific record to check weather user is successfully created.
                $user = selectOne($tableName, ['id' => $user_id]); // remember selectOne fn is show selected row only
                // Now logging user in to save the information in the session
                //dd($user); // so we have to import the "dd" function that where db.php file #1    

                loginUser($user);
            }
        } else {
            $username = $_POST['username'];
            $admin = isset($_POST['admin']) ? 1 : 0;
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConf = $_POST['passwordConf'];
        }
    }


    // Editing Admin User
    if (isset($_GET['id'])) {


        $user = selectOne($tableName, ['id' => $_GET['id']]);
        // Putting values in variables so thta the form is fill for after clicking edit
        // For updateing id is needed
        $id = $user['id'];
        $username = $user['username'];
        // $admin = isset($user['admin']) ? 1 : 0;
        // $admin = $user['admin'] == 1 ? 1 : 0;
        $admin = $user['admin'];
        $email = $user['email'];
    }

    // For updating the user after clicking edit and then clicking update-user button
    if (isset($_POST['update-user'])) {
        adminOnly(); //Currently admin can only update user profile
        // dd($_POST);
        // Updating is much like registering
        $errors = validateUser($_POST);

        if (count($errors) === 0) {
            $id = $_POST['id']; //we don't need tp update if while inserting data in table so we are unsetting in next line
            unset($_POST['passwordConf'], $_POST['update-user'], $_POST['id']);
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            // Checking if the values are coming from admin user

            $_POST['admin'] = isset($_POST['admin']) ? 1 : 0; //Making the user admin
            $count = update($tableName, $id, $_POST); //Updating data into the users table count check for no of effected rows
            // Flash messages ot show that admin is created
            $_SESSION['message'] = "Admin user created Successfully";
            $_SESSION['type'] = "success";
            // Redirecting to the same page
            header('location: ' . BASE_URL . '/admin/users/index.php');
            exit();
        } else {
            $username = $_POST['username'];
            $admin = isset($_POST['admin']) ? 1 : 0;
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConf = $_POST['passwordConf'];
        }
    }
    // /*this file for users login, log out and register*/

    // Now working for login.php below
    if (isset($_POST['login-btn'])) {
        $errors = validateLogin($_POST);
        if (count($errors) === 0) {

            $user = selectOne($tableName, ['username' => $_POST['username']]); //tablename ,condition in the function

            if ($user && password_verify($_POST['password'], $user['password'])) { //user and password true and logic
                //login redirect
                // user info in session variable
                loginUser($user);
            } else {
                array_push($errors, 'wrong credentials');
            }
        }
        $username = $_POST['username'];
        // $password = $_POST['password'];
    }
    // Now working for Reset pasword below
    if (isset($_POST['reset-btn'])) {
        $errors = validateReset($_POST);
        if (count($errors) === 0) {

            $user = selectOne($tableName, ['username' => $_POST['username']]); //tablename ,condition in the function

            if ($user && $_POST['email'] == $user['email']) { //user and password true and logic
                //login redirect
                // user info in session variable
                // loginUser($user);
                header('location: ' . BASE_URL . '/admin/users/index.php');
            } else {
                array_push($errors, 'wrong credentials');
            }
        }
        $username = $_POST['username'];
        // $password = $_POST['password'];
    }
    // Deleteing Admin User
    if (isset($_GET['delete_id'])) {
        adminOnly(); //Currently admin can only delete user profile
        $count = delete($tableName, $_GET['delete_id']);
        // Flash messages ot show that admin is deleted
        $_SESSION['message'] = "Admin user deleted Successfully";
        $_SESSION['type'] = "success";
        // Redirecting to the same page
        header('location: ' . BASE_URL . '/admin/users/index.php');
        exit();
    }
