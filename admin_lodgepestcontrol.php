<?php
include 'tpl/auth.php';
include 'tpl/sql.php';

if ((strlen($_POST['submit']) > 1)) {
	$treated_room = filter_var($_POST['treated_room'], FILTER_SANITIZE_STRING);
	$action_taken = filter_var($_POST['action_taken'], FILTER_SANITIZE_STRING);

        $sql="INSERT INTO treatments (room, action_taken) VALUES('$treated_room','$action_taken')";
        if ($result = mysqli_query($con, $sql)) {
          // echo "Returned rows are: " . mysqli_num_rows($result);
        } else {
           echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        //$cultivarid = mysqli_insert_id();
        mysqli_close($con);
        $savesuccess = 'true';
        }
?>


?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT :: Lodge pest control</title>

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

      <h1 class="title">Lodge pest control action</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align='center'>Keep track of all the treatment actions taken for pest control / IPM</p>
	<?php if($savesuccess=='true'){ echo "<p class='content-padded' align='center'><font color='red'>Saved!</font></p>";} ?>
      <div class="card">
	<p>
        <form action='admin_lodgepestcontrol.php' method='post' class='input-group'>
        Choose room the pest control was taken for:<br />
        <select name='treated_room' id='treated_room'>
	<?php foreach($rooms as $currentroom) {
		echo "        <option value='" . $currentroom . "'>" . $currentroom . "</option>";
		} ?>
        </select>
	<br />
	Select the pest-control action taken:<br />
        <select name='action_taken' id='action_taken'>
        <?php foreach($treatments as $currentaction) {
                echo "        <option value='" . $currentaction . "'>" . $currentaction . "</option>";
                } ?>
        </select>


          <button class="btn btn-positive btn-block" type="submit" name="submit" value="save">Submit</button>
        </form>

	</p>
      </div>
    </div>

  </body>
</html>
