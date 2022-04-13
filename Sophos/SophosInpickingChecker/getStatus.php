<?php
$scanCodeInput = $_GET['scanCodeInput'];
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    <title>Sophos - Inpicking Checker</title>
</head>

<body>

    <!-- As a heading -->

    <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">DILTPE Tools</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="http://10.161.1.33:8162/NewTools/DILTPE_Tools/">Home</a>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Framework
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="http://10.161.1.33:8162/NewTools/DILTPE_Tools/Framework/InvoiceGenerator/">Invoice Generator</a></li>
            <li><a class="dropdown-item" href="http://10.161.1.33:8162/NewTools/DILTPE_Tools/Framework/InpickingChecker/">Inpicking Checker</a></li>
            <li><a class="dropdown-item" href="#">--</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Skyworks
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="http://10.161.1.33:8162/NewTools/DILTPE_Tools/Skyworks/InpickingChecker/">Inpicking Checker</a></li>
            <li><a class="dropdown-item" href="#">--</a></li>
            <li><a class="dropdown-item" href="#">--</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sophos
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="http://10.161.1.33:8162/NewTools/DILTPE_Tools/Sophos/SophosInpickingChecker/index.php">Inpicking Checker</a></li>
            <li><a class="dropdown-item" href="http://10.161.1.33:8162/Sophos%20Export%20EDI/esophos_app_process.aspx" target="_blank">外網 - Jerome</a></li>
            <li><a class="dropdown-item" href="http://10.161.1.33:8162/proweb/eSophos_transXMLintoWMS.aspx" target="_blank">轉正式單 - Jerome</a></li>
            <li><a class="dropdown-item" href="http://10.161.1.33:8162/proweb/eSophos_transXLSintoWMS.aspx" target="_blank">轉預撿單 - Jerome</a></li>
            <li><a class="dropdown-item" href="http://10.161.1.33:8162/Sophos%20Export%20EDI/SKUResetTool.aspx" target="_blank">序號換規 - Jerome</a></li>
            <li><a class="dropdown-item" href="http://10.161.1.33:8162/Sophos%20Export%20EDI/SearchSerialNumber.aspx" target="_blank">序號查詢狀態 - Jerome</a></li>
            
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Supreme
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="#">進出貨紀錄查詢</a></li>
            <li><a class="dropdown-item" href="#">出貨作業人員查詢</a></li>
            <li><a class="dropdown-item" href="#">--</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://10.161.1.33:8162/WMStoCustoms/WMS2Customs.aspx" target="_blank">扣帳彙整 - Jerome</a>
        </li>
      </div>
    </div>
  </div>
</nav>

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