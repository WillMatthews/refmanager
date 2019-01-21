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
// REMEMBER TO USE `addslashes` for the upload form!


include 'dbconn.php';

if(!$con) {
  echo " ERROR. Could not connect to database.";
  echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
  exit();
} 



if(isset($_GET['del'])) {
  if($_GET['del'] == 1) {
    $sql_SQRY="UPDATE `library`
               SET `haspdf`= 0, `pdf`= Null
               WHERE `id` = ".$_GET['record'].";";

    mysqli_query($con,$sql_SQRY);
    mysqli_commit($con);
    mysqli_close($con);
    header('Location: uploadpdf.php?record='.$_GET['record']);
    exit();
  }
}






$record=$_GET['record'];

// run QUERY and then fetch ROW from RESULT
$sql_SQRY="SELECT * FROM `library` WHERE `id` LIKE ".$record.";";
$result=mysqli_query($con,$sql_SQRY);
$row=mysqli_fetch_assoc($result);

if(!$result) {
    echo "ERROR!  NO RESULT RETURNED FROM TABLE<br/>";
    echo mysqli_error($con);
    exit();
}



echo "<h1>Add a PDF for Record: " . $row['key'] . "</h1>";
if ($row['haspdf'] or count($_FILES) > 0) {
  echo "<h2>PDF Present, Upload will replace existing PDF.</h2>";

  echo "<br/><br/><a href='uploadpdf.php?record=" . $row["id"] . "&del=1' class='confirmation'  ><font color='red'>Delete PDF</font></a>";

} else {
  echo "<h2>No PDF Present, Upload will add a PDF.</h2>";
}

if (count($_FILES) > 0) {
  if (is_uploaded_file($_FILES['userFile']['tmp_name'])) {
    $fileData = base64_encode(file_get_contents($_FILES['userFile']['tmp_name']));

    $sql_SQRY = 'UPDATE `library` SET `haspdf` = 1, `pdf` = "'. $fileData . '" WHERE `id` = ' . $record . ';';
    mysqli_query($con,$sql_SQRY);
    mysqli_commit($con);

  }
}
echo mysqli_error($con)."<br/><br/>";

mysqli_close($con);
?>

<br/>
20MB limit (as set by php.ini)
<br/>
<br/>
<BODY>
    <form name="frmImage" enctype="multipart/form-data" action=""
        method="post" class="frmImageUpload">
        <label>Upload File:</label><br /> <input name="userFile"
            type="file" class="inputFile" accept="application/pdf"/> <input type="submit"
            value="Submit" class="btnSubmit" />
    </form>
    </div>


<script type="text/javascript">
var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
              if (!confirm('Are you sure you want to delete?')) e.preventDefault();
                  };
for (var i = 0, l = elems.length; i < l; i++) {
          elems[i].addEventListener('click', confirmIt, false);
              }
</script>



</BODY>
</HTML>
