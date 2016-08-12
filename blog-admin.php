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

    <script>
        $(document).ready(function() {
            $('#mainModal').on('show.bs.modal', function(e) {
                var changeType = $(e.relatedTarget).data('change-type');
                var blogname = $(e.relatedTarget).data('blogname');

                $('#myModalLabel').html(changeType + " Post");

                // if editing user, then the user's existing info is filled in
                if (changeType === "Edit") {
                    var postData = $(e.relatedTarget).data('post-info');
                    $(e.currentTarget).find('input#postTitle').val(postData[0].title);
                    $(e.currentTarget).find('textarea#postContent').val(postData[0].content);

                    $("form#changeForm").attr('action', 'maintenance/update-post.php?table=' + blogname + '&type=edit&id=' + postData[0].id);

                // if creating a new user, defaults everything to blank
                } else if (changeType === "Add") {
                    $(e.currentTarget).find('input#postTitle').val("");
                    $(e.currentTarget).find('input#postContent').val("");

                    $("form#changeForm").attr('action', 'maintenance/update-post.php?table=' + blogname + '&type=add');
                }
            });

            $('#deleteModal').on('show.bs.modal', function(e) {
                var blogname = $(e.relatedTarget).data('blogname');
                var id = $(e.relatedTarget).data('id');
                $('form#deleteForm').attr('action', 'maintenance/delete-data.php?table=' + blogname + '&id=' + id);
            });
        });
    </script>
</head>

<body>

<?php include('header.php') ?>

<div class="content">
    <?php
        $blogname = $mysqli->query("SELECT * FROM categories WHERE id=$blogid")->fetch_all(MYSQLI_ASSOC)[0]['blogname'];
        $blognameurl = urlencode($blogname);
    ?>
    <!-- new post/blog buttons -->
    <div class="row">
        <button class="btn btn-default" data-toggle="modal" data-target="#mainModal" data-change-type="Add"
            data-blogname=<?php echo "\"$blognameurl\"";?>>New Post</button>
        <button class="btn btn-default">New Blog</button>
    </div>

    <!-- main content / navbar -->
	<div class="col-sm-9">
        
        <?php
            $query = "SELECT * FROM `$blogname`";

            $result = $mysqli->query($query);
            if ($result) {
                while ($article = $result->fetch_assoc()) {
                    $title = $article['title'];
                    $date = $article['date'];
                    $content = $article['content'];
                    $author = $article['author'];
                    $id = $article['id'];
                    echo "<div class=\"post\">";
                    echo "<h2>$title</h2>";
                    echo "<h4><i>posted on $date by $author</i></h4>";
                    echo "<p>$content</p>";
                    echo "<button class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#mainModal\" data-change-type=\"Edit\" data-post-info=\"".htmlspecialchars(json_encode(array($article)), ENT_QUOTES, 'UTF-8')."\" data-blogname=\"$blognameurl\">Edit Post</button>";
                    echo "     ";
                    echo "<button class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#deleteModal\" data-id=\"$id\" data-blogname=\"$blognameurl\">
                        Delete Post</button>";
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

<!-- edit user modal -->
<div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <form id="changeForm" action="maintenance/update-blog.php" method="POST">
          <div class="modal-body">
            <div class="form-group">
                <label for="postTitle">Title:</label>
                <input type="text" class="form-control" id="postTitle" name="title">
            </div>
            <div class="form-group">
                <label for="postContent">Write Post Here:</label>
                <textarea class="form-control" id="postContent" rows="20" name="content"></textarea>
            </div>
            <input type="hidden" name="date" value= <?php
                date_default_timezone_set('America/Chicago');
                $date = date('m/d/Y h:i a');
                echo "\"$date\"";
            ?> />
            <input type="hidden" name="author" value= <?php
                $author = $_SESSION['name'];
                echo "\"$author\"";
            ?> />
            <input type="hidden" name="blogid" value= <?php
                $blogid = $_GET['blogid'];
                echo "\"$blogid\"";
            ?> />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary">
          </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Delete User</h4>
      </div>
      <form id="deleteForm" action="maintenance/delete-post.php" method="POST">
          <div class="modal-body">
            <div class="form-group">
                <p> You're about to delete this post. <strong>To proceed, type the post's title into the field below.</strong></p>
                <input type="text" class="form-control" name="name">
            </div>
            <input type="hidden" name="blogid" value= <?php
                $blogid = $_GET['blogid'];
                echo "\"$blogid\"";
            ?> />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-danger">
          </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="newBlogModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">New Blog</h4>
      </div>
      <form id="newBlogForm" action="maintenance/delete-post.php" method="POST">
          <div class="modal-body">
            <div class="form-group">
                <p> You're about to delete this post. <strong>To proceed, type the post's title into the field below.</strong></p>
                <input type="text" class="form-control" name="title">
            </div>
            <input type="hidden" name="blogid" value= <?php
                $blogid = $_GET['blogid'];
                echo "\"$blogid\"";
            ?> />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-danger">
          </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
