

<?php
/*
$servername ="diltpe.dimerco.com";
$username ="BITWeb";
$password ="Web2012@P";
$db ="eChainVP_DILTPE";

$conn = sqlsrv_connect($server, $cinfo);

if(!$conn)
{
  die("connection Failed".mysqli_connect_error());
}
*/
?>



<?php
$server   = "diltpe.dimerco.com";
$database = "eChainVP_DILTPE";
$username = "L0029";
$password = "M9P8et*H";

$cinfo = array(
    "Database" => $database,
    "UID" => $username,
    "PWD" => $password,
    "CharacterSet" => "UTF-8"
);
$conn = sqlsrv_connect($server, $cinfo);
if ($conn === false) {
    echo "Error (sqlsrv_connect): " . print_r(sqlsrv_errors(), true);
    exit;
}

?>