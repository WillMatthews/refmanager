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

include 'dbconn.php';
if($key){

//escape all of these! and then put quotes

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



  if(!$con) {
    echo "ERROR. Could not connect to database. Firewall problem?";
    echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
  } else {
    mysqli_query($con,$sql_SQRY);
    mysqli_commit($con);
    echo mysqli_error($con);
    echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
    mysqli_close($con);
    header('Location: search.php?query='.$key);
    exit();
  }

} else { // if there is no POST data

  $sql_SQRY="SELECT MAX(`key`) FROM `library`";
  if(!$con){
    echo "<h1>NO DATABASE CONNECTION!</h1>";
    echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
    exit();
  }
  // run QUERY and then fetch ROW from RESULT
  $result=mysqli_query($con,$sql_SQRY);
  $row=mysqli_fetch_array($result);
  echo "<h1>Add a Record</h1>";
  echo $row[0];
  $newKey = $row[0] + 1;
}
?>

<br/>
<br/>
<form action="add.php" method="post">
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="inputKey">Key</label>
      <input type="text" class="form-control" name="key" placeholder="Reference key..." value ="<?php echo $newKey; ?>">
    </div>
    <div class="form-group col-md-9">
      <label for="inputTitle">Title</label>
	  <textarea class="form-control" placeholder="Title of source..." name="title"></textarea>
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-3">
    <label for="inputYear">Year</label>
    <input type="text" class="form-control" name="year" placeholder="Year..." >
  </div>
  <div class="form-group col-md-9">
    <label for="inputAuthor">Author</label>
    <input type="text" class="form-control" name="author" placeholder="Author..." >
  </div>
 </div>
<div class="form-group">
	<label for="inputAbstract">Abstract</label>
	<textarea class="form-control" placeholder="Abstract / main text of the source..." name="abstract"></textarea>

</div>
<div class="form-group">
	<label for="inputComments">Comments</label>
	<textarea class="form-control" placeholder="Notable comments... Journal / article etc." name="comments"></textarea>

</div>
<div class="form-group">
    <label for="inputURL">URL</label>
    <input type="text" class="form-control" name="url" placeholder="URL...">
</div>
<div class="form-group">
    <label for="inputAuthor">Keywords</label>
    <input type="text" class="form-control" name="keywords" placeholder="Keywords..." >
</div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputVolume">Volume</label>
      <input type="text" class="form-control" name="volume" placeholder="Volume No." >
    </div>
    <div class="form-group col-md-4">
      <label for="inputNumber">Number</label>
      <input type="text" id="inputState" class="form-control" name="number" placeholder="Number">
    </div>
    <div class="form-group col-md-4">
      <label for="inputPages">Pages</label>
      <input type="text" class="form-control" placeholder="Page ranges... e.g. 112-118" name="pages" >
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>


</div>
</body>
</html>
