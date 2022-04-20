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
  <h3>Supreme - 料號進出貨記錄查詢</h3>
  </div>

  <form class="my-5" method="get" name="form" action="getStatus.php">
    <div class="row g-3 justify-content-center align-items-center m-3">
      <div class="col-auto">
        <label for="searchInput" class="col-form-label fw-bold">ItemCode:</label>
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

  <h5 class="text-center mb-5">(僅顯示最近 100 筆資料)</h5>
  <table class="table table-hover table-bordered table-striped">
    <thead>
      <tr>
        <th scope="col">GR / GI</th>
        <th scope="col">TransNo</th>
        <th scope="col">Item Code</th>
        <th scope="col">Quantity</th>
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

      $query = "SELECT TOP 100 MoveType, TransNo, ItemCode, SUM(OrderQTY) AS [Qty], CONVERT(varchar,WMTransDT.CreatedDT,111) as [Date]  FROM WMTransDT
      LEFT JOIN WMTransHD ON WMTransHD.ID = WMTransDT.TransHDID
      WHERE WMTransDT.ProjectID = 51 AND ItemCode = '$searchInput'
      GROUP BY MoveType, TransNo, ItemCode, CONVERT(varchar,WMTransDT.CreatedDT,111)
      ORDER BY CONVERT(varchar,WMTransDT.CreatedDT,111) DESC";

      $options = array('ReturnDatesAsStrings' => true);
      $query_run = sqlsrv_query($conn, $query, null, $options);
      if ($query_run === false) {
        echo "Error (sqlsrv_query): " . print_r(sqlsrv_errors(), true);
        exit;
      }
      while ($row = sqlsrv_fetch_array($query_run, SQLSRV_FETCH_ASSOC)) {

      ?>
        <tr>
          <th scope="row"> <?php echo $row['MoveType'] ?></td>
          <td> <?php echo $row['TransNo'] ?></td>
          <td> <?php echo $row['ItemCode'] ?></td>
          <td> <?php echo $row['Qty'] ?></td>
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