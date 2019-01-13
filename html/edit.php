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


$update=False;
if(!$record){
  $record=$_POST['id'];
  $key=$_POST['key'];
  $author=$_POST['author'];
  $year=$_POST['year'];
  $abstract=$_POST['abstract'];
  $keywords=$_POST['keywords'];
  $volume=$_POST['volume'];
  $number=$_POST['number'];
  $pages=$_POST['pages'];
  $url=$_POST['url'];
  $comments=$_POST['comments'];
  $title=$_POST['title'];


//escape all of these! and then put quotes

  echo $record;
  echo "<h1>Editing Record...</h1>";
$sql_SQRY= "UPDATE `library` SET `key` = ". $key.", `author` = ". $author. ", `year` = ". $year.", `abstract` = ".$abstract.", `keywords` = ".$keywords.", `volume` = ".$volume.", `number` = ".$number.", `pages` = ".$pages.", `url` = ".$url.", `comments` = ".$comments.", `title` = ".$title." WHERE `id` = ". $record .";";
  $update=True;
}

include 'dbconn.php';

if(!$con) {
    echo "ERROR. Could not connect to database. Firewall problem?";
    echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
} elseif($update) {
echo $sql_SQRY;
  mysqli_query($con,$sql_SQRY);
  mysqli_commit($con);
  mysqli_close($con);
  exit();
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
  echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
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

<br/>
<br/>
<br/>
<br/>

<form action="edit.php" method="post">
Key: <input type="text" name="key" value="<?php echo $key; ?>" ><br>
Title: <input type="text" name="title" value="<?php echo $title; ?>" ><br>
Author: <input type="text" name="author" value="<?php echo $author; ?>" ><br>
Year: <input type="text" name="year" value="<?php echo $year; ?>" ><br>
Abstract: <input type="text" name="abstract" value="<?php echo $abstract; ?>" ><br>
Keywords: <input type="text" name="keywords" value="<?php echo $keywords; ?>" ><br>
Volume: <input type="text" name="volume" value="<?php echo $volume; ?>" ><br>
Number: <input type="text" name="number" value="<?php echo $number; ?>" ><br>
Pages: <input type="text" name="pages" value="<?php echo $pages; ?>" ><br>
URL: <input type="text" name="url" value="<?php echo $url; ?>" ><br>
Comments: <input type="text" name="comments" value="<?php echo $comments; ?>" ><br>
<input type="hidden" value="<?php echo $record; ?>" name="id" />
<input type="submit">
</form>



</body>
</html>
