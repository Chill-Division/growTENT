<?php
include 'tpl/auth.php';
include 'tpl/sql.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>growTENT :: Admin Portal</title>

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
    <header class="bar bar-nav">
     <a href="login.php?logout=true"><button class="btn btn-link btn-nav pull-left">
       <span class="icon icon-left-nav"></span>
       Log out
     </button></a>

      <h1 class="title">growTENT - Tracking Everything Non-Trivial</h1>
    </header>

    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
    <div class="content">
      <p class="content-padded" align="center">Skyman Industries seed to sale medicinal cannabis tracker &amp; record book</p>
      <p class="content-padded" align="center">Demo stock: 10 flowers, 10 vege, 5 seedlings, 10 seeds, 25lb drying, 12lb cured (Soon to be just plants).</p>
      <div class="card">
        <ul class="table-view">
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_scanplant.php">
              <strong>Scan plant</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_moveplant.php">
              <strong>Move plants between areas</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_nutrients.php">
              <strong>Lodge nutrient dosing</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_relabel.php">
              <strong># Re-create label</strong>
            </a>
          </li>
          <li class="table-view-divider"></li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_discrepancy.php">
              <strong># Lodge discrepancy</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_harvest.php">
              <strong># Harvest plant</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_updateplant.php">
              <strong># Perform other plant status update</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_lodgepestcontrol.php">
              <strong>Lodge pest control action</strong>
            </a>
          </li>
          <li class="table-view-divider"></li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_inventory.php">
              <strong>View current inventory</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_reporting.php">
              <strong># View historical plants</strong>
            </a>
          </li>
          <li class="table-view-divider"></li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_manifest.php">
              <strong># Generate shipping manifest</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_recall.php">
              <strong># Initiate recall</strong>
            </a>
          </li>
	  <li class="table-view-divider"></li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_addcultivar.php">
              <strong>Add new cultivar</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_addstarters.php">
              <strong># Add new seeds / mothers to stock</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_newseason.php">
              <strong>Start new season</strong>
            </a>
          </li>
          <li class="table-view-divider"></li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_newfacility.php">
              <strong>Set up new facility</strong>
            </a>
          </li>
          <li class="table-view-divider"></li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_lodgedailysecuritycheck.php">
              <strong># Lodge daily security check</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_lodge3mosecurityaudit.php">
              <strong># Lodge quarterly security audit</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_lodgecalibration.php">
              <strong># Lodge monthly sensor calibration</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_stocktake.php">
              <strong># Lodge annual stocktake</strong>
            </a>
          </li>
          <li class="table-view-divider"></li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_newdoc.php">
              <strong>Add procedural document</strong>
            </a>
          </li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_viewdocs.php">
              <strong>Review procedural documents</strong>
            </a>
          </li>
          <li class="table-view-divider"></li>
          <li class="table-view-cell">
            <a class="navigate-right" href="admin_export.php">
              <strong>Export / backups</strong>
            </a>
          </li>
        </ul>
      </div>
    </div>

  </body>
</html>
