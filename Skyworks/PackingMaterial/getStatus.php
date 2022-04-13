<!doctype html>
<html lang="en">

<head>

  <?php require_once('../../head.php'); ?>

</head>

<body>

  <!-- As a heading -->
  <?php require_once('../../navbar.php'); ?>


  <form class="my-5" method="get" name="form" action="getStatus.php">
    <div class="row g-3 justify-content-center align-items-center m-3">
      <h2 class="col-auto">
        Skyworks 紙箱庫存
</h2>
      <div class="col-auto">
        <input type="submit" value="查詢" id="generateBtn" class="btn btn-lg btn-primary">
        <!-- <button type="button" name="save" class="btn btn-success ml-2  disabled" id="download"><i class="bi bi-file-pdf-fill"></i>Fix It!</button> -->
      </div>
    </div>
  </form>

  <!--Table-->
  <table class="table table-hover table-bordered table-striped">
    <thead>
      <tr>
        <th scope="col">Box Type 箱型</th>
        <th scope="col">Status 狀態</th>
        <th scope="col">Stock 庫存量</th>
        <th scope="col">Safety Stock 安全庫存量</th>
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

      $query = "SELECT WMTransDT.ItemCode, SUM(WMTransWH.AvailableQTY) AS Stock, 
      CASE 
      WHEN WMTransDT.ItemCode = 'ABOX' THEN 600 
      WHEN WMTransDT.ItemCode = 'BBOX' THEN 600
      WHEN WMTransDT.ItemCode = 'CBOX' THEN 600
      WHEN WMTransDT.ItemCode = 'DBOX' THEN 1500
      WHEN WMTransDT.ItemCode = 'EBOX' THEN 600
      WHEN WMTransDT.ItemCode = 'FBOX' THEN 1500
      WHEN WMTransDT.ItemCode = 'GBOX' THEN 1500
      ELSE 0 END AS [Safety Stock] FROM WMTransWH
      LEFT JOIN WMTransDT ON WMTransDT.ID = WMTransWH.TransDTID
      WHERE WMTransWH.ProjectID = 99 AND WMTransDT.ItemCode LIKE '%BOX' AND AvailableQTY > 0
      GROUP BY WMTransDT.ItemCode
      ORDER BY WMTransDT.ItemCode";
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
        <tr class="fs-5">
          <th scope="row"> <?php echo $row['ItemCode'] ?></td>

          <?php if ($row['Stock'] < $row['Safety Stock']) {
            echo '<td class="fw-bold text-danger">不足</td>';
          } else if ($row['Stock'] > $row['Safety Stock']) {
            echo '<td class="fw-bold text-success">足夠</td>';
          }
            ?>

          <td> <?php echo $row['Stock'] ?></td>
          <td> <?php echo $row['Safety Stock'] ?></td>
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