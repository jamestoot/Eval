<nav class="top-bar" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <h1><a href="<?=$strLocation?>admin/">Puckstoppers Admin</a></h1>
    </li>
    <?
    if(!empty($_SESSION['AdminUser'])){
    ?>
    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
    <?
    }
    ?>
  </ul>
  <?
  if(!empty($_SESSION['AdminUser'])){
  ?>
  <section class="top-bar-section">

    <!-- Left Nav Section -->
    <ul class="left">
      <li><a href="add_eval.php">Create an Evaluation</a></li>
      <li><a href="add_comments.php">Add General Comment</a></li>
    </ul>
    
    <!-- Right Nav Section -->
    <ul class="right">
      <li class="has-dropdown active">
        <a>Admin Options</a>
        <ul class="dropdown">
          <li><a href="<?=$strLocation?>admin/logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>
    
  </section>
  <?
  }
  ?>
</nav>