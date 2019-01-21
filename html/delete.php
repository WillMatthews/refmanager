<html>
<head>
<style type="text/css">
body,td,th {
    font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    text-align: center;
    font-size: medium;
}
</style>
<title>Add a PDF</title>
</head>
<body>

<?php

$record=$_GET['record'];
include 'dbconn.php';

$sql_SQRY="DELETE FROM `library` WHERE `id` = ".$record.";";
$result=mysqli_query($con,$sql_SQRY);
$row=mysqli_fetch_assoc($result);

echo "<h1>Record ".$row['key'] ." deleted.</h1>";
echo "<h2>Close this page to continue.</h2>";

?>
