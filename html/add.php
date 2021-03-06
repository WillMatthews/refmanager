<html>
<head>
<style type="text/css">
body,td,th {
    font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    text-align: center;
    font-size: medium;
}
</style>
<title>Add a Record</title>
<link rel="stylesheet" href="static/bootstrap.css">
</head>
<body>
<div class="container">

<?php

include 'dbconn.php';


if(!$con){
  echo "<h1>ERROR. Could not connect to database.</h1>";
  echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
  exit();
}



if(isset($_POST['key'])){

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

  echo "<h1>Adding Record</h1>";
  $sql_SQRY= 'INSERT INTO `library`
          (`key`,
          `author`,
          `year`,
          `abstract`,
          `keywords`,
          `volume`,
          `number`,
          `pages`,
          `url`,
          `comments`,
          `title`)
          VALUES
          ("'.$key .'",
          "'. $author .'",
          "'. $year .'",
          "'. $abstract .'",
          "'. $keywords.'",
          "'. $volume.'",
          "'. $number.'",
          "'. $pages.'", 
          "'. $url.'", 
          "'. $comments.'",
          "'. $title.'");';

  mysqli_query($con,$sql_SQRY);
  mysqli_commit($con);
  echo mysqli_error($con);
  mysqli_close($con);
  header('Location: search.php?query='.$key);
  exit();

} else { // if there is no POST data

  // run QUERY and then fetch ROW from RESULT
  $sql_SQRY="SELECT MAX(`key`) FROM `library`";
  $result=mysqli_query($con,$sql_SQRY);
  $row=mysqli_fetch_array($result);
  echo "<h1>Add a Record</h1>";
  $newKey = $row[0] + 1;
}
?>

<br/>
<br/>
<form action="add.php" method="post">
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="inputKey">Key</label>
      <input type="text" class="form-control" name="key" placeholder="Reference Key..." value ="<?php echo $newKey; ?>" autocomplete="off">
    </div>
    <div class="form-group col-md-9">
      <label for="inputTitle">Title</label>
	  <textarea class="form-control" placeholder="Title of source..." name="title"></textarea>
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-3">
    <label for="inputYear">Year</label>
    <input type="text" class="form-control" name="year" placeholder="Year..." autocomplete="off">
  </div>
  <div class="form-group col-md-9">
    <label for="inputAuthor">Author</label>
    <input type="text" class="form-control" name="author" placeholder="Author..." autocomplete="off">
  </div>
 </div>
<div class="form-group">
	<label for="inputAbstract">Abstract</label>
	<textarea class="form-control" placeholder="Abstract / Source Text..." name="abstract"></textarea>

</div>
<div class="form-group">
	<label for="inputComments">Comments</label>
	<textarea class="form-control" placeholder="Notable comments... (Journal / Article etc.)" name="comments"></textarea>

</div>
<div class="form-group">
    <label for="inputURL">URL</label>
    <input type="text" class="form-control" name="url" placeholder="URL..." autocomplete="off">
</div>
<div class="form-group">
    <label for="inputAuthor">Keywords</label>
    <input type="text" class="form-control" name="keywords" placeholder="Keywords..." autocomplete="off">
</div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputVolume">Volume</label>
      <input type="text" class="form-control" name="volume" placeholder="Volume No..." autocomplete="off">
    </div>
    <div class="form-group col-md-4">
      <label for="inputNumber">Number</label>
      <input type="text" id="inputState" class="form-control" name="number" placeholder="Number..." autocomplete="off">
    </div>
    <div class="form-group col-md-4">
      <label for="inputPages">Pages</label>
      <input type="text" class="form-control" placeholder="Page Ranges..." name="pages" autocomplete="off">
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>
</body>
</html>
