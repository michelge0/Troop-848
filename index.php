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

    <!-- main content  -->
	<div class="col-sm-9">

        <!-- intro message  -->
        <i style="color: rgb(150, 0, 0)"><strong>Welcome to the homepage. Here you can view the most recent blog posts and events. Admins: you can't modify anything here. To delete or edit a post, visit the blog that the post belongs to.</strong></i>

        <!-- posts  -->
        <?php
            $blogs = $mysqli->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);

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

</body>
</html>
