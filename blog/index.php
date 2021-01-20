<?php include("path.php");
// include(ROOT_PATH . "/app/database/db.php"); already included in topics.php
include(ROOT_PATH . "/app/controllers/topics.php");
// include(ROOT_PATH . "/app/controllers/institutes.php");


// $posts = selectAll('projects', ['published' => 1]); //fetching projects from database 
// Modifying the above query to get username from tables
// $posts = getPublishedPosts();
$postTitle = 'Recent Projects';
// dd($posts);
if (isset($_GET['t_id'])) {
  $posts = getProjectsByTopicID($_GET['t_id']);
  $postTitle = "You searched for projects under '" . $_GET['name'] . "'"; //changing the title of page when click on specific topic
} else if (isset($_POST['search-term'])) {
  $posts = searchPosts($_POST['search-term']);
  $postTitle = "You searched for '" . $_POST['search-term'] . "'"; //changing the title of page when user search
} // When institute is clicked
else if (isset($_GET['i_id'])) {
  $posts = getProjectsByInstituteID($_GET['i_id']);
  $postTitle = "You searched for projects under '" . $_GET['name'] . "'"; //changing the title of page when click on specific topic
  // dd($posts);
} else {
  $posts = getPublishedPosts();
  // dd($posts);
}
// When institute is clicked
// if (isset($_GET['i_id'])) {
//   $posts = getProjectsByInstituteID($_GET['i_id']);
//   $postTitle = "You searched for projects under '" . $_GET['name'] . "'"; //changing the title of page when click on specific topic
// } else if (isset($_POST['search-term'])) {
//   $posts = searchPosts($_POST['search-term']);
//   $postTitle = "You searched for '" . $_POST['search-term'] . "'"; //changing the title of page when user search
// } else {
//   // Error after adding the name of institute
//   $posts = getPublishedPosts();
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Custom Styles -->
  <link rel="stylesheet" href="assets/css/style.css">

  <title>FYPPortal Web</title>
</head>

<body>

  <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
  <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
  <!-- Page wrapper -->
  <div class="page-wrapper">

    <!-- Posts Slider -->
    <div class="posts-slider">
      <h1 class="slider-title">Trending Projects</h1>
      <i class="fa fa-chevron-right next"></i>
      <i class="fa fa-chevron-left prev"></i>

      <div class="posts-wrapper">
        <!-- Post -->
        <?php foreach ($posts as $post) : ?>
          <div class="post">
            <div class="inner-post">
              <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" alt="" style="height: 200px; width: 100%; border-top-left-radius: 5px; border-top-right-radius: 5px;">
              <div class="post-info">
                <h4><a href="single.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h4>
                <div>
                  <i class="fa fa-user-o"></i> <?php echo $post['username']; ?>
                  &nbsp;
                  <i class="fa fa-calendar"></i> <?php echo date('F j,Y', strtotime($post['created_at'])); ?>
                  <br>
                  <i class="fa fa-university" aria-hidden="true"></i> <?php echo $post['name']; ?>

                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>

    <!-- // Posts Slider -->
    <!-- content -->
    <div class="content clearfix">
      <div class="page-content">
        <h1 class="recent-posts-title"><?php echo $postTitle; ?></h1>

        <?php foreach ($posts as $post) : ?>
          <div class="post clearfix">
            <img src="<?php echo BASE_URL . '/assets/images/' . $post['image']; ?>" class="post-image" alt="">
            <div class="post-content">
              <h2 class="post-title"><a href="single.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h2>
              <div class="post-info">
                <i class="fa fa-user-o"></i> <?php echo $post['username']; ?>
                &nbsp;
                <i class="fa fa-calendar"></i> <?php echo date('F j,Y', strtotime($post['created_at'])); ?>
                <br>
                <i class="fa fa-university" aria-hidden="true"></i><?php echo $post['name']; ?>
              </div>
              <p class="post-body"><?php echo html_entity_decode(substr($post['body'], 0, 150) . '...'); ?>
              </p>
              <a href="single.php?id=<?php echo $post['id']; ?>" class="read-more">Read More</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="sidebar">
        <!-- Search -->
        <div class="search-div">

          <!-- This is our search form 
          From does not need a search button we just need to press the enter -->
          <?php if (isset($_SESSION['id'])) { ?>
            <button class="text-input" style="background-color: #008489; color: white"><a href="/FYP_Portal_Updated/blog/users/posts/create.php"> Add your Project</a></button>
          <?php  } else { ?>
            <button class="text-input" style="background-color: #008489; color: white"><a href="/FYP_Portal_Updated/blog/register.php"> Add your Project</a></button>
          <?php } ?>
          <!-- </form> -->
        </div>
        <!-- // Search -->
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
              <a href="<?php echo BASE_URL . '/index.php?i_id=' . $institute['id'] . '&name=' . $institute['name']; ?>">
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