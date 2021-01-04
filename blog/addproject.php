<?php include("/blog/path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/posts.php");
adminOnly();
?>
<!DOCTYPE html>
<html lang="en">
<!-- Updated -->

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
    <title>Admin - Create Project Post</title>
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
                <a href="create.php" class="btn btn-sm">Add Project</a>
                <a href="index.php" class="btn btn-sm">Manage Project</a>
            </div>
            <div class="">
                <h2 style="text-align: center;">Create Project</h2>

                <?php include(ROOT_PATH . "/app/helpers/formErrors.php") ?>
                <!-- Creating form for positng project on the webiste -->

                <form action="create.php" method="post" enctype="multipart/form-data">

                    <div class="input-group">
                        <label>Title
                            <input type="text" name="title" value="<?php echo $title; ?>" class="text-input">
                        </label>
                    </div>
                    <!-- Text Editor is attached using javascript -->
                    <div class="input-group">
                        <label for="body">Body
                            <textarea name="body" id="body"><?php echo $body; ?></textarea>
                        </label>
                    </div>
                    <!-- Uploading Image -->
                    <div>
                        <label>Image
                            <input type="file" name="image" class="text-input">
                        </label>
                    </div>
                    <!-- Selecting topic for the project -->
                    <div class="input-group">
                        <label>Topic
                            <select class="text-input" name="topic_id">
                                <option value=""></option>
                                <?php foreach ($topics as $key => $topic) : ?>

                                    <?php if (!empty($topic_id) && $topic_id = $topic['id']) : ?>
                                        <option selected value="<?php echo $topic['id']; ?>"><?php echo $topic['name']; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $topic['id']; ?>"><?php echo $topic['name']; ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>
                    <!-- Selecting institute for the project -->
                    <div class="input-group">
                        <label>Institutes
                            <select class="text-input" name="institute_id">
                                <option value=""></option>
                                <?php foreach ($institutes as $key => $institute) : ?>

                                    <?php if (!empty($institute_id) && $institute_id = $institute['id']) : ?>
                                        <option selected value="<?php echo $institute['id']; ?>"><?php echo $institute['name']; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $institute['id']; ?>"><?php echo $institute['name']; ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>
                    <!-- Checkbox for publishing -->
                    <!-- Checkbox for publishing -->
                    <div class="input-group">
                        <?php if (empty($published)) : ?>
                            <label>
                                <input type="checkbox" name="published" /> Publish
                            </label>
                        <?php else : ?>
                            <label>
                                <input type="checkbox" name="published" checked /> Publish
                            </label>
                        <?php endif; ?>
                    </div>
                    <!-- Checkbox for publishing -->
                    <div class="input-group">
                        <button type="submit" name="add-post" class="btn">Post Project</button>
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