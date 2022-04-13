<?php
$itemCodeInput = $_GET['itemCodeInput'];
$scanCodeInput = $_GET['scanCodeInput'];
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
    <h3>Skyworks - Inpicking Checker</h1>
  </div>

  <form class="my-5" method="get" name="form" action="getStatus.php">
    <div class="row g-3 justify-content-center align-items-center m-3">
      <div class="col-auto">
        <label for="itemCodeInput" class="col-form-label fw-bold">Item Code:</label>
      </div>
      <div class="col-auto">
        <input type="text" id="inputInvoice" class="form-control" name="itemCodeInput" value="<?php echo $itemCodeInput ?>" aria-describedby="passwordHelpInline">
      </div>
      <div class="col-auto">
        <label for="scanCodeInput" class="col-form-label fw-bold">Scan Code:</label>
      </div>
      <div class="col-auto">
        <input type="text" id="inputInvoice" class="form-control" name="scanCodeInput" value="<?php echo $scanCodeInput ?>" aria-describedby="passwordHelpInline">
      </div>
      <div class="col-auto">
        <input type="submit" value="Search" id="generateBtn" class="btn btn-primary">
        <!-- <button type="button" name="save" class="btn btn-success ml-2  disabled" id="download"><i class="bi bi-file-pdf-fill"></i>Fix It!</button> -->
      </div>
    </div>
  </form>

  <!--Table-->
  <table class="table table-hover table-bordered table-striped">
    <thead>
      <tr>
        <th scope="col">Status</th>
        <th scope="col">MoveType</th>
        <th scope="col">TransNo</th>
        <th scope="col">TransDate</th>
        <th scope="col">PackingList</th>
        <!-- <th scope="col">ArrivedDockDate</th> -->
        <th scope="col">DN</th>
        <th scope="col">OrderQTY</th>
        <th scope="col">DeliveryParty</th>
        <th scope="col">ItemCode</th>
        <th scope="col">ScanCode</th>
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

      $query = "SELECT WMTransHD.TransStatus, WMTransHD.MoveType, WMTransHD.TransNo, CONVERT(varchar,WMTransHD.CreatedDT,111) AS [TransDate], WMTransWH.Extra1 AS [PackingList], GRHD.ArrivedDockDate, WMTransHD.Extra1, SUM(WMPackList.ScanedQTY) AS [Qty], WMTransHD.DocNo AS [DeliveryParty], WMTransDT.ItemCode, WMTransDT.ScanCode FROM WMTransDT
      LEFT JOIN WMTransHD ON WMTransHD.ID = WMTransDT.TransHDID
      LEFT JOIN WMPackList ON WMPackList.TransDTID = WMTransDT.ID
      LEFT JOIN WMTransWH ON WMTransWH.ID = WMPackList.TargetWHID
      LEFT JOIN WMTransHD GRHD ON WMTransHD.ID = WMTransWH.TransHDID
      WHERE WMTransDT.ProjectID = 99 AND WMTransHD.MoveType = 'GI' AND WMTransDT.ItemCode = '$itemCodeInput' AND WMTransDT.ScanCode = '$scanCodeInput'
      GROUP BY WMTransHD.TransStatus, WMTransHD.MoveType, WMTransHD.TransNo, CONVERT(varchar,WMTransHD.CreatedDT,111), WMTransWH.Extra1, GRHD.ArrivedDockDate, WMTransHD.Extra1, WMTransHD.DocNo, WMTransDT.ItemCode, WMTransDT.ScanCode
			ORDER BY TransNo";
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
          <th scope="row"> <?php echo $row['TransStatus'] ?></td>
          <td> <?php echo $row['MoveType'] ?></td>
          <td> <?php echo $row['TransNo'] ?></td>
          <td> <?php echo $row['TransDate'] ?></td>
          <td> <?php echo $row['PackingList'] ?></td>
          <!-- <td> <?php //echo $row['ArrivedDockDate'] 
                    ?> </td>-->
          <td> <?php echo $row['Extra1'] ?></td>
          <td> <?php echo $row['Qty'] ?></td>
          <td> <?php echo $row['DeliveryParty'] ?></td>
          <td> <?php echo $row['ItemCode'] ?></td>
          <td> <?php echo $row['ScanCode'] ?></td>

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

</body>

</html>