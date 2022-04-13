<!DOCTYPE html>
<html lang="en">

<head>

    <?php require_once('../../head.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
</head>

<body>

    <!-- As a heading -->
    <?php require_once('../../navbar.php'); ?>

    <div class="m-5 text-center">
        <h3>Skyworks - GITransAPI</h3>
    </div>

    <div class="conatiner mt-5">
        <div class="row justify-content-center">
            <div class="col-auto col-md-5 mt-5">
                <input class="form-control form-control-lg" type="file" id="input" accept=".xls,.xlsx">
            </div>
            <div class="col-auto col-md-2 mt-5">
                <button class="btn btn-lg btn-primary" id="button">Convert</button>
            </div>
            <form class="col-12" method="post" name="form" action="upload.php">
                <div class="row justify-content-center text-center">

                    <div class="m-5">
                        <button class="btn btn-lg btn-danger invisible" id="uploadBtn">Upload</button>
                        <input type="text" id="upload" class="form-control d-none" name="upload" value="" aria-describedby="passwordHelpInline">
                    </div>

                </div>
            </form>
            <div class="col-md-12 invisible" id="jsondataContent">
                <h3 class="text-center">Result of XLS conversion to JSON</h3>
                <pre id="jsondata" name="jsondata"></pre>
            </div>
        </div>

        <script type="text/javascript">
            let selectedFile;
            console.log(window.XLSX);
            document.getElementById('input').addEventListener("change", (event) => {
                selectedFile = event.target.files[0];
            })

            let data = [{
                "name": "jayanth",
                "data": "scd",
                "abc": "sdef"
            }]

            document.getElementById('button').addEventListener("click", () => {
                XLSX.utils.json_to_sheet(data, 'out.xlsx');
                if (selectedFile) {
                    let fileReader = new FileReader();
                    fileReader.readAsBinaryString(selectedFile);
                    fileReader.onload = (event) => {
                        let data = event.target.result;
                        let workbook = XLSX.read(data, {
                            type: "binary"
                        });
                        console.log(workbook);
                        workbook.SheetNames.forEach(sheet => {
                            let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                            console.log(rowObject);
                            document.getElementById("jsondata").innerHTML = JSON.stringify(rowObject, undefined, 4)
                            document.getElementById("upload").value = JSON.stringify(rowObject, undefined, 4)
                        });
                    }
                    document.getElementById("uploadBtn").className = "btn btn-lg btn-danger visible"
                    document.getElementById("jsondataContent").className = "col-md-12 bg-light visible"


                }
            });
        </script>

</body>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>