<?php include("../../path.php");
include(ROOT_PATH . "/app/controllers/user_posts.php");
// adminOnly(); 
userOnly();
?>
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

    <title>Admin - Manage Projects</title>
</head>

<body>

    <!-- header -->
    <?php include(ROOT_PATH . "/app/includes/userHeader.php"); ?>
    <!-- // header -->

    <div class="admin-wrapper clearfix">
        <!-- Left Sidebar -->
        <?php include(ROOT_PATH . "/app/includes/userSidebar.php"); ?>
        <!-- // Left Sidebar -->

        <!-- Admin Content -->
        <div class="admin-content clearfix">
            <div class="button-group">
                <a href="create.php" class="btn btn-sm">Add Project</a>
                <a href="index.php" class="btn btn-sm">Manage Project</a>
            </div>
            <div class="">
                <h2 style="text-align: center;">Manage Projects Posted</h2>

                <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

                <table>
                    <thead>
                        <th>N</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th colspan="3">Action</th>
                    </thead>
                    <tbody>
                        <?php foreach ($user_posts as $key => $post) : ?>
                            <tr class="rec">
                                <td><?php echo $key + 1; ?></td>
                                <td><a href="#"><?php echo $post['title']; ?></a></td>
                                <!-- This username is coming from the relation with the user table -->
                                <td>Awa</td>
                                <td><a href="edit.php?id=<?php echo $post['id']; ?>" class="edit">Edit</a></td>
                                <!-- Above Fetching data from database using id when click on edit link -->
                                <td><a href="edit.php?deleteid=<?php echo $post['id']; ?>" class="delete">Delete</a></td>
                                <?php if ($post['published']) : ?>
                                    <td><a href="edit.php?published=0&p_id=<?php echo $post['id'] ?>" class="publish">Unpublish</a></td>
                                <?php else : ?>
                                    <td><a href="edit.php?published=1&p_id=<?php echo $post['id'] ?>" class="publish">Publish</a></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
        <!-- // Admin Content -->

    </div>


    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js"></script>

    <!-- Custome Scripts -->
    <script src="../../assets/js/scripts.js"></script>

</body>

</html>