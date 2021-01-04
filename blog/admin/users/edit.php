<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . '/app/controllers/users.php');
adminOnly(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <!-- Custom Styles -->
    <link rel="stylesheet" href="../../assets/css/style.css">

    <!-- Admin Styling -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <!-- This is the issue needed to be resolved -->
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/12.3.0/classic/ckeditor.js"></script> -->
    <title>Admin - Edit User</title>
</head>

<body>

    <!-- header -->
    <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>
    <!-- // header -->

    <div class="admin-wrapper clearfix">
        <!-- Left Sidebar -->
        <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>
        <!-- // Left Sidebar -->

        <!-- Admin Content -->
        <div class="admin-content clearfix">
            <div class="button-group">
                <a href="create.php" class="btn btn-sm">Add User</a>
                <a href="index.php" class="btn btn-sm">Manage Users</a>
            </div>
            <div class="">
                <h2 style="text-align: center;">Edit User</h2>

                <form action="edit.php" method="post">
                    <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>
                    <input type="hidden" name="id" class="text-input" value="<?php echo $id; ?>">
                    <!-- WE will need id in order to identify user and then update in the database -->
                    <div class="input-group">
                        <label style="font-weight: bold;">Username
                            <input type="text" name="username" class="text-input" value="<?php echo $username; ?>">
                        </label>
                    </div>
                    <div class="input-group">
                        <label style="font-weight: bold;">Email
                            <input type="email" name="email" class="text-input" value="<?php echo $email; ?>">
                        </label>
                    </div>
                    <div class="input-group">
                        <label style="font-weight: bold;">Password
                            <input type="password" name="password" class="text-input" value="<?php echo $password; ?>">
                        </label>
                    </div>
                    <div class="input-group">
                        <label style="font-weight: bold;">Confirm Password
                            <input type="password" name="passwordConf" class="text-input" value="<?php echo $passwordConf; ?>">
                        </label>
                    </div>
                    <div class="input-group">
                        <?php if (isset($admin) && $admin == 1) : ?>
                            <label style="font-weight: bold;">
                                <input type="checkbox" name="admin" checked>
                                Admin
                            </label>
                        <?php else : ?>
                            <label style="font-weight: bold;">
                                <input type="checkbox" name="admin">
                                Admin
                            </label>
                        <?php endif; ?>
                    </div>
                    <div class="input-group">
                        <button type="submit" name="update-user" class="btn">Update User</button>
                    </div>
                </form>

            </div>
        </div>
        <!-- // Admin Content -->

    </div>
    <!-- Page wrapper -->

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js"></script>

    <!-- Custome Scripts -->
    <script src="../../assets/js/scripts.js"></script>



</body>

</html>