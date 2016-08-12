<?php
session_start();
require('database-helper.php');

if (isset($_GET['blogid'])) {
    $blogid = $_GET['blogid'];
} else {
    // redirect to error page
    die("Wrong id in query string.");
}

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

<?php include('header.php') ?>

<div class="content">
	<div class="col-sm-9">
        <?php
            $blogname = $mysqli->query("SELECT * FROM categories WHERE id=$blogid")->fetch_all(MYSQLI_ASSOC)[0]['blogname'];

            $query = "SELECT * FROM `$blogname`";
            $result = $mysqli->query($query);
            if ($result) {
                while ($article = $result->fetch_assoc()) {
                    $title = $article['title'];
                    $date = $article['date'];
                    $content = $article['content'];
                    $author = $article['author'];
                    echo "<div class=\"post\">";
                    echo "<h2>$title</h2>";
                    echo "<h4><i>posted on $date by $author</i></h4>";
                    echo "<p>$content</p>";
                    echo "</div>";
                }
            } else {
                echo "<h2> No articles yet! </h2>";
            }
        ?>
    </div>
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
