<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT :: Start new season</title>

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
  </head>
  <body>

    <!-- Make sure all your bars are the first things in your <body> -->
    <h1 class="title">Sign in to the facility</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align="center">Please enter your details to sign in to the facility</p>
      <div class="card">
	<form action='index.php' method='post'>
         <div class="input-row">
	 <label>Name:</label>
         <input type="text" placeholder="John Smith" id="visitor_name" name="visitor_name">
	 </div>
         <div class="input-row">
	 <label>Contact Phone:</label>
         <input type="number" placeholder="021 123 456" id="visitor_phone" name="visitor_phone">
	 </div>
         <div class="input-row">
         <label>Purpose for visit:</label>
         <input type="text" placeholder="Facility tour" id="visitor_purpose" name="visitor_purpose">
         </div>
         <div class="input-row"> 
         <label>Escorted by:</label>
	 <select name='escorted_by' id='escorted_by'>
	<?php
        foreach($escortingstaff as $currentstaff) {
            echo "<option value='" . $currentstaff . "'>" . $currentstaff . "</option>\n";
        }
?>
	 </select>
	 </div>
	  <button class="btn btn-positive btn-block" type="submit" name="submit" value="submit">Submit details</button>
	</form>
      </div>
    </div>

  </body>
</html>

