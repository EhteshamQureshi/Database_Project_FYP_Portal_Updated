<?php include("path.php"); ?>
<?php include(ROOT_PATH . '/app/controllers/user_ideas.php');

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

</head>

<body>

    <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>
    <!-- Page wrapper -->
    <div class="page-wrapper" style="margin-left: 50px;">
        <h1>1. INTRODUCTION</h1>
        <p>The FYP tracer system is a web portal, which is implemented to gather all the information about final year
            projects. It stores all the records of projects of different universities or organizations.

            It provides number of features such as smart search, software competition, innovation (unique idea), sharing of
            idea and discussion along with consultancy. This website provides user friendly interface and proper search
            facility for user.
        </p>
        <br>
        <h3>It provides number of features such as:</h3>
        <ul>
            <li>smart search</li>
            <li>innovation (unique idea)</li>
            <li>software competition</li>
            <li>sharing of idea and discussion along with consultancy</li>
        </ul>
        <br>
        <strong>This website provides user friendly interface and proper search facility for user.</strong>
        <p>There is a single platform to get all the information about previous project and their domains in which they are
            working and which tools to used.</p>
        <h1>Features of This Web Portal</h1>
        <ul>
            <li>Secure registration of all the users.</li>
            <li>Complete search for previous and current year projects on which students worked or working on domain,
                session and tools.</li>
            <li>To provide all the records of final year projects in centralized database which help to provide
                transparency in the work.</li>
        </ul>

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