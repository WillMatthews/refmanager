<html>
<head>
<style type="text/css">
body,td,th {
    font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    text-align: center;
    font-size: medium;
}
</style>
</head>
<body>

<?php
$record=$_GET['record'];

if(!$record){
echo "<h1>No ID Data, Please Try Again.</h1>";
exit();
}

include 'dbconn.php';

if(!$con) {
    echo " ERROR. Could not connect to database. Firewall problem?";
    echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
} else {
    $sql_SQRY="SELECT library.`id`,
    library.`key`,
    library.`author`,
    library.`year`,
    library.`abstract`,
    library.`keywords`,
    library.`volume`,
    library.`number`,
    library.`pages`,
    library.`url`,
    library.`comments`,
    library.`title`,
    library.`haspdf` FROM `library` WHERE `id` LIKE " . $record . ";";
}

// run QUERY and then fetch ROW from RESULT
$result=mysqli_query($con,$sql_SQRY);
$row=mysqli_fetch_assoc($result);

if(!$result){
  echo "<h1>No Matching Record Found. Please Try Again</h1>";
  exit();
} else {
  echo "<h1>Editing Record: ".$row['key'] . "</h1>";
}

$title=$row['title'];
$abstract=$row['abstract'];
$author=$row['author'];
$year=$row['year'];
$keywords=$row['keywords'];
$volume=$row['volume'];
$number=$row['number'];
$pages=$row['pages'];
$url=$row['url'];
$comments=$row['comments'];
$key=$row['key'];
$haspdf=$row['haspdf'];

mysqli_close($con);

if ( !empty( $row["haspdf"] ) ) {
    echo "<a href='getpdf.php?record=". $row["id"] ."' target='_blank'>View PDF</a> <br/>";
    echo "<a href='uploadpdf.php?record=". $row["id"] ."' target='_blank'>Upload New PDF</a>";
} else {
    echo "<a href='uploadpdf.php?record=". $row["id"] ."' target='_blank'>Add PDF</a>";
} 

?>

<!-- PUT THE FORM HERE!
key
title
author
year
abstract
keywords
volume
number
pages
url
comments
-->



</body>
</html>
