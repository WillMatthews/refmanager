<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<!-- Adapted from FEUDAL
      VERSION 3 -->

<html>
<head>
<style type="text/css">
body,td,th {
    font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    text-align: center;
    font-size: small;
}
</style>
<title>AgriCoat Library Search</title>
<link href="style_std.css" rel="stylesheet" type="text/css">
<style type="text/css">
body,td,th {
    font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
    text-align: center;
    font-size: small;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<FORM ACTION="search.php" method=get>
  <table width="100%" height="734" border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td><table width="100%" height="980" border="0" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
          <td width="60%"><table width="100%" height="734" border="0" cellpadding="0" cellspacing="0">
            <tbody>
              <tr>
                <td><table width="100%" height="980" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                    <tr>
                      <td width="20%" height="144">&nbsp;</td>
                      <td width="60%"><p class="s_font"><strong><em style="font-size: 64px">AgriCoat Library</em></strong></p>
                        <p class="s_font" style="font-size: 16px"><a href="search.php">Search</a> • <a href="add.php">Add Record</a> • <a href="edit.php" target="_blank">Edit Record</a> • <a href="errors.php">Errors</a></p></td>
                      <td width="20%">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="235">&nbsp;</td>
                      <td><table width="575" height="227" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tbody>
                          <tr>
                            <td width ="70" height="57">&nbsp;</td>
                            <td width="435"><div style = "text-align:center"><span class="Style_1" style="font-size: medium"> Search AgriCoat Library</span></div></td>
                            <td width="70">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="35">&nbsp;</td>
                            <td><input name="query" type="text" autofocus="autofocus" class="Style_1" placeholder="Insert Your Search Term (one word)" size="44" maxlength="35" value="<?php echo isset($_GET['query']) ? $_GET['query'] : '' ?>" ></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="34">&nbsp;</td>
                            <td><input type="submit" class="Style_1" value="Search"  ></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="86">&nbsp;</td>
                            <td style="text-align: center"><p><br />
                              Choose how data should be presented:</p>
                              <table width="165" align="center">
                                <tr>
                                  <td width="157" style="text-align: left"><label>
                                    <input name="order" type="radio" id="order_0" value="kd"<?php if($_GET['order'] == "kd" OR !$_GET['order']) { print ' checked="checked"'; } ?>>
                                    Record No Descending</label></td>
                                </tr>
                                <tr>
                                  <td style="text-align: left"><label>
                                    <input type="radio" name="order" value="ka" id="order_1"<?php if($_GET['order'] == "ka") { print ' checked="checked"'; } ?>>
                                    Record No Ascending</label></td>
                                </tr>
                                <tr>
                                  <td style="text-align: left"><label>
                                    <input name="order" type="radio" id="order_2" value="dd"<?php if($_GET['order'] == "dd") { print ' checked="checked"'; } ?>>
                                    Date Descending</label></td>
                                </tr>
                                <tr>
                                  <td style="text-align: left"><label>
                                    <input name="order" type="radio" id="order_3" value="da"<?php if($_GET['order'] == "da") { print ' checked="checked"'; } ?>>
                                    Date Ascending</label></td>
                                </tr>
                              </table>
                              <p></p></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td style="text-align: center"><p>Something not working? Contact William or Charles</p></td>

                            <td>&nbsp;</td>
                          </tr>
                        </tbody>
                      </table></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="135">&nbsp;</td>
                      <td style="font-size: 16px"><p><span style="font-size: medium">
<?php

// CHECK INDENTING! I think it is very fishy...


    // SQL VARS
    include 'dbconn.php';

    // Start Timer
    $time_start=microtime(true);

    if(!$con) {
        echo " ERROR. Could not connect to database. Firewall problem?";
        echo "<br/>".mysqli_connect_errno() . ":" . mysqli_connect_error();
    } else {
    
        // gets _GET info
        $query=$_GET['query'];
        $order=$_GET['order'];
  
        // $query max and min length - check this
        $max_length = 30;
        $min_length = 0;
    
        // run only if query exists (not on page load)
        if($query){
            if(strlen($query) >= $min_length AND strlen($query) <= $max_length){ // query length to stop people breaking our page
                // General input sanitation
                $query=htmlspecialchars($query); 
                $order=htmlspecialchars($order); 
                $query=mysqli_real_escape_string($con,$query);
                $order=mysqli_real_escape_string($con,$order);

                // Heading Output
                echo "<b>Search Results:<br/></b>";

                // User Order Request data - manipulates SQL Search
                if($order == "kd"){
                    $ordercode = "`key` DESC";
                } elseif($order == "ka"){
                    $ordercode = "`key` ASC";
                } elseif($order == "dd"){
                        $ordercode = "`year` DESC";
                } elseif($order == "da"){
                        $ordercode = "`year` ASC";
                } else {
                    // Catch people fiddling and tell them to back down.
                    echo "<br/> <b> STOP TRYING TO BREAK OUR STUFF! </b> <br/>";
                    exit();
                }

                // Check if $query is only digits - if it is then add to $sql_SQRY a search for the number column
                if(ctype_digit($query)){
                    $numstat="OR num LIKE ".$query;
                } else {
                    $numstat="";
                }


                // S E L E C T   S I N G L E   W O R D   Q U E R Y
                // ===========================================================
                $query = "'%" . $query . "%'";
                $sql_SQRY="SELECT * FROM `library` WHERE (`keywords` LIKE " . $query . " OR `title` LIKE " . $query . " OR `abstract` LIKE " . $query . " OR `key` LIKE " . $query . " OR `author` LIKE " . $query . " ) ORDER BY " . $ordercode . ";";



                // S E L E C T   A L L   Q U E R Y
                // ===========================================================
                // $query = "'%" . $query . "%'";
                // $sql_SQRY="SELECT * FROM `library`;";



                // N E W    F U L L T E X T    Q U E R Y
                // ===========================================================
                // $query = "'" . $query . "'";
                // $sql_SQRY = "SELECT *,
                //                 MATCH (`keywords`,`abstract`,`title`,`author`,`key`) AGAINST (" . $query . ") AS relevance,
                //                 MATCH (`title`) AGAINST (" . $query . ") AS title_relevance
                //             FROM `library`
                //             WHERE MATCH (`keywords`,`abstract`,`title`,`author`,`key`) AGAINST (" . $query . ")
                //             ORDER BY title_relevance DESC, relevance DESC";
                //


                // Runs SQL Query
                $result=mysqli_query($con,$sql_SQRY);
                
                // Get number of rows, stop timer, calculte runtime & round.
                $rowcount=mysqli_num_rows($result);
                $time_stop=microtime(true);
                $time_exec=$time_stop-$time_start;
                $runtime_1=round($time_exec,3);

                // Just below the 'Search Results' heading - display search info
                echo $rowcount;
                if($rowcount == 1){
                    echo " hit for the search: ";
                } else {
                    echo " hits for the search: ";
                }
                echo "<i>'".$query."'</i>  in ".$runtime_1." seconds<br/><br/><br/>";

                // Displays error if we get no result.
                if(!$result) {
                    echo "ERROR!  NO RESULT RETURNED FROM TABLE<br/>";
                    echo mysqli_error($con);
                    echo "<br/>";
                }

                // Result processing
                if ($rowcount  > 0) {
                    // Output data of each row
                        while($row=mysqli_fetch_assoc($result)) {
                        // check BLOB for pdf presence:
                        if ( !empty( $row["pdf"] ) ) {
                            $imout = "<a href='getpdf.php?record=". $row["id"] ."' target='_blank'><img src='static/pdf_icon.png' height='42' width='42'></a>";
                        } else {
                            $imout = "<img src='static/nopdf_icon.png' height='42' width='42'>";
                        }

                        // Outputs the Key # (linked) for a single row.  
                        echo "<b><i>Key#: ".$row["key"]."</b></i> " . $imout .  "<br/>" ;
                        // Outputs the Title and year for a single row.
                        echo "<b>" . $row["title"]."   ".$row["year"] ."</b><br/><br/>";
                        // Outputs the abstract information.
                        echo "<i>" . nl2br(rtrim(ltrim($row["abstract"])))."</i><br/>";
                        // Output PDF information (may need a conditional?)
                        //echo "PDF:"
                        echo "<br/><hr><br/>";
                    }
                } else {
                    echo "No Results";
                }

                // Close SQL connection
                mysqli_close($con); 
            }
            // Catch when people put in query of bad length and show error message
            else{ // If query length is less than minimum
                echo "<b>Your query was rejected due to bad size.</b><br />";
                echo "Minimum length is ".$min_length;
                echo "<br />Maximum length is ".$max_length;
            }
            // Displayed result when no search is done. (no $query from $_GET)
        } else {
        echo "No Search Yet";
        }
    }
?>
                      </span></p></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="110">&nbsp;</td>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr>
                            <td height="80" style="font-style: normal; font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif; font-size: medium;"><p></p></td>
                          </tr>
                          <tr>
                            <td height="66"><p style="font-size: xx-small"><strong>Disclaimer:</strong> Results produced by AgriCoat Search are not representitive of the viewpoints of the creators, or even AgriCoat. In no event will we be liable for any loss or damage including without limitation, indirect or consequential loss or damage, or any loss or damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this website. Every effort is made to keep the website up and running smoothly. However, we take no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control. Use at own risk.</p>
                              <p>© William &amp; Charles Matthews 2019</p></td>
                          </tr>
                        </tbody>
                      </table></td>
                      <td>&nbsp;</td>
                    </tr>
                  </tbody>
                </table></td>
              </tr>
            </tbody>
          </table>            <p class="s_font">&nbsp;</p></td>
        </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
  </table>
</form>
</body>
</html>