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
<div class="container">

<?php
$record=$_GET['record'];


$update=False;
if(!$record){
  $record=   addslashes($_POST['id']);
  $key=      addslashes($_POST['key']);
  $author=   addslashes($_POST['author']);
  $year=     addslashes($_POST['year']);
  $abstract= addslashes($_POST['abstract']);
  $keywords= addslashes($_POST['keywords']);
  $volume=   addslashes($_POST['volume']);
  $number=   addslashes($_POST['number']);
  $pages=    addslashes($_POST['pages']);
  $url=      addslashes($_POST['url']);
  $comments= addslashes($_POST['comments']);
  $title=    addslashes($_POST['title']);


//escape all of these! and then put quotes

  echo $record;
  echo "<h1>Editing Record...</h1>";
$sql_SQRY= 'UPDATE `library` SET `key` = "'. $key.'", `author` = "'. $author. '", `year` = "'. $year.'", `abstract` = "'.$abstract.'", `keywords` = "'.$keywords.'", `volume` = "'.$volume.'", `number` = "'.$number.'", `pages` = "'.$pages.'", `url` = "'.$url.'", `comments` = "'.$comments.'", `title` = "'.$title.'" WHERE `id` = "'. $record .'";';
  $update=True;
}

include 'dbconn.php';

if(!$con) {
    echo "ERROR. Could not connect to database. Firewall problem?";
    echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
} elseif($update) {
    mysqli_query($con,$sql_SQRY);
    mysqli_commit($con);
    echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
    mysqli_close($con);
    header('Location: search.php?query='.$key);
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
}

$title=     $row['title'];
$abstract=  $row['abstract'];
$author=    $row['author'];
$year=      $row['year'];
$keywords=  $row['keywords'];
$volume=    $row['volume'];
$number=    $row['number'];
$pages=     $row['pages'];
$url=       $row['url'];
$comments=  $row['comments'];
$key=       $row['key'];
$haspdf=    $row['haspdf'];

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
<form action="edit.php" method="post">
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="inputKey">Key</label>
      <input type="text" class="form-control" name="key" placeholder="Reference key..." value ="<?php echo $key; ?>">
    </div>
    <div class="form-group col-md-9">
      <label for="inputTitle">Title</label>
	  <textarea class="form-control" placeholder="Title of source..." name="title"><?php echo $title; ?></textarea>
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-3">
    <label for="inputYear">Year</label>
    <input type="text" class="form-control" name="year" placeholder="Year..." value="<?php echo $year; ?>">
  </div>
  <div class="form-group col-md-9">
    <label for="inputAuthor">Author</label>
    <input type="text" class="form-control" name="author" placeholder="Author..." value="<?php echo $author; ?>">
  </div>
 </div>
<div class="form-group">
	<label for="inputAbstract">Abstract</label>
	<textarea class="form-control" placeholder="Abstract / main text of the source..." name="abstract"><?php echo $abstract; ?></textarea>

</div>
<div class="form-group">
	<label for="inputComments">Comments</label>
	<textarea class="form-control" placeholder="Notable comments... Journal / article etc." name="comments"><?php echo $comments; ?></textarea>

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
      <input type="text" class="form-control" name="volume" placeholder="Volume No." value="<?php echo $volume; ?>">
    </div>
    <div class="form-group col-md-4">
      <label for="inputNumber">Number</label>
      <input type="text" id="inputState" class="form-control" name="number" placeholder="Number" value="<?php echo $number; ?>">
    </div>
    <div class="form-group col-md-4">
      <label for="inputPages">Pages</label>
      <input type="text" class="form-control" placeholder="Page ranges... e.g. 112-118" name="pages" value="<?php echo $pages; ?>">
    </div>
  </div>
  <input type="hidden" value="<?php echo $record; ?>" name="id" />

  <button type="submit" class="btn btn-primary">Submit</button>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>


</div>
</body>
</html>
