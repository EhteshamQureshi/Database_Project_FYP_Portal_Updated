<?php include("path.php"); ?>
<?php include(ROOT_PATH . '/app/controllers/user_ideas.php');

if (isset($_GET['id'])) {
    // echo 'This is id = = ' . $_GET['id'];
    $idea = selectOne('ideas', ['id' => $_GET['id']]);
    // dd($post);
}
$popularProjects = selectAll('projects', ['published' => 1]);
$topics = selectAll('topics');
// dd($popularProjects);
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
    <link rel="stylesheet" href="assets/css/style.css">

    <title> <?php if (isset($idea)) {
                echo $idea['title'];
            } else {
                echo "FYP Web Portal | Idea Section";
            } ?></title>
</head>

<body>

    <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
    <!-- Page wrapper -->
    <div class="page-wrapper">



        <!-- // Posts Slider -->
        <!-- content -->
        <div class="content clearfix">
            <div class="page-content">


                <?php foreach ($ideas as $idea) : ?>
                    <div class="post clearfix">

                        <div class="post-content">
                            <h2 class="post-title"><a href="single.php?idea_id=<?php echo $idea['id']; ?>"><?php echo $idea['title']; ?></a></h2>
                            <div class="post-info">
                                <i class="fa fa-user-o"></i> <?php echo $idea['user_id']; ?>
                                &nbsp;
                                <i class="fa fa-calendar"></i> <?php echo date('F j,Y', strtotime($idea['created_at'])); ?>
                                <br>
                                <!-- <i class="fa fa-university" aria-hidden="true"></i><?php echo $idea['name']; ?> idea is not related to any institute-->
                            </div>
                            <p class="post-body"><?php echo html_entity_decode(substr($idea['body'], 0, 150) . '...'); ?>
                            </p>
                            <a href="single.php?idea_id=<?php echo $idea['id']; ?>" class="read-more">Read More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="sidebar">
                <!-- Add IDEA -->
                <div class="search-div">
                    <?php if (isset($_SESSION['id'])) { ?>
                        <button class="text-input" style="background-color: #008489; color: white;"><a href="/FYP_Portal_Updated/blog/users/ideas/create.php"> Add your IDEA</a></button>
                    <?php  } else { ?>
                        <button class="text-input" style="background-color: #008489; color: white;"><a href="/FYP_Portal_Updated/blog/register.php"> Add your IDEA</a></button>
                    <?php } ?>

                </div>
                <!-- Search -->
                <div class="search-div">
                    <!-- This is our search form -->
                    <!-- From does not need a search button we just need to press the enter -->
                    <form action="index.php" method="post">
                        <input type="text" name="search-term" class="text-input" placeholder="Search...">
                    </form>
                </div>
                <!-- // Search -->

                <!-- topics -->
                <div class="section topics">
                    <h2>Domains</h2>
                    <ul>
                        <!--Using loop to show the topics fetched from database  -->
                        <?php foreach ($topics as $key => $topic) : ?>
                            <a href="<?php echo BASE_URL . '/index.php?t_id=' . $topic['id'] . '&name=' . $topic['name']; ?>">
                                <li> <?php echo $topic['name']; ?></li>
                            </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- // topics -->
                <!-- Institutes section with same topic styling-->
                <div class="section topics">
                    <h2>Institutes</h2>
                    <ul>
                        <!--Using loop to show the Institutes fetched from database  -->
                        <?php foreach ($institutes as $key => $institute) : ?>
                            <a href="<?php echo BASE_URL . '/index.php?i_id=' . $institutes['id'] . '&name=' . $institute['name']; ?>">
                                <li> <?php echo $institute['name']; ?></li>
                            </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- // Institutes -->

            </div>
        </div>
        <!-- // content -->

    </div>
    <!-- // page wrapper -->

    <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Slick JS -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script src="assets/js/scripts.js"></script>

</body>

</html>