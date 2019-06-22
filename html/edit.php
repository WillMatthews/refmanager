<html>
<head>
<!--
<style type="text/css">
body,td,th {
    font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    text-align: center;
    font-size: medium;
}
</style>
-->
<title>Edit a Record</title>
<link rel="stylesheet" href="static/bootstrap.css">

</head>
<body>

<div class="container">

<?php

include 'dbconn.php';


if(isset($_GET['record'])) {
  $record=$_GET['record'];
}

$update=False;
if(!isset($_GET['record'])){
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

  $sql_SQRY="SELECT `id` FROM `library` WHERE `key` = ".$record.";";
  $result=mysqli_query($con,$sql_SQRY);
  $row=mysqli_fetch_assoc($result);


  $sql_SQRY= 'UPDATE `library` SET `key` = "'. $key.'", `author` = "'. $author. '", `year` = "'. $year.'", `abstract` = "'.$abstract.'", `keywords` = "'.$keywords.'", `volume` = "'.$volume.'", `number` = "'.$number.'", `pages` = "'.$pages.'", `url` = "'.$url.'", `comments` = "'.$comments.'", `title` = "'.$title.'" WHERE `id` = "'. $row["id"] .'";';
  $update=True;
}


if(!$con) {
    echo "<h1>ERROR. Could not connect to database.</h1>";
    echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
    exit();
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
               library.`haspdf` FROM `library` WHERE `key` = " . $record . ";";
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

if(!empty($row["haspdf"])) {
    echo "<a href='static/pdfs/" . $row["key"] . ".pdf' target='_blank'>View PDF</a> <br/>";
    echo "<a href='uploadpdf.php?record=" . $row["key"] . "' target='_blank'>Upload New PDF / Delete PDF</a>";
} else {
    echo "<a href='uploadpdf.php?record=" . $row["key"] . "' target='_blank'>Add PDF</a>";
}
echo "<br/><br/><a href='delete.php?record=" . $row["id"] . "' class='confirmation'  ><font color='red'>Delete Record</font></a>";
?>

<br/>
<br/>
<form action="edit.php" method="post">
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="inputKey">Key</label>
      <input type="text" class="form-control" name="key" placeholder="Reference Key..." value ="<?php echo $key; ?>" autocomplete="off">
    </div>
    <div class="form-group col-md-9">
      <label for="inputTitle">Title</label>
	  <textarea class="form-control" placeholder="Title of source..." name="title"><?php echo $title; ?></textarea>
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-3">
    <label for="inputYear">Year</label>
    <input type="text" class="form-control" name="year" placeholder="Year..." value="<?php echo $year; ?>" autocomplete="off">
  </div>
  <div class="form-group col-md-9">
    <label for="inputAuthor">Author</label>
    <input type="text" class="form-control" name="author" placeholder="Author..." value="<?php echo $author; ?>">
  </div>
 </div>
<div class="form-group">
	<label for="inputAbstract">Abstract</label>
	<textarea class="form-control" placeholder="Abstract / Source Text..." name="abstract"><?php echo $abstract; ?></textarea>

</div>
<div class="form-group">
	<label for="inputComments">Comments</label>
	<textarea class="form-control" placeholder="Notable comments... (Journal / Article etc.)" name="comments"><?php echo $comments; ?></textarea>

</div>
<div class="form-group">
    <label for="inputURL">URL</label>
    <input type="text" class="form-control" name="url" placeholder="URL..." value="<?php echo $url; ?>" autocomplete="off">
</div>
<div class="form-group">
    <label for="inputAuthor">Keywords</label>
    <input type="text" class="form-control" name="keywords" placeholder="Keywords..." value="<?php echo $keywords; ?>" autocomplete="off">
</div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputVolume">Volume</label>
      <input type="text" class="form-control" name="volume" placeholder="Volume No..." value="<?php echo $volume; ?>" autocomplete="off">
    </div>
    <div class="form-group col-md-4">
      <label for="inputNumber">Number</label>
      <input type="text" id="inputState" class="form-control" name="number" placeholder="Number..." value="<?php echo $number; ?>" autocomplete="off">
    </div>
    <div class="form-group col-md-4">
      <label for="inputPages">Pages</label>
      <input type="text" class="form-control" placeholder="Page Ranges..." name="pages" value="<?php echo $pages; ?>" autocomplete="off">
    </div>
  </div>
  <input type="hidden" value="<?php echo $record; ?>" name="id" />

  <button type="submit" class="btn btn-primary">Submit</button>
  <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
</form>
</div>

<script type="text/javascript">
var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
              if (!confirm('Are you sure you want to delete? (This cannot be undone!)')) e.preventDefault();
                  };
for (var i = 0, l = elems.length; i < l; i++) {
          elems[i].addEventListener('click', confirmIt, false);
              }
</script>

</body>
</html>
