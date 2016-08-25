<?php
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
<form action="helper/file-upload-backend.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="imageUpload" id="imageUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
</div>

</body>
</html>
