<?php
include 'tpl/auth.php';
include 'tpl/sql.php';

// If we're getting something to upload:
$target_file = $upload_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
/*
// Check if file is an image or not -- Removed because we want to do DOC / PDF etc
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
 // mime check to make sure its actually an image
 if($check !== false) {
    $uploaderror = "File is an image - " . $check['mime'] . ".";
    $uploadOk = 1;
  } else {
    $uploaderror = "File is not an image.";
    $uploadOk = 0;
  } */

	// Check if file already exists
	if (file_exists($target_file)) {
	  $uploaderror = "Sorry, file already exists.";
	  $uploadOk = 0;
	}

	// Check file size (10MB)
	if ($_FILES["fileToUpload"]["size"] > 10000000) {
	  $uploaderror = "Sorry, your file is too large.";
	  $uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx") {
	  $uploaderror = "Sorry, only JPG, JPEG, PNG, GIF, PDF or DOC / DOCX files are allowed.";
	  $uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		// We were doing one overarching error but now we do a single status message
		//  $uploaderror = "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	    $uploaderror = "Success! The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
	  } else {
	    $uploaderror = "Sorry, there was an error uploading your file.";
	  }
	}
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Upload new document</title>

    <!-- Sets initial viewport load and disables zooming  -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">

    <!-- Makes your prototype chrome-less once bookmarked to your phone's home screen -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Include the compiled Ratchet CSS -->
    <link rel="stylesheet" href="ratchet-theme-ios.min.css">
    <link rel="stylesheet" href="ratchet.min.css">
    <link rel="stylesheet" href="app.css">
-
    <!-- Include the compiled Ratchet JS -->
    <!-- <script src="ratchet.js"></script> -->
    <script src="html5-qrcode.min.js"></script>
  </head>
  <body>

    <!-- Make sure all your bars are the first things in your <body> -->
    <header class="bar bar-nav">
     <a href="admin.php"><button class="btn btn-link btn-nav pull-left">
       <span class="icon icon-home"></span>
       Home
     </button></a>

      <h1 class="title">Upload new procedural document</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align='center'>Here you can upload procedural documents for later reference</p>
	<?php if(isset($uploaderror)){ echo "<p class='content-padded' align='center'><font color='red'>" . $uploaderror . "</font></p>";} ?>
      <div class="card">
	<form action="admin_newdoc.php" method="post" enctype="multipart/form-data">
	  Select image / document to upload:  <input type="file" name="fileToUpload" id="fileToUpload"><br /><br />
	  <button class="btn btn-positive btn-block" type="submit" name="submit" value="save">Submit</button>
	</form>
      </div>
      <div class="card">
	<p class="content-padded">Permitted file types are JPG, JPEG, PNG, GIF, PDF or DOC / DOCX.</p>
      </div>
    </div>

  </body>
</html>
