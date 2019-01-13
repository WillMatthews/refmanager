<html>
<head>
<style type="text/css">
body,td,th {
    font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    text-align: center;
    font-size: medium;
}
</style>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>
<body>
<div class =container>
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
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="inputKey">Key</label>
      <input type="text" class="form-control" name="key" placeholder="Key" value ="<?php echo $key; ?>">
    </div>
    <div class="form-group col-md-9">
      <label for="inputTitle">Title</label>
      <input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo $title; ?>">
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-3">
    <label for="inputYear">Year</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Year" value="<?php echo $year; ?>">
  </div>
  <div class="form-group col-md-9">
    <label for="inputAuthor">Author</label>
    <input type="text" class="form-control" name="author" placeholder="Test" value="<?php echo $author; ?>">
  </div>
 </div>
<div class="form-group">
	<label for="inputAbstract">Abstract</label>
	<textarea class="form-control" name="abstract"><?php echo $keywords; ?></textarea>

</div>
<div class="form-group">
	<label for="inputComments">Comments</label>
	<textarea class="form-control" name="comments"><?php echo $comments; ?></textarea>

</div>
<div class="form-group">
    <label for="inputURL">URL</label>
    <input type="text" class="form-control" name="url" placeholder="URL..." value="<?php echo $url; ?>">
</div>
<div class="form-group">
    <label for="inputAuthor">Keywords</label>
    <input type="text" class="form-control" name="keywords" placeholder="Keywords..." value="<?php echo $keywords; ?>">
</div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputVolume">Volume</label>
      <input type="text" class="form-control" name="volume" value="<?php echo $volume; ?>">
    </div>
    <div class="form-group col-md-4">
      <label for="inputNumber">Number</label>
      <input type="text" id="inputState" class="form-control" name="number" value="<?php echo $number; ?>">
    </div>
    <div class="form-group col-md-4">
      <label for="inputPages">Pages</label>
      <input type="text" class="form-control" name="pages" value="<?php echo $pages; ?>">
    </div>
  </div>
  <input type="hidden" value="<?php echo $record; ?>" name="id" />

  <button type="submit" class="btn btn-primary">Submit</button>
</form>


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

<input type="submit">
</form>


</div>
</body>
</html>
