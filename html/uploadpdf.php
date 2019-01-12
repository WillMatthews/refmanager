<?php


if(!function_exists('_mime_content_type')) {

    function _mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}


// REMEMBER TO USE `addslashes` for the upload form!

include 'dbconn.php';


if (count($_FILES) > 0) {
    if (is_uploaded_file($_FILES['userFile']['tmp_name'])) {
        $fileData = addslashes(file_get_contents($_FILES['userFile']['tmp_name']));
        //$imageProperties = getimageSize($_FILES['userFile']['tmp_name']);
        /////////file_put_contents("data.pdf",$fileData);
        //$sql = "INSERT INTO database( pdfData) VALUES('{$imgData}')";

        header('Content-Disposition: attachment; filename="'.$_FILES['userFile']['name'].'"');
        //header('Content-Type: application/pdf');// . _mime_content_type($_FILES['userFile']['name']));
        //header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Content-Length: ' . strlen($fileData));
        header('Connection: close');

        echo stripslashes($fileData);
        }
}
?>

<HTML>
Form takes a file, sends it via POST, which converts to string and returns the original file through headers.
<br/>
Use this PHP for file upload and file download components.
2MB limit (as set by php.ini)
<br/>
<br/>
<BODY>
    <form name="frmImage" enctype="multipart/form-data" action=""
        method="post" class="frmImageUpload">
        <label>Upload File:</label><br /> <input name="userFile"
            type="file" class="inputFile" /> <input type="submit"
            value="Submit" class="btnSubmit" />
    </form>
    </div>
</BODY>
</HTML>
