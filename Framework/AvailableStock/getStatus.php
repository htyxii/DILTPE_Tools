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
    <h3>Framework - Available Stock</h1>
  </div>

  <form class="my-5" method="get" name="form" action="getStatus.php">
    <div class="row g-3 justify-content-center align-items-center m-3">
      <div class="col-auto">
        <label for="searchInput" class="col-form-label fw-bold">Item Code:</label>
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
  <table class="table table-hover table-bordered table-striped">
    <thead>
      <tr>
        <th scope="col">Item Code</th>
        <th scope="col">Location</th>
        <th scope="col">Total Qty</th>
        <th scope="col">Date</th>
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

      $query = "SELECT TOP 100000 CartonID AS [Item Code], LocationCode AS [Location], SUM(AvailableQTY) AS [Total Qty], CONVERT(varchar,CreatedDT,23) AS [Date] FROM WMTransWH
      LEFT JOIN WMLocation ON WMLocation.ID = WMTransWH.LocationID
      WHERE ProjectID = 100 AND WMTransWH.AvailableQTY > 0 AND CartonID = '$searchInput'
      GROUP BY CartonID, LocationCode, LocationID, CONVERT(varchar,CreatedDT,23)
      ORDER BY CONVERT(varchar,CreatedDT,23)";
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
          <th scope="row"> <?php echo $row['Item Code'] ?></td>
          <td> <?php echo $row['Location'] ?></td>
          <td> <?php echo $row['Total Qty'] ?></td>
          <td> <?php echo $row['Date'] ?></td>

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