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
// REMEMBER TO USE `addslashes` for the upload form!
$record=$_GET['record'];
include 'dbconn.php';

// run QUERY and then fetch ROW from RESULT
$sql_SQRY="SELECT * FROM `library` WHERE `id` LIKE ".$record.";";
$result=mysqli_query($con,$sql_SQRY);
$row=mysqli_fetch_assoc($result);

echo "<h1>Add a PDF for Record: " . $row['key'] . "</h1>";
if ($row['haspdf'] or count($_FILES > 0)) {
        echo "<h2>PDF Present, Upload will replace existing PDF.</h2>";
} else {
        echo "<h2>No PDF Present, Upload will add a PDF.</h2>";
}

if (count($_FILES) > 0) {
    if (is_uploaded_file($_FILES['userFile']['tmp_name'])) {
        $fileData = base64_encode(file_get_contents($_FILES['userFile']['tmp_name']));

        $sql_SQRY = 'UPDATE `library` SET `haspdf` = 1, `pdf` = "'. $fileData . '" WHERE `id` = ' . $record . ';';
        mysqli_query($con,$sql_SQRY);

        echo mysqli_error($con)."<br/><br/>";
        }
}

mysqli_close($con);

?>

<br/>
2MB limit (as set by php.ini)
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
</BODY>
</HTML>
