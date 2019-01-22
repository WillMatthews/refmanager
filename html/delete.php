<html>
<head>
<style type="text/css">
body,td,th {
    font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    text-align: center;
    font-size: medium;
}
</style>
<title>Deletion Complete</title>
</head>
<body>
<?php
if(isset($_GET['record'])) {
  $record=$_GET['record'];
  include 'dbconn.php';

  $sql_SQRY="DELETE FROM `library` WHERE `id` = ".$record.";";
  mysqli_query($con,$sql_SQRY);
  mysqli_commit($con);
  mysqli_close($con);

  echo "<h1>Record ".$row['key']." deleted.</h1>";
  echo "<h2>Close this page to continue.</h2>";
  echo "<script>window.close();</script>";
}
?>
</body>
</html>
