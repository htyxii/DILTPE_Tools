<?php
$fromInput = $_GET['fromInput'];
$toInput = $_GET['toInput'];
?>

<!doctype html>
<html lang="en">

<head>

  <?php require_once('../../head.php'); ?>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">

  <style> 
			@media print { 
			.noprint { 
        display: none; 
			} 
			} 
		</style> 

</head>

<body>

  <!-- <div class="m-5 text-center">
    <h3>Framework - Picking List</h1>
  </div> -->

  <!-- <form class="my-5" method="get" name="form" action="getStatus.php">
    <div class="row g-3 justify-content-center align-items-center m-3">
      <div class="col-auto">
        <label for="fromInput" class="col-form-label fw-bold">Trans.From:</label>
      </div>
      <div class="col-auto">
        <input type="text" id="fromInput" class="form-control" name="fromInput" value="<?php echo $fromInput ?>" aria-describedby="passwordHelpInline">
      </div>
      <div class="col-auto">
        <label for="toInput" class="col-form-label fw-bold">Trans.To:</label>
      </div>
      <div class="col-auto">
        <input type="text" id="toInput" class="form-control" name="toInput" value="<?php echo $toInput ?>" aria-describedby="passwordHelpInline">
      </div>
      <div class="col-auto">
        <input type="submit" value="Generate" id="generateBtn" class="btn btn-primary"> -->
  <!-- not using -->
  <!-- <button type="button" name="save" class="btn btn-success ml-2  disabled" id="download"><i class="bi bi-file-pdf-fill"></i>Fix It!</button> -->
  <!-- </div>
      <div class="col-auto">
        <button type="button" id="toExcel" class="btn btn-success">Download</button> -->
  <!-- not using -->
  <!-- <button type="button" name="save" class="btn btn-success ml-2  disabled" id="download"><i class="bi bi-file-pdf-fill"></i>Fix It!</button> -->
  <!-- </div>
    </div>
  </form> -->



  <?php
  require_once("database.php");

  date_default_timezone_set("Asia/Taipei");
  $getDate = date("F j, Y, g:i a");

  $query = "SELECT DISTINCT HD.DocNo AS [DN], HD.Extra1 AS [Name], HD.Extra4 AS [Phone], HD.TransNo AS [TransNo], HD.Extra9 AS [Country] FROM WMTransDT DT
	  LEFT JOIN WMTransHD HD ON HD.ID = DT.TransHDID
	  OUTER APPLY (SELECT TOP 1 * FROM WMTransWH WHERE WMTransWH.CartonID = DT.ItemCode AND WMTransWH.AvailableQTY > 0 ORDER BY WMTransWH.ID) AS WH
	  LEFT JOIN WMLocation ON WMLocation.ID = WH.LocationID
	  LEFT JOIN WMItemMaster IM ON IM.ItemCode = DT.ItemCode
	  WHERE DT.ProjectID = 100 AND HD.MoveType = 'GI' AND HD.TransStatus = 'Planning' AND HD.TransNo BETWEEN '$fromInput' AND '$toInput'
	  ORDER BY HD.TransNo";

  $options = array('ReturnDatesAsStrings' => true);
  $query_run = sqlsrv_query($conn, $query, null, $options);
  if ($query_run === false) {
    echo "Error (sqlsrv_query): " . print_r(sqlsrv_errors(), true);
    exit;
  }

  while ($row = sqlsrv_fetch_array($query_run, SQLSRV_FETCH_ASSOC)) {

  ?>

    <div class="m-0 px-1" style="page-break-after:always; width:300px;">

    <div class="col-auto">
        <p style="font-size: 14px; align: left;" class="m-0 p-0"><?php echo $row['Country'] ?></p>
 
        </div>
        <div class="col-auto">
          <span class="px-4 m-0" style="color: #000000;font-family:'Libre Barcode 39 Text';font-size: 34px; vertical-align:bottom;">*<?php echo $row['DN'] ?>*</span>
        </div>

    </div>
  <?php
  }
  ?>




  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <script src="./Script/scripts.js"></script>

</body>

</html>