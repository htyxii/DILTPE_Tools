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

  $query = "SELECT DISTINCT HD.DocNo AS [DN], HD.Extra1 AS [Name], HD.Extra4 AS [Phone], HD.TransNo AS [TransNo] FROM WMTransDT DT
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

    <div class="border m-3 p-3" style="page-break-after:always">
      <div class="row justify-content-between">
        <div class="col-3">

          <div class="d-flex justify-content-between border-bottom">
            <div>PO</div>
            <div><?php echo $row['DN'] ?></div>
          </div>
          <div class="d-flex justify-content-between border-bottom">
            <div>Customer PO</div>
            <div>-</div>
          </div>
          <div class="d-flex justify-content-between border-bottom">
            <div>DeliveryParty</div>
            <div><?php echo $row['Name'] ?></div>
          </div>
          <div class="d-flex justify-content-between border-bottom">
            <div>ContactPhone</div>
            <div><?php echo $row['Phone'] ?></div>
          </div>
          <div class="d-flex justify-content-between border-bottom">
            <div>ContactEmail</div>
            <div>-</div>
          </div>
          <div class="d-flex justify-content-between border-bottom">
            <div>TransNo</div>
            <div><?php echo $row['TransNo'] ?></div>
          </div>

        </div>

        <div class="col-3 text-center align-items-center">
          <p style="font-family:'Libre Barcode 39 Text';font-size: 3em;">*<?php echo $row['DN'] ?>*</p>
        </div>

        <div class="col-6">

          <table class="table table-bordered h-100">
            <thead>
              <tr>
                <th class="col-1" scope="col">併單張數</th>
                <th class="col-1" scope="col">倂單 (CS)</th>
                <th class="col-1" scope="col">倂貨 (倉管)</th>
                <th class="col-1" scope="col">複驗貨 (倉管)</th>
                <th class="col-1" scope="col">出貨查核 (CS)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row"></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
          </table>
        </div>
      </div>

      <table class="table table-bordered mt-3">
        <thead>
          <tr>
            <th scope="col">Item Code</th>
            <th scope="col">Location</th>
            <th scope="col">Location-2</th>
            <th scope="col">Location-3</th>
            <th scope="col">Description</th>
            <th scope="col">Quantity</th>
          </tr>
        </thead>
        <tbody id="<?php echo $row['DN'] ?>">
        </tbody>
        <tfoot>
          <tr>

            <td colspan="4">Created Time: <?php echo $getDate ?></td>
          </tr>
        </tfoot>
      </table>
    </div>
  <?php
  }
  ?>



  <!-- List -->
  <?php
  require_once("database.php");

  date_default_timezone_set("Asia/Taipei");
  $getDate = date("F j, Y, g:i a");

  $query = "SELECT HD.DocNo AS [DN], HD.Extra1 AS [Name], HD.Extra4 AS [Phone], HD.TransNo AS [TransNo], DT.ItemCode AS [ItemCode], WMLocation.LocationCode AS [Location], WH2.LocationCode AS [Location2], WH3.LocationCode AS [Location3], IM.ItemDesc AS [ItemDesc], DT.OrderQTY [Qty] FROM WMTransDT DT
  LEFT JOIN WMTransHD HD ON HD.ID = DT.TransHDID
  OUTER APPLY (SELECT TOP 1 * FROM WMTransWH WHERE WMTransWH.CartonID = DT.ItemCode AND WMTransWH.AvailableQTY > 0 ORDER BY WMTransWH.ID) AS WH
  LEFT JOIN WMLocation ON WMLocation.ID = WH.LocationID
  LEFT JOIN WMItemMaster IM ON IM.ItemCode = DT.ItemCode

  OUTER APPLY (SELECT CartonID, LocationCode, SUM(QTY) AS [QTY], CONVERT(varchar,CreatedDT,23) AS [CreatedDT] FROM WMTransWH
    LEFT JOIN WMLocation ON WMLocation.ID = WMTransWH.LocationID
    WHERE WMTransWH.CartonID = DT.ItemCode AND WMTransWH.AvailableQTY > 0
    GROUP BY CartonID, LocationCode, CONVERT(varchar,CreatedDT,23)
    ORDER BY CONVERT(varchar,WMTransWH.CreatedDT,23)
    OFFSET 1 ROWS
    FETCH NEXT 1 ROWS ONLY
    ) AS WH2

  OUTER APPLY (SELECT CartonID, LocationCode, SUM(QTY) AS [QTY], CONVERT(varchar,CreatedDT,23) AS [CreatedDT] FROM WMTransWH
    LEFT JOIN WMLocation ON WMLocation.ID = WMTransWH.LocationID
    WHERE WMTransWH.CartonID = DT.ItemCode AND WMTransWH.AvailableQTY > 0
    GROUP BY CartonID, LocationCode, CONVERT(varchar,CreatedDT,23)
    ORDER BY CONVERT(varchar,WMTransWH.CreatedDT,23)
    OFFSET 2 ROWS
    FETCH NEXT 1 ROWS ONLY
    ) AS WH3

  WHERE DT.ProjectID = 100 AND HD.MoveType = 'GI' AND HD.TransStatus = 'Planning' AND HD.TransNo BETWEEN '$fromInput' AND '$toInput'
  GROUP BY DT.ItemCode, WMLocation.LocationCode, HD.TransStatus, IM.ECCN, WH2.LocationCode, WH3.LocationCode, HD.DocNo, HD.Extra1, HD.Extra4, HD.TransNo, IM.ItemDesc, DT.OrderQTY, DT.ID
  ORDER BY DT.ID";

  $options = array('ReturnDatesAsStrings' => true);
  $query_run = sqlsrv_query($conn, $query, null, $options);
  if ($query_run === false) {
    echo "Error (sqlsrv_query): " . print_r(sqlsrv_errors(), true);
    exit;
  }

  echo '<script type="text/JavaScript">
    
    let newItem

   </script>';

  while ($row = sqlsrv_fetch_array($query_run, SQLSRV_FETCH_ASSOC)) {

    $rowDN = $row['DN'];
    $rowItemCode = $row['ItemCode'];
    $rowLocation = $row['Location'];
    $rowLocation2 = $row['Location2'];
    $rowLocation3 = $row['Location3'];
    $rowItemDesc = $row['ItemDesc'];
    $rowQty = $row['Qty'];

    echo '<script type="text/JavaScript">
    
    newItem = document.createElement("tr")

    newItem.innerHTML = `
    <th class="d-flex align-items-center" scope="row">';
    echo $rowItemCode;
    echo '<span class="ms-3" style="';
    echo "font-family:'Libre Barcode 39 Text';";
    echo 'font-size:2em; font-weight: normal;">*';
    echo $rowItemCode;
    echo '*</span></th>
    <td>';
    echo $rowLocation;
    echo '</td>
    <td>';
    echo $rowLocation2;
    echo '</td>
    <td>';
    echo $rowLocation3;
    echo '</td>
    <td>';
    echo $rowItemDesc;
    echo '</td>
    <td>';
    echo $rowQty;
    echo '</td>`

     itemList = document.querySelector("#';
    echo $rowDN;
    echo '")
     itemList.append(newItem)

   </script>';

  ?>

  <?php
  }
  ?>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <script src="./Script/scripts.js"></script>

</body>

</html>