
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Troop 848</title>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap-3.3.6-dist/css/bootstrap-theme.min.css" rel="stylesheet" />
    <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/landing.css" />
</head>

<body>

<form id="changeForm" action="/update-post.php" enctype="multipart/form-data" method="POST">
    <div class="modal-body">
    <div class="form-group">
        <label for="postTitle">Title:</label>
        <input type="text" class="form-control" id="postTitle" name="title">
    </div>
    <div class="form-group">
        <label for="postContent">Write Post Here:</label>
        <textarea class="form-control" id="postContent" rows="20" name="content"></textarea>
    </div>
    <!-- <div class="form-group">
      <label>Upload image (optional):</label>
      <input type="file" name="imageUpload" id="imageUpload">
    </div> -->
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
    <input type="submit" class="btn btn-primary">
</form>

</body>

</html>
