<?php
$result = $_GET['invoiceNo'];
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
    <h3>Framework - Invoice Generator</h1>
  </div>

  <form method="get" name="form" action="getInvoice.php">
    <div class="row g-3 justify-content-center align-items-center m-3">
      <div class="col-auto">
        <label for="inputInvoice" class="col-form-label fw-bold">Invoice Number:</label>
      </div>
      <div class="col-auto">
        <input type="text" id="inputInvoice" class="form-control" name="invoiceNo" value="" <?php echo $result ?>" aria-describedby="passwordHelpInline">
      </div>
      <div class="col-auto">
        <input type="submit" value="Submit" id="generateBtn" class="btn btn-primary">
        <button type="button" name="save" class="btn btn-success ml-2" id="download">
          <i class="bi bi-file-pdf-fill"></i>Download as PDF
        </button>
      </div>
    </div>
  </form>

  <div class="m-auto" id="content" style="height:1855px; width:1584px; margin:20px;">
    <!-- margin:108px 144px -->

    <?php

    $getDate = date("m/d/Y");
    require_once("database.php");

    $queryHD = "SELECT TOP 1 * FROM WMTransHD WHERE ProjectID = 100 AND DocNo = '$result'";
    $optionsHD = array('ReturnDatesAsStrings' => true);
    $query_runHD = sqlsrv_query($conn, $queryHD, null, $optionsHD);

    while ($rowHD = sqlsrv_fetch_array($query_runHD, SQLSRV_FETCH_ASSOC)) {
      $dispatchedDate = $rowHD['Extra6'];
      $invoiceNo = $rowHD['DocNo'];
      $contactName = $rowHD['Extra1'];
      $contactNumber = $rowHD['Extra4'];
      $contactAddress = $rowHD['DeliveryAddr'];
      $city = $rowHD['Extra2'];
      $country = $rowHD['Extra9'];
      $zipCode = $rowHD['Extra3'];
    ?>
    <?php
    }
    ?>

    <!--Headline-->
    <div class="d-flex justify-content-between align-items-center">
      <h1 class="fw-bold">Commercial Invoice / Packing</h1>
      <img src="frameworkLogo.png" width="15%" height="15%" alt="Logo">
    </div>

    <!--Info-->
    <div style="background-color:#F3F3F3; margin-top:35px;">
      <div>
        <span style="width:288px; display:inline-block;" class="fw-bold">Date</span>
        <span>
          <?php echo $dispatchedDate ?>
        </span>
      </div>
      <div>
        <span style="width:288px; display:inline-block;" class="fw-bold">Invoice / Packing List No.</span>
        <span id="fileName">
          <?php echo $invoiceNo ?>
        </span>
      </div>
      <div>
        <span style="width:288px; display:inline-block;" class="fw-bold">Incoterm</span>
        <span>DDP</span>
      </div>
    </div>

    <!--Seller & Buyer / Notify Party-->
    <div style="background-color:#F3F3F3; margin-top:35px;" class="d-flex justify-content-between">
      <!--1-->
      <div style="background-color:#FFFFFF; width:720px; height:108px;" class="fw-bold border border-secondary">
        <div style="height:35px; padding-left:3px;" class="d-flex">Seller</div>
        <span class="d-flex text-center align-items-center mx-5">Framework Computer Inc C/O Diversified International Logistics Co. Ltd</span>
        <span style="color:#999999" class="d-flex align-items-center mx-5">Address: FTZ International Logistics Center 2F.-6, No. 7, Hangxiang Rd., Dayuan Dist., Taoyuan City 337407 , Taiwan</span>
      </div>
      <!--2-->
      <div style="background-color:#FFFFFF; width:720px; height:108px;" class="fw-bold border border-secondary">
        <div style="height:35px; padding-left:3px;" class="d-flex">Buyer / Notify Party</div>
        <span class="d-flex text-center align-items-center mx-5 fs-5">
          <?php echo $contactName ?>
        </span>
      </div>
    </div>

    <!--Contact Detail-->
    <div style="background-color:#F3F3F3; margin-top:35px;" class="d-flex justify-content-between border border-secondary">
      <!--1-->
      <div style="background-color:#FFFFFF; width:576px; height:108px;" class="fw-bold border">
        <div style="height:35px; padding-left:3px;" class="d-flex">Contact Person</div>
        <span class="d-flex text-center align-items-center mx-5 fs-5">
          <?php echo $contactName ?>
        </span>
      </div>
      <!--2-->
      <div style="color:#999999; background-color:#FFFFFF; width:432px; height:108px;" class="fw-bold border">
        <div style="height:35px; padding-left:3px;" class="d-flex">Contact Number</div>
        <span class="d-flex text-center align-items-center mx-5 fs-5">
          <?php echo $contactNumber ?>
        </span>
      </div>
      <!--3-->
      <div style="color:#999999; background-color:#FFFFFF; width:576px; height:108px;" class="fw-bold border">
        <div style="height:35px; padding-left:3px;" class="d-flex">Address</div>
        <span class="d-flex text-center align-items-center mx-5">
          <?php echo $contactAddress ?>
        </span>
        <span style="color:#999999" class="d-flex align-items-center mx-5">
          <?php echo $city;
          echo ',';
          echo $country;
          echo ' ';
          echo $zipCode ?>
        </span>
      </div>
    </div>

    <div style="height:70px"></div>
    <div style="height:35px;" class="border-top border-secondary"></div>

    <!--Table-->
    <table class="table table-hover table-borderless table-striped">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Part Number</th>
          <th scope="col">Description</th>
          <th scope="col">Carton No.</th>
          <th scope="col">COO</th>
          <th scope="col">HTS Code</th>
          <th scope="col">QTY</th>
          <th scope="col">GW Total</th>
          <th scope="col">Unit Price</th>
          <th scope="col">Total Price</th>
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


        $query = "SELECT DT2.ItemCode, WMItemMaster.ItemDesc, WH1.CartonID, SUM(WMPackList.ScanedQTY) AS OrderQty, DT2.HSCode AS DTHSCode, DT1.COO, DT2.Supplier, DT2.Description, WMItemMaster.GW FROM WMPackList
          LEFT JOIN WMTransHD ON WMTransHD.ID = WMPackList.TransHDID
          LEFT JOIN WMTransWH WH1 ON WH1.ID = WMPackList.TransWHID
          LEFT JOIN WMTRANSWH WH2 ON WH2.ID = WMPackList.TargetWHID
          LEFT JOIN WMTransDT DT1 ON DT1.ID = WH2.TransDTID
          LEFT JOIN WMTransDT DT2 ON DT2.ID = WMPackList.TransDTID
          LEFT JOIN WMItemMaster ON WMItemMaster.ItemCode = DT2.ItemCode
          WHERE DT2.ProjectID = 100 AND WMTransHD.DocNo = '$result'
          GROUP BY DT2.ItemCode, WMItemMaster.ItemDesc, WH1.CartonID, DT2.HSCode, DT1.COO, DT2.Supplier, DT2.Description, WMItemMaster.GW";
        $options = array('ReturnDatesAsStrings' => true);
        $query_run = sqlsrv_query($conn, $query, null, $options);
        if ($query_run === false) {
          echo "Error (sqlsrv_query): " . print_r(sqlsrv_errors(), true);
          exit;
        }
        while ($row = sqlsrv_fetch_array($query_run, SQLSRV_FETCH_ASSOC)) {
          //echo print_r($row, true);
          //echo "Name: ".$row['CustomerPN']."\n";
          //$CustomerPN = "".$row['CustomerPN']."\n";
          $seq += 1;
          $totalQty += $row['OrderQty'];
          $totalGW += $row['GW'] * $row['OrderQty'];
          $currency = $row['Supplier'];
          $totalPrice += $row['Description'] * $row['OrderQty'];
          array_push($cartonNoArr, $row['CartonID']);
        ?>
          <tr>
            <th scope="row">
              <?php echo $seq ?>
            </th>
            <td>
              <?php echo $row['ItemCode'] ?>
            </td>
            <td>
              <?php echo $row['ItemDesc'] ?>
            </td>
            <td>
              <?php echo $row['CartonID'] ?>
            </td>
            <td>
              <?php echo $row['COO'] ?>
            </td>
            <td>
              <?php echo $row['DTHSCode'] ?>
            </td>
            <td>
              <?php echo $row['OrderQty'] ?> each
            </td>
            <!-- <td> <?php //echo number_format((float)$row['GW'], 2, '.', '') * $row['OrderQty']
                      ?> kg</td> -->
            <td>
              <?php echo number_format((float)$row['GW'] * $row['OrderQty'], 2, '.', '') ?> kg
            </td>
            <td>
              <?php echo $row['Supplier'];
              echo ' ';
              echo $row['Description'] ?>
            </td>
            <td>
              <?php echo $row['Supplier'];
              echo ' ';
              echo number_format((float)$row['Description'] * $row['OrderQty'], 2, '.', '') ?>
            </td>
          </tr>

        <?php
        }
        ?>

        <?php
        $totalCarton = array_unique($cartonNoArr);
        //var_dump($totalCarton);
        ?>

      </tbody>

      <tfoot>
        <tr class="fw-bold">
          <th scope="row">Total</th>
          <td></td>
          <td></td>
          <td>
            <?php echo count($totalCarton) ?>
          </td>
          <td></td>
          <td></td>
          <td>
            <?php echo $totalQty ?> each
          </td>
          <td>
            <?php echo $totalGW ?> kg
          </td>
          <td></td>
          <td>
            <?php echo $currency;
            echo ' ';
            echo $totalPrice ?>
          </td>
        </tr>
      </tfoot>
    </table>

    <div style="height:35px"></div>
    <div style="height:70px;" class="border-top border-secondary"></div>

    <!--InfoBottom-->
    <div>
      <div style="margin-bottom:35px;">
        <span style="width:144px; display:inline-block;" class="fw-bold">Declaration:</span>
        <span>We hereby certify that the information of this invoice is true and correct and that the contents of this shipment are as stated as above.</span>
      </div>

      <div style="margin-bottom:35px;">
        <span style="width:144px; display:inline-block;" class="fw-bold">Name:</span>
        <span>Jocelyn Ang</span>
      </div>

      <div style="margin-bottom:35px;">
        <span style="width:144px; display:inline-block;" class="fw-bold">Date:</span>
        <span>
          <?php echo $getDate ?>
        </span>
      </div>

      <div style="margin-bottom:35px;" class="d-flex align-items-start">
        <span style="width:144px; display:inline-block;" class="fw-bold">Signature:</span>
        <img src="signature.png" alt="signature">
      </div>

    </div>


    <!-- new -->

    <div class="d-flex align-items-center" style="color:#999999">
      <div>
        <div style="width:288px; display:inline-block;">
          <div>UK Responsible Person</div>
          <div>UKCA Experts Ltd.</div>
          <div>Dept 302, 43 Owston Road</div>
          <div>Carcroft, Doncaster, DN6 8DA</div>
          <div>United Kingdom</div>
        </div>
        <div style="width:288px; display:inline-block;">
          <div>Authorised Representative</div>
          <div>AR Experts</div>
          <div>P.O. Box 5047</div>
          <div>3620 AA Breukelen</div>
          <div>The Netherlands</div>
        </div>
      </div>

      <div style="display:inline-block;">

        <table class="table table-hover" style="color:#999999">
          <thead>
            <tr>
              <th scope="col">Country</th>
              <th scope="col">EORI #</th>
              <th scope="col">VAT #</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Germany</th>
              <td>FRUS1209508090001</td>
              <td>DE350806374</td>
            </tr>
            <tr>
              <th scope="row">France</th>
              <td>FRUS1209508090001</td>
              <td>FR29909542169</td>
            </tr>
            <tr>
              <th scope="row">Netherlands</th>
              <td>BSN: 8265.75.791</td>
              <td>NL826575791B01</td>
            </tr>
            <tr>
              <th scope="row">UK</th>
              <td>GB086788641000</td>
              <td>N/A</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>









  </div>

  <!--Download-->
  <script>
    window.onload = function() {
      document.getElementById("download")
        .addEventListener("click", () => {

          const invoice = this.document.getElementById("content");
          console.log(invoice);
          console.log(window);
          let fileName = document.querySelector("#fileName").innerText;

          let body = document.body,
            html = document.documentElement;
          let pageHeight = Math.max(body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight);

          var opt = {
            margin: 1,
            filename: `${fileName}.pdf`,
            image: {
              type: 'jpeg',
              quality: 0.98
            },
            html2canvas: {
              scale: 2,
              width: 1615,
              height: pageHeight
            },
            jsPDF: {
              unit: 'mm',
              format: 'a4',
              orientation: 'p'
            }
          };

          html2pdf().from(invoice).set(opt).save();

        })
    }
  </script>

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>