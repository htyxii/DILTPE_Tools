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
        <input type="text" id="inputInvoice" class="form-control" name="invoiceNo" aria-describedby="passwordHelpInline">
      </div>
      <div class="col-auto">
        <input type="submit" value="Submit" id="generateBtn" class="btn btn-primary">
        <!-- <button type="button" name="save" class="btn btn-success ml-2" id="download"><i class="bi bi-file-pdf-fill"></i>Download as PDF</button> -->
      </div>
    </div>
  </form>

  <div id="content" style="height:1855px; width:1584px; margin:108px 144px;">
  </div>

  <!--Download-->
  <script>
    window.onload = function() {
      document.getElementById("download")
        .addEventListener("click", () => {

          const invoice = this.document.getElementById("content");
          console.log(invoice);
          console.log(window);
          var opt = {
            margin: 1,
            filename: 'Invoice.pdf',
            image: {
              type: 'jpeg',
              quality: 0.98
            },
            html2canvas: {
              scale: 2,
              width: 1900
            },
            jsPDF: {
              unit: 'in',
              format: 'tabloid',
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