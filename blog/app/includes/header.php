  <!-- header -->
  <header class="clearfix">
    <div class="logo">
      <a href="<?php echo BASE_URL . '/index.php' ?>">
        <h1 class="logo-text"><span>FYP</span>Portal</h1>
      </a>
    </div>
    <div class="fa fa-reorder menu-toggle"></div>
    <nav>
      <ul>
        <li><a href="<?php echo BASE_URL . '/index.php' ?>">Home</a></li>
        <li><a href="<?php echo BASE_URL . '/about.php' ?>">About</a></li>
        <!-- <li><a href="<?php echo BASE_URL . '/researchForum.php' ?>">Research Forum</a></li> -->
        <li><a href="<?php echo BASE_URL . '/ideaForum.php' ?>">Idea Forum</a></li>
        <!-- If the user is logged in -->
        <?php if (isset($_SESSION['id'])) : ?>
          <li>
            <a href="#" class="userinfo">
              <i class="fa fa-user"></i>
              <?php echo $_SESSION['username']; ?>
              <i class="fa fa-chevron-down"></i>
            </a>
            <ul class="dropdown">
              <?php if (isset($_SESSION['admin']) && ($_SESSION['admin'] == 1)) : ?>
                <li><a href="<?php echo BASE_URL . '/admin/dashboard.php' ?>">Dashboard</a></li>
              <?php endif; ?>
              <li><a href="<?php echo BASE_URL . '/logout.php' ?>" class="logout">logout</a></li>
            </ul>
          </li>
          <!-- user not logged in -->
        <?php else : ?>
          <li><a href="<?php echo BASE_URL . '/register.php' ?>">Sign Up</a></li>
          <li><a href="<?php echo BASE_URL . '/login.php' ?>">Login</a></li>
        <?php endif; ?>
        <!-- <li><a href="register.php">Sign up</a></li>
        <li>
          <a href="login.php">
            <i class="fa fa-sign-in"></i>
            Login
          </a>
        </li> -->

      </ul>
    </nav>
  </header>
  <!-- // header -->