<?php
$jsonData = $_POST['upload'];
?>

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

            <div class="card col-10">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" id="responseIsSuccess">An item</li>
                    <li class="list-group-item" id="responseMessage">A second item</li>
                    <li class="list-group-item" id="responseHeaderError">A third item</li>
                    <li class="list-group-item" id="responseDetailError">A third item</li>
                </ul>
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

        <?php

        $curl = curl_init();

        curl_setopt_array($curl, array(
            //CURLOPT_URL => 'http://10.161.252.23:8120/V3NewAPI/WM_APP/insertEDIDataToGISkyworks',
            CURLOPT_URL => 'https://diltpe.dimerco.com:8888/V3NewAPI/WM_APP/insertEDIDataToGISkyworks',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
        "stationID" : "725",
        "CurrentUserID" : "B0191",
        "projectID" : 99,
        "CNEE" : 287392,
        "data":
      ' . $jsonData . '
   }  ',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo '<span class="d-none" id="response">' . $response . '</span>';

        echo '<script type="text/JavaScript">
        responseHTML = document.getElementById("response").innerHTML
        responseArr = responseHTML.split(",");

        document.getElementById("responseIsSuccess").innerHTML = responseArr[2];
        document.getElementById("responseMessage").innerHTML = responseArr[3];
        document.getElementById("responseHeaderError").innerHTML = responseArr[4];
        document.getElementById("responseDetailError").innerHTML = responseArr[5];
        
        </script>'

        ?>












</body>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->
<!--<script src="excel.js"></script> -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>