<?php
$searchInput = $_GET['searchInput'];

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
  <h3>Supreme - 進出貨記錄查詢</h3>
  </div>

  <form class="my-5" method="get" name="form" action="getStatus.php">
    <div class="row g-3 justify-content-center align-items-center m-3">
      <div class="col-auto">
        <label for="searchInput" class="col-form-label fw-bold">Carton ID:</label>
      </div>
      <div class="col-auto">
        <input type="text" id="searchInput" class="form-control" name="searchInput" value="<?php echo $searchInput ?>" aria-describedby="passwordHelpInline">
      </div>

      <div class="col-auto">
        <input type="submit" value="Search" id="generateBtn" class="btn btn-primary">
        <!-- <button type="button" name="save" class="btn btn-success ml-2  disabled" id="download"><i class="bi bi-file-pdf-fill"></i>Fix It!</button> -->
      </div>
    </div>
  </form>


  <!--Table-->

  <h3 class="text-center">進貨紀錄</h3>
  <table class="table table-hover table-bordered table-striped">
    <thead>
      <tr>
        <th scope="col">Item Code</th>
        <th scope="col">Carton ID</th>
        <th scope="col">進貨數量</th>
        <th scope="col">Lot Code</th>
        <th scope="col">Location</th>
        <th scope="col">Date & Time</th>
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

      $query = "SELECT customerPN, CartonID, ScanQTY AS [Qty], LotCode, WMLocation.LocationCode AS [Location], CreatedDate AS [Date] FROM WMOMTransDetail --查進貨紀錄
      LEFT JOIN WMLocation ON WMLocation.ID = WMOMTransDetail.LocationID
      WHERE ProjectID = 51 AND CartonID = '$searchInput'";
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
          <th scope="row"> <?php echo $row['customerPN'] ?></td>
          <td> <?php echo $row['CartonID'] ?></td>
          <td> <?php echo $row['Qty'] ?></td>
          <td> <?php echo $row['LotCode'] ?></td>
          <td> <?php echo $row['Location'] ?></td>
          
          <td> <?php echo $row['Date'] ?></td>

        </tr>

      <?php
      }
      ?>

    </tbody>

  </table>


  <!--Table-->
  <h3 class="text-center">出貨紀錄</h3>
  <table class="table table-hover table-bordered table-striped">
    <thead>
      <tr>
        <th scope="col">Item Code</th>
        <th scope="col">Carton ID</th>
        <th scope="col">出貨數量</th>
        <th scope="col">Location</th>
        <th scope="col">TransNo</th>
        <th scope="col">Date & Time</th>
        
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

      $query = "SELECT ItemCode, WMTransWH.CartonID AS [CartonID], WMPickList.QTY AS [Qty], WMLocation.LocationCode, WMTransHD.TransNo, WMPickList.CreatedDT AS [Date] FROM WMPickList --查出貨紀錄
      LEFT JOIN WMTransDT ON WMTransDT.ID = WMPickList.TransDTID
      LEFT JOIN WMTransWH ON WMTransWH.ID = WMPickList.TargetTransWHID
      LEFT JOIN WMLocation ON WMLocation.ID = WMTransWH.LocationID
      LEFT JOIN WMTransHD ON WMTransHD.ID = WMPickList.TransHDID
      WHERE WMPickList.ProjectID = 51 AND WMTransWH.CartonID = '$searchInput'";
      $options = array('ReturnDatesAsStrings' => true);
      $query_run = sqlsrv_query($conn, $query, null, $options);
      if ($query_run === false) {
        echo "Error (sqlsrv_query): " . print_r(sqlsrv_errors(), true);
        exit;
      }
      while ($row = sqlsrv_fetch_array($query_run, SQLSRV_FETCH_ASSOC)) {
        
      ?>
        <tr>
          <th scope="row"> <?php echo $row['ItemCode'] ?></td>
          <td> <?php echo $row['CartonID'] ?></td>
          <td> <?php echo $row['Qty'] ?></td>
          <td> <?php echo $row['LocationCode'] ?></td>
          <td> <?php echo $row['TransNo'] ?></td>
          <td> <?php echo $row['Date'] ?></td>
          

        </tr>

      <?php
      }
      ?>

    </tbody>

  </table>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <script src="./Script/scripts.js"></script>

</body>

</html>