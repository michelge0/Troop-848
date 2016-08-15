<?php
require('authenticate.php');
require('database-helper.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="google-signin-client_id" content="251137415595-uttj6cdrkgfahoc0hffe2je2gt29utbo.apps.googleusercontent.com">
<title>Personal Website</title>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap-3.3.6-dist/css/bootstrap-theme.min.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
    <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/style.css" />
    <script src="https://apis.google.com/js/platform.js" async defer></script>
</head>

<body>

<?php require('header.php'); ?>

<div class="content">

    <?php if ($_SESSION['permissions'] >= 1) : ?>
    <div class="row">
        <button class="btn btn-default" data-toggle="modal" data-target="#newBlogModal">New Blog</button>
    </div>
    <?php endif; ?>

    <!-- main content  -->
	<div class="col-sm-9">

        <!-- intro message  -->
        <i style="color: rgb(150, 0, 0)"><strong>Welcome to the homepage. Here you can view the most recent blog posts and events.</strong></i>

        <!-- posts  -->
        <?php
            $blogs = $mysqli->query("SELECT * FROM blogs")->fetch_all(MYSQLI_ASSOC);

            $allposts = [];
            for ($i = 0; $i < count($blogs); $i++) {
            	$blog = $blogs[$i];
            	$blogname = $blog['blogname'];

            	$posts = $mysqli->query("SELECT * FROM `$blogname`");
            	if ($posts) {
            		$posts = $posts->fetch_all(MYSQLI_ASSOC);
            		$allposts = array_merge($allposts, $posts);
            	}
            }

            usort($allposts, function($a, $b) {
            	$adatestring = $a['date'];
            	$adate = date_create_from_format('m/d/Y h:i a', $adatestring);

            	$bdatestring = $b['date'];
            	$bdate = date_create_from_format('m/d/Y h:i a', $bdatestring);

            	if ($adate == $bdate) {
            		return 0;
            	}

            	return $adate < $bdate ? -1 : 1;
            });

            for ($i = 0; $i < count($allposts); $i++) {
            	$post = $allposts[$i];
        	    $title = $post['title'];
                $date = $post['date'];
                $content = $post['content'];
                $author = $post['author'];
                echo "<div class=\"post\">";
                echo "<h2>$title</h2>";
                echo "<h4><i>posted on $date by $author</i></h4>";
                echo "<p>$content</p>";
                echo "</div>";
            }
        ?>
    </div>

    <!-- navbar  -->
	<div class="col-sm-3" id="sidebarScrollSpy">
        <ul class="nav" data-spy="affix" data-offset-top="160">
            <!-- <li> <a href="#"> Test </a></li>
            <li> <a href="#"> test 2 </a></li>  -->
            Navbar TODO
        </ul>
    </div>
</div>

<?php if($_SESSION['permissions'] >= 1) : ?>

<div class="modal fade" id="newBlogModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">New Blog</h4>
      </div>
      <form id="newBlogForm" action="maintenance/new-blog.php" method="POST">
          <div class="modal-body">
            <div class="form-group">
                <label>Blog Name:</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label>Blog Category:</label>
                <select class="form-control" name="category">
                        <option value="scouting">Scouting</option>
                        <option value="adventures">Adventures</option>
                </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-danger">
          </div>
      </form>
    </div>
  </div>
</div>

<?php endif; ?>

</body>
</html>
