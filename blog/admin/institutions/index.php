<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/institutes.php");
adminOnly(); ?>
<!-- for showing the success message after adding institute above include stmt is needed -->
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

    <title>Admin - Manage Institutes</title>
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
                <a href="create.php" class="btn btn-sm">Add Institue</a>
                <a href="index.php" class="btn btn-sm">Manage Institues</a>
            </div>
            <div class="">
                <h2 style="text-align: center;">Manage Institues</h2>
                <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
                <table>
                    <thead>
                        <th>N</th>
                        <th>Name</th>
                        <th colspan="2">Action</th>
                    </thead>
                    <tbody>
                        <!--Using loop to show the institutes fetched from database  -->
                        <?php foreach ($institutes as $key => $institute) : ?>
                            <tr class="rec">
                                <td> <?php echo $key + 1; ?></td>
                                <!--This is serial no-->
                                <td>
                                    <a href="#"><?php echo $institute['name']; ?></a>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?php echo $institute['id']; ?> " class="edit">
                                        Edit
                                    </a>
                                </td>
                                <td>
                                    <a href="index.php?del_id=<?php echo $institute['id']; ?>" class="delete">
                                        Delete
                                    </a>
                                </td>
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
    <script src="../../assets/scripts.js"></script>

</body>

</html>