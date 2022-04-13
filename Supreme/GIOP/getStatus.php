<?php
$dcTransNoInput = $_GET['dcTransNoInput'];
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
    <h3>Supreme - 出貨作業人員查詢</h1>
  </div>

  <form class="my-5" method="get" name="form" action="getStatus.php">
    <div class="row g-3 justify-content-center align-items-center m-3">
      <div class="col-auto">
        <label for="dcTransNoInput" class="col-form-label fw-bold">DCTransNo:</label>
      </div>
      <div class="col-auto">
        <input type="text" id="inputInvoice" class="form-control" name="dcTransNoInput" value="<?php echo $dcTransNoInput ?>" aria-describedby="passwordHelpInline">
      </div>
      <div class="col-auto">
        <input type="submit" value="Search" id="generateBtn" class="btn btn-primary">
        <!-- <button type="button" name="save" class="btn btn-success ml-2  disabled" id="download"><i class="bi bi-file-pdf-fill"></i>Fix It!</button> -->
      </div>
    </div>
  </form>

  <!--Table-->


  <?php
  require_once("database.php");

  $query = "SELECT TransNo, MoveType, TransDate, TransStatus, DimercoRef, WMOMTransDetailScan.UpdatedBy AS [User], CONVERT(varchar,WMOMTransDetailScan.UpdatedDate,111) AS [Date], * FROM WMTransHD
      LEFT JOIN WMOMTransDetailScan ON WMOMTransDetailScan.TransHDID = WMTransHD.ID 
      WHERE WMTransHD.ProjectID = 51 AND TransNo = '$dcTransNoInput'";
  $options = array('ReturnDatesAsStrings' => true);
  $query_run = sqlsrv_query($conn, $query, null, $options);
  if ($query_run === false) {
    echo "Error (sqlsrv_query): " . print_r(sqlsrv_errors(), true);
    exit;
  }
  while ($row = sqlsrv_fetch_array($query_run, SQLSRV_FETCH_ASSOC)) {
    $transNo = $row['TransNo'];
    $user = $row['User'];
    $date = $row['Date'];
    $transStatus = $row['TransStatus'];
    //$onhandQty = $row['OnhandQTY'];
    //$inpickingQty = $row['InPickingQTY'];
    //$availableQty = $row['AvailableQTY'];
    //$inreceivingQty = $row['InReceivingQTY'];
    //$transNo = $row['TransNo'];
  ?>

  <?php
  }
  ?>

  <div class="card text-center">
    <div class="card-header">
      <h2>單號: <?php echo $transNo ?></h1>
    </div>
    <div class="card-body m-5">
      <h1 class="card-title text-danger">作業人員: <?php echo $user ?></h1>
      <h3 class="card-text">狀態: <?php echo $transStatus ?></h3>
    </div>
    <div class="card-footer text-muted">
      <h2>日期: <?php echo $date ?></h2>
    </div>
  </div>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>