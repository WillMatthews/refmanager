<h1> Obtaining your PDF... </h1>

<?php
$record=$_GET['record'];

include 'config.php';

$con=mysqli_connect($dbhost,$user,$pass,$dbname);//code hangs here???

if(!$con) {
    echo " ERROR. Could not connect to database. Firewall problem?";
    echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
} else {
    $sql_SQRY="SELECT * FROM `library` WHERE `id` IS " . $record . ";";
}

$result=mysqli_query($con,$sql_SQRY);

$row=mysqli_fetch_assoc($result);

$row["pdf"]


?>
