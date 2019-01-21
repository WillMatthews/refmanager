<?php

if(isset($_GET['record'])) {
  $record=$_GET['record'];
}

if(!isset($_GET['record'])) {
  echo "<h1>No ID Data, Please Try Again.</h1>";
  exit();
}

include 'dbconn.php';

if(!$con) {
  echo " ERROR. Could not connect to database. Firewall problem?";
  echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
} else {
  $sql_SQRY="SELECT * FROM `library` WHERE `id` LIKE " . $record . ";";
}

//echo "<br/><br/><br/>".$sql_SQRY."<br/><br/><br/>";

// run QUERY and then fetch ROW from RESULT
$result=mysqli_query($con,$sql_SQRY);
$row=mysqli_fetch_assoc($result);

if(!$result){
  echo "<h1>No Matching Record Found. Please Try Again</h1>";
  mysqli_close($con);
  exit();
} elseif(!$row['pdf']) {
  echo "<h1>No PDF Data Found. Please Try Again</h1>";
  mysqli_close($con);
  exit();
} else {
  echo "<h1>Obtaining your file...</h1>";
  $pdfDoc = base64_decode($row['pdf']);
  mysqli_close($con);
}


// DOWNLOAD FILE
header('Content-Disposition: attachment; filename="'.$row['key'].'.pdf"');
//header('Content-Type: application/pdf');// . _mime_content_type($_FILES['userFile']['name']));
//header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Content-Length: ' . strlen($row['pdf']));
header('Connection: close');

echo ($pdfDoc);

?>
