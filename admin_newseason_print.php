<?php
include 'tpl/auth.php';
include 'tpl/sql.php';
require_once 'phpqrcode.php';

if ((strlen($_POST['submit']) > 1) && (strlen($_POST['newplants']) > 0)) {
	// We define newplants as a low number as a fallback in case of issues
	$newplants = 1;

	// Pull the details from the submitted form
	$cultivarid = filter_var($_POST['cultivar'], FILTER_SANITIZE_STRING);
        $cultivar = filter_var($_POST['cultivar'], FILTER_SANITIZE_STRING);
	$facilityid = filter_var($_POST['facility'], FILTER_SANITIZE_STRING);
	$newplants = filter_var($_POST['newplants'], FILTER_SANITIZE_STRING);
	$seasonid = filter_var($_POST['seasonid'], FILTER_SANITIZE_STRING);

	// Before we go any further, we want to get the cultivar human readable name
        /*$sql = "SELECT * FROM cultivars where id='$cultivarid'";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$cultivarname = $row[0]['cultivar_name'];*/
	$cultivarname = filter_var($_POST['cultivar'], FILTER_SANITIZE_STRING);
        //echo "<br />\n";
	//echo $cultivarname;
	//print_r($row);
	//echo "<br />\n";

	// And the facility
        $sql = "SELECT * FROM facilities where id='$facilityid'";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$facilityname = $row[0]['facilityname'];
        //echo "<br />\n";
        //echo $facilityname;
        //print_r($row);
        echo "<br />\n";

	if ($newplants > 500) { $newplants = 10; }

	// variables needed for the inserts
	$date = date('Y-m-d');
	$current_row_for_insert = 0;
	$current_row_on_page = 0;
	while ($current_row_for_insert < $newplants) {
		// Make a UniqueID for the plant
		$plant_uniqueid = uniqid('p', true);

		// Now we make a QR Code for it
		$fileName = $plant_uniqueid . ".png";
		$pngAbsoluteFilePath = 'qrcodes/' . $fileName;
		if (!file_exists($pngAbsoluteFilePath)) {
		        QRcode::png($plant_uniqueid, $pngAbsoluteFilePath, QR_ECLEVEL_L, 4, 2);
		//echo 'File generated!';
		} else {
		//echo 'File already generated! We can use this cached file to speed up site on common codes!';
		}


		// Increase plant #
		$current_row_for_insert++;
		$current_row_on_page++;

		$sql="INSERT INTO inventory (date_of_spawn, plant_uniqueid, season_id, plant_num, where_is_it_now, current_state, cultivar, mother_uniqueid) VALUES ('$date','$plant_uniqueid',$seasonid,'$current_row_for_insert','Nursery','In the early life stages','$cultivarname', 'Seed')";
		//if (mysqli_query($conn, $sql)) {
	        if ($result = mysqli_query($con, $sql)) {

		//  echo "New record created successfully";
		// So now we can make the label
		// For that we're going to want a table
		echo "<table style='font-family: monospace; padding: 0;'>
  <tr>
    <td rowspan='5'><img src='" . $pngAbsoluteFilePath . "' width='80' height='80' /></td>
    <td>Plant #" . $current_row_for_insert . "</td>
    <td style='padding-left: 30px; padding-right: 30px'> | </td>
    <td rowspan='5'><img src='" . $pngAbsoluteFilePath . "' width='80' height='80' /></td>
    <td>Plant #" . $current_row_for_insert . "</td>
  </tr>
  <tr>
    <td>Clone date: " . $date . "</td>
    <td style='padding-left: 30px; padding-right: 30px'> | </td>
    <td>Clone date: " . $date . "</td>  </tr>
  <tr>
    <td>" . $cultivarname . "</td>
    <td style='padding-left: 30px; padding-right: 30px'> | </td>
    <td>" . $cultivarname . "</td>
  </tr>
  <tr>
    <td>" . $plant_uniqueid . "</td>
    <td style='padding-left: 30px; padding-right: 30px'> | </td>
    <td>" . $plant_uniqueid . "</td>
  </tr>
</table><hr />";
//		echo $current_row_on_page . "<br />";
		if (($current_row_on_page / 10) == 1) {
		// We have 7 so now we pagebreak
			echo "<p style='page-break-after: always;'>&nbsp;</p>";
			$current_row_on_page = 0;
			}
		} else {
		  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

	}
	$savesuccess = 'true';
}
?>
