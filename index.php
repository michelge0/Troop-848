<?php
require('helper/authenticate.php');
require('helper/database-helper.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php require('helper/imports.php'); ?>
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
	<div>

        <!-- intro message  -->
        <i style="color: rgb(150, 0, 0)"><strong>Welcome to the homepage. Here you can view the most recent blog posts.</strong></i>

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
