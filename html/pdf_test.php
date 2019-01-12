<?php

include 'config.php';

$con=mysqli_connect($dbhost,$user,$pass,$dbname);//code hangs here???

if (count($_FILES) > 0) {
    if (is_uploaded_file($_FILES['userImage']['tmp_name'])) {
        require_once "db.php";
        $imgData = addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
        $imageProperties = getimageSize($_FILES['userImage']['tmp_name']);
        
        $sql = "INSERT INTO database( pdfData) VALUES('{$imgData}')";
        }
}
?>
<HTML>
<BODY>
    <form name="frmImage" enctype="multipart/form-data" action=""
        method="post" class="frmImageUpload">
        <label>Upload Image File:</label><br /> <input name="userImage"
            type="file" class="inputFile" /> <input type="submit"
            value="Submit" class="btnSubmit" />
    </form>
    </div>
</BODY>
</HTML>
