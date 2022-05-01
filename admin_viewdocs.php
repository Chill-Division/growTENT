<?php
include 'tpl/auth.php';
include 'tpl/sql.php';

$directory_listing = scandir($upload_dir);
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT page template</title>

    <!-- Sets initial viewport load and disables zooming  -->
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">

    <!-- Makes your prototype chrome-less once bookmarked to your phone's home screen -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Include the compiled Ratchet CSS -->
    <link rel="stylesheet" href="ratchet-theme-ios.min.css">
    <link rel="stylesheet" href="ratchet.min.css">
    <link rel="stylesheet" href="app.css">

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

      <h1 class="title">Procedural documents</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align='center'>Here's a list of all the uploaded procedural documents (sorted alphabetically)</p>
<?php if($savesuccess=='true'){ echo "<p class='content-padded'><font color='red'>Saved!</font></p>";} ?>
      <div class="card">
	<ul class="table-view">
<?php
	foreach($directory_listing as $current_file) {
		if($current_file != "." && $current_file != ".." && $current_file != "index.php") {
			echo "  <li class='table-view-cell'>\n<a href='" . $upload_dir . $current_file . "' class='navigate-right' target='_blank'>" . $current_file . "</a></li>";
			}
		}
?>
      </div>
	</ul>
    </div>

  </body>
</html>
