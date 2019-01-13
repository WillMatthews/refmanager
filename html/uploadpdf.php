<?php
// REMEMBER TO USE `addslashes` for the upload form!
$record=$_GET['record'];
include 'dbconn.php';

// run QUERY and then fetch ROW from RESULT
$sql_SQRY="SELECT * FROM `library` WHERE `id` LIKE ".$record.";";
$result=mysqli_query($con,$sql_SQRY);
$row=mysqli_fetch_assoc($result);

echo "<h1>Add a PDF for Record: " . $row['key'] . "</h1>";

if (count($_FILES) > 0) {
    if (is_uploaded_file($_FILES['userFile']['tmp_name'])) {
        $fileData = addslashes(file_get_contents($_FILES['userFile']['tmp_name']));

        //$sql = "INSERT INTO database( pdfData) VALUES('{$imgData}')";

        }
}
?>

<HTML>
Form takes a file, sends it via POST, which converts to string and returns the original file through headers.
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
