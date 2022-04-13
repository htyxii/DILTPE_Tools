<!doctype html>
<html lang="en">

<head>

  <?php require_once('../../head.php'); ?>

</head>

<body>

  <!-- As a heading -->
  <?php require_once('../../navbar.php'); ?>

  <div class="m-5 text-center">
    <h3>Skyworks - Inpicking Checker</h3>
  </div>

  <form class="my-5" method="get" name="form" action="getStatus.php">
    <div class="row g-3 justify-content-center align-items-center m-3">
      <div class="col-auto">
        <label for="itemCodeInput" class="col-form-label fw-bold">Item Code:</label>
      </div>
      <div class="col-auto">
        <input type="text" id="inputInvoice" class="form-control" name="itemCodeInput" value="" aria-describedby="passwordHelpInline">
      </div>
      <div class="col-auto">
        <label for="scanCodeInput" class="col-form-label fw-bold">Scan Code:</label>
      </div>
      <div class="col-auto">
        <input type="text" id="inputInvoice" class="form-control" name="scanCodeInput" value="" aria-describedby="passwordHelpInline">
      </div>
      <div class="col-auto">
        <input type="submit" value="Search" id="generateBtn" class="btn btn-primary">
        <!-- <button type="button" name="save" class="btn btn-success ml-2" id="download"><i class="bi bi-file-pdf-fill"></i>Download as PDF</button> -->
      </div>
    </div>
  </form>


  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>