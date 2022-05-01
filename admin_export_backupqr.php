<?php
include 'tpl/auth.php';
include 'tpl/sql.php';

//$backup_file = "backups/" . $dbname . date("Y-m-d-H-i-s") . '.gz';
//$command = "mysqldump --opt -h $dbhost -u $dbuser -p $dbpass ". "$dbname | gzip > $backup_file";
//system($command);

$backup_file = $backup_dir . "qr-" . date("d-m-Y") . ".tar";
//$mime = "application/x-gzip";
//header( "Content-Type: " . $mime );
//header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

$cmd = "tar cf $backup_file qrcodes/";

passthru( $cmd );


?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT :: QR codes backup</title>

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

      <h1 class="title">QR code backups</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align='center'>The QR codes have now been backed up to the server. If you want a local copy, please click the button below</p>
<?php if($savesuccess=='true'){ echo "<p class='content-padded' align='center'><font color='red'>Saved!</font></p>";} ?>
      <div class="card">
	<p><a href="<?php echo $backup_file; ?>"><button class="btn btn-positive btn-block">Download QR codes backup</button></a></p>
      </div>
    </div>

  </body>
</html>
