<?php
$fromInput = $_GET['fromInput'];
$toInput = $_GET['toInput'];
?>

<!doctype html>
<html lang="en">

<head>

  <?php require_once('../../head.php'); ?>

</head>

<body>

  <!-- As a heading -->
  <?php require_once('../../navbar.php'); ?>

  <div class="m-5 text-center">
    <h3>Framework - Picking List</h1>
  </div>

  <form class="my-5" method="get" name="form" action="getStatus.php">
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
        <input type="submit" value="Generate" id="generateBtn" class="btn btn-primary">
        <!-- <button type="button" name="save" class="btn btn-success ml-2  disabled" id="download"><i class="bi bi-file-pdf-fill"></i>Fix It!</button> -->
      </div>
      <div class="col-auto">
        <button type="button" id="toExcel" class="btn btn-success">Download</button>
        <!-- <button type="button" name="save" class="btn btn-success ml-2  disabled" id="download"><i class="bi bi-file-pdf-fill"></i>Fix It!</button> -->
      </div>
    </div>
  </form>

  <!--Table-->
  <table class="table table-hover table-bordered table-striped">
    <thead>
      <tr>
        <th scope="col">Item Code</th>
        <th scope="col">Total Qty</th>
        <th scope="col">1st Location</th>
        <th scope="col">2nd Location</th>
        <th scope="col">3rd Location</th>
        <th scope="col">4th Location</th>
        <th scope="col">5th Location</th>
        <th scope="col">ECCN</th>
        <th scope="col">Status</th>

      </tr>
    </thead>
    <tbody>

      <?php
      require_once("database.php");

      $seq = "0";
      $totalQty = "0";
      $totalGW = "0";
      $totalPrice = "0";
      $cartonNoArr = array();

      $query = "SELECT WMTransDT.ItemCode, SUM(WMTransDT.OrderQTY) AS [Total Qty], WMLocation.LocationCode AS [1st Location], WH2.LocationCode AS [2nd Location], WH3.LocationCode AS [3rd Location], WH4.LocationCode AS [4th Location], WH5.LocationCode AS [5th Location],  WMTransHD.TransStatus, WMItemMaster.ECCN FROM WMTransDT
      LEFT JOIN WMTransHD ON WMTransHD.ID = WMTransDT.TransHDID
      OUTER APPLY (SELECT TOP 1 * FROM WMTransWH WHERE WMTransWH.CartonID = WMTransDT.ItemCode AND WMTransWH.AvailableQTY > 0 ORDER BY WMTransWH.ID) AS WH
      LEFT JOIN WMLocation ON WMLocation.ID = WH.LocationID
      LEFT JOIN WMItemMaster ON WMItemMaster.ItemCode = WMTransDT.ItemCode

      OUTER APPLY (SELECT CartonID, LocationCode, SUM(QTY) AS [QTY], CONVERT(varchar,CreatedDT,23) AS [CreatedDT] FROM WMTransWH
      LEFT JOIN WMLocation ON WMLocation.ID = WMTransWH.LocationID
      WHERE WMTransWH.CartonID = WMTransDT.ItemCode AND WMTransWH.AvailableQTY > 0
      GROUP BY CartonID, LocationCode, CONVERT(varchar,CreatedDT,23)
      ORDER BY CONVERT(varchar,WMTransWH.CreatedDT,23)
      OFFSET 1 ROWS
      FETCH NEXT 1 ROWS ONLY
      ) AS WH2

      OUTER APPLY (SELECT CartonID, LocationCode, SUM(QTY) AS [QTY], CONVERT(varchar,CreatedDT,23) AS [CreatedDT] FROM WMTransWH
      LEFT JOIN WMLocation ON WMLocation.ID = WMTransWH.LocationID
      WHERE WMTransWH.CartonID = WMTransDT.ItemCode AND WMTransWH.AvailableQTY > 0
      GROUP BY CartonID, LocationCode, CONVERT(varchar,CreatedDT,23)
      ORDER BY CONVERT(varchar,WMTransWH.CreatedDT,23)
      OFFSET 2 ROWS
      FETCH NEXT 1 ROWS ONLY
      ) AS WH3

      OUTER APPLY (SELECT CartonID, LocationCode, SUM(QTY) AS [QTY], CONVERT(varchar,CreatedDT,23) AS [CreatedDT] FROM WMTransWH
      LEFT JOIN WMLocation ON WMLocation.ID = WMTransWH.LocationID
      WHERE WMTransWH.CartonID = WMTransDT.ItemCode AND WMTransWH.AvailableQTY > 0
      GROUP BY CartonID, LocationCode, CONVERT(varchar,CreatedDT,23)
      ORDER BY CONVERT(varchar,WMTransWH.CreatedDT,23)
      OFFSET 3 ROWS
      FETCH NEXT 1 ROWS ONLY
      ) AS WH4

      OUTER APPLY (SELECT CartonID, LocationCode, SUM(QTY) AS [QTY], CONVERT(varchar,CreatedDT,23) AS [CreatedDT] FROM WMTransWH
      LEFT JOIN WMLocation ON WMLocation.ID = WMTransWH.LocationID
      WHERE WMTransWH.CartonID = WMTransDT.ItemCode AND WMTransWH.AvailableQTY > 0
      GROUP BY CartonID, LocationCode, CONVERT(varchar,CreatedDT,23)
      ORDER BY CONVERT(varchar,WMTransWH.CreatedDT,23)
      OFFSET 4 ROWS
      FETCH NEXT 1 ROWS ONLY
      ) AS WH5

      WHERE WMTransDT.ProjectID = 100 AND WMTransHD.MoveType = 'GI' AND WMTransHD.TransStatus = 'Planning'  AND WMTransHD.TransNo BETWEEN '$fromInput' AND '$toInput'
      GROUP BY WMTransDT.ItemCode, WMLocation.LocationCode, WMTransHD.TransStatus, WMItemMaster.ECCN, WH2.LocationCode, WH3.LocationCode, WH4.LocationCode, WH5.LocationCode";
      $options = array('ReturnDatesAsStrings' => true);
      $query_run = sqlsrv_query($conn, $query, null, $options);
      if ($query_run === false) {
        echo "Error (sqlsrv_query): " . print_r(sqlsrv_errors(), true);
        exit;
      }
      while ($row = sqlsrv_fetch_array($query_run, SQLSRV_FETCH_ASSOC)) {
        //$scanCode = $row['ScanCode'];
        //$onhandQty = $row['OnhandQTY'];
        //$inpickingQty = $row['InPickingQTY'];
        //$availableQty = $row['AvailableQTY'];
        //$inreceivingQty = $row['InReceivingQTY'];
        //$transNo = $row['TransNo'];
      ?>
        <tr>
          <th scope="row"> <?php echo $row['ItemCode'] ?></td>
          <td> <?php echo $row['Total Qty'] ?></td>
          <td> <?php echo $row['1st Location'] ?></td>
          <td> <?php echo $row['2nd Location'] ?></td>
          <td> <?php echo $row['3rd Location'] ?></td>
          <td> <?php echo $row['4th Location'] ?></td>
          <td> <?php echo $row['5th Location'] ?></td>
          <td> <?php echo $row['ECCN'] ?></td>
          <td> <?php echo $row['TransStatus'] ?></td>



        </tr>

      <?php
      }
      ?>

      <?php
      $totalCarton = array_unique($cartonNoArr);
      //var_dump($totalCarton);
      ?>

    </tbody>

  </table>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <script src="./Script/scripts.js"></script>

</body>

</html>