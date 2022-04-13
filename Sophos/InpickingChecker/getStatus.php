<?php
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
    <h3>Sophos - Inpicking Checker</h1>
  </div>

  <form class="my-5" method="get" name="form" action="getStatus.php">
    <div class="row g-3 justify-content-center align-items-center m-3">
      <div class="col-auto">
        <label for="scanCodeInput" class="col-form-label fw-bold">Scan Code (Serial Number):</label>
      </div>
      <div class="col-auto">
        <input type="text" id="inputInvoice" class="form-control" name="scanCodeInput" value="<?php echo $scanCodeInput ?>" aria-describedby="passwordHelpInline">
      </div>
      <div class="col-auto">
        <input type="submit" value="Search" id="generateBtn" class="btn btn-primary">

      </div>
    </div>
  </form>

  <!--Table-->
  <table class="table table-hover table-border table-striped">
    <thead>
      <tr>
        <th scope="col">ItemCode</th>
        <th scope="col">SKU</th>
        <th scope="col">ScanCode</th>
        <th scope="col">OnhandQty</th>
        <th scope="col">InReceivingQty</th>
        <th scope="col">InPickingQty</th>
        <th scope="col">AvailableQty</th>
        <th scope="col">NetAvailableQty</th>
        <th scope="col">TransNo</th>
        <th scope="col">DocNo</th>
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

      $query = "SELECT TOP 10 WMTransWH.CartonID AS [ScanCode], * FROM WMTransWH
            LEFT JOIN WMPackList ON WMPackList.TargetWHID = WMTransWH.ID
            LEFT JOIN WMTransHD ON WMTransHD.ID = WMPackList.TransHDID
            LEFT JOIN WMTransDT ON WMTransDT.ID = WMTransWH.TransDTID
            WHERE WMTransWH.ProjectID = 55 AND WMTransWH.CartonID = '$scanCodeInput'";
      $options = array('ReturnDatesAsStrings' => true);
      $query_run = sqlsrv_query($conn, $query, null, $options);
      if ($query_run === false) {
        echo "Error (sqlsrv_query): " . print_r(sqlsrv_errors(), true);
        exit;
      }
      while ($row = sqlsrv_fetch_array($query_run, SQLSRV_FETCH_ASSOC)) {
        $scanCode = $row['ScanCode'];
        $onhandQty = $row['OnhandQTY'];
        $inpickingQty = $row['InPickingQTY'];
        $availableQty = $row['AvailableQTY'];
        $inreceivingQty = $row['InReceivingQTY'];
        $transNo = $row['TransNo'];
      ?>
        <tr>
          <th scope="row"> <?php echo $row['ItemCode'] ?></td>
          <td> <?php echo $row['Extra12'] ?></td>
          <td> <?php echo $row['ScanCode'] ?></td>
          <td> <?php echo $row['OnhandQTY'] ?></td>
          <td> <?php echo $row['InReceivingQTY'] ?></td>
          <td> <?php echo $row['InPickingQTY'] ?></td>
          <td> <?php echo $row['AvailableQTY'] ?></td>
          <td> <?php echo $row['NetAvailableQTY'] ?></td>
          <td> <?php echo $row['TransNo'] ?></td>
          <td> <?php echo $row['DocNo'] ?></td>
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

  <h1 class="text-center mt-5"><?php echo $scanCode ?></h1>
  <?php

  if ($onhandQty < 0 || $inpickingQty < 0 || $availableQty < 0) {
    echo '<h1 class="text-center mt-5 text-danger">[ 數值異常 ]</h1>';
  } elseif ($onhandQty === 0 && $inpickingQty === 0 && $availableQty === 0) {
    echo '<h1 class="text-center mt-5 text-success">[ 已出貨 ]</h1>';
  } elseif ($onhandQty === 1 && $inpickingQty === 1 && $availableQty === 0 && strlen($transNo) < 1) {
    echo '<h1 class="text-center mt-5 text-danger">[ 出貨異常: 無單號 ]</h1>';
  } elseif ($onhandQty === 1 && $inpickingQty === 0 && $availableQty === 1 && strlen($transNo) > 1) {
    echo '<h1 class="text-center mt-5 text-danger">[ 出貨異常: 有單號 ]</h1>';
  } elseif ($onhandQty === 1 && $inpickingQty === 1 && $availableQty === 0) {
    echo '<h1 class="text-center mt-5 text-primary">[ 出貨中 ]</h1>';
  } elseif ($onhandQty === 1 && $inpickingQty < 1 && $availableQty === 1) {
    echo '<h1 class="text-center mt-5 text-success">[ 有庫存 ]</h1>';
  } elseif ($onhandQty < 1 && $inreceivingQty === 1 && $availableQty === 1) {
    echo '<h1 class="text-center mt-5 text-primary">[ 進貨中 ]</h1>';
  } else {
    echo '<h1 class="text-center mt-5 text-danger">[ 不明: 請洽 IT ]</h1>';
  }

  ?>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>