<?php
include 'tpl/auth.php';
include 'tpl/sql.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT :: Shipping manifests</title>

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

      <h1 class="title">Generate a shipping manifest</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align='center'>Create a shipping manifest for cannabis biomass</p>
<?php if($savesuccess=='true'){ echo "<p class='content-padded' align='center'><font color='red'>Saved!</font></p>";} ?>
      <div class="card">
        <form action='admin_create_manifest.php' method='post' class='input-group'>
         <div class="input-row">
          <label>Name of staff preparing shipment: </label>
          <input type="text" placeholder="John Doe" name="name_of_preparer" value="">
         </div>
         <div class="input-row">
          <label>Email address for notification: </label>
          <input type="text" placeholder="user@skyman.co.nz" name="email" value="">
         </div>
         <div class="input-row">
          <label>Product type: </label>
	  <select name='product_type' id='product_type' style="margin-top: 3px; margin-bottom: 3px; float: left; width: 63%; margin-right: 10px;">
	  <option value='dry_flower'>Dry flower</option>
	  <option value='plants'>Plants</option>
	  <option value='cuttings'>Cuttings</option>
	  </select>
         </div>
         <div class="input-row">
          <label>Number of bags /containers: </label>
          <input type="text" placeholder="5" name="number_being_shipped" value="">
         </div>
         <div class="input-row">
          <label>Total shipment weight excl packaging: </label>
          <input type="text" placeholder="Weight in grams or KG (number only)" name="total_weight" value="">
         </div>
         <div class="input-row">
          <label>Total shipment weight incl packaging: </label>
          <input type="text" placeholder="Weight in grams or KG (number only)" name="total_weight_incl_packaging" value="">
         </div>
         <div class="input-row">
          <label>Recipient Name / Company: </label>
          <input type="text" placeholder="John Doe" name="recipient_name" value="">
         </div>
         <div class="input-row">
          <label>Destination address: </label>
          <textarea name="destination_address" id="destination_address" maxlength="2048" rows="3"></textarea>
         </div>
         <div class="input-row">
          <label>Collected from facility by: </label>
          <input type="text" placeholder="Courier name or Staff name" name="collected_by" value="">
         </div>
        <br /><button class="btn btn-positive btn-block" type="submit" name="createmanifest" value="createmanifest">Create manifest</button>
	</form>
    </div>

  </body>
</html>
