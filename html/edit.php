
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
    $sql_SQRY="SELECT * FROM `library` WHERE `id` IS " . $record . ";";
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

?>
