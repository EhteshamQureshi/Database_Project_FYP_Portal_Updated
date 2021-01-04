<?php include("path.php"); ?>
<?php include(ROOT_PATH . '/app/controllers/posts.php');

if (isset($_GET['id'])) {
  // echo 'This is id = = ' . $_GET['id'];
  $post = selectOne('projects', ['id' => $_GET['id']]);
  // dd($post);
}
if (isset($_GET['idea_id'])) {
  // echo 'This is id = = ' . $_GET['id'];
  $idea = selectOne('ideas', ['id' => $_GET['idea_id']]);
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

  <title><?php if (isset($_GET['idea_id'])) {
            echo $idea['title'];
          } else if (isset($_GET['id'])) {
            echo $post['title'];
          } ?> FYP Web Portal</title>
</head>

<body>

  <div id="fb-root"></div>
  <script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src =
        'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2&appId=285071545181837&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    //for liking post
    function likePost() {

      var request = new XMLHttpRequest();
      request.open("POST", "controller/likepost.php");
      // Retrieving the form data
      var formData = new FormData();
      formData.set("likeValue", likeValue);

      formData.set("user_id", "<?php echo $_SESSION["id"]; ?>");
      formData.set("ideaid", "<?php echo $_GET["idea_id"]; ?>");

      request.send(formData);
      request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
          var response = this.responseText;
          console.log("LikeValue = " + response);
          // document.getElementById('classRemainingTime').value = response;
        }
      };
    }

    //for commenting post
    function commentPost() {

      var commentValue = document.getElementById('commentValue');

      var request = new XMLHttpRequest();
      request.open("POST", "controller/commentpost.php");
      // Retrieving the form data
      var formData = new FormData();
      formData.set("commentValue", commentValue.value);

      formData.set("user_id", "<?php echo $_SESSION["id"]; ?>");
      formData.set("ideaid", "<?php echo $_GET["idea_id"]; ?>");
      request.send(formData);
      request.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
          var response = this.responseText;
          console.log("Comment = " + response);
          // document.getElementById('classRemainingTime').value = response;

        }
      };
    }
  </script>

  <?php include(ROOT_PATH . "/app/includes/header.php"); ?>

  <!-- Page wrapper -->
  <div class="page-wrapper">

    <!-- content -->
    <div class="content clearfix">
      <div class="page-content single">
        <h2 style="text-align: center;"><?php
                                        if (isset($_GET['idea_id'])) {
                                          echo $idea['title'];
                                        } else if (isset($_GET['id'])) {
                                          echo $post['title'];
                                        } ?></h2>
        <br>
        <?php
        if (isset($_GET['idea_id'])) {
          echo html_entity_decode($idea['body']);
        } else if (isset($_GET['id'])) {
          echo html_entity_decode($post['body']);
        } ?>

        <div style="display: flex; align-items: center; justify-content: center;">
          <img src="assets/svg/like.svg" width="20px" style="cursor: pointer; margin-right: 10px !important;" onclick="
            
            if(likeValue == 0){
              likeValue = 1;
            }else{
              likeValue = 0;
            }

            likePost();">
          <!-- <form method="POST"> -->
          <input type="text" name="comment" id="commentValue" placeholder="Comment here" style="margin-right: 10px;">
          <input type="button" name="btn-comment" id="btn-comment" value="Submit Comment" onclick="commentPost();">
          <!-- </form> -->
        </div>
      </div>

      <div class="sidebar single">
        <!-- fb page -->
        <div class="fb-page" data-href="https://www.facebook.com/Piece-of-Advice-1055745464557488/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
          <blockquote cite="https://www.facebook.com/Piece-of-Advice-1055745464557488/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Piece-of-Advice-1055745464557488/">Piece of Advice</a></blockquote>
        </div>
        <!-- // fb page -->

        <!-- Popular Posts -->
        <div class="section popular">
          <h2>Popular Projects</h2>
          <?php foreach ($popularProjects as $project) : ?>
            <div class="post clearfix">
              <img src="<?php echo BASE_URL . '/assets/images/' . $project['image']; ?>">

              <a href="single.php?id=<?php echo $project['id']; ?>"><?php echo $project['title']; ?></a>
            </div>
          <?php endforeach; ?>
        </div>
        <!-- // Popular Posts -->

        <!-- topics -->
        <div class="section topics">
          <h2>Topics</h2>
          <ul>
            <?php foreach ($topics as $topic) : ?>
              <a href="<?php echo BASE_URL . '/index.php?t_id=' . $topic['id'] . '&name=' . $topic['name']; ?>;">
                <li><?php echo $topic['name']; ?></li>
              </a>
            <?php endforeach; ?>
          </ul>
        </div>
        <!-- // topics -->

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